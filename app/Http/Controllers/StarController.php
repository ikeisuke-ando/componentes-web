<?php

namespace App\Http\Controllers;

use App\Http\Services\StarDataService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;

class StarController extends Controller
{
    protected $starDataService;

    public function __construct(StarDataService $starDataService)
    {
        $this->starDataService = $starDataService;
    }

    public function index(Request $request, $sample)
    {
        $options = $this->starDataService->getFiltersOptions();
        $filters = $this->starDataService->createFilters($request, $options);
        $data = $this->starDataService->getStarData($sample);
        $filteredData = $this->starDataService->applyFilters($data, $filters['groupBy']['data'],  $filters['type']['data'],  $filters['timeRange']['data']);
        $users = $this->starDataService->getHighlightedUsers($data);
        $chart = $this->createChart($data, $filteredData);

        return view('index', compact('filteredData', 'filters', 'users', 'chart', 'options'));
    }

    public function createChart($data, $filteredData) {
            $end = Carbon::now();
            $start = $end->copy()->subMonths(1);

            $createdAtDates = collect($filteredData)->pluck('starred_at');

            $period = CarbonPeriod::create($start, "1 month", $end);

            $usersPerMonth = collect($period)->map(function ($date) use ($createdAtDates) {
                $endDate = $date->copy()->endOfMonth();

                return [
                    "count" => $createdAtDates->filter(function ($starredAt) use ($endDate) {
                        return Carbon::parse($starredAt)->lessThanOrEqualTo($endDate);
                    })->count(),
                    "month" => $endDate->format("Y-m-d")
                ];
            });

            $data = $usersPerMonth->pluck("count")->toArray();
            $labels = $usersPerMonth->pluck("month")->toArray();

            $chart = Chartjs::build()
                ->name("StarGrowthChart")
                ->type("line")
                ->size(["width" => 400, "height" => 200])
                ->labels($labels)
                ->datasets([
                    [
                        "label" => "Crescimento de Estrelas",
                        "backgroundColor" => "rgba(38, 185, 154, 0.31)",
                        "borderColor" => "rgba(38, 185, 154, 0.7)",
                        "data" => $data
                    ]
                ])
                ->options([
                    'scales' => [
                        'x' => [
                            'type' => 'time',
                            'time' => [
                                'unit' => 'month'
                            ],
                            'min' => $start->format("Y-m-d"),
                        ]
                    ],
                    'plugins' => [
                        'title' => [
                            'display' => true,
                            'text' => 'Crescimento Mensal de Estrelas do Repositório'
                        ],
                        'tooltip' => [
                            'callbacks' => [
                                'label' => function($tooltipItem) {
                                    return "Estrelas: " . $tooltipItem['formattedValue'];
                                },
                            ],
                        ]
                    ]
                ]);

            return $chart;
    }
}
