<?php

namespace Botble\RealEstate\Supports;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\RealEstate\Enums\ModerationStatusEnum;
use Botble\RealEstate\Enums\ProjectStatusEnum;
use Botble\RealEstate\Enums\PropertyStatusEnum;

class RealEstateHelper
{
    public function isRegisterEnabled(): bool
    {
        return setting('real_estate_enabled_register', '1') == '1';
    }

    public function propertyExpiredDays(): int
    {
        $days = (int)setting('property_expired_after_days');

        if ($days > 0) {
            return $days;
        }

        return config('plugins.real-estate.real-estate.property_expired_after_x_days');
    }

    public function getPropertyRelationsQuery(): array
    {
        return [
            'slugable:id,key,prefix,reference_id',
            'city:id,name,state_id',
            'city.state:id,name,country_id',
            'currency:id,is_default,exchange_rate,symbol,title,is_prefix_symbol',
            'categories' => function ($query) {
                return $query->where('status', BaseStatusEnum::PUBLISHED)
                    ->orderBy('created_at', 'DESC')
                    ->orderBy('is_default', 'DESC')
                    ->orderBy('order', 'ASC')
                    ->select('re_categories.id', 're_categories.name');
            },
        ];
    }

    public function getProjectRelationsQuery(): array
    {
        return [
            'slugable:id,key,prefix,reference_id',
            'categories' => function ($query) {
                return $query->where('status', BaseStatusEnum::PUBLISHED)
                    ->orderBy('created_at', 'DESC')
                    ->orderBy('is_default', 'DESC')
                    ->orderBy('order', 'ASC')
                    ->select('re_categories.id', 're_categories.name');
            },
            'city:id,name,state_id',
            'city.state:id,name',
        ];
    }

    public function isEnabledCreditsSystem(): bool
    {
        return setting('real_estate_enable_credits_system', 1) == 1;
    }

    public function getThousandSeparatorForInputMask(): string
    {
        return ',';
    }

    public function getDecimalSeparatorForInputMask(): string
    {
        return '.';
    }

    public function getPropertyDisplayQueryConditions(): array
    {
        $conditions = [
            're_properties.moderation_status' => ModerationStatusEnum::APPROVED,
        ];

        foreach ($this->exceptedPropertyStatuses() as $status) {
            $conditions[] = ['re_properties.status', '!=', $status];
        }

        return $conditions;
    }

    public function getProjectDisplayQueryConditions(): array
    {
        $conditions = [];

        foreach ($this->exceptedProjectsStatuses() as $status) {
            $conditions[] = ['re_projects.status', '!=', $status];
        }

        return $conditions;
    }

    public function exceptedPropertyStatuses(): array
    {
        $statuses = setting('real_estate_hide_properties_in_statuses');

        if ($statuses) {
            return json_decode($statuses, true);
        }

        return [PropertyStatusEnum::NOT_AVAILABLE];
    }

    public function exceptedProjectsStatuses(): array
    {
        $statuses = setting('real_estate_hide_projects_in_statuses');

        if ($statuses) {
            return json_decode($statuses, true);
        }

        return [ProjectStatusEnum::NOT_AVAILABLE];
    }

    public function isEnabledWishlist(): bool
    {
        return setting('real_estate_enable_wishlist', '1') == '1';
    }
}
