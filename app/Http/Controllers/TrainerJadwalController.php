<?php

namespace App\Http\Controllers;

use App\Models\MembershipDetail;
use Illuminate\Http\Request;

class TrainerJadwalController extends Controller
{
    public function index()
    {
        // Ambil semua detail membership yang accepted & belum selesai
        $jadwals = MembershipDetail::with(['membership.customer', 'membership.paket'])
            ->whereHas('membership', function ($query) {
                $query->where('accepted_trainer', true);
            })
            ->orderBy('tgl_datang', 'asc')
            ->get();

        return view('trainer.jadwal', compact('jadwals'));
    }

    public function selesai(MembershipDetail $membershipDetail)
    {
        $membershipDetail->update(['selesai' => true]);
        return redirect()->back()->with('success', 'Status selesai berhasil diperbarui.');
    }
}
