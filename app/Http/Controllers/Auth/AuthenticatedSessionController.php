<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        // Get the user by email
        $user = User::where('email', $request->email)->first();
        
        if ($user) {
            // Check if user is admin (hashed password) or regular user (plain text)
            if ($user->role === 'admin') {
                // Admin: Check using Hash::check
                if (!Hash::check($request->password, $user->password)) {
                    return back()->withErrors([
                        'email' => 'The provided credentials do not match our records.',
                    ]);
                }
            } else {
                // Regular User: Check plain text password directly
                if ($user->password !== $request->password) {
                    return back()->withErrors([
                        'email' => 'The provided credentials do not match our records.',
                    ]);
                }
            }
            
            // Log the user in
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();
            
            return redirect()->intended(route('dashboard', absolute: false));
        }
        
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}