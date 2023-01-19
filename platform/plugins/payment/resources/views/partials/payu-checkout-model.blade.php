<form action={{$action}} method="post" id="payuForm" name="payuForm" class="pb-0">

    <input type="hidden" name="key" value="{{ @$MERCHANT_KEY , '' }}"/>
    <input type="hidden" name="hash" value="{{ @$hash , ''}}"/>
    <input type="hidden" name="txnid" value="{{ @$txnid , ''}}"/>
    <input type="hidden" name="salt" value="{{ @$salt , ''}}"/>
    {{-- <input type="hidden" name="userInfo" value="{{Auth('account')->user() , ''}}"/> --}}
    <input class="input-box form-control w-100" placeholder="Amount *" id="pay_total" type="hidden" name="amount"
                            value="{{!empty($posted['amount']) ? $posted['amount'] : ''}}">
    <div class="px-5 pt-4 pb-5 form-block" style="display: none">
        <div class="row">
            <div class="col-12">
                <div class="form-group mb-3 position-relative">
                    <input type="text" class="input-box form-control w-100" placeholder="Name *"
                            aria-label="Recipient's username"
                            aria-describedby="button-addon2" name="firstname"
                            value="{{!empty($posted['firstname']) ? $posted['firstname'] : ''}}">
                    <div class="icon-group-append">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group mb-3 position-relative">
                    <input class="input-box form-control w-100" placeholder="Email *" type="email" name="email"
                            value="{{!empty($posted['email']) ? $posted['email'] : ''}}">
                    <div class="icon-group-append">
                        <i class="fas fa-envelope"></i>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group mb-3 position-relative">
                    <input class="input-box form-control w-100" placeholder="Phone *" type="number" name="phone"
                            value="{{!empty($posted['phone']) ? $posted['phone'] : ''}}">
                    <div class="icon-group-append">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                </div>
            </div>
            {{-- <div class="col-12">
                <div class="form-group mb-3 position-relative">
                    <input class="input-box form-control w-100" placeholder="Amount *" id="pay_total" type="text" name="amount"
                            value="{{!empty($posted['amount']) ? $posted['amount'] : ''}}">
                    <div class="icon-group-append">
                        <i class="fas fa-tag"></i>
                    </div>
                </div>
            </div> --}}
            <div class="col-12">
                <div class="form-group mb-3 position-relative">
                    <textarea class="input-box form-control w-100" placeholder="Note *" name="productinfo">{{!empty($posted['productinfo']) ? $posted['productinfo'] : ''}}</textarea>
                    <div class="icon-group-append">
                        <i class="fas fa-pencil-alt"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 text-center">
        <button class="btn btn-primary w-100 continue-pay-btn" id="continue-pay-btn"><span>Continue to pay</span></button>
    </div>

    <input name="surl" id="surl" value="{{$data['checkoutUrl']}}" hidden/>
    <input name="furl" id="furl" value="{{$returnUrl}}" hidden/>
    <input type="hidden" name="service_provider" value="payu_paisa"/>
</form>
