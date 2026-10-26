<?php

namespace App\Http\Controllers;

use App\Models\GoogleCredential;
use App\Services\GoogleDrive\AuthorizationUrl;
use App\Services\GoogleDrive\ConnectAccount;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GoogleOAuthController extends Controller
{
    public function redirect(Request $request, GoogleCredential $credential, AuthorizationUrl $authorizationUrl): RedirectResponse
    {
        $state = Str::random(40);

        $request->session()->put('google_oauth', [
            'state' => $state,
            'credential_id' => $credential->id,
        ]);

        return redirect()->away($authorizationUrl->handle($credential, route('google.callback'), $state));
    }

    public function callback(Request $request, ConnectAccount $connectAccount): RedirectResponse
    {
        $oauth = $request->session()->pull('google_oauth');

        if (! $oauth || ! hash_equals($oauth['state'], (string) $request->query('state'))) {
            return redirect()->route('credentials.index')->withErrors(['google' => 'Estado OAuth inválido. Tente conectar novamente.']);
        }

        if ($request->filled('error') || ! $request->filled('code')) {
            return redirect()->route('credentials.index')->withErrors(['google' => 'Acesso ao Google Drive não autorizado.']);
        }

        $credential = GoogleCredential::findOrFail($oauth['credential_id']);
        $account = $connectAccount->handle($credential, route('google.callback'), $request->query('code'));

        return redirect()->route('credentials.index')->with('status', "Drive de {$account->email} conectado.");
    }
}
