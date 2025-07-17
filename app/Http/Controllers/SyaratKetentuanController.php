<?php

namespace App\Http\Controllers;

use App\Models\SyaratKetentuan;
use Illuminate\Http\Request;

class SyaratKetentuanController extends Controller
{
    public function index()
    {
        $syarat = SyaratKetentuan::all();
        return view('syaratketentuan.index', compact('syarat'));
    }

    public function create()
    {
        return view('syaratketentuan.index');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'kategori' => 'required',
            'isi' => 'required',
        ]);

        SyaratKetentuan::create($request->all());

        return redirect()->back()->with('success', 'Data berhasil ditambahkan.');
    }


    public function update(Request $request, SyaratKetentuan $syarat)
    {
        $request->validate([
            'kategori' => 'required',
            'isi' => 'required',
        ]);

        $syarat->update($request->all());

        return redirect()->back()->with('success', 'Data berhasil diupdate.');
    }

    public function destroy($id, SyaratKetentuan $syarat)
    {
        $syarat = SyaratKetentuan::findOrFail($id);
        $syarat->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }


}
