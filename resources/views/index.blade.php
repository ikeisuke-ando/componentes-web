@extends('layout.app')

@section('content')
    <div class="container">
        <h1>Estatísticas de Estrelas do Repositório</h1>

        <x-filter-component :filters="$filters" :options="$options" />
        <x-stars-chart-component :filteredData="$filteredData" :type="$filters['type']['data']" :chart="$chart" />
        <x-highlight-component :users="$users" />
    </div>
@endsection
