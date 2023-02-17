<?php

namespace Botble\RealEstate\Http\Requests;

use Botble\Support\Http\Requests\Request;

class AccountEditRequest extends Request
{
    public function rules(): array
    {
        $rules = [
            // 'first_name' => 'required|max:120|min:2',
            // 'last_name' => 'required|max:120|min:2',
            // 'username' => 'required|max:60|min:2|unique:re_accounts,username,' . $this->route('account'),
            'fff_name' => 'required|max:120|min:2',
            'email' => 'required|max:60|min:6|email|unique:re_accounts,email,' . $this->route('account'),
            'phone' => 'required',
            'city_id' => 'required',

        ];

        if ($this->input('is_change_password') == 1) {
            $rules['password'] = 'required|min:6|confirmed';
        }

        return $rules;
    }
}
