<?php

namespace App\Services\Dashboard;

use App\Models\Detection;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardChartService
{
    public function getDetectionsTrend(int $days = 7): array
    {
        return $this->getTrend('detected_at', $days);
    }

    public function getViolationsTrend(int $days = 7): array
    {
        $start = today()->subDays($days - 1);
        $end = today();

        $counts = Detection::query()
            ->whereNotNull('violation_type')
            ->whereBetween('detected_at', [$start->copy()->startOfDay(), $end->copy()->endOfDay()])
            ->selectRaw('DATE(detected_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');

        return $this->buildTrendArray($start, $end, $counts);
    }

    public function getColorDistribution(int $days = 7): array
    {
        return $this->getDistribution('detected_color', $days);
    }

    public function getTypeDistribution(int $days = 7): array
    {
        return $this->getDistribution('detected_type', $days);
    }

    public function getMatchRate(int $days = 7): array
    {
        $start = today()->subDays($days - 1)->startOfDay();
        $end = today()->endOfDay();

        $stats = Detection::query()
            ->whereBetween('detected_at', [$start, $end])
            ->selectRaw("
                COUNT(*) as total,
                SUM(CASE WHEN plate_match = true THEN 1 ELSE 0 END) as matched
            ")
            ->first();

        $total = (int) $stats->total;
        $matched = (int) $stats->matched;
        $unmatched = $total - $matched;

        return [
            'matched' => $matched,
            'unmatched' => $unmatched,
            'matched_percentage' => $total > 0 ? round(($matched / $total) * 100, 1) : 0.0,
            'unmatched_percentage' => $total > 0 ? round((($total - $matched) / $total) * 100, 1) : 0.0,
        ];
    }

    public function getSeverityDistribution(int $days = 7): array
    {
        $start = today()->subDays($days - 1)->startOfDay();
        $end = today()->endOfDay();

        $rows = Detection::query()
            ->whereBetween('detected_at', [$start, $end])
            ->whereNotNull('severity')
            ->selectRaw('severity as label, COUNT(*) as count')
            ->groupBy('severity')
            ->orderByDesc('count')
            ->get();

        $total = $rows->sum('count');

        return $rows->map(fn($row) => [
            'label' => $row->label,
            'count' => $row->count,
            'percentage' => $total > 0 ? round(($row->count / $total) * 100, 1) : 0.0,
        ])->all();
    }

    private function getTrend(string $column, int $days): array
    {
        $start = today()->subDays($days - 1);
        $end = today();

        $counts = Detection::query()
            ->whereBetween($column, [$start->copy()->startOfDay(), $end->copy()->endOfDay()])
            ->selectRaw('DATE(' . $column . ') as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');

        return $this->buildTrendArray($start, $end, $counts);
    }

    private function buildTrendArray(Carbon $start, Carbon $end, $counts): array
    {
        $trend = [];
        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $key = $date->toDateString();
            $trend[] = [
                'date' => $key,
                'count' => (int) ($counts[$key] ?? 0),
            ];
        }
        return $trend;
    }

    private function getDistribution(string $column, int $days): array
    {
        $start = today()->subDays($days - 1)->startOfDay();
        $end = today()->endOfDay();

        $rows = Detection::query()
            ->whereBetween('detected_at', [$start, $end])
            ->whereNotNull($column)
            ->selectRaw("{$column} as label, COUNT(*) as count")
            ->groupBy($column)
            ->orderByDesc('count')
            ->get();

        $total = $rows->sum('count');

        return $rows->map(fn($row) => [
            'label' => $row->label,
            'count' => $row->count,
            'percentage' => $total > 0 ? round(($row->count / $total) * 100, 1) : 0.0,
        ])->all();
    }
}
