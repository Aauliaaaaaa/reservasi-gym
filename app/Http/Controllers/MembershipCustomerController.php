<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paket;
use App\Models\Pelatih;
use App\Models\Membership;
use Illuminate\Support\Facades\Auth;

class MembershipCustomerController extends Controller
{
    public function index()
    {
        $customerId = Auth::user()->customer->id;
        $memberships = Membership::where('customer_id', $customerId)
                                 ->with(['paket', 'pelatih']) // Eager load relasi
                                 ->latest() // Urutkan dari yang terbaru
                                 ->get();

        return view('customer.reservasi.index', compact('memberships'));
    }

    /**
     * Menampilkan detail satu reservasi.
     */
    public function show(Membership $membership)
    {
        // Pastikan customer hanya bisa melihat reservasinya sendiri
        if ($membership->customer_id !== Auth::user()->customer->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('customer.reservasi.show', compact('membership'));
    }

    /**
     * Menampilkan form untuk mengubah jadwal.
     */
    public function edit(Membership $membership)
    {
        // Pastikan customer hanya bisa mengakses reservasinya sendiri
        if ($membership->customer_id !== Auth::user()->customer->id) {
            abort(403);
        }

        // PERBAIKAN: Tolak akses jika kategori paket adalah Privat
        if (strtolower($membership->sub_kategori) === 'privat') {
            return redirect()->route('customer.reservasi.index')->with('error', 'Jadwal untuk paket privat diatur langsung bersama pelatih.');
        }

        return view('customer.reservasi.edit', compact('membership'));
    }
    /**
     * Memperbarui jadwal reservasi.
     */
     public function update(Request $request, Membership $membership)
    {
        if ($membership->customer_id !== Auth::user()->customer->id) {
            abort(403);
        }

        // PERBAIKAN: Validasi dan update berdasarkan jenis paket
        $subKategori = strtolower($membership->sub_kategori);

        if ($subKategori === 'bulanan' || $subKategori === 'reguler') {
            $validatedData = $request->validate([
                'tgl_mulai' => 'required|date',
                'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
            ]);
            $membership->update($validatedData);

        } elseif ($subKategori === 'harian' || $subKategori === 'insidental') {
            $validatedData = $request->validate([
                'tgl_datang' => 'required|date',
            ]);
            $membership->update($validatedData);
        }

        return redirect()->route('customer.reservasi.index')->with('success', 'Jadwal reservasi berhasil diperbarui.');
    }

    /**
     * Menandai membership sebagai selesai oleh customer.
     */
    public function markAsComplete(Membership $membership)
    {
        if ($membership->customer_id !== Auth::user()->customer->id) {
            abort(403);
        }

        $membership->update(['status_selesai' => true]);

        return redirect()->route('customer.reservasi.index')->with('success', 'Terima kasih! Sesi Anda telah ditandai selesai.');
    }

    // --- Metode untuk form pemesanan (tetap sama) ---
    private function getMembershipData($kategori)
    {
        $paket = Paket::where('kategori', $kategori)->get();
        $pelatih = Pelatih::with('paket')->whereHas('paket', function ($query) use ($kategori) {
            $query->where('kategori', $kategori);
        })->get();

        return [
            'kategori_utama' => $kategori,
            'paket' => $paket,
            'pelatih' => $pelatih
        ];
    }
    
    public function createGym()
    {
        $data = $this->getMembershipData('Gym');
        return view('customer.membership.create', $data);
    }
    public function createMuayThai()
    {
        $data = $this->getMembershipData('Muay Thai');
        return view('customer.membership.create', $data);
    }
    public function createBoxing()
    {
        $data = $this->getMembershipData('Boxing');
        return view('customer.membership.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string',
            'sub_kategori' => 'required|string', // Ini akan menjadi 'Privat', 'Reguler', dll.
            'pelatih_id' => 'nullable|exists:pelatih,id',
            'paket_id' => 'required|exists:paket,id',
            'tgl_datang' => 'nullable|date',
            'tgl_mulai' => 'nullable|date',
            'tgl_selesai' => 'nullable|date|after_or_equal:tgl_mulai',
            'bukti_bayar' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $data = $request->all();
        $data['customer_id'] = Auth::user()->customer->id;
        $data['status'] = 'belum lunas';
        $data['status_selesai'] = false;

        if ($request->hasFile('bukti_bayar')) {
            $data['bukti_bayar'] = $request->file('bukti_bayar')->store('bukti_bayar', 'public');
        }

        Membership::create($data);

        // Anda perlu membuat halaman/route ini. Untuk sementara bisa redirect ke dashboard
         return redirect()->route('customer.reservasi.index')->with('success', 'Reservasi berhasil dibuat! Mohon tunggu konfirmasi dari admin.');
     }
}
