<?php

use Botble\LanguageAdvanced\Models\PageTranslation;
use Botble\Page\Models\Page;
use Illuminate\Database\Migrations\Migration;

class ImproveHomepageSearchBox extends Migration
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

            $homepageDescription = theme_option('home_banner_description');
            $homepageBanner = theme_option('home_banner');
            $enableProjectsSearch = theme_option('enable_search_projects_on_homepage_search', 'yes');
            $defaultSearchType = theme_option('default_home_search_type', 'project');

            $searchBox = '[search-box title="' . $homepageDescription .'" background_image="' . $homepageBanner . '" enable_search_projects_on_homepage_search="' . $enableProjectsSearch . '" default_home_search_type="' . $defaultSearchType . '"][/search-box]';

            if ($homepage) {
                if (!str_contains($homepage->content, '[search-box title="')) {
                    $homepage->content = $searchBox . $homepage->content;
                    $homepage->save();
                }

                try {
                    if (is_plugin_active('language') && is_plugin_active('language-advanced')) {
                        foreach ($homepage->translations()->get() as $translation) {
                            if (!str_contains($translation->content, '[search-box title="')) {
                                $searchBox = '[search-box title="' . (theme_option($translation->lang_code . '-home_banner_description') ?: $homepageDescription)  .'" background_image="' . (theme_option($translation->lang_code . '-home_banner') ?: $homepageBanner) . '" enable_search_projects_on_homepage_search="' . (theme_option($translation->lang_code . '-enable_search_projects_on_homepage_search', 'yes') ?: $enableProjectsSearch) . '" default_home_search_type="' . (theme_option($translation->lang_code . '-default_home_search_type', 'project') ?: $defaultSearchType) . '"][/search-box]';

                                PageTranslation::where('pages_id', $homepageId)
                                    ->where('lang_code', $translation->lang_code)
                                    ->update(['content' => $searchBox . $translation->content]);
                            }
                        }
                    }
                } catch (Throwable $exception) {
                    info($exception->getMessage());
                }
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
