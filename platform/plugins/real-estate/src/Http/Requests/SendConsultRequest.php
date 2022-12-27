<?php

namespace Botble\RealEstate\Http\Requests;

use Botble\Support\Http\Requests\Request;

class SendConsultRequest extends Request
{
    public function rules(): array
    {
        if (setting('enable_captcha') && is_plugin_active('captcha')) {
            return [
                'name' => 'required',
                'email' => 'required|email',
                'content' => 'required',
                'g-recaptcha-response' => 'required|captcha',
            ];
        }

        return [
            'name' => 'required',
            'email' => 'required|email',
            'content' => 'required',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => trans('plugins/real-estate::consult.form.name.required'),
            'email.required' => trans('plugins/real-estate::consult.form.email.required'),
            'email.email' => trans('plugins/real-estate::consult.form.email.email'),
            'content.required' => trans('plugins/real-estate::consult.form.content.required'),
            'g-recaptcha-response.required' => trans('plugins/real-estate::consult.form.g-recaptcha-response.required'),
            'g-recaptcha-response.captcha' => trans('plugins/real-estate::consult.form.g-recaptcha-response.captcha'),
        ];
    }
}
