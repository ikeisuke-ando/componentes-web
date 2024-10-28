<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StarsChartComponent extends Component
{
    public $data;
    public $type;
    /**
     * Create a new component instance.
     */
    public function __construct(array $data = [], string $type = 'cumulative')
    {
        //
        $this->data = $data;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.stars-chart-component');
    }
}
