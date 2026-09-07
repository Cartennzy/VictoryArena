<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * TAMPILKAN SEMUA DATA CUSTOMER / MEMBER
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'customer');

        // Fitur Pencarian Nama, Email, atau WhatsApp
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->q . '%')
                  ->orWhere('email', 'like', '%' . $request->q . '%')
                  ->orWhere('phone', 'like', '%' . $request->q . '%');
            });
        }

        $customers = $query->withCount('reservations')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // ===============================
        // SUMMARY STATISTIK KONTROL
        // ===============================
        $totalCustomers = User::where('role', 'customer')->count();

        $activeCustomers = Reservation::where('status', 'approved')
            ->distinct('user_id')
            ->count('user_id');

        // Customer Paling Aktif Booking
        $topCustomer = Reservation::select(
                'user_id',
                DB::raw('COUNT(*) as total_booking')
            )
            ->with('user')
            ->groupBy('user_id')
            ->orderBy('total_booking', 'desc')
            ->first();

        // 🔥 SINKRONKAN DARI 'customers.index' KE 'admin.customers.index'
        return view('admin.customers.index', compact(
            'customers',
            'totalCustomers',
            'activeCustomers',
            'topCustomer'
        ));
    }

    /**
     * HAPUS DATA CUSTOMER
     */
    public function destroy(User $customer)
    {
        $customer->delete();
        return back()->with('success', 'Data member pemain berhasil dihapus.');
    }
}