@props(['filters', 'options'])
<div class="mb-4">
    <form method="GET" action="{{ request()->url() }}">
        @foreach ($filters as $filterKey => $filter)
            <x-itens.select-component :filter="$filter" :options="$options[$filterKey]" />
        @endforeach
        <button type="submit" class="btn btn-primary">Filtrar</button>
    </form>
</div>
