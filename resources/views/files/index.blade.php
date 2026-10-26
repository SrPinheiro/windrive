@extends('layouts.app', ['title' => 'Arquivos'])

@section('content')
    <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-lg font-semibold">{{ $account->email }}</h1>
            <p class="text-sm text-gray-600">{{ $account->credential->name }}</p>
        </div>
        @if ($folder)
            <a href="{{ route('files.index', $account) }}" class="text-sm text-blue-700 hover:underline">Voltar à raiz</a>
        @endif
    </div>

    <form method="POST" action="{{ route('files.store', $account) }}" enctype="multipart/form-data" class="mb-4 flex flex-wrap items-center gap-3 rounded border bg-white p-4">
        @csrf
        <input type="hidden" name="folder" value="{{ $folder }}">
        <input type="file" name="file" required class="text-sm">
        <button class="rounded bg-gray-900 px-4 py-2 text-sm text-white">Enviar</button>
    </form>

    <div class="overflow-x-auto rounded border bg-white">
        <table class="w-full text-left text-sm">
            <thead class="border-b bg-gray-50">
                <tr>
                    <th class="px-4 py-2">Nome</th>
                    <th class="px-4 py-2">Modificado</th>
                    <th class="px-4 py-2">Tamanho</th>
                    <th class="px-4 py-2"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($files as $file)
                    <tr class="border-b last:border-0">
                        <td class="px-4 py-2">
                            @if ($file->getMimeType() === 'application/vnd.google-apps.folder')
                                <a href="{{ route('files.index', [$account, 'folder' => $file->getId()]) }}" class="text-blue-700 hover:underline">📁 {{ $file->getName() }}</a>
                            @else
                                <a href="{{ $file->getWebViewLink() }}" target="_blank" class="hover:underline">{{ $file->getName() }}</a>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-gray-600">{{ \Illuminate\Support\Carbon::parse($file->getModifiedTime())->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-2 text-gray-600">{{ $file->getSize() ? \Illuminate\Support\Number::fileSize($file->getSize()) : '—' }}</td>
                        <td class="px-4 py-2 text-right">
                            <form method="POST" action="{{ route('files.destroy', [$account, $file->getId()]) }}" onsubmit="return confirm('Mover para a lixeira?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-700 hover:underline">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-gray-500">Nenhum arquivo.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($nextPageToken)
        <div class="mt-4 text-right">
            <a href="{{ route('files.index', [$account, 'folder' => $folder, 'page' => $nextPageToken]) }}" class="text-sm text-blue-700 hover:underline">Próxima página →</a>
        </div>
    @endif
@endsection
