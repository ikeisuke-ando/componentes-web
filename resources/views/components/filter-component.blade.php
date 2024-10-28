@props(['groupBy', 'type', 'timeRange'])
<div class="mb-4">
    <form method="GET" action="{{ request()->url() }}">
        <div class="form-group">
            <label for="groupBy">Agrupar por:</label>
            <select name="groupBy" id="groupBy" class="form-control">
                <option value="day" {{ $groupBy == 'day' ? 'selected' : '' }}>Dia</option>
                <option value="week" {{ $groupBy == 'week' ? 'selected' : '' }}>Semana</option>
                <option value="month" {{ $groupBy == 'month' ? 'selected' : '' }}>Mês</option>
                <option value="year" {{ $groupBy == 'year' ? 'selected' : '' }}>Ano</option>
            </select>
        </div>
        <div class="form-group">
            <label for="type">Tipo:</label>
            <select name="type" id="type" class="form-control">
                <option value="absolute" {{ $type == 'absolute' ? 'selected' : '' }}>Absoluto</option>
                <option value="cumulative" {{ $type == 'cumulative' ? 'selected' : '' }}>Cumulativo</option>
            </select>
        </div>

        <div class="form-group">
            <label for="timeRange">Intervalo de tempo:</label>
            <select name="timeRange" id="timeRange" class="form-control">
                <option value="all" {{ $timeRange == 'all' ? 'selected' : '' }}>Todo o período</option>
                <option value="30_days" {{ $timeRange == '30_days' ? 'selected' : '' }}>Últimos 30 dias</option>
                <option value="6_months" {{ $timeRange == '6_months' ? 'selected' : '' }}>Últimos 6 meses</option>
                <option value="1_year" {{ $timeRange == '1_year' ? 'selected' : '' }}>Último ano</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Filtrar</button>
    </form>
</div>
