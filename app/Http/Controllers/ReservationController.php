<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * TAMPILKAN SEMUA DATA RESERVASI ADMIN
     */
    public function index(Request $request)
    {
        $query = Reservation::with('user');

        // Filter Pencarian (Nama User atau Nama Lapangan)
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->whereHas('user', function ($u) use ($request) {
                    $u->where('name', 'like', '%' . $request->q . '%');
                })->orWhere('field', 'like', '%' . $request->q . '%');
            });
        }

        // Filter Status Jika Ada
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $reservations = $query->orderBy('date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(10)
            ->withQueryString();

        // ===============================
        // SUMMARY STATISTIK KONTROL
        // ===============================
        $totalReservasi    = Reservation::count();
        $reservasiPending  = Reservation::where('status', 'pending')->count();
        $reservasiApproved = Reservation::where('status', 'approved')->count();
        $totalPendapatan   = Reservation::where('payment_status', 'paid')->sum('total_price');

        // 🔥 SINKRONKAN KE VIEW ADMIN YANG BENAR: 'admin.reservations.index'
        return view('admin.reservations.index', compact(
            'reservations',
            'totalReservasi',
            'reservasiPending',
            'reservasiApproved',
            'totalPendapatan'
        ));
    }

    /**
     * UPDATE STATUS RESERVASI & PEMBAYARAN
     */
    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'status'         => 'required|in:pending,approved,cancelled,rejected',
            'payment_status' => 'required|in:pending,paid,failed',
        ]);

        $reservation->status         = $request->status;
        $reservation->payment_status = $request->payment_status;
        $reservation->save();

        return back()->with('success', "Status reservasi {$reservation->field} berhasil diperbarui!");
    }

    /**
     * HAPUS DATA RESERVASI
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return back()->with('success', 'Data reservasi berhasil dihapus.');
    }
}