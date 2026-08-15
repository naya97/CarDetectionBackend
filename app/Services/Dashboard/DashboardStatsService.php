<?php

namespace App\Services\Dashboard;

use App\Models\Detection;
use App\Models\Video;
use Carbon\Carbon;

class DashboardStatsService
{
    public function getVideoStats(): array
    {
        $total = Video::count();
        $completed = Video::where('status', 'completed')->count();
        $processing = Video::where('status', 'processing')->count();
        $failed = Video::where('status', 'failed')->count();

        return [
            'total' => $total,
            'completed' => $completed,
            'processing' => $processing,
            'failed' => $failed,
            'completion_rate' => $total > 0 ? round(($completed / $total) * 100, 1) : 0.0,
        ];
    }

    public function getDetectionsTodayStats(): array
    {
        $today = Detection::whereDate('detected_at', today())->count();
        $yesterday = Detection::whereDate('detected_at', today()->subDay())->count();

        return $this->buildComparisonStat($today, $yesterday);
    }

    public function getViolationsTodayStats(): array
    {
        $today = Detection::whereDate('detected_at', today())
            ->whereNotNull('violation_type')
            ->count();
        $yesterday = Detection::whereDate('detected_at', today()->subDay())
            ->whereNotNull('violation_type')
            ->count();

        return $this->buildComparisonStat($today, $yesterday);
    }

    public function getWantedVehiclesStats(): array
    {
        $today = Detection::whereDate('detected_at', today())
            ->where('plate_mismatch', true)
            ->count();
        $yesterday = Detection::whereDate('detected_at', today()->subDay())
            ->where('plate_mismatch', true)
            ->count();

        return $this->buildComparisonStat($today, $yesterday);
    }

    public function getOverviewStats(): array
    {
        return [
            'total_videos' => Video::count(),
            'total_detections' => Detection::count(),
            'total_violations' => Detection::whereNotNull('violation_type')->count(),
            'high_violations' => Detection::where('severity', 'high')->count(),
        ];
    }

    private function buildComparisonStat(int $current, int $previous): array
    {
        return [
            'value' => $current,
            'previous_value' => $previous,
            'change_percentage' => $this->calculatePercentageChange($current, $previous),
            'trend' => $this->resolveTrend($current, $previous),
        ];
    }

    private function calculatePercentageChange(int $current, int $previous): float
    {
        if ($previous === 0) {
            return $current > 0 ? 100.0 : 0.0;
        }

        return round((($current - $previous) / $previous) * 100, 1);
    }

    private function resolveTrend(int $current, int $previous): string
    {
        return match (true) {
            $current > $previous => 'up',
            $current < $previous => 'down',
            default => 'neutral',
        };
    }
}
