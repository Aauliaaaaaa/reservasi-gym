<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paket;
use App\Models\Pelatih;
use App\Models\Membership;
use App\Models\MembershipDetail;
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
            $membership->update([
                'tgl_datang' => $validatedData['tgl_datang'],
                'accepted_trainer' => null, // Reset status pelatih
                'reason' => null, // Reset alasan penolakan
            ]);
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
        $pelatih = Pelatih::with(['user','paket'])->whereHas('paket', function ($query) use ($kategori) {
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
        if ($request->sub_kategori === 'Privat') {
            $request->validate([
                'kategori' => 'required|string',
                'sub_kategori' => 'required|string',
                'pelatih_id' => 'required|exists:pelatih,id',
                'paket_id' => 'required|exists:paket,id',
                'tgl_datang_private' => 'required|array',
                'jam_mulai_private' => 'required|array',
                'jam_selesai_private' => 'required|array',
                'tgl_datang_private.*' => 'required|date',
                'jam_mulai_private.*' => 'required|date_format:H:i',
                'jam_selesai_private.*' => 'required|date_format:H:i|after:jam_mulai_private.*',
            ]);

            // Validasi konflik jadwal pelatih untuk paket privat
            foreach ($request->tgl_datang_private as $index => $tgl) {
                $jamMulai = $request->jam_mulai_private[$index];
                $jamSelesai = $request->jam_selesai_private[$index];
                
                // Cek apakah ada membership privat lain dengan pelatih yang sama di tanggal dan jam yang bentrok
                $konfliks = Membership::where('pelatih_id', $request->pelatih_id)
                    ->where('accepted_trainer', true) // Pastikan pelatih sudah menerima booking
                    ->where('status_selesai', false) // Pastikan membership belum selesai
                    ->where('sub_kategori', 'Privat')
                    ->whereHas('membershipDetails', function ($query) use ($tgl, $jamMulai, $jamSelesai) {
                        $query->where('tgl_datang', $tgl)
                            ->where(function ($q) use ($jamMulai, $jamSelesai) {
                                // Cek bentrok jam: jam baru dimulai sebelum jam lama selesai DAN jam baru selesai setelah jam lama dimulai
                                $q->where(function ($timeQuery) use ($jamMulai, $jamSelesai) {
                                    $timeQuery->where('jam_mulai', '<', $jamSelesai)
                                            ->where('jam_selesai', '>', $jamMulai);
                                });
                            });
                    })
                    ->exists();

                if ($konfliks) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors([
                            'jadwal_konflik' => "Pelatih sudah memiliki jadwal di tanggal {$tgl} pada jam {$jamMulai} - {$jamSelesai}. Silakan pilih waktu lain."
                        ]);
                }
            }
        } else {
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
        }

        $data = $request->all();
        $data['customer_id'] = Auth::user()->customer->id;
        $data['status'] = 'belum lunas';
        $data['status_selesai'] = false;

        if ($request->hasFile('bukti_bayar')) {
            $data['bukti_bayar'] = $request->file('bukti_bayar')->store('bukti_bayar', 'public');
        }

        if ($request->sub_kategori === 'Privat') {
            $membership = Membership::create([
                'customer_id' => $data['customer_id'],
                'pelatih_id' => $data['pelatih_id'] ?? null,
                'paket_id' => $data['paket_id'],
                'kategori' => $data['kategori'],
                'sub_kategori' => $data['sub_kategori'],
                'bukti_bayar' => $data['bukti_bayar'] ?? null,
                'status' => $data['status'],
                'status_selesai' => $data['status_selesai'],
            ]);

            foreach ($request->tgl_datang_private as $index => $tgl) {
                $membership->membershipDetails()->create([
                    'tgl_datang' => $tgl,
                    'jam_mulai' => $request->jam_mulai_private[$index],
                    'jam_selesai' => $request->jam_selesai_private[$index],
                ]);
            }
        } else {
            $membership = Membership::create([
                'customer_id' => $data['customer_id'],
                'pelatih_id' => $data['pelatih_id'] ?? null,
                'paket_id' => $data['paket_id'],
                'kategori' => $data['kategori'],
                'sub_kategori' => $data['sub_kategori'],
                'tgl_datang' => $data['tgl_datang'] ?? null,
                'tgl_mulai' => $data['tgl_mulai'] ?? null,
                'tgl_selesai' => $data['tgl_selesai'] ?? null,
                'bukti_bayar' => $data['bukti_bayar'] ?? null,
                'status' => $data['status'],
                'status_selesai' => $data['status_selesai'],
            ]);
        }

        // Anda perlu membuat halaman/route ini. Untuk sementara bisa redirect ke dashboard
         return redirect()->route('customer.reservasi.index')->with('success', 'Reservasi berhasil dibuat! Mohon tunggu konfirmasi dari admin.');
     }

     public function editPrivat(Membership $membership)
     {
         // Pastikan customer hanya bisa mengakses reservasinya sendiri
         if ($membership->customer_id !== Auth::user()->customer->id) {
             abort(403);
         }

         // PERBAIKAN: Tolak akses jika kategori paket bukan Privat
         if (strtolower($membership->sub_kategori) !== 'privat') {
             return redirect()->route('customer.reservasi.index')->with('error', 'Hanya reservasi privat yang bisa diubah.');
         }

         $data = $this->getMembershipData($membership->kategori);

         return view('customer.reservasi.edit-privat', compact('membership', 'data'));
     }

     public function editPrivatUpdate(Request $request, Membership $membership)
     {
         if ($membership->customer_id !== Auth::user()->customer->id) {
             abort(403);
         }

         // Validasi input
         $request->validate([
             'pelatih_id' => 'required|exists:pelatih,id',
             'tgl_datang_private' => 'required|array',
             'jam_mulai_private' => 'required|array',
             'jam_selesai_private' => 'required|array',
             'tgl_datang_private.*' => 'required|date',
             'jam_mulai_private.*' => 'required',
             'jam_selesai_private.*' => 'required|after:jam_mulai_private.*',
         ]);

         // Validasi konflik jadwal pelatih untuk paket privat
            foreach ($request->tgl_datang_private as $index => $tgl) {
                $jamMulai = $request->jam_mulai_private[$index];
                $jamSelesai = $request->jam_selesai_private[$index];
                
                // Cek apakah ada membership privat lain dengan pelatih yang sama di tanggal dan jam yang bentrok
                $konfliks = Membership::where('pelatih_id', $request->pelatih_id)
                    ->where('accepted_trainer', true) // Pastikan pelatih sudah menerima booking
                    ->where('status_selesai', false) // Pastikan membership belum selesai
                    ->where('sub_kategori', 'Privat')
                    ->whereHas('membershipDetails', function ($query) use ($tgl, $jamMulai, $jamSelesai) {
                        $query->where('tgl_datang', $tgl)
                            ->where(function ($q) use ($jamMulai, $jamSelesai) {
                                // Cek bentrok jam: jam baru dimulai sebelum jam lama selesai DAN jam baru selesai setelah jam lama dimulai
                                $q->where(function ($timeQuery) use ($jamMulai, $jamSelesai) {
                                    $timeQuery->where('jam_mulai', '<', $jamSelesai)
                                            ->where('jam_selesai', '>', $jamMulai);
                                });
                            });
                    })
                    ->exists();

                if ($konfliks) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors([
                            'jadwal_konflik' => "Pelatih sudah memiliki jadwal di tanggal {$tgl} pada jam {$jamMulai} - {$jamSelesai}. Silakan pilih waktu lain."
                        ]);
                }
            }

         // Hapus semua detail lama
         $membership->membershipDetails()->delete();

         // Tambahkan detail baru
         foreach ($request->tgl_datang_private as $index => $tgl) {
             $membership->membershipDetails()->create([
                 'tgl_datang' => $tgl,
                 'jam_mulai' => $request->jam_mulai_private[$index],
                 'jam_selesai' => $request->jam_selesai_private[$index],
             ]);
         }

         // Update membership
         $membership->update([
             'pelatih_id' => $request->pelatih_id,
             'status_selesai' => false, // Reset status selesai
             'accepted_trainer' => null, // Reset status pelatih
             'reason' => null, // Reset alasan penolakan
         ]);

         return redirect()->route('customer.reservasi.index')->with('success', 'Reservasi privat berhasil diperbarui.');
     }
}
