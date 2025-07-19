<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    // public function index()
    // {
    //     $customer = Customer::all();
    //     return view('customer.index', compact('customer'));
    // }
    // public function index(Request $request)
    // {
    //     $query = Customer::query();

    //     if ($request->filled('bulan')) {
    //         $bulan = $request->bulan;
    //         $query->whereMonth('created_at', $bulan);
    //     }

    //     $customer = $query->orderBy('created_at', 'desc')->get();

    //     return view('customer.index', compact('customer'));
    // }

    // public function cetakPdf(Request $request)
    // {
    //     $query = Customer::query();

    //     if ($request->filled('bulan')) {
    //         $bulan = $request->bulan;
    //         $query->whereMonth('created_at', $bulan);
    //     }

    //     $customers = $query->get();

    //     $bulanNama = $request->filled('bulan')
    //         ? Carbon::create()->month((int) $request->bulan)->locale('id')->translatedFormat('F')
    //         : 'Semua Bulan';

    //     $pdf = Pdf::loadView('customer.pdf', compact('customers', 'bulanNama'))->setPaper('a4', 'portrait');
    //     return $pdf->download('laporan-customer-' . strtolower($bulanNama) . '.pdf');
    // }
    public function index(Request $request)
    {
        $query = Customer::query();

        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        $customer = $query->orderBy('created_at', 'desc')->get();

        return view('customer.index', compact('customer'));
    }

    public function cetakPdf(Request $request)
    {
        $query = Customer::query();

        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        $customers = $query->get();

        $bulanNama = $request->filled('bulan')
            ? \Carbon\Carbon::create()->month((int) $request->bulan)->locale('id')->translatedFormat('F')
            : 'Semua Bulan';

        $tahunNama = $request->filled('tahun') ? $request->tahun : 'Semua Tahun';

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('customer.pdf', compact('customers', 'bulanNama', 'tahunNama'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('laporan-customer-' . strtolower($bulanNama) . '-' . $tahunNama . '.pdf');
    }


    public function indexForOwner(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

    $customers = Customer::query();

    if ($bulan) {
        $customers->whereMonth('created_at', $bulan);
    }
    if ($tahun) {
        $customers->whereYear('created_at', $tahun);
    }
    $customers = $customers->latest()->get();

    return view('owner.customer.index', compact('customers'));
    }

    public function cetakPdfForOwner(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $query = Customer::query();

        if ($bulan) {
            $query->whereMonth('created_at', $bulan);
        }

        if ($tahun) {
            $query->whereYear('created_at', $tahun);
        }

        $customers = $query->get();

        $bulanNama = $bulan
            ? \Illuminate\Support\Str::ucfirst(\Carbon\Carbon::create()->month((int) $bulan)->locale('id')->translatedFormat('F'))
            : 'Semua Bulan';

        $judul = 'Laporan Customer Body Zone';
        
        return Pdf::loadView('owner.customer.pdf', compact('customers', 'bulanNama', 'tahun', 'judul'))
            ->setPaper('a4', 'portrait')
            ->download('laporan-customer-' . strtolower($bulanNama) . '-' . ($tahun ?? 'semua') . '.pdf');
    }

    public function createBiodata()
    {
        return view('customer.biodata');
    }

    // Menampilkan form untuk menambah customer
    public function create()
    {
        return view('customer.index');
    }

    // Menyimpan customer baru
    public function store(Request $request)
    {
        $validated = $request->validate([
             'nama' => 'required|max:50',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_telp' => 'required|max:20',
            'alamat' => 'required',
        ]);

        $user = User::create([
            'name' => $request->no_telp,
            'email' => $request->no_telp . '@gmail.com',
            'password' => Hash::make($request->no_telp),
            'email_verified_at' => now(),
        ]);
        $user->assignRole('customer');
        $validated['user_id'] = $user->id;

        Customer::create($validated);

        return redirect()->route('customer.index')->with('success', 'Customer berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit customer
    public function edit(Customer $customer)
    {
        //
    }

    // Mengupdate data customer
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'nama' => 'required|max:50',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_telp' => 'required|max:20',
            'alamat' => 'required',
        ]);

        $customer->update($request->all());

        return redirect()->route('customer.index')->with('success', 'Customer berhasil diperbarui.');
    }

    public function reportPdf(Request $request)
    {
        $query = Membership::with(['customer', 'paket', 'pelatih'])->latest();

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('sub_kategori')) {
            $query->where('sub_kategori', $request->sub_kategori);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        $memberships = $query->get();

        $pdf = Pdf::loadView('owner.membership.pdf', compact('memberships'));
        return $pdf->stream('laporan_membership.pdf');
    }
    // Menghapus customer
    public function destroy($id, Customer $customer)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }
}
