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
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
    $request->authenticate();
    $request->session()->regenerate();

    $user = auth()->user();

    if ($user->hasRole('admin')) {
        return redirect()->intended('/dashboard');
    }elseif ($user->hasRole('owner')) {
        return redirect()->intended('/owner');
    } elseif ($user->hasRole('customer')) {
        return redirect()->intended('/customer/dashboard');
    } elseif ($user->hasRole('pelatih')) {
        return redirect()->intended('/trainer');
    }

    // fallback jika tidak punya role
    return redirect()->intended('/');
    }
    
//    public function store(LoginRequest $request): RedirectResponse
//     {
//     $request->authenticate();

//     $request->session()->regenerate();

//     /** @var \App\Models\User $user */
//     $user = Auth::user();

//     if ($user->hasRole('admin')) {
//         return redirect()->route('admin.dashboard');
//     } elseif ($user->hasRole('owner')) {
//         return redirect()->route('owner.dashboard');
//     } elseif ($user->hasRole('customer')) {
//         return redirect()->route('customer.dashboard');
//     } else {
//         Auth::guard('web')->logout();
//         return redirect()->route('login')->with('status', 'Role tidak dikenali.');
//     }
//     }
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
