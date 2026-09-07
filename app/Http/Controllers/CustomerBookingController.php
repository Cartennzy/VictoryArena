<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CustomerBookingController extends Controller
{
    private function lapanganList()
    {
        return [
            [
                'name'        => 'Lapangan 1',
                'harga_siang' => 120000,
                'harga_malam' => 175000,
                'foto'        => 'assets/lapangan1.jpg',
                'spesifikasi' => 'Vinyl Interlock • High Lux LED • Digital Scoreboard'
            ],
            [
                'name'        => 'Lapangan 2',
                'harga_siang' => 120000,
                'harga_malam' => 175000,
                'foto'        => 'assets/lapangan2.jpg',
                'spesifikasi' => 'Vinyl Interlock • High Lux LED • Digital Scoreboard'
            ],
            [
                'name'        => 'Lapangan 3',
                'harga_siang' => 120000,
                'harga_malam' => 175000,
                'foto'        => 'assets/lapangan3.jpg',
                'spesifikasi' => 'Vinyl Interlock • High Lux LED • Digital Scoreboard'
            ],
        ];
    }

    /**
     * TAMPILKAN RIWAYAT BOOKING SAYA
     */
    public function index()
    {
        $user = Auth::user();

        $reservations = Reservation::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->orderBy('start_time', 'desc')
            ->get();

        $totalCount    = $reservations->count();
        $approvedCount = $reservations->where('status', 'approved')->count();
        $pendingCount  = $reservations->where('status', 'pending')->count();
        $totalSpent    = $reservations->where('payment_status', 'paid')->sum('total_price');

        return view('customer.reservations.index', compact(
            'reservations',
            'totalCount',
            'approvedCount',
            'pendingCount',
            'totalSpent'
        ));
    }

    /**
     * HALAMAN VIEW KALENDER JADWAL TERSEDIA (CUSTOMER)
     */
    public function schedulesIndex(Request $request)
    {
        $lapangan = $this->lapanganList();
        return view('customer.schedules.index', compact('lapangan'));
    }

    /**
     * FORM BOOKING LAPANGAN
     */
    public function create()
    {
        $user = Auth::user();

        if (empty($user->phone)) {
            return redirect()->route('customer.customer.form')->with('info', 'Lengkapi data customer terlebih dahulu.');
        }

        return view('customer.reservations.create', [
            'lapangan' => $this->lapanganList(),
            'user'     => $user,
        ]);
    }

    /**
     * SIMPAN RESERVASI BARU
     */
    public function store(Request $request)
    {
        $request->validate([
            'field'          => 'required',
            'date'           => 'required|date',
            'start_time'     => 'required',
            'end_time'       => 'required',
            'payment_method' => 'required|in:transfer,cash',
        ]);

        $start = Carbon::createFromFormat('H:i', $request->start_time);
        $end   = Carbon::createFromFormat('H:i', $request->end_time);

        if ($end->diffInMinutes($start) < 60) {
            return back()->withErrors(['time' => 'Minimal durasi bermain adalah 1 jam'])->withInput();
        }

        // Cek Bentrok
        $bentrok = Reservation::where('field', $request->field)
            ->where('date', $request->date)
            ->whereIn('status', ['pending', 'approved'])
            ->where(function ($q) use ($request) {
                $q->whereBetween('start_time', [$request->start_time, $request->end_time])
                  ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                  ->orWhere(function ($q2) use ($request) {
                      $q2->where('start_time', '<=', $request->start_time)
                         ->where('end_time', '>=', $request->end_time);
                  });
            })
            ->exists();

        if ($bentrok) {
            return back()->withErrors(['bentrok' => 'Jadwal sudah terisi, silakan pilih waktu lain.'])->withInput();
        }

        // Sinkronisasi Tarif: Siang Rp 120.000 / Malam & Weekend Rp 175.000
        $bookingDate = Carbon::parse($request->date);
        $startHour   = (int) $start->format('H');
        $isWeekend   = $bookingDate->isWeekend();

        $tarifPerJam = ($isWeekend || $startHour >= 16) ? 175000 : 120000;
        $durasiJam   = $end->diffInHours($start);
        $totalHarga  = $tarifPerJam * ($durasiJam ?: 1);

        $reservation = Reservation::create([
            'user_id'        => Auth::id(),
            'field'          => $request->field,
            'date'           => $request->date,
            'start_time'     => $request->start_time,
            'end_time'       => $request->end_time,
            'total_price'    => $totalHarga,
            'payment_method' => $request->payment_method,
            'status'         => 'pending',
            'payment_status' => 'pending',
        ]);

        if ($request->payment_method === 'transfer') {
            return redirect()->route('payment.midtrans', $reservation->id);
        }

        return redirect()->route('customer.reservations.index')->with('success', 'Booking berhasil dibuat! Silakan bayar di kasir arena.');
    }

    public function getBookedSchedule(Request $request)
    {
        $request->validate(['field' => 'required', 'date' => 'required|date']);
        $jadwal = Reservation::where('field', $request->field)
            ->where('date', $request->date)
            ->whereIn('status', ['pending', 'approved'])
            ->get(['start_time', 'end_time']);

        return response()->json($jadwal);
    }

    /**
     * HYBRID JADWAL GRID:
     * JIKA DIAKSES MANUAL OLEH BROWSER (BUKAN AJAX) => MERENDER VIEW KALENDER VISUAL
     * JIKA DIPANGGIL VIA JAVASCRIPT FETCH => MENGEMBALIKAN DATA JSON
     */
    public function jadwalGrid(Request $request)
    {
        // 1. Deteksi apakah diakses langsung via browser URL
        if (!$request->ajax() && !$request->wantsJson() && !$request->has('lapangan')) {
            $lapangan = $this->lapanganList();
            return view('customer.schedules.index', compact('lapangan'));
        }

        // 2. Jika dipanggil fetch JSON untuk kalkulasi jadwal slot
        $field = $request->lapangan ?? 'Lapangan 1';
        $date  = $request->date ?? date('Y-m-d');
        $hours = range(8, 22);

        $reservations = Reservation::where('field', $field)
            ->where('date', $date)
            ->whereIn('status', ['pending', 'approved'])
            ->get();

        $blocked = [];
        $pending = [];

        foreach ($reservations as $r) {
            $range = range(
                (int) substr($r->start_time, 0, 2),
                (int) substr($r->end_time, 0, 2) - 1
            );

            if ($r->payment_status === 'paid') {
                $blocked = array_merge($blocked, $range);
            } else {
                $pending = array_merge($pending, $range);
            }
        }

        return response()->json([
            'hours'   => $hours,
            'blocked' => array_values(array_unique($blocked)),
            'pending' => array_values(array_unique($pending)),
        ]);
    }
}