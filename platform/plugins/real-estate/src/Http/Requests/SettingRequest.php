<?php

namespace Botble\RealEstate\Http\Requests;

use BaseHelper;
use Botble\Support\Http\Requests\Request;

class SettingRequest extends Request
{
    public function rules(): array
    {
        return [
            'username' => 'required|max:60|min:2|unique:re_accounts,username,' . auth('account')->id(),
            'first_name' => 'required|max:120',
            'last_name' => 'required|max:120',
            'phone' => 'sometimes|' . BaseHelper::getPhoneValidationRule(),
            'dob' => 'max:20|sometimes',
        ];
    }
}
