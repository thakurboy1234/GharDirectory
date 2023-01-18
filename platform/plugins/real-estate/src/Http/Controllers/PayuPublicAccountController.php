<?php

namespace Botble\RealEstate\Http\Controllers;

use Assets;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Media\Chunks\Exceptions\UploadMissingFileException;
use Botble\Media\Chunks\Handler\DropZoneUploadHandler;
use Botble\Media\Chunks\Receiver\FileReceiver;
use Botble\Media\Repositories\Interfaces\MediaFileInterface;
use Botble\Media\Services\ThumbnailService;
use Botble\Payment\Enums\PaymentStatusEnum;
use Botble\Payment\Repositories\Interfaces\PaymentInterface;
use Botble\Paypal\Services\Gateways\PayPalPaymentService;
use Botble\RealEstate\Http\Requests\AvatarRequest;
use Botble\RealEstate\Http\Requests\SettingRequest;
use Botble\RealEstate\Http\Requests\UpdatePasswordRequest;
use Botble\RealEstate\Http\Resources\AccountResource;
use Botble\RealEstate\Http\Resources\ActivityLogResource;
use Botble\RealEstate\Http\Resources\PackageResource;
use Botble\RealEstate\Http\Resources\TransactionResource;
use Botble\RealEstate\Models\Account;
use Botble\RealEstate\Models\Package;
use Botble\RealEstate\Repositories\Interfaces\AccountActivityLogInterface;
use Botble\RealEstate\Repositories\Interfaces\AccountInterface;
use Botble\RealEstate\Repositories\Interfaces\PackageInterface;
use Botble\RealEstate\Repositories\Interfaces\TransactionInterface;
use EmailHandler;
use Exception;
use File;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealEstateHelper;
use RvMedia;
use SeoHelper;
use Throwable;

class PayuPublicAccountController extends Controller
{
    /**
     * @var AccountInterface
     */
    protected $accountRepository;

    /**
     * @var AccountActivityLogInterface
     */
    protected $activityLogRepository;

    /**
     * @var MediaFileInterface
     */
    protected $fileRepository;

    /**
     * PublicController constructor.
     * @param Repository $config
     * @param AccountInterface $accountRepository
     * @param AccountActivityLogInterface $accountActivityLogRepository
     * @param MediaFileInterface $fileRepository
     */
    public function __construct(
        Repository $config,
        AccountInterface $accountRepository,
        AccountActivityLogInterface $accountActivityLogRepository,
        MediaFileInterface $fileRepository
    ) {
        $this->accountRepository = $accountRepository;
        $this->activityLogRepository = $accountActivityLogRepository;
        $this->fileRepository = $fileRepository;

        Assets::setConfig($config->get('plugins.real-estate.assets'));
    }

    /**
     * @return Application|Factory|View
     */
    public function getDashboard()
    {
        $user = auth('account')->user();

        SeoHelper::setTitle(auth('account')->user()->name);

        Assets::addScriptsDirectly([
            'vendor/core/plugins/real-estate/js/components.js',
            'vendor/core/plugins/real-estate/libraries/cropper.js',
        ])->usingVueJS();

        return view('plugins/real-estate::account.dashboard.index', compact('user'));
    }

    /**
     * @return Factory|View
     */
    public function getSettings()
    {
        SeoHelper::setTitle(trans('plugins/real-estate::account.account_settings'));

        $user = auth('account')->user();

        Assets::addScriptsDirectly(['vendor/core/plugins/real-estate/libraries/cropper.js']);

        return view('plugins/real-estate::account.settings.index', compact('user'));
    }

    /**
     * @param SettingRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse|RedirectResponse
     */
    public function postSettings(SettingRequest $request, BaseHttpResponse $response)
    {
        $year = $request->input('year');
        $month = $request->input('month');
        $day = $request->input('day');

        if ($year && $month && $day) {
            $request->merge(['dob' => implode('-', [$year, $month, $day])]);

            $validator = Validator::make($request->input(), [
                'dob' => 'nullable|date',
            ]);

            if ($validator->fails()) {
                return redirect()->route('public.account.settings');
            }
        }

        $this->accountRepository->createOrUpdate(
            $request->except('email'),
            ['id' => auth('account')->id()]
        );

        $this->activityLogRepository->createOrUpdate(['action' => 'update_setting']);

        return $response
            ->setNextUrl(route('public.account.settings'))
            ->setMessage(trans('plugins/real-estate::account.update_profile_success'));
    }

    /**
     * @return Application|Factory|View
     */
    public function getSecurity()
    {
        SeoHelper::setTitle(trans('plugins/real-estate::account.security'));

        return view('plugins/real-estate::account.settings.security');
    }

    /**
     * @return Application|Factory|View
     */
    public function getPackages()
    {
        if (! RealEstateHelper::isEnabledCreditsSystem()) {
            abort(404);
        }

        SeoHelper::setTitle(trans('plugins/real-estate::account.packages'));

        Assets::addScriptsDirectly('vendor/core/plugins/real-estate/js/components.js')
            ->usingVueJS();

        return view('plugins/real-estate::account.settings.package');
    }

    /**
     * @return Factory|View
     */
    public function getTransactions()
    {
        if (! RealEstateHelper::isEnabledCreditsSystem()) {
            abort(404);
        }

        SeoHelper::setTitle(trans('plugins/real-estate::account.transactions'));

        Assets::addScriptsDirectly('vendor/core/plugins/real-estate/js/components.js')
            ->usingVueJS();

        return view('plugins/real-estate::account.settings.transactions');
    }

    /**
     * @param PackageInterface $packageRepository
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function ajaxGetPackages(PackageInterface $packageRepository, BaseHttpResponse $response)
    {
        if (! RealEstateHelper::isEnabledCreditsSystem()) {
            abort(404);
        }

        $account = $this->accountRepository->findOrFail(
            auth('account')->id(),
            ['packages']
        );

        $packages = $packageRepository->getModel()
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->get();

        $packages = $packages->filter(function ($package) use ($account) {
            return $package->account_limit === null || $account->packages->where(
                'id',
                $package->id
            )->count() < $package->account_limit;
        });

        return $response->setData([
            'packages' => PackageResource::collection($packages),
            'account' => new AccountResource($account),
        ]);
    }

    /**
     * @param Request $request
     * @param PackageInterface $packageRepository
     * @param BaseHttpResponse $response
     * @param TransactionInterface $transactionRepository
     * @return BaseHttpResponse
     */
    public function ajaxSubscribePackage(
        Request $request,
        PackageInterface $packageRepository,
        BaseHttpResponse $response,
        TransactionInterface $transactionRepository
    ) {
        if (! RealEstateHelper::isEnabledCreditsSystem()) {
            abort(404);
        }

        $package = $packageRepository->findOrFail($request->input('id'));

        $account = $this->accountRepository->findOrFail(auth('account')->id());

        if ($package->account_limit && $account->packages()->where(
            'package_id',
            $package->id
        )->count() >= $package->account_limit) {
            abort(403);
        }

        if ((float)$package->price) {
            session(['subscribed_packaged_id' => $package->id]);

            return $response->setData(['next_page' => route('public.account.package.subscribe', $package->id)]);
        }

        $this->savePayment($package, null, $transactionRepository, true);

        return $response
            ->setData(new AccountResource($account->refresh()))
            ->setMessage(trans('plugins/real-estate::package.add_credit_success'));
    }

    /**
     * @param Package $package
     * @param string|null $chargeId
     * @param TransactionInterface $transactionRepository
     * @param bool $force
     * @return bool
     * @throws FileNotFoundException
     * @throws Throwable
     */
    protected function savePayment(Package $package, ?string $chargeId, TransactionInterface $transactionRepository, $request, bool $force = false)
    {
        if (! RealEstateHelper::isEnabledCreditsSystem()) {
            abort(404);
        }
        // Log::info('savePayment '.Auth::check());
        $payment = app(PaymentInterface::class)->getFirstBy(['charge_id' => $chargeId]);
        if (! $payment && ! $force) {
            return false;
        }
        // if( $payment->status == PaymentStatusEnum::COMPLETED){
        //     dd($payment);
        //     return false;
        // }
        // dd(1);
        $payment->update([
            'status'=>PaymentStatusEnum::COMPLETED
        ]);
        // Log::info('update '.Auth::check());
        $account='';
        if(auth('account')->user() != null ){
        $account = auth('account')->user();
        }else{
        $account = Account::class::find($request->userid);
        }
        // dump(11);

        // dd($account);

        if (($payment && $payment->status == PaymentStatusEnum::COMPLETED) || $force) {
            // dd(11);
            $account->credits += $package->number_of_listings;
            $account->save();

            $account->packages()->attach($package);
        }
        // dd();
        Log::info('update '.Auth::check());

        $transactionRepository->createOrUpdate([
            'user_id' => 0,
            'account_id' => $account->id,
            'credits' => $package->number_of_listings,
            'payment_id' => $payment ? $payment->id : null,
        ]);
        // dd(1);
        // dump($transactionRepository);

        // dd(110);
        if (! $package->total_price) {
            EmailHandler::setModule(REAL_ESTATE_MODULE_SCREEN_NAME)
                ->setVariableValues([
                    'account_name' => $account->name,
                    'account_email' => $account->email,
                ])
                ->sendUsingTemplate('free-credit-claimed');
        } else {
            EmailHandler::setModule(REAL_ESTATE_MODULE_SCREEN_NAME)
                ->setVariableValues([
                    'account_name' => $account->name,
                    'account_email' => $account->email,
                    'package_name' => $package->name,
                    'package_price' => format_price($package->total_price / $package->number_of_listings) . '/credit',
                    'package_discount' => ($package->percent_discount ?: 0) . '%' . ($package->percent_discount > 0 ? ' (Save ' . format_price($package->price - $package->total_price) . ')' : ''),
                    'package_total' => format_price($package->total_price) . ' for ' . $package->number_of_listings . ' credits',
                ])
                ->sendUsingTemplate('payment-received');
        }

        EmailHandler::setModule(REAL_ESTATE_MODULE_SCREEN_NAME)
            ->setVariableValues([
                'account_name' => $account->name,
                'package_name' => $package->name,
                'package_price' => format_price($package->total_price / $package->number_of_listings) . '/credit',
                'package_discount' => ($package->percent_discount ?: 0) . '%' . ($package->percent_discount > 0 ? ' (Save ' . format_price($package->price - $package->total_price) . ')' : ''),
                'package_total' => format_price($package->total_price) . ' for ' . $package->number_of_listings . ' credits',
            ])
            ->sendUsingTemplate('payment-receipt', $account->email);

        return true;
    }

    /**
     * @param int $id
     * @param PackageInterface $packageRepository
     * @return Application|Factory|View
     */
    public function getSubscribePackage($id, PackageInterface $packageRepository)
    {
        if (! RealEstateHelper::isEnabledCreditsSystem()) {
            abort(404);
        }

        $package = $packageRepository->findOrFail($id);

        SeoHelper::setTitle(trans('plugins/real-estate::package.subscribe_package', ['name' => $package->name]));

        return view('plugins/real-estate::account.checkout', compact('package'));
    }

    /**
     * @param $packageId
     * @param Request $request
     * @param PackageInterface $packageRepository
     * @param TransactionInterface $transactionRepository
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws FileNotFoundException
     * @throws Throwable
     */
    public function getPackageSubscribeCallback(
        $packageId,
        Request $request,
        PackageInterface $packageRepository,
        TransactionInterface $transactionRepository,
        BaseHttpResponse $response
        ) {
            // dd($request->all());
            // Log::info('getPackageSubscribeCallback '.Auth::check());
            $charge_id= $request->input('charge_id');
            if($request->type == 'payu'){
                if($request->input('type')=='payu'){
                    $charge_id= trim($charge_id,"pay_");
                }
            }
            if (! RealEstateHelper::isEnabledCreditsSystem()) {
                abort(404);
            }
            Log::info('RealEstateHelper::isEnabledCreditsSystem() '.Auth::check());

            $package = $packageRepository->findOrFail($packageId);
            // dd($package);
            // dump(1);
            if (is_plugin_active('paypal') && $request->input('type') == PAYPAL_PAYMENT_METHOD_NAME) {
                $validator = Validator::make($request->input(), [
                    'amount' => 'required|numeric',
                    'currency' => 'required',
                ]);
            if ($validator->fails()) {
                return $response->setError()->setMessage($validator->getMessageBag()->first());
            }
            // dd(11);
            $payPalService = app(PayPalPaymentService::class);

            $paymentStatus = $payPalService->getPaymentStatus($request);

            if ($paymentStatus) {
                $chargeId = session('paypal_payment_id');

                $payPalService->afterMakePayment($request->input());

                $this->savePayment($package, $chargeId, $transactionRepository,$request);

                return $response
                ->setNextUrl(route('public.account.packages'))
                ->setMessage(trans('plugins/real-estate::package.add_credit_success'));
            }

            // dd('getPackageSubscribeCallback end');
            return $response
                ->setError()
                ->setNextUrl(route('public.account.packages'))
                ->setMessage($payPalService->getErrorMessage());
        }
        // Log::info('savePayment '.Auth::check());
        // dd(11);
        $this->savePayment($package, $charge_id, $transactionRepository,$request);
        // dd(11111);
        if (! $request->has('success') || $request->input('success')) {
            return $response
                ->setNextUrl(route('public.account.packages'))
                ->setMessage(session()->get('success_msg') ?: trans('plugins/real-estate::package.add_credit_success'));
        }

        return $response
            ->setError()
            ->setNextUrl(route('public.account.packages'))
            ->setMessage(__('Payment failed!'));
    }

    /**
     * @param UpdatePasswordRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function postSecurity(UpdatePasswordRequest $request, BaseHttpResponse $response)
    {
        $this->accountRepository->update(['id' => auth('account')->id()], [
            'password' => bcrypt($request->input('password')),
        ]);

        $this->activityLogRepository->createOrUpdate(['action' => 'update_security']);

        return $response->setMessage(trans('plugins/real-estate::dashboard.password_update_success'));
    }

    /**
     * @param AvatarRequest $request
     * @param ThumbnailService $thumbnailService
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function postAvatar(AvatarRequest $request, ThumbnailService $thumbnailService, BaseHttpResponse $response)
    {
        try {
            $account = auth('account')->user();

            $result = RvMedia::handleUpload($request->file('avatar_file'), 0, 'accounts');

            if ($result['error']) {
                return $response->setError()->setMessage($result['message']);
            }

            $avatarData = json_decode($request->input('avatar_data'));

            $file = $result['data'];

            $thumbnailService
                ->setImage(RvMedia::getRealPath($file->url))
                ->setSize((int)$avatarData->width, (int)$avatarData->height)
                ->setCoordinates((int)$avatarData->x, (int)$avatarData->y)
                ->setDestinationPath(File::dirname($file->url))
                ->setFileName(File::name($file->url) . '.' . File::extension($file->url))
                ->save('crop');

            $this->fileRepository->forceDelete(['id' => $account->avatar_id]);

            $account->avatar_id = $file->id;

            $this->accountRepository->createOrUpdate($account);

            $this->activityLogRepository->createOrUpdate([
                'action' => 'changed_avatar',
            ]);

            return $response
                ->setMessage(trans('plugins/real-estate::dashboard.update_avatar_success'))
                ->setData(['url' => Storage::url($file->url)]);
        } catch (Exception $ex) {
            return $response
                ->setError()
                ->setMessage($ex->getMessage());
        }
    }

    /**
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function getActivityLogs(BaseHttpResponse $response)
    {
        $activities = $this->activityLogRepository->getAllLogs(auth('account')->id());

        Assets::addScriptsDirectly('vendor/core/plugins/real-estate/js/components.js')
            ->usingVueJS();

        return $response->setData(ActivityLogResource::collection($activities))->toApiResponse();
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse|JsonResponse
     */
    public function postUpload(Request $request, BaseHttpResponse $response)
    {
        if (setting('media_chunk_enabled') != '1') {
            $validator = Validator::make($request->all(), [
                'file.0' => 'required|image|mimes:jpg,jpeg,png,webp',
            ]);

            if ($validator->fails()) {
                return $response->setError()->setMessage($validator->getMessageBag()->first());
            }

            $result = RvMedia::handleUpload(Arr::first($request->file('file')), 0, 'accounts');

            if ($result['error']) {
                return $response->setError()->setMessage($result['message']);
            }

            return $response->setData($result['data']);
        }

        try {
            // Create the file receiver
            $receiver = new FileReceiver('file', $request, DropZoneUploadHandler::class);
            // Check if the upload is success, throw exception or return response you need
            if ($receiver->isUploaded() === false) {
                throw new UploadMissingFileException();
            }
            // Receive the file
            $save = $receiver->receive();
            // Check if the upload has finished (in chunk mode it will send smaller files)
            if ($save->isFinished()) {
                $result = RvMedia::handleUpload($save->getFile(), 0, 'accounts');

                if (! $result['error']) {
                    return $response->setData($result['data']);
                }

                return $response->setError(true)->setMessage($result['message']);
            }
            // We are in chunk mode, lets send the current progress
            $handler = $save->handler();

            return response()->json([
                'done' => $handler->getPercentageDone(),
                'status' => true,
            ]);
        } catch (Exception $exception) {
            return $response->setError(true)->setMessage($exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function postUploadFromEditor(Request $request)
    {
        return RvMedia::uploadFromEditor($request, 0, 'accounts');
    }

    /**
     * @param TransactionInterface $transactionRepository
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function ajaxGetTransactions(TransactionInterface $transactionRepository, BaseHttpResponse $response)
    {
        if (! RealEstateHelper::isEnabledCreditsSystem()) {
            abort(404);
        }

        $transactions = $transactionRepository->advancedGet([
            'condition' => [
                'account_id' => auth('account')->id(),
            ],
            'paginate' => [
                'per_page' => 10,
                'current_paged' => 1,
            ],
            'order_by' => ['created_at' => 'DESC'],
            'with' => ['payment', 'user'],
        ]);

        return $response->setData(TransactionResource::collection($transactions))->toApiResponse();
    }

    public function callback(Request $request)
    {
        dd($request->all());
        dump(Crypt::decryptString('eyJpdiI6Ikw3azNLWXdCQWJLbzZXZlVPZkFFM1E9PSIsInZhbHVlIjoidGorQUVscTRNNW13bGFLWFZieW9Vdz09IiwibWFjIjoiM2RhMmYxOTc1YzQyZGE4MTA1N2M5MThhNThhZmQyMzE5MmQxZDQ1YmNhNGMyZGFjMDgwYTNlNzMwODM2YjFlZCIsInRhZyI6IiJ9'));
        dd(Crypt::encryptString('123'));
    }
}
