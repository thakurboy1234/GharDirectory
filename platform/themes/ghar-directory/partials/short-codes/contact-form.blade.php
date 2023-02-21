<div id="contact">
    <div class="row">
        <div class="col-md-6">
            <div class="wrapper"><h2 class="h2">{{ __('Contact information') }}</h2>
                <div class="contact-main">
                    {{-- <p>{{ theme_option('about-us') }}</p> --}}
                    <div class="contact-name" style="text-transform: uppercase">{{ theme_option('company_name') }}</div>
                    <div class="address_row contact-address">
                        <span class="icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </span>
                        <p>
                            <span class="heading">{{ __('Address') }}:</span>
                            <span class="text">{{ theme_option('address') }}</span>
                        </p>
                    </div>
                    <div class="address_row contact-phone">
                        <span class="icon">
                            <i class="fas fa-phone-alt"></i>
                        </span>
                        <p>
                            <span class="heading">{{ __('Hotline') }}:</span>
                            <span class="text">{{ theme_option('hotline') }}</span>
                        </p>
                    </div>
                    <div class="address_row contact-email">
                        <span class="icon">
                            <i class="fas fa-paper-plane"></i>
                        </span>
                        <p>
                            <span class="heading">{{ __('Email') }}:</span>
                            <span class="text">{{ theme_option('email') }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <form action="{{ route('public.send.contact') }}" method="post" class="generic-form">
                <div class="wrapper">
                    <h2 class="h2">{{ __('HOW WE CAN HELP YOU?') }}</h2>
                    @csrf
                    {!! apply_filters('pre_contact_form', null) !!}

                    <div class="form-group">
                        <input class="form-control" type="text" name="name" placeholder="{{ __('Name') }} *"
                               required="">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="text" name="email"
                               placeholder="{{ __('Email') }} *" required="">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="text" name="phone"
                               placeholder="{{ __('Phone') }}">
                    </div>
                    <div class="form-group">
                                <textarea class="form-control" name="content" rows="6" minlength="10"
                                              placeholder="{{ __('Message') }} *" required=""></textarea>
                    </div>
                    @if (is_plugin_active('captcha'))
                        @if (setting('enable_captcha'))
                            <div class="form-group">
                                {!! Captcha::display() !!}
                            </div>
                        @endif

                        @if (setting('enable_math_captcha_for_contact_form', 0))
                                <div class="form-group">
                                {!! app('math-captcha')->input(['class' => 'form-control', 'id' => 'math-group', 'placeholder' => app('math-captcha')->label()]) !!}
                            </div>
                        @endif
                    @endif

                    {!! apply_filters('after_contact_form', null) !!}

                    <div class="alert alert-success text-success text-left" style="display: none;">
                        <span></span>
                    </div>
                    <div class="alert alert-danger text-danger text-left" style="display: none;">
                        <span></span>
                    </div>
                    <br>
                    <div class="form-actions">
                        <button class="btn-special" type="submit">{{ __('Send message') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
