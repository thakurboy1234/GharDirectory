<?php

namespace Botble\RealEstate\Http\Requests;

use Botble\Support\Http\Requests\Request;

class AccountChangeAvatarRequest extends Request
{
    public function rules(): array
    {
        return [
            'avatar' => 'required|image|mimes:jpg,jpeg,png',
        ];
    }
}
