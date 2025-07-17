<?php

namespace App\Http\Controllers;

use App\Models\LaporanTahunan;
use App\Models\Membership;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanController extends Controller
{
    /**
     * Menampilkan halaman laporan tahunan.
     */
    public function tahunan(Request $request)
    {
        // Ambil data laporan tahunan yang sudah ada, urutkan dari tahun terbaru
        $laporanTahunan = LaporanTahunan::orderBy('tahun', 'desc')->get();

        // Siapkan data untuk grafik
        $selectedYear = $request->input('tahun', Carbon::now()->year);

        $growthData = Membership::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('COUNT(*) as jumlah')
            )
            ->whereYear('created_at', $selectedYear)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('jumlah', 'bulan')
            ->all();

        // Siapkan array 12 bulan dengan nilai 0
        $chartData = array_fill(1, 12, 0);
        foreach ($growthData as $bulan => $jumlah) {
            $chartData[$bulan] = $jumlah;
        }

        return view('owner.laporan.tahunan', [
            'laporanTahunan' => $laporanTahunan,
            'chartData' => array_values($chartData), // Kirim hanya nilainya
            'selectedYear' => $selectedYear,
        ]);
    }

    /**
     * Membuat rekapitulasi dan menyimpan laporan tahunan baru.
     */
    public function storeTahunan(Request $request)
    {
        $request->validate(['tahun' => 'required|numeric|unique:laporan_tahunan,tahun']);
        $tahun = $request->tahun;

        // 1. Hitung total pendapatan
        $totalPendapatan = Membership::whereYear('created_at', $tahun)
                                     ->where('status', 'lunas')
                                     ->with('paket')
                                     ->get()
                                     ->sum(function($membership) {
                                         return $membership->paket->harga ?? 0;
                                     });

        // 2. Hitung jumlah member baru
        $jumlahMemberBaru = Customer::whereYear('created_at', $tahun)->count();

        // 3. Hitung total member aktif di tahun itu (contoh: yang pernah transaksi)
        $totalMemberAktif = Membership::whereYear('created_at', $tahun)->distinct('customer_id')->count();

        // Simpan ke database
        LaporanTahunan::create([
            'tahun' => $tahun,
            'total_pendapatan' => $totalPendapatan,
            'jumlah_member_baru' => $jumlahMemberBaru,
            'total_member_aktif' => $totalMemberAktif,
        ]);

        return redirect()->route('owner.laporan.tahunan')->with('success', 'Laporan tahun ' . $tahun . ' berhasil dibuat!');
    }
}
