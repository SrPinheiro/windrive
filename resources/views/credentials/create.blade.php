@extends('layouts.app', ['title' => 'Nova credencial'])

@section('content')
    <div class="max-w-lg rounded border bg-white p-6">
        <h1 class="mb-4 text-lg font-semibold">Nova credencial</h1>

        <form method="POST" action="{{ route('credentials.store') }}" class="space-y-4">
            @csrf
            <div>
                <label for="name" class="block text-sm">Nome</label>
                <input id="name" name="name" value="{{ old('name') }}" required class="mt-1 w-full rounded border px-3 py-2">
            </div>
            <div>
                <label for="client_id" class="block text-sm">Client ID</label>
                <input id="client_id" name="client_id" value="{{ old('client_id') }}" required class="mt-1 w-full rounded border px-3 py-2">
            </div>
            <div>
                <label for="client_secret" class="block text-sm">Client Secret</label>
                <input id="client_secret" name="client_secret" type="password" required class="mt-1 w-full rounded border px-3 py-2">
            </div>
            <div class="flex gap-3">
                <button class="rounded bg-gray-900 px-4 py-2 text-white">Salvar</button>
                <a href="{{ route('credentials.index') }}" class="px-4 py-2 text-gray-600">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
