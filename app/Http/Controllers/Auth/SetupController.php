<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class SetupController extends Controller
{
    public function show(): View|RedirectResponse
    {
        if (! User::needsSetup()) {
            return redirect()->route('login');
        }

        return view('auth.setup');
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless(User::needsSetup(), 404);

        $admin = User::first();

        $data = $request->validate([
            'email' => ['required', 'email', Rule::notIn(['admin@email.com']), Rule::unique('users')->ignore($admin)],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $admin->update($data);

        Auth::login($admin);
        $request->session()->regenerate();

        return redirect()->route('credentials.index');
    }
}
