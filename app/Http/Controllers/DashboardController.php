<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Membership;
use App\Models\Pelatih;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        if ($user->customer) {
            $customerId = $user->customer->id;

            $reservasiBerjalan = Membership::where('customer_id', $customerId)
                                           ->where('status_selesai', false)
                                           ->count();

            $reservasiSelesai = Membership::where('customer_id', $customerId)
                                          ->where('status_selesai', true)
                                          ->count();

            $riwayatMembership = Membership::where('customer_id', $customerId)
                                        ->with('paket')
                                        ->latest()
                                        ->take(5)
                                        ->get();

            return view('customer.dashboard', [
                'reservasiBerjalan' => $reservasiBerjalan,
                'reservasiSelesai' => $reservasiSelesai,
                'riwayatMembership' => $riwayatMembership,
            ]);
        } else {
            // Jika customer belum punya biodata, arahkan ke halaman biodata.
            return redirect()->route('customer.biodata')->with('info', 'Silakan lengkapi biodata Anda terlebih dahulu.');
        }
    }

    public function index()
    {
         // 1. Menghitung jumlah member yang statusnya belum selesai (aktif)
        $jumlahMemberAktif = Membership::where('status_selesai', false)->count();

        // 2. Menghitung jumlah semua pelatih
        $jumlahPelatih = Pelatih::count();

        // 3. Menghitung jumlah semua customer yang terdaftar
        $jumlahCustomer = Customer::count();

        // 4. Menghitung jumlah transaksi yang lunas pada bulan ini
        $transaksiBulanIni = Membership::where('status', 'lunas')
                                ->whereMonth('created_at', Carbon::now()->month)
                                ->whereYear('created_at', Carbon::now()->year)
                                ->count();

        // 5. Mengambil 5 customer terbaru untuk ditampilkan di tabel
        $memberBaru = Customer::latest()->take(5)->get();

        // 6. Mengirim semua data ke view
        return view('dashboard', [
            'jumlahMemberAktif' => $jumlahMemberAktif,
            'jumlahPelatih' => $jumlahPelatih,
            'jumlahCustomer' => $jumlahCustomer,
            'transaksiBulanIni' => $transaksiBulanIni,
            'memberBaru' => $memberBaru,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
