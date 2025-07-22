<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\MembershipDetail;
use App\Models\Pelatih;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        // dd(Auth::id());
        $pelatih = Pelatih::select('id')
                            ->where('user_id', Auth::id())
                            ->get()
                            ->pluck('id');

        $memberships = Membership::whereIn('pelatih_id', $pelatih)
                                 ->with(['customer', 'paket'])
                                 ->latest()
                                 ->get();

        return view('trainer.booking.index', compact('memberships'));
    }

    public function detail($membership)
    {
        $dataMembership = Membership::with(['customer', 'paket', 'membershipDetails'])
                                ->where('id', $membership)
                                ->firstOrFail();
        // dd($dataMembership);
        return view('trainer.booking.detail', compact('dataMembership'));
    }

    public function accept(Request $request, $membership)
    {
        $membership = Membership::findOrFail($membership);
        $membership->update([
            'accepted_trainer' => true,
        ]);

        return redirect()->route('trainer.booking.index')->with('success', 'Booking accepted successfully.');
    }

    public function reject(Request $request, $membership)
    {
        $membership = Membership::findOrFail($membership);
        $membership->update([
            'accepted_trainer' => false,
            'reason' => $request->input('reason', 'No reason provided'),
        ]);

        return redirect()->route('trainer.booking.index')->with('success', 'Booking rejected successfully.');
    }

    public function selesai(Request $request, $membership)
    {
        $membership = Membership::findOrFail($membership);
        $membership->update([
            'status_selesai' => true,
        ]);

        return redirect()->back()->with('success', 'Booking completed successfully.');
    }

    public function selesaiPrivate(Request $request, $membership, $detail)
    {
        $membershipDetail = MembershipDetail::findOrFail($detail);

        $membershipDetail->update([
            'selesai' => true,
        ]);

        // Check if all membership details are completed
        $allCompleted = MembershipDetail::where('membership_id', $membership)
                                        ->where('selesai', false)
                                        ->count() === 0;

        if ($allCompleted) {
            $membershipRecord = Membership::findOrFail($membership);
            $membershipRecord->update([
                'status_selesai' => true,
            ]);
        }

        return redirect()->back()->with('success', 'Private session marked as completed successfully.');
    }
}
