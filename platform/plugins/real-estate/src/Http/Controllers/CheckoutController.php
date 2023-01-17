<?php

namespace Botble\RealEstate\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Payment\Enums\PaymentMethodEnum;
use Botble\Payment\Services\Gateways\BankTransferPaymentService;
use Botble\Payment\Services\Gateways\CodPaymentService;
use Botble\Payment\Services\Gateways\PayuPaymentService;
use Botble\RealEstate\Http\Requests\CheckoutRequest;
use Botble\RealEstate\Models\Account;
// use Botble\Support\Http\Requests\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * @param CheckoutRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse|RedirectResponse
     */
    public function postCheckout(CheckoutRequest $request, BaseHttpResponse $response)
    {
        // dd(11);
        $returnUrl = $request->input('return_url');

        $currency = $request->input('currency', config('plugins.payment.payment.currency'));
        $currency = strtoupper($currency);
        // dd(11);

        $data = [
            'error' => false,
            'message' => false,
            'amount' => $request->input('amount'),
            'currency' => $currency,
            'type' => $request->input('payment_method'),
            'charge_id' => null,
        ];

        session()->put('selected_payment_method', $data['type']);

        $paymentData = apply_filters(PAYMENT_FILTER_PAYMENT_DATA, [], $request);

        switch ($request->input('payment_method')) {
            case PaymentMethodEnum::COD:
                $codPaymentService = app(CodPaymentService::class);
                $data['charge_id'] = $codPaymentService->execute($paymentData);
                $data['message'] = trans('plugins/payment::payment.payment_pending');
                $data['checkoutUrl'] = $request->input('callback_url') . '?charge_id=' . $data['charge_id'];

                break;

            case PaymentMethodEnum::BANK_TRANSFER:
                $bankTransferPaymentService = app(BankTransferPaymentService::class);
                $data['charge_id'] = $bankTransferPaymentService->execute($paymentData);
                $data['message'] = trans('plugins/payment::payment.payment_pending');
                $data['checkoutUrl'] = $request->input('callback_url') . '?charge_id=' . $data['charge_id'];

                break;
            case PaymentMethodEnum::PAYU:
                // dd(11);
                $bankTransferPaymentService = app(PayuPaymentService::class);
                $data['charge_id'] = $bankTransferPaymentService->execute($paymentData);
                $data['message'] = trans('plugins/payment::payment.payment_pending');
                $data['checkoutUrl'] = $request->input('callback_url') . '?charge_id=' . $data['charge_id'];

                break;

            default:
                $data = apply_filters(PAYMENT_FILTER_AFTER_POST_CHECKOUT, $data, $request);

                break;
        }

        if ($checkoutUrl = Arr::get($data, 'checkoutUrl')) {
            return $response
                ->setError($data['error'])
                ->setNextUrl($checkoutUrl)
                ->withInput()
                ->setMessage($data['message']);
        }

        if ($data['error'] || ! $data['charge_id']) {
            return $response
                ->setError()
                ->setNextUrl($returnUrl)
                ->withInput()
                ->setMessage($data['message'] ?: __('Checkout error!'));
        }

        $callbackUrl = $request->input('callback_url') . '?' . http_build_query($data);

        return redirect()->to($callbackUrl)->with('success_msg', trans('plugins/payment::payment.checkout_success'));
    }
    public function payuCheckout(CheckoutRequest $request)
    {
        // dd($request->all());
        // dump(Account::class::find(14));
        // dd( auth('account')->user());

        // dd(Auth('account')->user()->id);
        Log::info('selected_payment_method '.session()->get('selected_payment_method'));
        Log::info('selected_payment_method '.Auth::check());
        $returnUrl = $request->input('return_url');

        $currency = $request->input('currency', config('plugins.payment.payment.currency'));
        $currency = strtoupper($currency);
        // dd(11);

        $data = [
            'error' => false,
            'message' => false,
            'amount' => $request->input('amount'),
            'currency' => $currency,
            'type' => $request->input('payment_method'),
            'charge_id' => null,
            'token' => '',

        ];
        Log::info('selected_payment_method '.Auth::check());
        session()->put('selected_payment_method', $data['type']);
        $paymentData = apply_filters(PAYMENT_FILTER_PAYMENT_DATA, [], $request);
        $payuPaymentService = app(PayuPaymentService::class);

        $data['charge_id'] = $payuPaymentService->execute($paymentData);

        $data['message'] = 0;
        $data['checkoutUrl'] = $request->input('callback_url') . '?charge_id=' . $data['charge_id']. '&userid=' . Auth('account')->user()->id;
        // dd($data);
        Log::info('checkoutUrl '.Auth::check());
        // dd($paymentData);
        $MERCHANT_KEY = 'dke7p5s2';
        $salt = 'JzBVnkPKdy';
        //    $MERCHANT_KEY = 'WJfoOMVi';
        // $salt = 'eJSbxabBVZ';
        $PAYU_BASE_URL = env('PAYU_BASE_URL','https://test.payu.in');

        $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);


        $action = $PAYU_BASE_URL . '/_payment';

        // $ship = Session::get('shipping_address');

        $productinfo = $request->name;

        $posted = array(
            'amount' => $data['amount'],
            'productinfo' => $productinfo,
            'firstname' => Auth('account')->user()->name,
            'email' => Auth('account')->user()->email,
            'phone' =>  Auth('account')->user()->phone,
            'key'  => $MERCHANT_KEY,
            'txnid' => $txnid,
        );
        $hash = '';
        $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
        $hashVarsSeq = explode('|', $hashSequence);
        $hash_string = '';
        foreach($hashVarsSeq as $hash_var) {
           $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
           $hash_string .= '|';
        }
        $hash_string .= $salt;
        // dd($hash_string);
        $hash = strtolower(hash('sha512', $hash_string));
        Log::info('return '.Auth::check());

        return response()->json([
            'status' => true,
            'html' => view('plugins/payment::partials.payu-checkout-model',compact('hash','action','MERCHANT_KEY','txnid','posted','data','salt','returnUrl'))->render()]);

        // dd($paymentData);

    }
}
