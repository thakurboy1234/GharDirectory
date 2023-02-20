<?php

namespace Botble\RealEstate\Http\Controllers;

use App\Http\Controllers\Controller;
use BaseHelper;
use Botble\ACL\Traits\RegistersUsers;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Location\Repositories\Interfaces\CityInterface;
use Botble\RealEstate\Models\Account;
use Botble\RealEstate\Models\PhoneVerify;
use Botble\RealEstate\Repositories\Interfaces\AccountInterface;
use EmailHandler;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use RealEstateHelper;
use Response;
use SeoHelper;
use Theme;
use URL;
use Twilio\Rest\Client;
use Illuminate\Contracts\Encryption\DecryptException;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default, this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = null;

    /**
     * @var AccountInterface
     */
    protected $accountRepository;

    /**
     * Create a new controller instance.
     *
     * @param AccountInterface $accountRepository
     */
    public function __construct(AccountInterface $accountRepository)
    {
        $this->accountRepository = $accountRepository;
        $this->redirectTo = route('public.account.register');
    }

    /**
     * Show the application registration form.
     *
     * @return Application|Factory|View|Response
     */
    public function showRegistrationForm()
    {
        if (!RealEstateHelper::isRegisterEnabled()) {
            abort(404);
        }
        $cities = app(CityInterface::class)->getModel()->get();
        SeoHelper::setTitle(__('Register'));

        if (view()->exists(Theme::getThemeNamespace() . '::views.real-estate.account.auth.register')) {
            return Theme::scope('real-estate.account.auth.register', compact('cities'))->render();
        }

        return view('plugins/real-estate::account.auth.register', compact('cities'));
    }

    /**
     * Confirm a user with a given confirmation code.
     *
     * @param int $id
     * @param Request $request
     * @param BaseHttpResponse $response
     * @param AccountInterface $accountRepository
     * @return BaseHttpResponse
     */
    public function confirm($id, Request $request, BaseHttpResponse $response, AccountInterface $accountRepository)
    {
        if (!RealEstateHelper::isRegisterEnabled()) {
            abort(404);
        }

        if (!URL::hasValidSignature($request)) {
            abort(404);
        }

        $account = $accountRepository->findOrFail($id);

        $account->confirmed_at = now();
        $this->accountRepository->createOrUpdate($account);

        $this->guard()->login($account);

        return $response
            ->setNextUrl(route('public.account.dashboard'))
            ->setMessage(__('You successfully confirmed your email address.'));
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return auth('account');
    }

    /**
     * Resend a confirmation code to a user.
     *
     * @param \Illuminate\Http\Request $request
     * @param AccountInterface $accountRepository
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function resendConfirmation(
        Request $request,
        AccountInterface $accountRepository,
        BaseHttpResponse $response
    ) {
        if (!RealEstateHelper::isRegisterEnabled()) {
            abort(404);
        }

        $account = $accountRepository->getFirstBy(['email' => $request->input('email')]);
        if (!$account) {
            return $response
                ->setError()
                ->setMessage(__('Cannot find this account!'));
        }

        $this->sendConfirmationToUser($account);

        return $response
            ->setMessage(__('We sent you another confirmation email. You should receive it shortly.'));
    }

    /**
     * Send the confirmation code to a user.
     *
     * @param Account $account
     */
    protected function sendConfirmationToUser($account)
    {
        // Notify the user
        $notificationConfig = config('plugins.real-estate.real-estate.notification');
        if ($notificationConfig) {
            $notification = app($notificationConfig);
            $account->notify($notification);
        }
    }

    /**
     * Handle a registration request for the application.
     *
     * @param \Illuminate\Http\Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function register(Request $request, BaseHttpResponse $response)
    {
        // dump(['email'=>'user@gmail.com','password'=>'123456']);
        // Auth::guard('account')->attempt(['email'=>'user@gmail.com','password'=>'password']);
        // dd(Auth::check());
        // dd(11);

        if (!RealEstateHelper::isRegisterEnabled()) {
            abort(404);
        }

        $this->validator($request->input())->validate();

        event(new Registered($account = $this->create($request->input())));

        // EmailHandler::setModule(REAL_ESTATE_MODULE_SCREEN_NAME)
        // ->setVariableValues([
        //     'account_name' =>  $account->name,
        //     'account_email' => $account->email,
        //     ])
        //     ->sendUsingTemplate('new-account-registered', $account->email,);

        // EmailHandler::setModule(REAL_ESTATE_MODULE_SCREEN_NAME)
        //     ->setVariableValues([
        //         'account_name' => $account->name,
        //         'account_email' => $account->email,
        //     ])
        //     ->sendUsingTemplate('account-registered');

        // if (setting('verify_account_email', false)) {
        //     $this->sendConfirmationToUser($account);

        //     return $this->registered($request, $account)
        //         ?: $response->setNextUrl((string)$this->redirectPath())
        //             ->setMessage(__('Please confirm your email address.'));
        // }
        $user_details =   app(AccountInterface::class)
            ->getModel()
            ->where('id', $account->id)
            ->first();
        if ($user_details->phone_number_verify_via_admin == 0 && !isset($user_details->phone_otp)) {
            return  $otpstatus = $this->check_phone_verify($user_details, $request->all());
            //    Log::info( $otpstatus);
            if ($otpstatus) {
                $account->confirmed_at = now();

                $this->accountRepository->createOrUpdate($account);
                $this->guard()->login($account);
                redirect()->route('dashboard.index');

                // return $response->setNextUrl((string)$this->redirectPath())->setMessage(__('Registered successfully!'));
            }
        }
        // dd(11);
        $account->confirmed_at = now();

        $this->accountRepository->createOrUpdate($account);
        $this->guard()->login($account);

        return $response->setNextUrl((string)$this->redirectPath())->setMessage(__('Registered successfully!'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'fff_name' => 'required|max:120',
            'city_id' => 'required|exists:cities,id',
            // 'company_name' => 'required|max:120',
            // 'username' => 'required|max:60|min:2|unique:re_accounts,username',
            'email' => 'required|email|max:255|unique:re_accounts',
            'password' => 'required|min:6|confirmed',
            'phone' => 'required|unique:re_accounts|' . BaseHelper::getPhoneValidationRule(),
        ];

        if (is_plugin_active('captcha') && setting('enable_captcha') && setting(
            'real_estate_enable_recaptcha_in_register_page',
            0
        )) {
            $rules += ['g-recaptcha-response' => 'required|captcha'];
        }

        return Validator::make($data, $rules, [
            'g-recaptcha-response.required' => __('Captcha Verification Failed!'),
            'g-recaptcha-response.captcha' => __('Captcha Verification Failed!'),
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return Account
     */
    protected function create(array $data)
    {
        return $this->accountRepository->create([
            'fff_name' => $data['fff_name'],
            'company' => $data['company'],
            'alternate_mobile_number' => $data['alternate_mobile_number'],
            // 'username' => $data['username'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'city_id' => $data['city_id'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * @return Factory|\Illuminate\View\View
     */
    public function getVerify()
    {
        if (!RealEstateHelper::isRegisterEnabled()) {
            abort(404);
        }

        return view('plugins/real-estate::account.auth.verify');
    }
    public function check_phone_verify($user_details = null, $form_data)
    {
        // dd($form_data);
        if (isset($user_details)) {
            if ($user_details->phone_number_verify_via_admin == 0 && !isset($user_details->phone_otp)) {
                $checkOtp =   PhoneVerify::where('user_id', $user_details->id)->OrderBy('id', 'desc')->first();
                if (isset($checkOtp)) {
                    $current = \Carbon\Carbon::now();
                    $diff = now()->diffInSeconds($checkOtp->updated_at);
                    if ($diff <= 600) {
                        // dump(1);
                        $encrypt_user_id =  \Crypt::encryptString($checkOtp->user_id);
                        $encrypt_otp =  \Crypt::encryptString($checkOtp->otp);
                        // dump(2);
                        return redirect(url('phone/verify/' . $encrypt_user_id . '/' . $form_data['password']));
                    } else {
                        return $this->generate_new_otp($user_details,$form_data);
                    }
                } else {

                    return $this->generate_new_otp($user_details,$form_data);
                    // // dd(312312);
                    // $otp = rand(1000, 9999);
                    // $phoneVerify = new  PhoneVerify();
                    // $phoneVerify->user_id = $user_details->id;
                    // $phoneVerify->otp = $otp;


                    // if ($phoneVerify->save()) {
                    //     $encrypt_user_id =  \Crypt::encryptString($phoneVerify->user_id);
                    //     $encrypt_otp =  \Crypt::encryptString($phoneVerify->otp);
                    //     return redirect(url('phone/verify/' . $encrypt_user_id . '/' . $form_data['password']));
                    // }
                    // // dump(6);
                }

            }
        }
    }



    public function phone_verify_page($user_id = null, $password = null,$login=false)
    {
        if($login){


        }

        SeoHelper::setTitle(__('Verify'));

        // dd(auth('account')->check());
        return Theme::scope('real-estate.account.auth.phoneVerify', compact('user_id', 'password'))->render();
        // return view('phoneVerify');


    }
    public function verify_otp(Request $request, $en_user_id, $password)
    {
        // dd(1121);
        //     dump(['email'=>'user@gmail.com','password'=>'123456']);
        // Auth::guard('account')->attempt(['email'=>'user@gmail.com','password'=>'password']);
        //     // dd(11);
        // redirect()->route('dashboard.index');


            $user_id='';
            try {
                $user_id = \Crypt::decryptString($en_user_id);
            } catch (DecryptException $e) {
                    if($e->getMessage() !=''){
                        return Redirect(route('public.account.login'));
                    }

            }
        $user_id = \Crypt::decryptString($en_user_id);
        $checkOtp =   PhoneVerify::where('user_id', $user_id)->OrderBy('id', 'desc')->first();

        $checkAccount = app(AccountInterface::class)
        ->getmodel()
        ->find($user_id);
        //check user phone number verifed or not
            if(isset($checkAccount->phone_otp)){
              return redirect()->route('public.account.login');
            }
         // end check user phone number verifed or not

        $current = \Carbon\Carbon::now();
        $diff = now()->diffInSeconds($checkOtp->updated_at);

      //time diff check 1o mint
        if ($diff <= 600) {
            if (isset($checkAccount)) {
                $fullOtp = '';
                if (count($request->otp)) {
                    foreach ($request->otp as $key => $value) {
                        $fullOtp .= $value;
                    }
                }
                // match opt here
                if ($checkOtp->otp == $fullOtp) {
                    $checkAccount->update(['phone_otp' => $checkOtp->otp, 'confirmed_at', now()]);
                    $attempt = ['email' => $checkAccount->email, 'password' => $password];
                    if (Auth::guard('account')->attempt($attempt)) {
                        return  redirect()->route('public.account.dashboard');
                    }
                } else {
                    //otp not match
                    return Redirect()->back()->withErrors(['msg' => 'Otp is invalid ! ']);
                }
            } else {
                //user not found
                return Redirect()->back()->withErrors(['msg' => 'User not found !']);
            }
        } else {
            //token is expire
            return Redirect()->back()->withErrors( ['msg' => 'Your token otp expire please send agian ']);

        }
        return Redirect()->back()->withErrors( ['msg' => 'Some Issue.........']);
    }

    public static function generate_new_otp($user_details = null, $form_data)
    {
        $otp = rand(1000, 9999);
        $phoneVerify = new  PhoneVerify();
        $phoneVerify->user_id = $user_details->id;
        $phoneVerify->otp = $otp;

        //twilio
          // $receiverNumber = 7248307698;
                    // $message = "This is testing from CodeSolutionStuff.com";

                    // try {

                    //     $account_sid = getenv("TWILIO_SID");
                    //     $auth_token = getenv("TWILIO_TOKEN");
                    //     $twilio_number = getenv("TWILIO_FROM");

                    //     $client = new Client($account_sid, $auth_token);
                    //     $client->messages->create($receiverNumber, [
                    //         'from' => $twilio_number,
                    //         'body' => $message]);

                    //     dd('SMS Sent Successfully.');

                    // } catch (\Exception $e) {
                    //     dd("Error: ". $e->getMessage());
                    // }

        //end


        if ($phoneVerify->save()) {
            $encrypt_user_id =  \Crypt::encryptString($phoneVerify->user_id);
            $encrypt_otp =  \Crypt::encryptString($phoneVerify->otp);
            return redirect(url('phone/verify/' . $encrypt_user_id . '/' . $form_data['password']));
        }

    }
}
