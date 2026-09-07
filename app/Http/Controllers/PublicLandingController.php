<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\Testimonial;
use Illuminate\Support\Facades\DB;

class PublicLandingController extends Controller
{
    public function index()
    {
        // Ambil semua lapangan
        $fields = Field::all();

        // Total booking approved
        $totalBookings = DB::table('reservations')
            ->where('status', 'approved')
            ->count();

        // Total lapangan
        $totalFields = Field::count();

        // Testimonial terbaru
        $testimonials = Testimonial::latest()->take(6)->get();

        // Booking heatmap per jam
        $heatmap = DB::table('reservations')
            ->selectRaw('HOUR(start_time) as hour, COUNT(*) as total')
            ->where('status','approved')
            ->groupBy('hour')
            ->get();

        return view('page-public.landing', compact(
            'fields',
            'totalBookings',
            'totalFields',
            'testimonials',
            'heatmap'
        ));
    }
}
