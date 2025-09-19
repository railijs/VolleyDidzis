<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
     // Parāda pieteikšanās formu (login view).
    public function create(): View
    {
        return view('auth.login');
    }
     // Apstrādā ienākošu autentifikācijas pieprasījumu (pieteikšanos).
    public function store(LoginRequest $request): RedirectResponse
    {
        
        $request->authenticate();
        // Atjauno sesiju, lai novērstu "session fixation" uzbrukumus
        $request->session()->regenerate();
        return redirect()->intended(route('dashboard', absolute: false));
    }

    // Izbeidz autentificētu sesiju (izraksta lietotāju).
    public function destroy(Request $request): RedirectResponse
    {
        // Atvieno lietotāju no sistēmas
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
