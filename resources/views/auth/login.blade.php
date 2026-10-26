@extends('layouts.app', ['title' => 'Login'])

@section('content')
    <div class="mx-auto max-w-sm rounded border bg-white p-6">
        <h1 class="mb-4 text-lg font-semibold">Entrar</h1>

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-sm">E-mail</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus class="mt-1 w-full rounded border px-3 py-2">
            </div>
            <div>
                <label for="password" class="block text-sm">Senha</label>
                <input id="password" name="password" type="password" required class="mt-1 w-full rounded border px-3 py-2">
            </div>
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="remember"> Lembrar
            </label>
            <button class="w-full rounded bg-gray-900 px-4 py-2 text-white">Entrar</button>
        </form>
    </div>
@endsection
