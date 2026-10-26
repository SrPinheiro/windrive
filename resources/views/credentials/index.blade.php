@extends('layouts.app', ['title' => 'Credenciais'])

@section('content')
    <div class="mb-4 flex items-center justify-between">
        <h1 class="text-lg font-semibold">Credenciais</h1>
        <a href="{{ route('credentials.create') }}" class="rounded bg-gray-900 px-4 py-2 text-sm text-white">Nova credencial</a>
    </div>

    <p class="mb-4 text-sm text-gray-600">
        Redirect URI para cadastrar no Google Console: <code class="rounded bg-gray-100 px-1">{{ route('google.callback') }}</code>
    </p>

    <div class="space-y-4">
        @forelse ($credentials as $credential)
            <section class="rounded border bg-white">
                <div class="flex flex-wrap items-center justify-between gap-3 border-b px-4 py-3">
                    <div class="min-w-0">
                        <h2 class="font-medium">{{ $credential->name }}</h2>
                        <p class="truncate text-sm text-gray-600">{{ $credential->client_id }}</p>
                    </div>
                    <div class="flex gap-3 text-sm">
                        <a href="{{ route('google.connect', $credential) }}" class="text-blue-700 hover:underline">Conectar conta</a>
                        <form method="POST" action="{{ route('credentials.destroy', $credential) }}" onsubmit="return confirm('Remover essa credencial e todas as contas conectadas?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-700 hover:underline">Remover</button>
                        </form>
                    </div>
                </div>

                <ul class="text-sm">
                    @forelse ($credential->accounts as $account)
                        <li class="flex items-center justify-between gap-3 border-b px-4 py-2 last:border-0">
                            <span class="truncate">{{ $account->email }}</span>
                            <div class="flex gap-3">
                                <a href="{{ route('files.index', $account) }}" class="text-blue-700 hover:underline">Arquivos</a>
                                <form method="POST" action="{{ route('accounts.destroy', $account) }}" onsubmit="return confirm('Desconectar essa conta?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-700 hover:underline">Desconectar</button>
                                </form>
                            </div>
                        </li>
                    @empty
                        <li class="px-4 py-3 text-gray-500">Nenhuma conta conectada.</li>
                    @endforelse
                </ul>
            </section>
        @empty
            <p class="rounded border bg-white px-4 py-6 text-center text-sm text-gray-500">Nenhuma credencial cadastrada.</p>
        @endforelse
    </div>
@endsection
