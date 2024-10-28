@props(['users'])
<div class="mt-4">
    <h2>Destaques</h2>
    <ul>
        @foreach ($users as $user)
            <li>{{ $user['user']['name'] }} - Seguidores: {{ $user['user']['followers'] }}</li>
        @endforeach
    </ul>
</div>

