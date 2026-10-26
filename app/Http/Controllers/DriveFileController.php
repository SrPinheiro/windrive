<?php

namespace App\Http\Controllers;

use App\Models\DriveAccount;
use App\Services\GoogleDrive\AccessToken;
use App\Services\GoogleDrive\CreateFile;
use App\Services\GoogleDrive\DeleteFile;
use App\Services\GoogleDrive\ListFiles;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DriveFileController extends Controller
{
    public function index(Request $request, DriveAccount $account, AccessToken $accessToken, ListFiles $listFiles): View
    {
        $files = $listFiles->handle(
            $accessToken->handle($account),
            $request->query('folder'),
            pageToken: $request->query('page'),
        );

        return view('files.index', [
            'account' => $account,
            'files' => $files->getFiles(),
            'nextPageToken' => $files->getNextPageToken(),
            'folder' => $request->query('folder'),
        ]);
    }

    public function store(Request $request, DriveAccount $account, AccessToken $accessToken, CreateFile $createFile): RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'file'],
            'folder' => ['nullable', 'string'],
        ]);

        $upload = $request->file('file');

        $createFile->handle(
            $accessToken->handle($account),
            $upload->getClientOriginalName(),
            $upload->getContent(),
            $upload->getMimeType(),
            $request->input('folder'),
        );

        return back()->with('status', 'Arquivo enviado.');
    }

    public function destroy(Request $request, DriveAccount $account, string $fileId, AccessToken $accessToken, DeleteFile $deleteFile): RedirectResponse
    {
        $deleteFile->handle($accessToken->handle($account), $fileId);

        return back()->with('status', 'Arquivo movido para a lixeira.');
    }
}
