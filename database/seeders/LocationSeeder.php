<?php

namespace Database\Seeders;

use Botble\Location\Models\City;
use Botble\Location\Models\CityTranslation;
use Botble\Location\Models\Country;
use Botble\Location\Models\CountryTranslation;
use Botble\Location\Models\State;
use Botble\Location\Models\StateTranslation;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CityTranslation::truncate();
        StateTranslation::truncate();
        CountryTranslation::truncate();

        foreach (Country::get() as $country) {
            CountryTranslation::insertOrIgnore([
                'countries_id' => $country->id,
                'lang_code' => 'vi',
                'name' => $country->name,
            ]);
        }

        foreach (State::get() as $state) {
            StateTranslation::insertOrIgnore([
                'states_id' => $state->id,
                'lang_code' => 'vi',
                'name' => $state->name,
            ]);
        }

        foreach (City::get() as $city) {
            CityTranslation::insertOrIgnore([
                'cities_id' => $city->id,
                'lang_code' => 'vi',
                'name' => $city->name,
            ]);
        }
    }
}
