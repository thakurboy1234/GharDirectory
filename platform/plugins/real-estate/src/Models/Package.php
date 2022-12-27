<?php

namespace Botble\RealEstate\Models;

use Botble\Base\Traits\EnumCastable;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Package extends BaseModel
{
    use EnumCastable;

    protected $table = 're_packages';

    protected $fillable = [
        'name',
        'price',
        'currency_id',
        'percent_save',
        'number_of_listings',
        'account_limit',
        'order',
        'is_default',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class)->withDefault();
    }

    public function accounts(): BelongsToMany
    {
        return $this->belongsToMany(Account::class, 're_account_packages', 'package_id', 'account_id');
    }
}
