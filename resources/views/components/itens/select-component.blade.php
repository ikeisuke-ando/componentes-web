@props(['filter', 'options'])

{{--<div class="form -" {{ $item['name'] }}  >--}}
{{--    <label for="{{$item['name']}}">{{ $item['name'] }}</label>--}}
{{--    <select name="{{$item['name']}}" id="{{$item['name']}}}" class="form-control">--}}
{{--        <option value="day" {{ $item['groupBy'] == 'day' ? 'selected' : '' }}>Dia</option>--}}
{{--        <option value="week" {{ $item['groupBy'] == 'week' ? 'selected' : '' }}>Semana</option>--}}
{{--        <option value="month" {{ $item['groupBy'] == 'month' ? 'selected' : '' }}>Mês</option>--}}
{{--        <option value="year" {{ $item['groupBy'] == 'year' ? 'selected' : '' }}>Ano</option>--}}
{{--    </select>--}}
{{--</div>--}}

<div class="form-group mt-4">
    <label for="{{ $filter['name'] }}">{{ ucfirst($filter['name']) }}</label>
    <select name="{{ $filter['name'] }}" id="{{ $filter['name'] }}" class="form-control">
        @foreach ($options as $option)
            <x-itens.option-component :value="$option" :selected="$filter['data'] == $option" />
        @endforeach
    </select>
</div>
