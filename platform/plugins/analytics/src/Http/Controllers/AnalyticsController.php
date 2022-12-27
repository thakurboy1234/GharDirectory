<?php

namespace Botble\Analytics\Http\Controllers;

use Analytics;
use Botble\Analytics\Exceptions\InvalidConfiguration;
use Botble\Analytics\Period;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Dashboard\Supports\DashboardWidgetInstance;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class AnalyticsController extends BaseController
{
    public function getGeneral(Request $request, BaseHttpResponse $response)
    {
        $dashboardInstance = new DashboardWidgetInstance();
        $predefinedRangeFound = $dashboardInstance->getFilterRange($request->input('predefined_range'));
        if ($request->input('changed_predefined_range')) {
            $dashboardInstance->saveSettings(
                'widget_analytics_general',
                ['predefined_range' => $predefinedRangeFound['key']]
            );
        }

        $startDate = $predefinedRangeFound['startDate'];
        $endDate = $predefinedRangeFound['endDate'];
        $dimensions = $this->getDimension($predefinedRangeFound['key']);

        try {
            $period = Period::create($startDate, $endDate);

            $visitorData = [];

            $answer = Analytics::performQuery($period, 'ga:visits,ga:pageviews', ['dimensions' => 'ga:' . $dimensions]);

            if ($answer->rows == null) {
                $answer->rows = [];
            }

            foreach ($answer->rows as $dateRow) {
                $visitorData[] = [
                    'axis' => $this->getAxisByDimensions($dateRow[0], $dimensions),
                    'visitors' => $dateRow[1],
                    'pageViews' => $dateRow[2],
                ];
            }

            $stats = collect($visitorData);
            $country_stats = Analytics::performQuery(
                $period,
                'ga:sessions',
                ['dimensions' => 'ga:countryIsoCode']
            )->rows;
            $total = Analytics::performQuery(
                $period,
                'ga:sessions, ga:users, ga:pageviews, ga:percentNewSessions, ga:bounceRate, ga:pageviewsPerVisit, ga:avgSessionDuration, ga:newUsers'
            )->totalsForAllResults;

            return $response->setData(
                view(
                    'plugins/analytics::widgets.general',
                    compact('stats', 'country_stats', 'total')
                )->render()
            );
        } catch (InvalidConfiguration) {
            return $response
                ->setError()
                ->setMessage(trans('plugins/analytics::analytics.wrong_configuration'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    protected function getAxisByDimensions(string $dateRow, string $dimensions = 'hour'): string
    {
        return match ($dimensions) {
            'date' => Carbon::parse($dateRow)->toDateString(),
            'yearMonth' => Carbon::createFromFormat('Ym', $dateRow)->format('Y-m'),
            default => (int)$dateRow . 'h',
        };
    }

    protected function getDimension(string $key): string
    {
        $data = [
            'this_week' => 'date',
            'last_7_days' => 'date',
            'this_month' => 'date',
            'last_30_days' => 'date',
            'this_year' => 'yearMonth',
        ];

        return Arr::get($data, $key, 'hour');
    }

    public function getTopVisitPages(Request $request, BaseHttpResponse $response)
    {
        $dashboardInstance = new DashboardWidgetInstance();
        $predefinedRangeFound = $dashboardInstance->getFilterRange($request->input('predefined_range'));

        if ($request->input('changed_predefined_range')) {
            $dashboardInstance->saveSettings(
                'widget_analytics_page',
                ['predefined_range' => $predefinedRangeFound['key']]
            );
        }

        $startDate = $predefinedRangeFound['startDate'];
        $endDate = $predefinedRangeFound['endDate'];

        try {
            $period = Period::create($startDate, $endDate);
            $pages = Analytics::fetchMostVisitedPages($period, 10);

            return $response->setData(view('plugins/analytics::widgets.page', compact('pages'))->render());
        } catch (InvalidConfiguration) {
            return $response
                ->setError()
                ->setMessage(trans('plugins/analytics::analytics.wrong_configuration'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    public function getTopBrowser(Request $request, BaseHttpResponse $response)
    {
        $dashboardInstance = new DashboardWidgetInstance();
        $predefinedRangeFound = $dashboardInstance->getFilterRange($request->input('predefined_range'));

        if ($request->input('changed_predefined_range')) {
            $dashboardInstance->saveSettings(
                'widget_analytics_browser',
                ['predefined_range' => $predefinedRangeFound['key']]
            );
        }

        $startDate = $predefinedRangeFound['startDate'];
        $endDate = $predefinedRangeFound['endDate'];

        try {
            $period = Period::create($startDate, $endDate);
            $browsers = Analytics::fetchTopBrowsers($period);

            return $response->setData(view('plugins/analytics::widgets.browser', compact('browsers'))->render());
        } catch (InvalidConfiguration) {
            return $response
                ->setError()
                ->setMessage(trans('plugins/analytics::analytics.wrong_configuration'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    public function getTopReferrer(Request $request, BaseHttpResponse $response)
    {
        $dashboardInstance = new DashboardWidgetInstance();
        $predefinedRangeFound = $dashboardInstance->getFilterRange($request->input('predefined_range'));

        if ($request->input('changed_predefined_range')) {
            $dashboardInstance->saveSettings(
                'widget_analytics_referrer',
                ['predefined_range' => $predefinedRangeFound['key']]
            );
        }

        $startDate = $predefinedRangeFound['startDate'];
        $endDate = $predefinedRangeFound['endDate'];

        try {
            $period = Period::create($startDate, $endDate);
            $referrers = Analytics::fetchTopReferrers($period, 10);

            return $response->setData(view('plugins/analytics::widgets.referrer', compact('referrers'))->render());
        } catch (InvalidConfiguration) {
            return $response
                ->setError()
                ->setMessage(trans('plugins/analytics::analytics.wrong_configuration'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }
}
