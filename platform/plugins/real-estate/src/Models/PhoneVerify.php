<?php

namespace Botble\RealEstate\Models;

use Botble\Base\Models\BaseModel;

class PhoneVerify extends BaseModel
{


    protected $table = 'phone_number_verify_otps';

    protected $fillable = [
        'otp',
        'user_id',
        'status',
    ];

}
