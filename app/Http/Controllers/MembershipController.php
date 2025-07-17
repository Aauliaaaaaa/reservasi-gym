<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\Customer;
use App\Models\Pelatih;
use App\Models\Paket;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class MembershipController extends Controller
{
    // ...

    // public function gym(Request $request)
    // {
    //     $subKategori = $request->kategori ?? 'Privat';

    //     $memberships = Membership::with(['customer', 'pelatih', 'paket'])
    //         ->where('kategori', 'Gym')
    //         ->where('sub_kategori', $subKategori)
    //         ->get();

    //     $customers = Customer::all();
    //     $paket = Paket::where('kategori', 'Gym')->get();
        
    //     // PERUBAHAN: Filter pelatih berdasarkan KATEGORI dan SUB-KATEGORI
    //     $pelatih = Pelatih::whereHas('paket', function ($query) use ($subKategori) {
    //         $query->where('kategori', 'Gym')
    //               ->where('nama', 'LIKE', '%' . $subKategori . '%');
    //     })->get();

    //     return view('membership.gym.index', compact('memberships', 'subKategori', 'customers', 'pelatih', 'paket'));
    // }
    public function gym(Request $request)
    {
        $subKategori = $request->kategori ?? 'Privat';
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $memberships = Membership::with(['customer', 'pelatih', 'paket'])
            ->where('kategori', 'Gym')
            ->where('sub_kategori', $subKategori);

        if ($bulan) {
            $memberships->whereMonth('created_at', $bulan);
        }
        if ($tahun) {
            $memberships->whereYear('created_at', $tahun);
        }

        $memberships = $memberships->get();

        $customers = Customer::all();
        $paket = Paket::where('kategori', 'Gym')->get();

        $pelatih = Pelatih::whereHas('paket', function ($query) use ($subKategori) {
            $query->where('kategori', 'Gym')
                ->where('nama', 'LIKE', '%' . $subKategori . '%');
        })->get();

        return view('membership.gym.index', compact(
            'memberships', 'subKategori', 'customers', 'pelatih', 'paket'
        ));
    }


    public function muaythai(Request $request)
    {
        $subKategori = $request->input('kategori', 'Privat');
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $memberships = Membership::where('kategori', 'Muay Thai')
                                ->where('sub_kategori', $subKategori)
                                ->with(['customer', 'pelatih', 'paket']);

        if ($bulan) {
            $memberships->whereMonth('created_at', $bulan);
        }
        if ($tahun) {
            $memberships->whereYear('created_at', $tahun);
        }

        $memberships = $memberships->get();

        $customers = Customer::all();
        $paket = Paket::where('kategori', 'Muay Thai')->get();

        $pelatih = Pelatih::whereHas('paket', function ($query) use ($subKategori) {
            $query->where('kategori', 'Muay Thai')
                ->where('nama', 'LIKE', '%' . $subKategori . '%');
        })->get();

        return view('membership.muaythai.index', compact(
            'memberships', 'subKategori', 'customers', 'pelatih', 'paket'
        ));
    }
    
    public function boxing(Request $request)
    {
        $subKategori = $request->input('kategori', 'Privat');
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $memberships = Membership::where('kategori', 'Boxing')
                                ->where('sub_kategori', $subKategori)
                                ->with(['customer', 'pelatih', 'paket']);

        if ($bulan) {
            $memberships->whereMonth('created_at', $bulan);
        }
        if ($tahun){
            $memberships->whereYear('created_at', $tahun);
        }

        $memberships = $memberships->get();

        $customers = Customer::all();
        $paket = Paket::where('kategori', 'Boxing')->get();

        $pelatih = Pelatih::whereHas('paket', function ($query) use ($subKategori) {
            $query->where('kategori', 'Boxing')
                ->where('nama', 'LIKE', '%' . $subKategori . '%');
        })->get();

        return view('membership.boxing.index', compact(
            'memberships', 'subKategori', 'customers', 'pelatih', 'paket'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'pelatih_id' => 'nullable|exists:pelatih,id',
            'paket_id' => 'nullable|exists:paket,id',
            'tgl_datang' => 'nullable|date',
            'tgl_mulai' => 'nullable|date',
            'tgl_selesai' => 'nullable|date|after_or_equal:tgl_mulai',
            'kategori' => 'required|in:Gym,Muay Thai,Boxing',
            'sub_kategori' => 'required|in:Privat,Harian,Bulanan,Reguler,Insidental',
            'bukti_bayar' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('bukti_bayar')) {
            $data['bukti_bayar'] = $request->file('bukti_bayar')->store('bukti_bayar', 'public');
        }

        $data['status'] = 'belum lunas';
        Membership::create($data);

        if ($request->kategori == 'Gym') {
            return redirect()->route('membership.gym', ['kategori' => $request->sub_kategori])
                             ->with('success', 'Data membership Gym berhasil ditambahkan.');
        } elseif ($request->kategori == 'Muay Thai') {
            return redirect()->route('membership.muaythai', ['kategori' => $request->sub_kategori])
                             ->with('success', 'Data membership Muay Thai berhasil ditambahkan.');
        } elseif ($request->kategori == 'Boxing') {
            return redirect()->route('membership.boxing', ['kategori' => $request->sub_kategori])
                             ->with('success', 'Data membership Boxing berhasil ditambahkan.');
        }

        return redirect()->back()->with('success', 'Data membership berhasil ditambahkan.');
    }

    // ... (method updateStatus, updateStatusSelesai, dan semua method cetak PDF tetap sama)

    public function updateStatus($id)
    {
        $membership = Membership::findOrFail($id);
        $membership->status = 'lunas';
        $membership->save();

        return back()->with('success', 'Status pembayaran diubah menjadi lunas.');
    }

    public function updateStatusSelesai($id)
    {
        $membership = Membership::findOrFail($id);
        $membership->status_selesai = true;
        $membership->save();

        return back()->with('success', 'Membership berhasil ditandai selesai.');
    }

   public function cetakPdfGym(Request $request)
    {
        $subKategori = $request->kategori ?? 'Privat';
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $memberships = Membership::with(['customer', 'pelatih', 'paket'])
            ->where('kategori', 'Gym')
            ->where('sub_kategori', $subKategori);

        if ($bulan) {
            $memberships->whereMonth('created_at', (int) $bulan); 
        }

        if ($tahun) {
            $memberships->whereYear('created_at', (int) $tahun);
        }

        $memberships = $memberships->get();

        $judul = 'Laporan Membership Gym - Kategori ' . $subKategori;

        if ($bulan) {
            $judul .= ' Bulan ' . \Carbon\Carbon::create()->month((int) $bulan)->translatedFormat('F');
        }

        if ($tahun) {
            $judul .= ' Tahun ' . $tahun;
        }

        $data = [
            'memberships' => $memberships,
            'subKategori' => $subKategori,
            'judul' => $judul,
        ];

        $filename = 'laporan-membership-gym-' . strtolower($subKategori);

        if ($bulan) {
            $filename .= '-bulan-' . $bulan;
        }

        if ($tahun) {
            $filename .= '-tahun-' . $tahun;
        }

        $filename .= '.pdf';

        $pdf = Pdf::loadView('membership.gym.pdf', $data);

        return $pdf->download($filename);
    }
    
    public function cetakPdfMuayThai(Request $request)
    {
        $subKategori = $request->kategori ?? 'Privat'; 
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $memberships = Membership::with(['customer', 'pelatih', 'paket'])
            ->where('kategori', 'Muay Thai')
            ->where('sub_kategori', $subKategori);

        if ($bulan) {
            $memberships->whereMonth('created_at', (int) $bulan); 
        }
        if ($tahun) {
            $memberships->whereYear('created_at', (int) $tahun);
        }

        $memberships = $memberships->get();

        $judul = 'Laporan Membership Muay Thai - Kategori ' . $subKategori;

        if ($bulan) {
            $judul .= ' Bulan ' . \Carbon\Carbon::create()->month((int) $bulan)->translatedFormat('F');
        }

        if ($tahun) {
            $judul .= ' Tahun ' . $tahun;
        }

        $data = [
            'memberships' => $memberships,
            'subKategori' => $subKategori,
            'judul' => $judul,
        ];

        $filename = 'laporan-membership-muaythai-' . strtolower($subKategori);

        if ($bulan) {
            $filename .= '-bulan-' . $bulan;
        }

        if ($tahun) {
            $filename .= '-tahun-' . $tahun;
        }

        $filename .= '.pdf';

        $pdf = Pdf::loadView('membership.muaythai.pdf', $data);

        return $pdf->download($filename);
    }
    
    // public function cetakPdfBoxing(Request $request)
    // {
    //     $subKategori = $request->kategori ?? 'Privat'; 
    //     $bulan = $request->bulan;

    //     $memberships = Membership::with(['customer', 'pelatih', 'paket'])
    //         ->where('kategori', 'Boxing')
    //         ->where('sub_kategori', $subKategori);
            
    //     if ($bulan) {
    //         $memberships->whereMonth('created_at', (int) $bulan); // 👈 Cast ke int
    //     }
        

    //     $memberships = $memberships->get();

    //     $data = [
    //         'memberships' => $memberships,
    //         'subKategori' => $subKategori,
    //         'judul' => 'Laporan Membership Boxing - Kategori ' . $subKategori . 
    //                 ($bulan ? ' Bulan ' . \Carbon\Carbon::create()->month((int) $bulan)->translatedFormat('F') : ''),
    //     ];

    //     $pdf = Pdf::loadView('membership.boxing.pdf', $data);

    //     return $pdf->download('laporan-membership-boxing-' . strtolower($subKategori) . 
    //     ($bulan ? '-bulan-' . $bulan : '') . '.pdf');
    // }
    public function cetakPdfBoxing(Request $request)
    {
        $subKategori = $request->kategori ?? 'Privat'; 
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $memberships = Membership::with(['customer', 'pelatih', 'paket'])
            ->where('kategori', 'Boxing')
            ->where('sub_kategori', $subKategori);

        if ($bulan) {
            $memberships->whereMonth('created_at', (int) $bulan);
        }

        if ($tahun) {
            $memberships->whereYear('created_at', (int) $tahun);
        }

        $memberships = $memberships->get();

        $judul = 'Laporan Membership Boxing - Kategori ' . $subKategori;

        if ($bulan) {
            $judul .= ' Bulan ' . \Carbon\Carbon::create()->month((int) $bulan)->translatedFormat('F');
        }

        if ($tahun) {
            $judul .= ' Tahun ' . $tahun;
        }

        $data = [
            'memberships' => $memberships,
            'subKategori' => $subKategori,
            'judul' => $judul,
        ];

        $filename = 'laporan-membership-boxing-' . strtolower($subKategori);

        if ($bulan) {
            $filename .= '-bulan-' . $bulan;
        }

        if ($tahun) {
            $filename .= '-tahun-' . $tahun;
        }

        $filename .= '.pdf';

        $pdf = Pdf::loadView('membership.boxing.pdf', $data);

        return $pdf->download($filename);
    }


     public function reportForOwner(Request $request)
    {
        // Memulai query builder
        $query = Membership::with(['customer', 'paket', 'pelatih'])->latest();

        // Terapkan filter jika ada
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }

        if ($request->has('sub_kategori') && $request->sub_kategori != '') {
            $query->where('sub_kategori', $request->sub_kategori);
        }

        if ($request->has('bulan') && $request->bulan != '') {
            $query->whereMonth('created_at', $request->bulan);
        }
        if ($request->has('tahun') && $request->tahun != '') {
            $query->whereYear('created_at', $request->tahun);
        } else {
            $query->whereYear('created_at', date('Y'));
        }
        // Filter berdasarkan tahun saat ini untuk relevansi
        $query->whereYear('created_at', date('Y'));

        // Ambil data dengan paginasi
        $memberships = $query->paginate(15);

        // Kirim data ke view
        return view('owner.membership.report', compact('memberships'));
    }
}
