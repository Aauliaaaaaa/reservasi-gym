<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use App\Models\Paket;
use Illuminate\Http\Request;
use App\Models\SyaratKetentuan;


class WelcomeController extends Controller
{
    public function index()
{
    $syarat = SyaratKetentuan::all(); // Tetap ambil syarat
    $pakets = Paket::all()->groupBy('kategori'); // Ambil paket dan group by kategori
    $fasilitas = Fasilitas::all(); // Ambil fasilitas

    // Kirim ke view
    return view('welcome', compact('syarat', 'pakets', 'fasilitas'));
}

}
