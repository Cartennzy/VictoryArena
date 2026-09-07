<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Reservation;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();

        // Mengambil data sesuai logic asli tanpa mengubah struktur data yang sudah ada
        return view('admin.dashboard-admin', [
            'totalCustomers'     => User::where('role', 'customer')->count(),
            'totalReservations'  => Reservation::count(),
            'todayReservations'  => Reservation::where('date', $today)->count(),
            'latestReservations' => Reservation::with('user')->latest()->take(5)->get(),
        ]);
    }
}