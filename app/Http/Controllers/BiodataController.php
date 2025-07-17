<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer; // Pastikan ini di-import

class BiodataController extends Controller
{
    /**
     * Menampilkan biodata customer yang sedang login.
     */
    public function biodata2()
    {
        return view('customer.biodata2');
    }

    public function index()
    {
        // Mengambil ID user yang sedang login
        $userId = Auth::id();

        // Mencari data customer yang berelasi dengan user tersebut.
        // Jika belum ada, buat objek customer baru agar form tidak error.
        $customer = Customer::firstOrNew(['user_id' => $userId]);

        // Mengirim data customer ke view
        return view('customer.biodata', compact('customer'));
    }

    /**
     * Mengupdate biodata customer yang sedang login.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $customer = $user->customer; // Dapatkan customer terkait

        if (!$customer) {
            return redirect()->back()->with('error', 'Profil customer tidak ditemukan.');
        }

        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_telp' => 'required|string|max:20|unique:customers,no_telp,' . $customer->id,
            'alamat' => 'required|string|max:500',
        ]);

        $customer->update($validatedData);

        return redirect()->back()->with('success', 'Biodata berhasil diperbarui.');
    }
}