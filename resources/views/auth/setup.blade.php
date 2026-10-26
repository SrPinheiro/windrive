@extends('layouts.app', ['title' => 'Configuração inicial'])

@section('content')
    <div class="mx-auto max-w-sm rounded border bg-white p-6">
        <h1 class="mb-1 text-lg font-semibold">Configuração inicial</h1>
        <p class="mb-4 text-sm text-gray-600">Defina o e-mail e a senha do administrador.</p>

        <form method="POST" action="{{ route('setup') }}" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-sm">E-mail</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus class="mt-1 w-full rounded border px-3 py-2">
            </div>
            <div>
                <label for="password" class="block text-sm">Senha</label>
                <input id="password" name="password" type="password" required class="mt-1 w-full rounded border px-3 py-2">
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm">Confirmar senha</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required class="mt-1 w-full rounded border px-3 py-2">
            </div>
            <button class="w-full rounded bg-gray-900 px-4 py-2 text-white">Salvar</button>
        </form>
    </div>
@endsection
