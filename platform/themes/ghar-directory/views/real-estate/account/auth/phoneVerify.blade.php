
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card login-form otp-form">
                <div class="card-body">
                    <h4 class="text-center">Mobile phone verification</h4>
                    @include(Theme::getThemeNamespace() . '::views.real-estate.account.auth.includes.messages')
                    <span class="mobile-text">Enter the code we just send on your
                        mobile phone <b class="text-danger">+91 {{isset($checkAccount)?'******'.substr($checkAccount->phone, -4):'....'}}</b></span>
                    <br>
                    <form action="{{url('verify/otp/'.$en_user_id.'/'.$password)}}" method="get" id="phone_verify">
                        <div class="form-group">
                            <div class="d-flex flex-row mt-3">
                                <input type="number" name="otp[]" required data-val='1'  maxlength='1'  class="form-control auto-focus focus-defau" autofocus>
                                <input type="number" name="otp[]" required data-val='2'  maxlength='1'  class="form-control auto-focus">
                                <input type="number" name="otp[]" required data-val='3'  maxlength='1'  class="form-control auto-focus">
                                <input type="number" name="otp[]"  required data-val='4'  maxlength='1' class="form-control auto-focus">
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-blue btn-full fw6">
                                Verify
                            </button>
                        </div>
                        <div class="text-center mt-3">
                            <span class="d-block mobile-text">Don't receive the code?</span>
                            <p class="m-0"> Resend OTP in <span id="countdowntimer">60 </span> Seconds</p>
                            <a href="{{url('verify/otp/resend/'.$en_user_id.'/'.$password)}}" id="disabled-link-id" class="font-weight-bold text-danger curso disabled-link">Resend</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

