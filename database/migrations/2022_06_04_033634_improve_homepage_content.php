<?php

use Botble\Page\Models\Page;
use Illuminate\Database\Migrations\Migration;

class ImproveHomepageContent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $homepageId = BaseHelper::getHomepageId();

        if ($homepageId) {
            $homepage = Page::find($homepageId);

            if ($homepage) {
                $homepage->content = str_replace('[featured-projects][/featured-projects]', '[featured-projects title="' . __('Featured projects') . '" subtitle="' . theme_option('home_project_description') . '"][/featured-projects]', $homepage->content);
                $homepage->content = str_replace('[properties-by-locations][/properties-by-locations]', '[properties-by-locations title="' . __('Properties by locations') . '" subtitle="' . theme_option('home_description_for_properties_by_locations') . '"][/properties-by-locations]', $homepage->content);
                $homepage->content = str_replace('[properties-for-sale][/properties-for-sale]', '[properties-for-sale title="' . __('Properties For Sale') . '" subtitle="' . theme_option('home_description_for_properties_for_sale') . '"][/properties-for-sale]', $homepage->content);
                $homepage->content = str_replace('[properties-for-rent][/properties-for-rent]', '[properties-for-rent title="' . __('Properties For Rent') . '" subtitle="' . theme_option('home_description_for_properties_for_rent') . '"][/properties-for-rent]', $homepage->content);
                $homepage->content = str_replace('[latest-news][/latest-news]', '[latest-news title="' . __('News') . '" subtitle="' . theme_option('home_description_for_news') . '"][/latest-news]', $homepage->content);

                $homepage->save();
            }
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
}
