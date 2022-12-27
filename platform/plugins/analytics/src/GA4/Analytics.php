<?php

namespace Botble\Analytics\GA4;

use Botble\Analytics\Abstracts\AnalyticsAbstract;
use Botble\Analytics\GA4\Traits\CustomAcquisitionTrait;
use Botble\Analytics\GA4\Traits\CustomDemographicsTrait;
use Botble\Analytics\GA4\Traits\CustomEngagementTrait;
use Botble\Analytics\GA4\Traits\CustomRetentionTrait;
use Botble\Analytics\GA4\Traits\CustomTechTrait;
use Botble\Analytics\GA4\Traits\DateRangeTrait;
use Botble\Analytics\GA4\Traits\DimensionTrait;
use Botble\Analytics\GA4\Traits\FilterByDimensionTrait;
use Botble\Analytics\GA4\Traits\FilterByMetricTrait;
use Botble\Analytics\GA4\Traits\MetricAggregationTrait;
use Botble\Analytics\GA4\Traits\MetricTrait;
use Botble\Analytics\GA4\Traits\OrderByDimensionTrait;
use Botble\Analytics\GA4\Traits\OrderByMetricTrait;
use Botble\Analytics\GA4\Traits\ResponseTrait;
use Botble\Analytics\GA4\Traits\RowOperationTrait;
use Botble\Analytics\Period;
use Google\Analytics\Data\V1beta\BetaAnalyticsDataClient;
use Illuminate\Support\Collection;

class Analytics extends AnalyticsAbstract
{
    use DateRangeTrait;
    use MetricTrait;
    use DimensionTrait;
    use OrderByMetricTrait;
    use OrderByDimensionTrait;
    use MetricAggregationTrait;
    use FilterByDimensionTrait;
    use FilterByMetricTrait;
    use RowOperationTrait;
    use CustomAcquisitionTrait;
    use CustomEngagementTrait;
    use CustomRetentionTrait;
    use CustomDemographicsTrait;
    use CustomTechTrait;
    use ResponseTrait;

    public array $orderBys = [];

    public function __construct(int $propertyId, string $credentials)
    {
        $this->propertyId = $propertyId;
        $this->credentials = $credentials;
    }

    public function getCredentials(): string
    {
        return $this->credentials;
    }

    public function getClient(): BetaAnalyticsDataClient
    {
        return new BetaAnalyticsDataClient([
            'credentials' => $this->getCredentials(),
        ]);
    }

    public function get(): AnalyticsResponse
    {
        $response = $this->getClient()->runReport([
            'property' => 'properties/' . $this->getPropertyId(),
            'dateRanges' => $this->dateRanges,
            'metrics' => $this->metrics,
            'dimensions' => $this->dimensions,
            'orderBys' => $this->orderBys,
            'metricAggregations' => $this->metricAggregations,
            'dimensionFilter' => $this->dimensionFilter,
            'metricFilter' => $this->metricFilter,
            'limit' => $this->limit,
            'offset' => $this->offset,
            'keepEmptyRows' => $this->keepEmptyRows,
        ]);

        return $this->formatResponse($response);
    }

    public function fetchVisitorsAndPageViews(Period $period): Collection
    {
        return $this->dateRange($period)
            ->metrics('screenPageViews', 'totalUsers')
            ->dimensions('pageTitle', 'fullPageUrl')
            ->get()
            ->table;
    }

    public function fetchTotalVisitorsAndPageViews(Period $period): Collection
    {
        return $this->dateRange($period)
            ->metrics('screenPageViews', 'totalUsers')
            ->dimensions('pageTitle', 'fullPageUrl')
            ->get()
            ->table;
    }

    public function fetchMostVisitedPages(Period $period, int $maxResults = 20): Collection
    {
        return $this->dateRange($period)
            ->metrics('screenPageViews')
            ->dimensions('pageTitle', 'fullPageUrl')
            ->orderByMetricDesc('screenPageViews')
            ->limit($maxResults)
            ->get()
            ->table;
    }

    public function fetchTopReferrers(Period $period, int $maxResults = 20): Collection
    {
        // TODO: Implement fetchTopReferrers() method.
    }

    public function fetchUserTypes(Period $period): Collection
    {
        // TODO: Implement fetchUserTypes() method.
    }

    public function fetchTopBrowsers(Period $period, int $maxResults = 10): Collection
    {
        return $this->dateRange($period)
            ->metrics('totalUsers')
            ->dimensions('browser')
            ->orderByMetricDesc('totalUsers')
            ->get()
            ->table;
    }
}
