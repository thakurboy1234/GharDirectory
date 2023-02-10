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
            'full_name' => 'required|max:120',
            'company_name' => 'required|max:120',
            'phone' => 'sometimes|' . BaseHelper::getPhoneValidationRule(),
            'dob' => 'max:20|sometimes',
        ];
    }
}
