@props(['value', 'selected'])

<option value="{{ $value }}" {{ $selected ? 'selected' : '' }}>
    {{ ucfirst($value) }}
</option>
