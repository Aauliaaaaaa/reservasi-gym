<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Customer; 
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // --- VALIDASI SEMUA DATA DALAM SATU PANGGILAN ---
        $request->validate([
            'nama' => ['required', 'string', 'max:255'], // Validasi untuk nama customer dari input 'nama'
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'no_telp' => ['required', 'string', 'max:20', 'unique:customers'], // unique di tabel customers
            'alamat' => ['required', 'string', 'max:500'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class], // unique di tabel users
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // --- 1. BUAT USER BARU ---
        // 'name' di tabel users akan diisi dengan nama lengkap dari form
        $user = User::create([
            'name' => $request->nama, // Menggunakan input 'nama' dari form
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // --- 2. BUAT CUSTOMER BARU dan tautkan dengan user yang baru dibuat ---
        $customer = Customer::create([
            'nama' => $request->nama, // Menggunakan input 'nama' dari form
            'user_id' => $user->id, // Tautkan dengan ID user yang baru dibuat
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
        ]);

        $user->assignRole('customer');
            event(new Registered($user));
        Auth::login($user);
        
        if(Auth::user()->hasRole =('customer')){
            return redirect(route('customer.biodata2', absolute: false));
        }
    }
}