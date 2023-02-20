
<div class="d-flex justify-content-center align-items-center container">

    <form action="{{url('verify/otp/'.$user_id.'/'.$password)}}" method="get" id="phone_verify">
    @include(Theme::getThemeNamespace() . '::views.real-estate.account.auth.includes.messages')
    <div class="card py-5 px-3">

        <h5 class="m-0">Mobile phone verification</h5>
        <span class="mobile-text">Enter the code we just send on your
            mobile phone <b class="text-danger">+91 86684833</b></span>
        <div class="d-flex flex-row mt-5">
            <input type="number" name="otp[]" class="form-control" autofocus="">
            <input type="number" name="otp[]"class="form-control">
            <input type="number" name="otp[]" class="form-control">
            <input type="number" name="otp[]" class="form-control">
        </div>
        <div>

            <button style="margin-top: 20px;  text-align: center;   width: 100px;" type="submit" class="btn btn-orange">Submit</button>
        </div>
        <div class="text-center mt-5"><span class="d-block mobile-text">Don't receive the code?</span>
       <span class="font-weight-bold text-danger cursor">Resend</span></div>
    </div>
</form>
</div>
