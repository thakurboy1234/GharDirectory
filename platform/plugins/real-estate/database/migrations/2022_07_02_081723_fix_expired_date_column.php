<?php

use Botble\RealEstate\Models\Property;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $properties = Property::whereNull('expire_date')->get();

        foreach ($properties as $property) {
            $property->expire_date = $property->created_at->addDays(RealEstateHelper::propertyExpiredDays());
            $property->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
