

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
                                <input type="number" name="otp[]" oninput='digitValidate(this)' onkeyup='tabChange(1)' maxlength=1  class="form-control auto-focus" autofocus="">
                                <input type="number" name="otp[]"  oninput='digitValidate(this)' onkeyup='tabChange(2)' maxlength=1  class="form-control auto-focus">
                                <input type="number" name="otp[]" oninput='digitValidate(this)' onkeyup='tabChange(3)' maxlength=1  class="form-control auto-focus">
                                <input type="number" name="otp[]"  oninput='digitValidate(this)' onkeyup='tabChange(4)' maxlength=1 class="form-control auto-focus">
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

<script>

    let digitValidate = function(ele){
        console.log(ele.value);
        ele.value = ele.value.replace(/[^0-9]/g,'');
      }

      let tabChange = function(val){
          let ele = document.querySelectorAll('input');
          if(ele[val-1].value != ''){
            ele[val].focus()
          }else if(ele[val-1].value == ''){
            ele[val-2].focus()
          }
       }
       //    otp timer
var timeleft = 60;
    var downloadTimer = setInterval(function(){
        if(timeleft <= 2){
            $('#disabled-link-id').removeClass('disabled-link');
         }else{
            $('#disabled-link-id').addClass('disabled-link');
        }
    timeleft--;
    document.getElementById("countdowntimer").textContent = timeleft;
    if(timeleft <= 0){
        clearInterval(downloadTimer);
    }
    },1000);
</script>
