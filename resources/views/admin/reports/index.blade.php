@extends('layouts.admin')

@section('title', 'Laporan Keuangan Arena | Victory Arena')

@section('content')

{{-- Chart.js CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{{-- ================= ULTRA-CLEAN SAAS STYLES ================= --}}
<style>
    .clean-panel {
        background: rgba(13, 20, 36, 0.75);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 20px;
        transition: border-color 0.2s ease;
    }
    .clean-panel:hover {
        border-color: rgba(255, 255, 255, 0.12);
    }

    .metric-card {
        background: rgba(10, 16, 30, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 18px;
        padding: 20px;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .metric-card:hover {
        background: rgba(13, 20, 38, 0.9);
        border-color: rgba(239, 68, 68, 0.3);
        transform: translateY(-2px);
    }

    .clean-select {
        height: 42px;
        background: rgba(8, 13, 26, 0.9);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 0 36px 0 14px;
        color: #f1f5f9;
        font-size: 0.82rem;
        font-weight: 700;
        outline: none;
        cursor: pointer;
        transition: all 0.2s ease;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 14px;
    }
    .clean-select:focus {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.18);
    }

    /* Primary Button with Push-Down State & Ripple */
    .btn-clean-primary {
        position: relative;
        overflow: hidden;
        height: 42px;
        border-radius: 12px;
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        border: 1px solid rgba(255, 255, 255, 0.18);
        color: #ffffff;
        font-weight: 800;
        font-size: 0.82rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 0 20px;
        cursor: pointer;
        user-select: none;
        box-shadow: 0 6px 18px -4px rgba(220, 38, 38, 0.5);
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .btn-clean-primary:hover {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        transform: translateY(-1px);
        box-shadow: 0 10px 22px -4px rgba(220, 38, 38, 0.65);
    }
    .btn-clean-primary:active {
        transform: translateY(2px) scale(0.98) !important;
        box-shadow: 0 2px 6px rgba(220, 38, 38, 0.3) !important;
    }

    .btn-clean-secondary {
        position: relative;
        overflow: hidden;
        height: 42px;
        border-radius: 12px;
        background: rgba(15, 23, 42, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.08);
        color: #94a3b8;
        font-weight: 700;
        font-size: 0.82rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 0 16px;
        cursor: pointer;
        user-select: none;
        transition: all 0.2s ease;
    }
    .btn-clean-secondary:hover {
        background: rgba(30, 41, 59, 0.9);
        color: #ffffff;
        border-color: rgba(255, 255, 255, 0.16);
        transform: translateY(-1px);
    }
    .btn-clean-secondary:active {
        transform: translateY(2px) scale(0.98) !important;
    }

    .ripple-wave {
        position: absolute;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.45);
        pointer-events: none;
        transform: scale(0);
        animation: rippleAnim 0.65s cubic-bezier(0, 0, 0.2, 1);
    }
    @keyframes rippleAnim {
        0% { transform: scale(0); opacity: 0.7; }
        100% { transform: scale(3.5); opacity: 0; }
    }

    @media print {
        header, aside, .no-print { display: none !important; }
        body, main, .clean-panel {
            background: #fff !important;
            color: #000 !important;
            border: 1px solid #ddd !important;
            box-shadow: none !important;
        }
        table { color: #000 !important; }
    }
</style>

<div class="max-w-7xl mx-auto space-y-7 text-slate-100 font-sans">

    {{-- ================= TOP HEADER ================= --}}
    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 no-print">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-950/50 border border-red-800/50 text-red-400 text-[10px] font-black tracking-widest uppercase mb-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                Financial & Occupancy Intelligence
            </div>
            <h1 class="text-2xl sm:text-3xl font-black uppercase tracking-tight text-white">
                Laporan Keuangan & Okupansi
            </h1>
            <p class="text-xs text-slate-400 mt-0.5">
                Ringkasan perputaran kas sewa lapangan futsal, status pembayaran, dan tren pemesanan.
            </p>
        </div>

        <div class="flex items-center gap-2.5 self-start sm:self-auto">
            <button type="button" onclick="window.print()" class="btn-clean-secondary">
                <i class="fa-solid fa-print text-xs text-red-500"></i>
                <span>Cetak Rekap</span>
            </button>
            <a href="{{ route('dashboard') }}" class="btn-clean-secondary">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                <span>Dashboard</span>
            </a>
        </div>
    </div>

    {{-- ================= INLINE COMPACT FILTER BAR ================= --}}
    <div class="clean-panel p-4 no-print">
        <form method="GET" action="{{ route('laporan.index') }}" class="flex flex-wrap items-center justify-between gap-3">
            <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                <div class="flex items-center gap-2">
                    <span class="text-[11px] font-bold uppercase text-slate-400">Bulan:</span>
                    <select name="month" class="clean-select w-36">
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="flex items-center gap-2">
                    <span class="text-[11px] font-bold uppercase text-slate-400">Tahun:</span>
                    <select name="year" class="clean-select w-28">
                        @for($y = Carbon\Carbon::now()->year; $y >= 2024; $y--)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>

                <div class="flex items-center gap-2">
                    <span class="text-[11px] font-bold uppercase text-slate-400">Arena:</span>
                    <select name="field" class="clean-select w-44">
                        <option value="all" {{ request('field') == 'all' ? 'selected' : '' }}>Semua Lapangan</option>
                        <option value="Lapangan 1" {{ request('field') == 'Lapangan 1' ? 'selected' : '' }}>Lapangan 1</option>
                        <option value="Lapangan 2" {{ request('field') == 'Lapangan 2' ? 'selected' : '' }}>Lapangan 2</option>
                        <option value="Lapangan 3" {{ request('field') == 'Lapangan 3' ? 'selected' : '' }}>Lapangan 3</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn-clean-primary w-full sm:w-auto">
                <i class="fa-solid fa-filter text-xs"></i>
                <span>Filter Data</span>
            </button>
        </form>
    </div>

    {{-- ================= 4 SPACIOUS METRIC CARDS (NO OVERLAP) ================= --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        {{-- Card 1: Total Omset Lunas --}}
        <div class="metric-card flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-400 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-wallet"></i>
            </div>
            <div class="min-w-0 flex-1">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block truncate">Total Omset Lunas</span>
                <p class="text-xl font-black text-emerald-400 mt-0.5 truncate">
                    Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                </p>
                <span class="text-[10px] text-emerald-500 font-semibold block mt-0.5">Terverifikasi Masuk</span>
            </div>
        </div>

        {{-- Card 2: Total Transaksi --}}
        <div class="metric-card flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-500/15 border border-blue-500/30 text-blue-400 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-receipt"></i>
            </div>
            <div class="min-w-0 flex-1">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block truncate">Total Transaksi</span>
                <p class="text-2xl font-black text-white mt-0.5">
                    {{ $totalTransaksi }} <span class="text-xs text-slate-500 font-bold">Booking</span>
                </p>
                <span class="text-[10px] text-slate-400 font-semibold block mt-0.5">{{ $transaksiLunas }} Selesai Lunas</span>
            </div>
        </div>

        {{-- Card 3: Menunggu Kasir --}}
        <div class="metric-card flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-500/15 border border-amber-500/30 text-amber-400 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-hourglass-half"></i>
            </div>
            <div class="min-w-0 flex-1">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block truncate">Belum Lunas / Kasir</span>
                <p class="text-2xl font-black text-amber-400 mt-0.5">
                    {{ $transaksiPending }} <span class="text-xs text-slate-500 font-bold">Slot</span>
                </p>
                <span class="text-[10px] text-amber-500/80 font-semibold block mt-0.5">Menunggu Pembayaran</span>
            </div>
        </div>

        {{-- Card 4: Arena Paling Diminati --}}
        <div class="metric-card flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-red-600/15 border border-red-500/30 text-red-500 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-trophy"></i>
            </div>
            <div class="min-w-0 flex-1">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block truncate">Arena Paling Ramai</span>
                <p class="text-base font-black text-white mt-0.5 truncate" title="{{ $lapanganFavorit }}">
                    {{ $lapanganFavorit }}
                </p>
                <span class="text-[10px] text-red-400 font-semibold block mt-0.5">Top Okupansi Match</span>
            </div>
        </div>

    </div>

    {{-- ================= REVENUE CHART ANALYTICS ================= --}}
    <div class="clean-panel p-6 sm:p-7 space-y-3 no-print">
        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-2 pb-3 border-b border-slate-800/80">
            <div>
                <span class="text-[10px] font-black uppercase tracking-widest text-red-500 block">Performance Curve</span>
                <h3 class="text-base font-black uppercase text-white tracking-wide">Tren Pendapatan Harian</h3>
            </div>
            <span class="text-xs font-semibold text-slate-400">
                Periode: <span class="text-slate-200 font-bold">{{ \Carbon\Carbon::create()->month((int)$month)->translatedFormat('F') }} {{ $year }}</span>
            </span>
        </div>

        <div class="h-60 sm:h-64 w-full pt-2">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    {{-- ================= RINCIAN TRANSAKSI ================= --}}
    <div class="clean-panel p-6 sm:p-7 space-y-4">
        <div class="flex justify-between items-center pb-3 border-b border-slate-800/80">
            <div>
                <span class="text-[10px] font-black uppercase tracking-widest text-red-500 block">Audit Log</span>
                <h3 class="text-base font-black uppercase text-white tracking-wide">Rincian Transaksi Booking</h3>
            </div>
            <span class="text-xs font-bold text-slate-400 bg-slate-900 border border-slate-800 px-3 py-1 rounded-xl">
                {{ $reservations->count() }} Data Ditemukan
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-slate-500 uppercase font-black text-[10px] border-b border-slate-800">
                        <th class="pb-3 px-3">No</th>
                        <th class="pb-3 px-3">Kode Booking</th>
                        <th class="pb-3 px-3">Nama Pemesan</th>
                        <th class="pb-3 px-3">Arena</th>
                        <th class="pb-3 px-3">Jadwal Tanding</th>
                        <th class="pb-3 px-3">Metode</th>
                        <th class="pb-3 px-3">Status</th>
                        <th class="pb-3 px-3 text-right">Nominal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 font-semibold text-slate-300">
                    @forelse($reservations as $index => $item)
                        <tr class="hover:bg-slate-900/40 transition-colors">
                            <td class="py-3 px-3 text-slate-500 font-mono">{{ $index + 1 }}</td>
                            <td class="py-3 px-3 font-mono font-bold text-slate-300">
                                VA-{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="py-3 px-3 font-bold text-white uppercase">
                                {{ $item->user->name ?? 'Customer' }}
                            </td>
                            <td class="py-3 px-3">
                                <span class="px-2 py-0.5 rounded-md bg-slate-900 border border-slate-800 text-[10px] font-black uppercase text-slate-200">
                                    {{ $item->field }}
                                </span>
                            </td>
                            <td class="py-3 px-3 font-medium">
                                {{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }} 
                                <span class="text-[11px] text-slate-500 font-mono">({{ substr($item->start_time, 0, 5) }}-{{ substr($item->end_time, 0, 5) }})</span>
                            </td>
                            <td class="py-3 px-3 uppercase text-[11px] text-slate-400">
                                {{ $item->payment_method === 'transfer' ? 'Midtrans' : 'Tunai' }}
                            </td>
                            <td class="py-3 px-3">
                                @if($item->payment_status === 'paid')
                                    <span class="px-2 py-0.5 rounded-md bg-emerald-500/15 text-emerald-400 border border-emerald-500/30 text-[9px] font-black uppercase">
                                        Lunas
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded-md bg-amber-500/15 text-amber-400 border border-amber-500/30 text-[9px] font-black uppercase">
                                        Pending
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-3 text-right font-black text-white">
                                Rp {{ number_format($item->total_price, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-10 text-center text-slate-500 font-bold">
                                <i class="fa-solid fa-chart-pie text-2xl mb-2 block opacity-30"></i>
                                Tidak ada data transaksi pada periode yang dipilih.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if($reservations->isNotEmpty())
                    <tfoot>
                        <tr class="border-t border-slate-700 bg-slate-950/50 font-black text-white">
                            <td colspan="7" class="py-3.5 px-3 text-right uppercase tracking-wider text-xs">Total Omset Lunas:</td>
                            <td class="py-3.5 px-3 text-right text-sm text-emerald-400 font-black">
                                Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>

</div>

{{-- Script Chart.js & Universal Ripple --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('revenueChart');
    if (!ctx) return;

    const labels = {!! json_encode($chartLabels) !!};
    const dataRevenue = {!! json_encode($chartRevenue) !!};

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels.length ? labels : ['Tidak Ada Data'],
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: dataRevenue.length ? dataRevenue : [0],
                borderColor: '#ef4444',
                backgroundColor: 'rgba(239, 68, 68, 0.08)',
                borderWidth: 2.5,
                tension: 0.35,
                fill: true,
                pointBackgroundColor: '#ef4444',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 1.5,
                pointRadius: 3.5,
                pointHoverRadius: 5.5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return ' Omset: Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                        }
                    }
                }
            },
            scales: {
                y: {
                    grid: { color: 'rgba(255, 255, 255, 0.04)' },
                    ticks: {
                        color: '#64748b',
                        font: { size: 10, weight: '600' },
                        callback: function(value) {
                            return 'Rp ' + (value / 1000) + 'k';
                        }
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: {
                        color: '#64748b',
                        font: { size: 10, weight: '600' }
                    }
                }
            }
        }
    });
});

// Ripple Effect
document.addEventListener('click', function(e) {
    const btn = e.target.closest('.btn-clean-primary, .btn-clean-secondary');
    if (!btn || btn.hasAttribute('disabled')) return;

    const rect = btn.getBoundingClientRect();
    const ripple = document.createElement('span');

    const diameter = Math.max(rect.width, rect.height);
    const radius = diameter / 2;

    ripple.style.width = ripple.style.height = `${diameter}px`;
    ripple.style.left = `${e.clientX - rect.left - radius}px`;
    ripple.style.top = `${e.clientY - rect.top - radius}px`;
    ripple.classList.add('ripple-wave');

    const prevRipple = btn.querySelector('.ripple-wave');
    if (prevRipple) prevRipple.remove();

    btn.appendChild(ripple);
    setTimeout(() => ripple.remove(), 650);
});
</script>

@endsection