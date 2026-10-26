<?php

namespace App\Http\Controllers;

use App\Models\DriveAccount;
use Illuminate\Http\RedirectResponse;

class DriveAccountController extends Controller
{
    public function destroy(DriveAccount $account): RedirectResponse
    {
        $account->delete();

        return redirect()->route('credentials.index')->with('status', "Conta {$account->email} desconectada.");
    }
}
