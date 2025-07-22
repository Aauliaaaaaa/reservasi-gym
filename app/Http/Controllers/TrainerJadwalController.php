<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\MembershipDetail;
use App\Models\Pelatih;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainerJadwalController extends Controller
{
    public function index()
    {
        $pelatih = Pelatih::select('id')
                    ->where('user_id', Auth::id())
                    ->get()
                    ->pluck('id');

        $memberships = Membership::whereIn('pelatih_id', $pelatih)
                     ->with(['customer', 'paket', 'membershipDetails' => function($query) {
                         $query->orderBy('tgl_datang', 'desc');
                     }])
                     ->where('accepted_trainer', true)
                     ->whereIn('sub_kategori', ['Insidental', 'Privat'])
                     ->orderBy('tgl_datang', 'desc')
                     ->get();

        $jadwals = [];
        foreach ($memberships as $membership) {
            if ($membership->sub_kategori === 'Insidental') {
            $jadwals[] = [
                'membership' => $membership,
                'detail' => null, // Insidental does not have details
            ];
            } else {
            foreach ($membership->membershipDetails as $detail) {
                $jadwals[] = [
                'membership' => $membership,
                'detail' => $detail,
                ];
            }
            }
        }

        usort($jadwals, function($a, $b) {
            $dateA = $a['detail'] ? $a['detail']->tgl_datang : $a['membership']->tgl_datang;
            $dateB = $b['detail'] ? $b['detail']->tgl_datang : $b['membership']->tgl_datang;
            return $dateB <=> $dateA;
        });

        return view('trainer.jadwal', compact('jadwals'));
    }

    public function selesai(MembershipDetail $membershipDetail)
    {
        $membershipDetail->update(['selesai' => true]);
        return redirect()->back()->with('success', 'Status selesai berhasil diperbarui.');
    }
}
