<?php

namespace Botble\Career\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class CareerRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'required',
            'location' => 'required',
            'salary' => 'required',
            'description' => 'max:400',
            'content' => 'required',
            'status' => Rule::in(BaseStatusEnum::values()),
        ];
    }
}
