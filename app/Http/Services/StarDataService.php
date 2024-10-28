<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class StarDataService {
    public function getStarData($sample = 'sample100')
    {
        $data = [];

        switch ($sample) {
            case 'sample1000':
                $json = file_get_contents(public_path('thefuck-sample-1000.json'));
                break;
            case 'sampleFull':
                $json = file_get_contents(public_path('thefuck-sample-full.json'));
                break;
            case 'sample100':
            default:
                $json = file_get_contents(public_path('thefuck-sample-100.json'));
                break;
        }

        $data = json_decode($json, true);
        return $data;
    }

    public function getHighlightedUsers($data)
    {
        $highlightedUsers = array_slice($data, 0, 5);

        return $highlightedUsers;
    }

    public function applyFilters(array $data, string $groupBy = 'day', string $type = 'cumulative', string $timeRange = 'all')
    {
        // Filtrar por intervalo de tempo
        $filteredData = $this->filterByTimeRange($data, $timeRange);

        // Agrupar por período especificado
        $groupedData = $this->groupByPeriod($filteredData, $groupBy);

        // Calcular valor cumulativo ou absoluto
        return $type === 'cumulative' ? $this->calculateCumulative($groupedData) : $groupedData;
    }

    private function filterByTimeRange(array $data, string $timeRange)
    {
        $endDate = Carbon::now();
        switch ($timeRange) {
            case '30_days':
                $startDate = $endDate->copy()->subDays(30);
                break;
            case '6_months':
                $startDate = $endDate->copy()->subMonths(6);
                break;
            case '1_year':
                $startDate = $endDate->copy()->subYear();
                break;
            default:
                return $data;
        }

        return array_filter($data, function ($star) use ($startDate, $endDate) {
            $starDate = Carbon::parse($star['starred_at']);
            return $starDate->between($startDate, $endDate);
        });
    }

    private function groupByPeriod(array $data, string $groupBy)
    {
        $grouped = [];
        foreach ($data as $star) {
            if (!isset($star['starred_at'])) {
                continue;
            }

            $date = Carbon::parse($star['starred_at']);
            $key = match($groupBy) {
                'day' => $date->format('Y-m-d'),
                'week' => $date->format('o-W'), // ISO-8601 week number
                'month' => $date->format('Y-m'),
                'year' => $date->format('Y'),
                default => $date->format('Y-m-d'),
            };
            $grouped[$key] = ($grouped[$key] ?? 0) + 1;
        }
        return $grouped;
    }

    private function calculateCumulative(array $groupedData)
    {
        $cumulative = [];
        $total = 0;
        foreach ($groupedData as $key => $value) {
            $total += $value;
            $cumulative[$key] = $total;
        }
        return $cumulative;
    }
}
