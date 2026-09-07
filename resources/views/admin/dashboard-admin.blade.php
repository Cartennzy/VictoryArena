@extends('layouts.admin')

@section('title', 'Command Center Admin | Victory Arena')

@section('content')

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

    /* Primary Button with Push-Down State & Ripple */
    .btn-clean-primary {
        position: relative;
        overflow: hidden;
        height: 44px;
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
        padding: 0 18px;
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
        height: 38px;
        border-radius: 10px;
        background: rgba(15, 23, 42, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.08);
        color: #94a3b8;
        font-weight: 700;
        font-size: 0.78rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 0 14px;
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
</style>

<div class="max-w-7xl mx-auto space-y-7 text-slate-100 font-sans">

    {{-- ================= TOP HEADER ================= --}}
    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-950/50 border border-red-800/50 text-red-400 text-[10px] font-black tracking-widest uppercase mb-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                Official Command Center
            </div>
            <h1 class="text-2xl sm:text-3xl font-black uppercase tracking-tight text-white">
                Dashboard Operasional
            </h1>
            <p class="text-xs text-slate-400 mt-0.5">
                Ringkasan aktivitas reservasi, antrean pertandingan hari ini, dan data statistik member.
            </p>
        </div>

        <div class="flex items-center gap-3 self-start sm:self-auto">
            <div class="hidden md:flex items-center gap-2 px-3.5 py-2 rounded-xl bg-slate-900/80 border border-slate-800 text-xs font-bold text-slate-300">
                <i class="fa-regular fa-calendar text-red-500"></i>
                <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
            </div>
            
            <a href="{{ Route::has('reservations.index') ? route('reservations.index') : url('/admin/reservations') }}" class="btn-clean-primary">
                <i class="fa-solid fa-list-check text-xs"></i>
                <span>Verifikasi Tiket</span>
            </a>
        </div>
    </div>

    {{-- ================= 3 SPACIOUS METRIC CARDS ================= --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        
        {{-- Card 1: Total Customer --}}
        <div class="metric-card flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-500/15 border border-blue-500/30 text-blue-400 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="min-w-0 flex-1">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block truncate">Total Customer</span>
                <p class="text-2xl font-black text-white mt-0.5 truncate">{{ $totalCustomers }} <span class="text-xs font-normal text-slate-400">Pemain</span></p>
                <span class="text-[10px] text-slate-500 font-semibold block mt-0.5">Member Terdaftar</span>
            </div>
        </div>

        {{-- Card 2: Kick-Off Hari Ini --}}
        <div class="metric-card flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-500/15 border border-amber-500/30 text-amber-400 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-calendar-day"></i>
            </div>
            <div class="min-w-0 flex-1">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block truncate">Kick-Off Hari Ini</span>
                <p class="text-2xl font-black text-amber-400 mt-0.5 truncate">{{ $todayReservations }} <span class="text-xs font-normal text-amber-400/80">Laga</span></p>
                <span class="text-[10px] text-amber-500/80 font-semibold block mt-0.5">Jadwal Main Tanggal Ini</span>
            </div>
        </div>

        {{-- Card 3: Akumulasi Booking --}}
        <div class="metric-card flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-400 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-futbol"></i>
            </div>
            <div class="min-w-0 flex-1">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block truncate">Akumulasi Booking</span>
                <p class="text-2xl font-black text-white mt-0.5 truncate">{{ $totalReservations }} <span class="text-xs font-normal text-slate-400">Match</span></p>
                <span class="text-[10px] text-slate-500 font-semibold block mt-0.5">Seluruh Riwayat Arena</span>
            </div>
        </div>

    </div>

    {{-- ================= ACTIVITY STREAM TABLE ================= --}}
    <div class="clean-panel p-6 sm:p-7 space-y-4">
        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-3 pb-4 border-b border-slate-800/80">
            <div>
                <span class="text-[10px] font-black uppercase tracking-widest text-red-500 block">Activity Stream</span>
                <h3 class="text-base font-black uppercase text-white tracking-wide">5 Reservasi Terbaru Masuk</h3>
            </div>
            
            <a href="{{ Route::has('reservations.index') ? route('reservations.index') : url('/admin/reservations') }}" class="btn-clean-secondary">
                <span>Buka Seluruh Data</span>
                <i class="fa-solid fa-arrow-right text-[11px] text-red-500 ml-1"></i>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-slate-500 uppercase font-black text-[10px] border-b border-slate-800">
                        <th class="pb-3 px-3">Nama Pemesan</th>
                        <th class="pb-3 px-3">Arena Lapangan</th>
                        <th class="pb-3 px-3">Tanggal Pertandingan</th>
                        <th class="pb-3 px-3">Slot Waktu</th>
                        <th class="pb-3 px-3">Nominal</th>
                        <th class="pb-3 px-3 text-right">Status Match</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 font-semibold text-slate-300">
                    @forelse($latestReservations as $item)
                        <tr class="hover:bg-slate-900/40 transition-colors">
                            <td class="py-3 px-3 font-bold text-white uppercase flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-lg bg-red-600/15 border border-red-500/30 text-red-400 flex items-center justify-center font-black text-[11px] shrink-0">
                                    {{ strtoupper(substr($item->user->name ?? 'C', 0, 1)) }}
                                </div>
                                <span class="truncate">{{ $item->user->name ?? 'Customer' }}</span>
                            </td>
                            <td class="py-3 px-3">
                                <span class="px-2 py-0.5 rounded-md bg-slate-900 border border-slate-800 text-white font-black text-[10px] uppercase">
                                    {{ $item->field }}
                                </span>
                            </td>
                            <td class="py-3 px-3 font-medium text-slate-300">
                                {{ \Carbon\Carbon::parse($item->date)->translatedFormat('l, d M Y') }}
                            </td>
                            <td class="py-3 px-3 font-mono font-bold text-slate-200">
                                {{ substr($item->start_time, 0, 5) }} - {{ substr($item->end_time, 0, 5) }} WIB
                            </td>
                            <td class="py-3 px-3 font-black text-emerald-400">
                                Rp {{ number_format($item->total_price, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-3 text-right">
                                @if($item->status === 'approved')
                                    <span class="px-2 py-0.5 rounded-md bg-emerald-500/15 text-emerald-400 border border-emerald-500/30 text-[9px] font-black uppercase">
                                        Approved
                                    </span>
                                @elseif($item->status === 'pending')
                                    <span class="px-2 py-0.5 rounded-md bg-amber-500/15 text-amber-400 border border-amber-500/30 text-[9px] font-black uppercase">
                                        Pending
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded-md bg-slate-800 text-slate-400 border border-slate-700 text-[9px] font-black uppercase">
                                        {{ $item->status }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-slate-500 font-bold">
                                <i class="fa-solid fa-inbox text-2xl mb-2 block opacity-30"></i>
                                Belum ada aktivitas reservasi yang tercatat di sistem.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Script Universal Ripple Effect --}}
<script>
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