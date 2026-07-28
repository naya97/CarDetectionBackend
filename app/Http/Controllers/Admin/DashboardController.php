<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\AlertFeedResource;
use App\Http\Resources\Dashboard\DashboardChartResource;
use App\Http\Resources\Dashboard\DashboardStatsResource;
use App\Services\Dashboard\AlertFeedService;
use App\Services\Dashboard\DashboardChartService;
use App\Services\Dashboard\DashboardStatsService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        private readonly DashboardStatsService $statsService,
        private readonly DashboardChartService $chartService,
        private readonly AlertFeedService $alertFeedService,
    ) {
    }

    public function stats()
    {
        return new DashboardStatsResource([
            'active_police_units' => $this->statsService->getPoliceUnitStats(),
            'scans_today' => $this->statsService->getScansTodayStats(),
            'alerts' => $this->statsService->getAlertsStats(),
            'wanted_vehicles' => $this->statsService->getWantedVehiclesStats(),
        ]);
    }

    public function charts(Request $request)
    {
        $days = (int) $request->query('days', 7);

        return new DashboardChartResource([
            'scans_trend' => $this->chartService->getScansTrend($days),
            'color_distribution' => $this->chartService->getColorDistribution($days),
            'type_distribution' => $this->chartService->getTypeDistribution($days),
            'match_rate' => $this->chartService->getMatchRate($days),
        ]);
    }

    public function latestAlerts(Request $request)
    {
        $limit = (int) $request->query('limit', 5);

        return AlertFeedResource::collection(
            $this->alertFeedService->getLatest($limit)
        );
    }
}
