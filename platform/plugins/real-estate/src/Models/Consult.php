<?php

namespace Botble\RealEstate\Models;

use Botble\Base\Models\BaseModel;
use Botble\Base\Supports\Avatar;
use Botble\Base\Traits\EnumCastable;
use Botble\RealEstate\Enums\ConsultStatusEnum;
use Exception;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use RvMedia;

class Consult extends BaseModel
{
    use EnumCastable;

    protected $table = 're_consults';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'content',
        'project_id',
        'property_id',
        'status',
    ];

    protected $casts = [
        'status' => ConsultStatusEnum::class,
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    protected function avatarUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                try {
                    return (new Avatar())->create($this->name)->toBase64();
                } catch (Exception) {
                    return RvMedia::getDefaultImage();
                }
            },
        );
    }
}
