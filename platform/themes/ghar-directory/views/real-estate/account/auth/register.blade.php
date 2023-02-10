
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
                        <div class="form-group mb-3">
                            <input id="fff_name" type="text"
                                   class="form-control{{ $errors->has('fff_name') ? ' is-invalid' : '' }}"
                                   name="fff_name" value="{{ old('fff_name') }}" required autofocus
                                   placeholder="{{ trans('plugins/real-estate::dashboard.fff_name') }}">
                            @if ($errors->has('fff_name'))
                                <span class="invalid-feedback">
                                <strong>{{ $errors->first('fff_name') }}</strong>
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
                            <input id="company" type="text"
                                   class="form-control{{ $errors->has('company') ? ' is-invalid' : '' }}"
                                   name="company" value="{{ old('company') }}"
                                   placeholder="{{ trans('plugins/real-estate::dashboard.company') }}">
                            @if ($errors->has('company'))
                                <span class="invalid-feedback">
                                <strong>{{ $errors->first('company') }}</strong>
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
                        <div class="form-group mb-3">
                            <input id="alternate_mobile_number" type="text"
                                   class="form-control{{ $errors->has('alternate_mobile_number') ? ' is-invalid' : '' }}"
                                   name="alternate_mobile_number" value="{{ old('alternate_mobile_number') }}"
                                   placeholder="{{ trans('plugins/real-estate::dashboard.alternate_mobile_number') }}">
                            @if ($errors->has('alternate_mobile_number'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('alternate_mobile_number') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <select name="city_id" class="form-control">
                                <option value="">Select City</option>
                                @if(count($cities))
                                    @foreach($cities as $key => $city)
                                    <option value="{{$city->id}}">{{$city->name}}</option>
                                    @endforeach
                                @endif
                            </select>

                        </div>

                        <div class="form-group">
                            <input id="password" type="password"
                                   class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                   name="password" required
                                   placeholder="{{ trans('plugins/real-estate::dashboard.password') }}">
                                    <span class="fa fa-fw fa-eye-slash viewpass mr-4 text-muted" onclick="handle('password')" id="eyeicon"></span>
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
                                   <span class="fa fa-fw fa-eye-slash viewpass mr-4 text-muted" onclick="handle('confirm_password')" id="eyeicon_confirm"></span>
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
            fff_name: {
                required: true,
                maxlength: 50
            },

            // last_name: {
            //     required: true,
            // },

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
            city_id: {
                required: true,
            },

        },
        messages: {
            fff_name: {
                required: "Full Name is required.",
            },
            // company: {
            //     required: "Last Name is required.",
            // },
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

