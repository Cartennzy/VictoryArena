<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * TAMPILKAN LAPORAN KEUANGAN & ANALITIK ARENA
     */
    public function index(Request $request)
    {
        $month = $request->input('month', Carbon::now()->month);
        $year  = $request->input('year', Carbon::now()->year);

        // Query Dasar Berdasarkan Filter Bulan & Tahun
        $reservationsQuery = Reservation::with('user')
            ->whereMonth('date', $month)
            ->whereYear('date', $year);

        // Filter Tambahan Lapangan jika Dipilih
        if ($request->filled('field') && $request->field !== 'all') {
            $reservationsQuery->where('field', $request->field);
        }

        $reservations = (clone $reservationsQuery)
            ->orderBy('date', 'desc')
            ->orderBy('start_time', 'desc')
            ->get();

        // ===============================
        // SUMMARY KEUANGAN & METRIK
        // ===============================
        $totalPendapatan = (clone $reservationsQuery)
            ->where('payment_status', 'paid')
            ->sum('total_price');

        $totalTransaksi = (clone $reservationsQuery)->count();

        $transaksiLunas = (clone $reservationsQuery)
            ->where('payment_status', 'paid')
            ->count();

        $transaksiPending = (clone $reservationsQuery)
            ->where('payment_status', 'pending')
            ->count();

        // Lapangan Paling Populer di Periode Ini
        $lapanganFavorit = (clone $reservationsQuery)
            ->select('field', DB::raw('COUNT(*) as total'))
            ->groupBy('field')
            ->orderBy('total', 'desc')
            ->value('field') ?? 'Belum ada data';

        // ===============================
        // DATA GRAFIK HARIAN (CHART)
        // ===============================
        $chartData = Reservation::whereMonth('date', $month)
            ->whereYear('date', $year)
            ->where('payment_status', 'paid')
            ->select(
                DB::raw('DATE(date) as tanggal'),
                DB::raw('SUM(total_price) as total_omset'),
                DB::raw('COUNT(*) as total_match')
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        // Format Label dan Data untuk Chart JS
        $chartLabels = $chartData->map(function ($item) {
            return Carbon::parse($item->tanggal)->format('d M');
        });

        $chartRevenue = $chartData->pluck('total_omset');
        $chartMatches = $chartData->pluck('total_match');

        // 🔥 SINKRONKAN DARI 'reports.index' KE 'admin.reports.index'
        return view('admin.reports.index', compact(
            'reservations',
            'totalPendapatan',
            'totalTransaksi',
            'transaksiLunas',
            'transaksiPending',
            'lapanganFavorit',
            'chartLabels',
            'chartRevenue',
            'chartMatches',
            'month',
            'year'
        ));
    }
}