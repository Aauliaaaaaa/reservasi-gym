<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class FasilitasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $fasilitas = Fasilitas::all();
        return view('fasilitas.index', compact('fasilitas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('fasilitas.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validatedData = $request->validate([
            'nama' => 'required|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'keterangan' => 'nullable|string',
        ]);

        $fotoPath = null;
        // --- PERBAIKAN DI SINI ---
        if ($request->hasFile('foto')) {
            // Simpan foto ke direktori 'fasilitas_foto' di disk 'public'
            // dan dapatkan path relatifnya (e.g., 'fasilitas_foto/namafileunik.png')
            $fotoPath = $request->file('foto')->store('fasilitas_foto', 'public');
        }

        Fasilitas::create([
            'nama' => $validatedData['nama'],
            'foto' => $fotoPath, // Simpan path yang benar
            'keterangan' => $validatedData['keterangan'],
        ]);

        return redirect()->route('fasilitas.index')->with('success', 'Fasilitas berhasil ditambahkan!');
   
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fasilitas $fasilitas)
    {
        $request->validate([
            'nama' => 'required|max:20',
            'keterangan' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

    // Update field nama dan keterangan
    $fasilitas->nama = $request->nama;
    $fasilitas->keterangan = $request->keterangan;

    // Cek kalau upload foto baru
    if ($request->hasFile('foto')) {
        // Optional: Hapus foto lama dari storage (kalau mau)
        if ($fasilitas->foto && Storage::disk('public')->exists($fasilitas->foto)) {
            Storage::disk('public')->delete($fasilitas->foto);
        }

        // Simpan foto baru
        $fotoBaru = $request->file('foto')->store('fasilitas', 'public');
        $fasilitas->foto = $fotoBaru;
    }

    $fasilitas->save();

    return redirect()->back()->with('success', 'Data berhasil diupdate.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Fasilitas $fasilitas)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        $fasilitas->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }
}
