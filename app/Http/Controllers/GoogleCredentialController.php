<?php

namespace App\Http\Controllers;

use App\Models\GoogleCredential;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GoogleCredentialController extends Controller
{
    public function index(): View
    {
        return view('credentials.index', [
            'credentials' => GoogleCredential::with('accounts')->orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('credentials.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'client_id' => ['required', 'string', 'max:255'],
            'client_secret' => ['required', 'string'],
        ]);

        GoogleCredential::create($data);

        return redirect()->route('credentials.index')->with('status', 'Credencial cadastrada.');
    }

    public function destroy(GoogleCredential $credential): RedirectResponse
    {
        $credential->delete();

        return redirect()->route('credentials.index')->with('status', 'Credencial removida.');
    }
}
