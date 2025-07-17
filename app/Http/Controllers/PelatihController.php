<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\Pelatih;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PelatihController extends Controller
{
    public function index()
    {
        $pelatih = Pelatih::with('paket')->get();
        $paket = Paket::all(); // Untuk dropdown di tambah/edit
        return view('pelatih.index', compact('pelatih', 'paket'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|max:50|email',
            'password' => 'required|min:8|max:50',
            'no_telp' => 'required|max:20',
            'alamat' => 'required',
            'paket_id' => 'required|exists:paket,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        Pelatih::create([
            'user_id' => $user->id,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'paket_id' => $request->paket_id
        ]);

        return redirect()->back()->with('success', 'Pelatih berhasil ditambahkan');
    }

    public function update(Request $request, Pelatih $pelatih)
    {
        $request->validate([
            'nama' => 'required|max:50',
            'no_telp' => 'required|max:20',
            'alamat' => 'required',
            'paket_id' => 'required|exists:paket,id',
        ]);

        $pelatih->update($request->all());

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
}
