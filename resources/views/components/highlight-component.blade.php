<div class="mt-4">
    <h2>Destaques</h2>
    @foreach ($users as $user)
        <x-user-component :user="$user['user']" />
    @endforeach
</div>
