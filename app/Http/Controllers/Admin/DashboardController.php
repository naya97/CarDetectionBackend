<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\DashboardChartResource;
use App\Http\Resources\Dashboard\DashboardStatsResource;
use App\Services\Dashboard\DashboardChartService;
use App\Services\Dashboard\DashboardStatsService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        private readonly DashboardStatsService $statsService,
        private readonly DashboardChartService $chartService,
    ) {}

    public function stats()
    {
        return new DashboardStatsResource([
            'videos' => $this->statsService->getVideoStats(),
            'detections_today' => $this->statsService->getDetectionsTodayStats(),
            'violations_today' => $this->statsService->getViolationsTodayStats(),
            'wanted_vehicles' => $this->statsService->getWantedVehiclesStats(),
            'overview' => $this->statsService->getOverviewStats(),
        ]);
    }

    public function charts(Request $request)
    {
        $days = (int) $request->query('days', 7);

        return new DashboardChartResource([
            'detections_trend' => $this->chartService->getDetectionsTrend($days),
            'violations_trend' => $this->chartService->getViolationsTrend($days),
            'color_distribution' => $this->chartService->getColorDistribution($days),
            'type_distribution' => $this->chartService->getTypeDistribution($days),
            'match_rate' => $this->chartService->getMatchRate($days),
            'severity_distribution' => $this->chartService->getSeverityDistribution($days),
        ]);
    }
}
