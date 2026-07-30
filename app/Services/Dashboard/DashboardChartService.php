<?php

namespace App\Services\Dashboard;

use App\Models\Detection;
use Illuminate\Database\Eloquent\Builder;

class DashboardChartService
{
    public function getScansTrend(int $days = 7): array
    {
        $start = today()->subDays($days - 1);
        $end = today();

        $counts = Detection::query()
            ->betweenDates($start->copy()->startOfDay(), $end->copy()->endOfDay())
            ->selectRaw('DATE(detected_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');

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

        // $total = Detection::betweenDates($start, $end)->count();
        // $matched = Detection::betweenDates($start, $end)->matched()->count();

        $stats = Detection::query()
            ->betweenDates($start, $end)
            ->selectRaw("
                COUNT(*) as total,
                SUM(CASE WHEN match_status = 'match' THEN 1 ELSE 0 END) as matched
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

    private function getDistribution(string $column, int $days): array
    {
        $start = today()->subDays($days - 1)->startOfDay();
        $end = today()->endOfDay();

        $rows = Detection::betweenDates($start, $end)
            ->whereNotNull($column)
            ->selectRaw("{$column} as label, COUNT(*) as count")
            ->groupBy($column)
            ->orderByDesc('count')
            ->get();

        $total = $rows->sum('count');

        return $rows->map(fn ($row) => [
            'label' => $row->label,
            'count' => $row->count,
            'percentage' => $total > 0 ? round(($row->count / $total) * 100, 1) : 0.0,
        ])->all();
    }
}
