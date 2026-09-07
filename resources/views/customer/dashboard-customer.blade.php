@extends('layouts.customer')

@section('title', 'Dashboard Customer | Victory Arena')

@section('content')

@php
/**
 * ==================================================
 * STATUS BADGE HELPER (SAFE FUNCTION WRAPPER)
 * ==================================================
 */
if (!function_exists('statusBadge')) {
    function statusBadge($item) {
        if ($item->payment_status === 'paid') {
            return ['Paid', 'emerald', 'fa-circle-check', 'bg-emerald-500/15 text-emerald-400 border-emerald-500/30'];
        }

        if ($item->date < now()->toDateString()) {
            return ['Expired', 'rose', 'fa-circle-xmark', 'bg-rose-500/15 text-rose-400 border-rose-500/30'];
        }

        return ['Pending', 'amber', 'fa-clock', 'bg-amber-500/15 text-amber-400 border-amber-500/30'];
    }
}
@endphp

{{-- ================= CUSTOM STYLES & INTERACTION ANIMATIONS ================= --}}
<style>
    .saas-card {
        background: rgba(15, 23, 42, 0.75);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 24px;
        box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.5);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .saas-card:hover {
        border-color: rgba(239, 68, 68, 0.25);
    }

    .btn-action {
        position: relative;
        overflow: hidden;
        user-select: none;
        transition: all 0.22s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .btn-action:hover {
        transform: translateY(-2px);
    }
    .btn-action:active {
        transform: translateY(2px) scale(0.97) !important;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3) !important;
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
        0% { transform: scale(0); opacity: 0.6; }
        100% { transform: scale(3.5); opacity: 0; }
    }

    .kpi-widget {
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.3s ease;
    }
    .kpi-widget:hover {
        transform: translateY(-4px);
    }
</style>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-slate-100 font-sans space-y-10">

    {{-- ==================================================
        HERO BANNER
    ================================================== --}}
    <div class="relative rounded-3xl overflow-hidden bg-gradient-to-r from-slate-900 via-slate-900 to-red-950/60 border border-slate-800 shadow-2xl p-8 md:p-10">
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-red-600/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute right-1/3 -bottom-20 w-60 h-60 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-red-950/60 border border-red-800/60 text-red-400 text-xs font-black tracking-widest uppercase mb-3">
                    <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                    Victory Arena Member Portal
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-white">
                    Selamat Datang, <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-rose-400">{{ $user->name }}</span>!
                </h1>
                <p class="mt-2 text-slate-400 text-sm sm:text-base max-w-xl leading-relaxed">
                    Kelola reservasi pertandingan tim, cek jam bermain yang aktif, dan amankan slot lapangan futsal tanpa antre.
                </p>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('customer.booking') }}"
                   class="btn-action px-6 py-3.5 rounded-xl bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-red-600/30">
                    <i class="fa-solid fa-plus mr-2 text-xs"></i> Booking Baru
                </a>
            </div>
        </div>
    </div>

    {{-- ==================================================
        KPI SECTION
    ================================================== --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Total Reservasi --}}
        <div class="saas-card kpi-widget p-6 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Reservasi</p>
                <p class="text-4xl font-black text-white mt-2">{{ $reservations->count() }}</p>
                <span class="text-[11px] text-slate-500 mt-1 block">Sepanjang waktu</span>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-blue-600/15 border border-blue-500/20 text-blue-400 flex items-center justify-center text-2xl">
                <i class="fa-solid fa-calendar-days"></i>
            </div>
        </div>

        {{-- Status Akun --}}
        <div class="saas-card kpi-widget p-6 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Status Akun</p>
                <div class="flex items-center gap-2 mt-2">
                    <p class="text-3xl font-black text-emerald-400">Aktif</p>
                    <span class="px-2 py-0.5 rounded-md bg-emerald-500/15 text-emerald-400 border border-emerald-500/30 text-[10px] font-extrabold uppercase tracking-wide">
                        Verified
                    </span>
                </div>
                <span class="text-[11px] text-slate-500 mt-1 block">{{ $user->email }}</span>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-emerald-600/15 border border-emerald-500/20 text-emerald-400 flex items-center justify-center text-2xl">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
        </div>

        {{-- Booking Baru Shortcut --}}
        <a href="{{ route('customer.booking') }}"
           class="saas-card kpi-widget p-6 flex items-center justify-between border-red-500/20 hover:border-red-500/50 group bg-gradient-to-br from-slate-900 to-red-950/30">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-red-400">Quick Match Action</p>
                <p class="text-2xl font-black text-white mt-2 group-hover:text-red-400 transition-colors">Pesan Lapangan</p>
                <span class="text-[11px] text-slate-400 mt-1 flex items-center gap-1">
                    Pilih slot waktu sekarang <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                </span>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-red-600/20 border border-red-500/30 text-red-500 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-futbol"></i>
            </div>
        </a>

    </div>

    {{-- ==================================================
        TABLE RESERVASI
    ================================================== --}}
    <div class="saas-card p-6 sm:p-8">
        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-6 pb-4 border-b border-slate-800">
            <div>
                <h3 class="text-xl font-bold uppercase tracking-tight text-white flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-red-500"></i> Riwayat Reservasi Saya
                </h3>
                <p class="text-xs text-slate-400 mt-0.5">Daftar jadwal dan status pembayaran seluruh match Anda.</p>
            </div>

            <a href="{{ route('jadwal.grid') }}"
               class="btn-action self-start sm:self-auto px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-750 text-slate-300 hover:text-white text-xs font-bold tracking-wider uppercase border border-slate-700">
                <i class="fa-solid fa-calendar mr-1.5 text-xs text-red-500"></i> Lihat Jadwal Lengkap
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="border-b border-slate-800 text-[11px] uppercase tracking-wider font-extrabold text-slate-400">
                        <th class="px-6 py-3.5">Tanggal Main</th>
                        <th class="px-6 py-3.5">Status Pembayaran</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-800/60">
                    @forelse($reservations as $item)
                        @php [$label, $color, $icon, $badgeStyle] = statusBadge($item); @endphp
                        <tr class="hover:bg-slate-800/30 transition-colors">
                            <td class="px-6 py-4 font-semibold text-white">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center text-slate-400 text-sm">
                                        <i class="fa-solid fa-calendar-day"></i>
                                    </div>
                                    <span>{{ \Carbon\Carbon::parse($item->date)->translatedFormat('l, d F Y') }}</span>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-bold border {{ $badgeStyle }}">
                                    <i class="fa-solid {{ $icon }} text-xs"></i>
                                    {{ $label }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-6 py-12 text-center text-slate-500">
                                <i class="fa-solid fa-calendar-xmark text-4xl mb-3 block text-slate-600"></i>
                                <p class="text-sm font-semibold">Belum ada riwayat reservasi.</p>
                                <p class="text-xs mt-1 text-slate-600">Mulai booking arena pertamamu sekarang!</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ==================================================
        CHART SECTION
    ================================================== --}}
    <div class="saas-card p-6 sm:p-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-xl font-bold uppercase tracking-tight text-white flex items-center gap-2">
                    <i class="fa-solid fa-chart-column text-red-500"></i> Jam Favorit Booking
                </h3>
                <p class="text-xs text-slate-400 mt-0.5">Analisis kepadatan jam main lapangan di Victory Arena.</p>
            </div>
        </div>

        <div class="w-full relative h-[260px]">
            <canvas id="bookingChart"></canvas>
        </div>
    </div>

</div>

{{-- Scripts: Chart.js & Universal Ripple Listener --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('bookingChart').getContext('2d');

    const gradient = ctx.createLinearGradient(0, 0, 0, 240);
    gradient.addColorStop(0, 'rgba(239, 68, 68, 0.85)');
    gradient.addColorStop(1, 'rgba(239, 68, 68, 0.1)');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['08-10', '10-12', '12-14', '14-16', '16-18', '18-20', '20-22'],
            datasets: [{
                label: 'Jumlah Booking',
                data: [2, 4, 1, 5, 6, 3, 4],
                backgroundColor: gradient,
                borderRadius: 8,
                borderWidth: 1,
                borderColor: '#ef4444',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0f172a',
                    titleColor: '#fff',
                    bodyColor: '#cbd5e1',
                    borderColor: 'rgba(255,255,255,0.1)',
                    borderWidth: 1,
                    padding: 10,
                    cornerRadius: 8
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(255, 255, 255, 0.05)' },
                    ticks: { color: '#64748b', font: { size: 11 } }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#94a3b8', font: { size: 11, weight: 'bold' } }
                }
            }
        }
    });
});

document.addEventListener('click', function(e) {
    const btn = e.target.closest('.btn-action');
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
    if (prevRipple) {
        prevRipple.remove();
    }

    btn.appendChild(ripple);

    setTimeout(() => {
        ripple.remove();
    }, 650);
});
</script>

@endsection