
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card login-form">
                <div class="card-body">
                    <h4 class="text-center">{{ trans('plugins/real-estate::dashboard.register-title') }}</h4>
                    <br>
                    @include(Theme::getThemeNamespace() . '::views.real-estate.account.auth.includes.messages')
                    <br>
                    <form method="POST" action="{{ route('public.account.register') }}" id="register_form">
                        @csrf
                        <div class="form-group">
                            <input id="first_name" type="text"
                                   class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}"
                                   name="first_name" value="{{ old('first_name') }}" required autofocus
                                   placeholder="{{ trans('plugins/real-estate::dashboard.first_name') }}">
                            @if ($errors->has('first_name'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <input id="last_name" type="text"
                                   class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}"
                                   name="last_name" value="{{ old('last_name') }}" required
                                   placeholder="{{ trans('plugins/real-estate::dashboard.last_name') }}">
                            @if ($errors->has('last_name'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <input id="username" type="text"
                                   class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}"
                                   name="username" value="{{ old('username') }}" required
                                   placeholder="{{ trans('plugins/real-estate::dashboard.username') }}">
                            @if ($errors->has('username'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <input id="email" type="email"
                                   class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                   name="email" value="{{ old('email') }}" required
                                   placeholder="{{ trans('plugins/real-estate::dashboard.email') }}">
                            @if ($errors->has('email'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <input id="phone" type="text"
                                   class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                   name="phone" value="{{ old('phone') }}" required
                                   placeholder="{{ trans('plugins/real-estate::dashboard.phone') }}">
                            @if ($errors->has('phone'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <input id="password" type="password"
                                   class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                   name="password" required
                                   placeholder="{{ trans('plugins/real-estate::dashboard.password') }}">
                                    <span style="  float: right;
                                    margin-left: -25px;
                                    margin-top: -26px;
                                    position: relative;
                                    font-size: large;
                                    z-index: 2;"  class="fa fa-fw fa-eye-slash viewpass mr-4 text-muted" onclick="handle('password')" id="eyeicon"></span>
                            @if ($errors->has('password'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <input id="password-confirm" type="password" class="form-control"
                                   name="password_confirmation" required
                                   placeholder="{{ trans('plugins/real-estate::dashboard.password-confirmation') }}">
                                   <span style="  float: right;
                                    margin-left: -25px;
                                    margin-top: -26px;
                                    position: relative;
                                    font-size: large;
                                    z-index: 2;" class="fa fa-fw fa-eye-slash viewpass mr-4 text-muted" onclick="handle('confirm_password')" id="eyeicon_confirm"></span>
                        </div>

                        @if (is_plugin_active('captcha') && setting('enable_captcha') && setting('real_estate_enable_recaptcha_in_register_page', 0))
                            <div class="form-group mb-3 captcha">
                                {!! Captcha::display() !!}
                                <span id="captcha_jq" value=""></span>
                            </div>

                        @endif

                        <div class="form-group">
                            <button type="submit" class="btn btn-blue btn-full fw6">
                                {{ trans('plugins/real-estate::dashboard.register-cta') }}
                            </button>
                        </div>

                        <div class="form-group text-center">
                            <button type="reset" id="reset" value="Reset" class="btn btn-blue btn-full fw6" style="width:50px;display: none">
                                <i class="fas fa-retweet-alt"></i>
                            </button>
                        </div>

                        <div class="form-group text-center">
                            <p>{{ __('Have an account already?') }} <a href="{{ route('public.account.login') }}" class="d-block d-sm-inline-block text-sm-left text-center">{{ __('Login') }}</a></p>
                        </div>

                        <div class="text-center">
                            {!! apply_filters(BASE_FILTER_AFTER_LOGIN_OR_REGISTER_FORM, null, \Botble\RealEstate\Models\Account::class) !!}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.4/jquery.validate.min.js"></script>

<script>
    function handle(type) {
        if(type == 'password'){
            var password = document.getElementById('password')
            var eyeicon = $('#eyeicon')
        }
        else{
            var password = document.getElementById('password-confirm')
            var eyeicon = $('#eyeicon_confirm')
        }

        if (password.type == "password") {
            password.type = "text"
            eyeicon.removeClass('fa-eye-slash').addClass('fa-eye');
        } else {
            password.type = "password"
            eyeicon.removeClass('fa-eye').addClass('fa-eye-slash');
        }
    }

    $(document).ready(function(){
    $("#register_form").validate({

        rules: {
            first_name: {
                required: true,
                maxlength: 50
            },

            last_name: {
                required: true,
            },

            username: {
                required: true,
            },

            email: {
                required: true,
            },

            phone: {
                required: true,
                number: true,
                minlength:10,
                maxlength:10,
            },
            password: {
                required: true,
                minlength: 6
            },
            password_confirmation: {
                required: true,
                minlength: 6
            },

        },
        messages: {
            first_name: {
                required: "First Name is required.",
            },
            last_name: {
                required: "Last Name is required.",
            },
            username: {
                required: "Username is required.",
            },
            email: {
                required: "Email is required.",
            },
            phone: {
                required: "Phone Number is required.",
            },
            password: {
                required: "Password is required.",
            },
            password_confirmation: {
                required: "Confirm-Password is required.",
            },
        },

    });
    $('#register_form').on('submit', function(e) {
        if (grecaptcha.getResponse() == "") {
            e.preventDefault();
            $('#captcha_jq').text('Captcha is Invalid.');
            $('#captcha_jq').css("color", "red");
            $('#captcha_jq').css("font-size", "12px");
        } else {
            $('#captcha_jq').hide();
        }
    });
    });

    $(document).ready(function(){
    $('#register_form input').keyup(function(){
        $('#reset').show();
            $('#reset').click(function(){
                $(this).hide();
                $("form"). validate(). resetForm();
                $('#captcha_jq').hide();
            })
    })
    });
 </script>

