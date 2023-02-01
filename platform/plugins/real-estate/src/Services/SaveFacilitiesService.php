<?php

namespace Botble\RealEstate\Services;

use Botble\RealEstate\Models\Project;
use Botble\RealEstate\Models\Property;

class SaveFacilitiesService
{
    public function execute(Property|Project $item, array|string|null $facilities): void
    {
        if (! $facilities || ! is_array($facilities)) {
            return;
        }

        $item->facilities()->detach();

        foreach ($facilities as $facility) {
            // dd( $facility['distance'].$facility['distance_unit']);

            if (empty($facility['id'])) {
                continue;
            }
            $unit='';
            if(isset($facility['distance_unit'])){
                $unit=$facility['distance_unit'];
            }
                      

            $item->facilities()->attach($facility['id'], ['distance' => $facility['distance'].' '.$unit]);
        }

        return;
    }
}
