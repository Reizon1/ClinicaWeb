<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TwoFactorController extends Controller
{
    /**
     * Display the 2FA verification view.
     */
    public function index(): View|RedirectResponse
    {
        // If the user is already authenticated and verified, redirect them
        if (Auth::check() && session('two_factor_verified')) {
            return redirect()->route('dashboard');
        }

        // If there's no temporary session ID, redirect to login
        if (!session()->has('auth.id')) {
            return redirect()->route('login');
        }

        return view('auth.two-factor');
    }

    /**
     * Process the 2FA verification code.
     */
    public function store(Request $request): RedirectResponse
    {
        $userId = session('auth.id');

        // Fallback to Auth::id() if the user is somehow logged in but not 2FA verified
        if (!$userId && Auth::check()) {
            $userId = Auth::id();
        }

        if (!$userId) {
            return redirect()->route('login');
        }

        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ]);

        $user = User::findOrFail($userId);

        if (
            $user->two_factor_code !== $request->code ||
            $user->two_factor_expires_at === null ||
            $user->two_factor_expires_at->isPast()
        ) {
            return back()->withErrors([
                'code' => 'El código de verificación de dos factores es incorrecto o ha expirado.',
            ]);
        }

        // Code is valid, clear 2FA fields
        $user->forceFill([
            'two_factor_code' => null,
            'two_factor_expires_at' => null,
        ])->save();

        // Login the user formally
        Auth::login($user);

        // Regenerate session for security
        $request->session()->regenerate();

        // Set verified flag
        session(['two_factor_verified' => true]);
        session()->forget('auth.id');

        // Redirect to dashboard
        return redirect()->route('dashboard');
    }
}
