<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Mengambil data reservasi milik customer yang sedang login
        $reservations = Reservation::where('user_id', $user->id)
            ->latest()
            ->get();

        // Mengarah ke file: resources/views/customer/dashboard-customer.blade.php
        return view('customer.dashboard-customer', compact('user', 'reservations'));
    }
}