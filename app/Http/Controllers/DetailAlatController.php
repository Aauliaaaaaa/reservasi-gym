<?php

namespace App\Http\Controllers;

use App\Models\DetailAlat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DetailAlatController extends Controller
{
    /**
     * Simpan monitoring alat baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fasilitas_id' => 'required|exists:fasilitas,id',
            'tanggal' => 'required|date',
            'kondisi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('detail_alat', 'public');
        }

        DetailAlat::create($validated);

        return redirect()->back()->with('success', 'Data monitoring berhasil ditambahkan.');
    }

    /**
     * Update data monitoring alat.
     */
    public function update(Request $request, DetailAlat $detailAlat)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'kondisi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($detailAlat->foto) {
                Storage::disk('public')->delete($detailAlat->foto);
            }
            $validated['foto'] = $request->file('foto')->store('detail_alat', 'public');
        }

        $detailAlat->update($validated);

        return redirect()->back()->with('success', 'Data monitoring berhasil diperbarui.');
    }

    /**
     * Hapus data monitoring alat.
     */
    public function destroy(DetailAlat $detailAlat)
    {
        if ($detailAlat->foto) {
            Storage::disk('public')->delete($detailAlat->foto);
        }

        $detailAlat->delete();

        return redirect()->back()->with('success', 'Data monitoring berhasil dihapus.');
    }
}
