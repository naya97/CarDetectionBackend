<?php

namespace App\Services\Dashboard;

use App\Models\Detection;
use App\Models\DetectionAlert;
use App\Models\PoliceUnit;

class DashboardStatsService
{
    public function getPoliceUnitStats(): array
    {
        $total = PoliceUnit::count();
        $active = PoliceUnit::active()->count();

        return [
            'active' => $active,
            'total' => $total,
            'percentage' => $total > 0 ? round(($active / $total) * 100, 1) : 0.0,
        ];
    }

    public function getScansTodayStats(): array
    {
        return $this->buildComparisonStat(
            Detection::today()->count(),
            Detection::yesterday()->count()
        );
    }

    public function getWantedVehiclesStats(): array
    {
        return $this->buildComparisonStat(
            Detection::today()->wanted()->count(),
            Detection::yesterday()->wanted()->count()
        );
    }

    public function getAlertsStats(): array
    {
        $today = DetectionAlert::today()->count();
        $thisWeek = DetectionAlert::thisWeek()->count();
        $lastWeek = DetectionAlert::query()
            ->whereBetween('created_at', [
                now()->subWeek()->startOfWeek(),
                now()->subWeek()->endOfWeek(),
            ])
            ->count();

        return [
            'today' => $today,
            'this_week' => $thisWeek,
            'change_percentage' => $this->calculatePercentageChange($thisWeek, $lastWeek),
            'trend' => $this->resolveTrend($thisWeek, $lastWeek),
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
