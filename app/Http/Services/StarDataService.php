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

    public function createFilters($request, $options)
    {
        //Agrupar
        $filters['groupBy']['name'] = 'Agrupar por';
        $filters['groupBy']['data'] = $request->query('Agrupar_por', $options['groupBy'][0]);

        //Tipos de filtro
        $filters['type']['name'] = 'Tipo';
        $filters['type']['data'] = $request->query('Tipo', $options['type'][0]);

        //Tempo
        $filters['timeRange']['name'] = 'Intervalo de tempo';
        $filters['timeRange']['data'] = $request->query('Intervalo_de_tempo', $options['timeRange'][0]);
        return $filters;
    }

    public function getFiltersOptions()
    {
        $filtersOptions['groupBy'] = [
            'Dia',
            'Semana',
            'Mes',
            'Ano',
        ];

        $filtersOptions['type'] = [
            'Cumulativo',
            'Absoluto',
        ];

        $filtersOptions['timeRange'] = [
            'Todo o período',
            'Últimos 30 Dias',
            'Últimos 6 Meses',
            'Último Ano',
        ];

        return $filtersOptions;
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
        return $type === 'Cumulativo' ? $this->calculateCumulative($groupedData) : $groupedData;
    }

    private function filterByTimeRange(array $data, string $timeRange)
    {
        $endDate = Carbon::now();
        switch ($timeRange) {
            case 'últimos 30 Dias':
                $startDate = $endDate->copy()->subDays(30);
                break;
            case 'Últimos 6 Meses':
                $startDate = $endDate->copy()->subMonths(6);
                break;
            case 'Último Ano':
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
                'Dia' => $date->format('Y-m-d'),
                'Semana' => $date->format('o-W'),
                'Mes' => $date->format('Y-m'),
                'Ano' => $date->format('Y'),
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
