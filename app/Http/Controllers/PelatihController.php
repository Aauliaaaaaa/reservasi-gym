<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\Pelatih;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class PelatihController extends Controller
{
    public function index()
    {
        $pelatih = Pelatih::with('paket')->get();
        $paket = Paket::all(); // Untuk dropdown di tambah/edit
        $userPelatih = User::role('pelatih')->get(); // Ambil semua user dengan role pelatih

        return view('pelatih.index', compact('pelatih', 'paket', 'userPelatih'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelatih_id' => 'required|exists:users,id',
            'no_telp' => 'required|max:20',
            'alamat' => 'required',
            'paket_id' => 'required|exists:paket,id',
        ]);

        Pelatih::create([
            'user_id' => $request->pelatih_id,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'paket_id' => $request->paket_id
        ]);

        return redirect()->back()->with('success', 'Pelatih berhasil ditambahkan');
    }

    public function update(Request $request, Pelatih $pelatih)
    {
        $request->validate([
            'pelatih_id' => 'required|exists:users,id',
            'no_telp' => 'required|max:20',
            'alamat' => 'required',
            'paket_id' => 'required|exists:paket,id',
        ]);

        $pelatih->update([
            'user_id' => $request->pelatih_id,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'paket_id' => $request->paket_id
        ]);

        return redirect()->back()->with('success', 'Pelatih berhasil diupdate');
    }

    // public function destroy($id, Pelatih $pelatih)
    // {
    //     $pelatih = Pelatih::findOrFail($id);
    //     $pelatih->delete();
    //     return redirect()->back()->with('success', 'Pelatih berhasil dihapus');
    // }
    public function destroy(Pelatih $pelatih)
    {
        $pelatih->delete();
        return redirect()->route('pelatih.index')->with('success', 'Pelatih berhasil dihapus.');
    }

    public function kelolaAkun()
    {
        $pelatih = User::role('pelatih')->get();
        return view('pelatih.kelola-akun', compact('pelatih'));
    }

    public function kelolaAkunDestroy($id)
    {
        $pelatih = User::findOrFail($id);
        // Hapus relasi pelatih jika ada
        if ($pelatih->pelatih) {
            $pelatih->pelatih->delete();
        }
        // Hapus user
        $pelatih->delete();
        
        return redirect()->route('pelatih.kelola_akun')->with('success', 'Akun pelatih berhasil dihapus.');
    }

    public function kelolaAkunUpdate(Request $request, $id)
    {
        $pelatih = User::findOrFail($id);
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|email|max:50',
            'password' => 'nullable|min:8|max:50',
        ]);

        $pelatih->name = $request->name;
        $pelatih->email = $request->email;
        if ($request->filled('password')) {
            $pelatih->password = Hash::make($request->password);
        }
        $pelatih->save();

        return redirect()->route('pelatih.kelola_akun')->with('success', 'Akun pelatih berhasil diperbarui.');
    }

    public function kelolaAkunStore(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|email|max:50|unique:users,email',
            'password' => 'required|min:8|max:50',
        ]);

        $pelatih = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
        ]);
        $pelatih->assignRole('pelatih');

        return redirect()->route('pelatih.kelola_akun')->with('success', 'Akun pelatih berhasil ditambahkan.');
    }
}
