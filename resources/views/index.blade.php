@extends('layout.app')

@section('content')
    <div class="container">
        <h1>Estatísticas de Estrelas do Repositório</h1>


        <x-filter-component :groupBy="$groupBy" :type="$type" :timeRange="$timeRange" />
        <x-stars-chart-component :filteredData="$filteredData" :type="$type" :chart="$chart" />
        <x-highlight-component :users="$users" />
    </div>
@endsection
