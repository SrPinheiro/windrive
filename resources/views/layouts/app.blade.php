<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? config('app.name') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-gray-50 text-gray-900">
        @auth
            <header class="border-b bg-white">
                <div class="mx-auto flex max-w-5xl items-center justify-between px-4 py-3">
                    <a href="{{ route('credentials.index') }}" class="font-semibold">{{ config('app.name') }}</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-sm text-gray-600 hover:text-gray-900">Sair</button>
                    </form>
                </div>
            </header>
        @endauth

        <main class="mx-auto max-w-5xl px-4 py-8">
            @if (session('status'))
                <div class="mb-4 rounded border border-green-200 bg-green-50 px-4 py-2 text-sm text-green-800">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="mb-4 rounded border border-red-200 bg-red-50 px-4 py-2 text-sm text-red-800">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @yield('content')
        </main>
    </body>
</html>
