<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    public function index()
    {
        $paket = Paket::all();
        return view('paket.index', compact('paket'));
    }

    public function create()
    {
        return view('paket.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string|max:25',
            'nama' => 'required|string|max:50',
            'harga' => 'required|integer',
        ]);

        Paket::create($request->all());

        return redirect()->route('paket.index')->with('success', 'Paket berhasil ditambahkan.');
    }

    public function edit(Paket $paket)
    {
        //
    }

    public function update(Request $request, Paket $paket)
    {
        $request->validate([
            'kategori' => 'required|string|max:25',
            'nama' => 'required|string|max:50',
            'harga' => 'required|integer',
        ]);

        $paket->update($request->all());

        return redirect()->route('paket.index')->with('success', 'Paket berhasil diperbarui.');
    }

    public function destroy(Paket $paket)
    {
        $paket->delete();
        return redirect()->route('paket.index')->with('success', 'Paket berhasil dihapus.');
    }
}
