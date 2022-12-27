<?php

namespace Botble\Analytics\Providers;

use Botble\Analytics\Analytics;
use Botble\Analytics\AnalyticsClient;
use Botble\Analytics\AnalyticsClientFactory;
use Botble\Analytics\Abstracts\AnalyticsAbstract;
use Botble\Analytics\Facades\AnalyticsFacade;
use Botble\Analytics\GA4\Analytics as AnalyticsGA4;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Botble\Analytics\Exceptions\InvalidConfiguration;

class AnalyticsServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(AnalyticsClient::class, function () {
            return AnalyticsClientFactory::createForConfig(config('plugins.analytics.general'));
        });

        $this->app->bind(AnalyticsAbstract::class, function () {
            $propertyId = setting('analytics_view_id') ?: setting('analytics_property_id');

            if (empty($propertyId)) {
                throw InvalidConfiguration::propertyIdNotSpecified();
            }

            $credentials = setting('analytics_service_account_credentials');

            if (! $credentials) {
                throw InvalidConfiguration::credentialsIsNotValid();
            }

            if (setting('analytics_property_id')) {
                return new AnalyticsGA4($propertyId, $credentials);
            }

            return new Analytics($this->app->make(AnalyticsClient::class), $propertyId);
        });

        AliasLoader::getInstance()->alias('Analytics', AnalyticsFacade::class);
    }

    public function boot()
    {
        $this->setNamespace('plugins/analytics')
            ->loadAndPublishConfigurations(['general', 'permissions'])
            ->loadRoutes()
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->publishAssets();

        $this->app->booted(function () {
            $this->app->register(HookServiceProvider::class);
        });
    }
}
