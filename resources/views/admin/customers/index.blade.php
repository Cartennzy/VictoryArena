@extends('layouts.admin')

@section('title', 'Database Customer & Pemain | Victory Arena')

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

    .clean-input {
        height: 42px;
        background: rgba(8, 13, 26, 0.9);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 0 16px 0 38px;
        color: #ffffff;
        font-size: 0.82rem;
        font-weight: 600;
        outline: none;
        transition: all 0.2s ease;
    }
    .clean-input:focus {
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
</style>

<div class="max-w-7xl mx-auto space-y-7 text-slate-100 font-sans">

    {{-- ================= TOP HEADER ================= --}}
    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-950/50 border border-red-800/50 text-red-400 text-[10px] font-black tracking-widest uppercase mb-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                Player Directory & Squad Hub
            </div>
            <h1 class="text-2xl sm:text-3xl font-black uppercase tracking-tight text-white">
                Database Customer Pemain
            </h1>
            <p class="text-xs text-slate-400 mt-0.5">
                Daftar akun pemain terdaftar, kontak WhatsApp tim, riwayat aktivitas laga, dan status member.
            </p>
        </div>

        <div class="flex items-center gap-2.5 self-start sm:self-auto">
            <a href="{{ route('dashboard') }}" class="btn-clean-secondary">
                <i class="fa-solid fa-arrow-left text-xs text-red-500"></i>
                <span>Kembali ke Dashboard</span>
            </a>
        </div>
    </div>

    {{-- Alert Notification --}}
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-bold flex items-center gap-2.5 shadow-lg shadow-emerald-950/30">
            <i class="fa-solid fa-circle-check text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- ================= 3 SPACIOUS METRIC CARDS ================= --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        
        {{-- Card 1: Total Member --}}
        <div class="metric-card flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-500/15 border border-blue-500/30 text-blue-400 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="min-w-0 flex-1">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block truncate">Total Member Terdaftar</span>
                <p class="text-2xl font-black text-white mt-0.5 truncate">{{ $totalCustomers }} <span class="text-xs font-normal text-slate-400">Pemain</span></p>
                <span class="text-[10px] text-slate-500 font-semibold block mt-0.5">Akun Aktif Sistem</span>
            </div>
        </div>

        {{-- Card 2: Pernah Bertanding --}}
        <div class="metric-card flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-400 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-user-check"></i>
            </div>
            <div class="min-w-0 flex-1">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block truncate">Pernah Bertanding</span>
                <p class="text-2xl font-black text-emerald-400 mt-0.5 truncate">{{ $activeCustomers }} <span class="text-xs font-normal text-emerald-400/80">Pemain Aktif</span></p>
                <span class="text-[10px] text-emerald-500 font-semibold block mt-0.5">Sudah Booking Lapangan</span>
            </div>
        </div>

        {{-- Card 3: Top Player Booking --}}
        <div class="metric-card flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-500/15 border border-amber-500/30 text-amber-400 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-trophy"></i>
            </div>
            <div class="min-w-0 flex-1">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block truncate">Top Player Booking</span>
                <p class="text-base font-black text-white mt-0.5 truncate" title="{{ $topCustomer->user->name ?? 'Belum ada' }}">
                    {{ $topCustomer->user->name ?? 'Belum ada' }}
                </p>
                <span class="text-[10px] text-amber-400 font-semibold block mt-0.5">{{ $topCustomer->total_booking ?? 0 }} Total Match</span>
            </div>
        </div>

    </div>

    {{-- ================= INLINE SEARCH BAR & TABLE ================= --}}
    <div class="clean-panel p-6 sm:p-7 space-y-5">
        
        {{-- Search Bar --}}
        <form method="GET" action="{{ route('customers.index') }}" class="flex flex-col sm:flex-row items-center justify-between gap-3 pb-4 border-b border-slate-800/80">
            <div class="w-full sm:w-80 relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-500 text-xs"></i>
                <input type="text" 
                       name="q" 
                       class="clean-input w-full" 
                       placeholder="Cari nama, email, atau no WhatsApp..." 
                       value="{{ request('q') }}">
            </div>

            <div class="flex items-center gap-2.5 w-full sm:w-auto justify-end">
                <button type="submit" class="btn-clean-primary">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    <span>Cari Pemain</span>
                </button>
            </div>
        </form>

        {{-- Table Container --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-slate-500 uppercase font-black text-[10px] border-b border-slate-800">
                        <th class="pb-3 px-3">Nama Pemain</th>
                        <th class="pb-3 px-3">Kontak WhatsApp</th>
                        <th class="pb-3 px-3">Alamat Email</th>
                        <th class="pb-3 px-3">Nama Tim / Domisili</th>
                        <th class="pb-3 px-3">Total Booking</th>
                        <th class="pb-3 px-3">Tanggal Daftar</th>
                        <th class="pb-3 px-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 font-semibold text-slate-300">
                    @forelse($customers as $c)
                        <tr class="hover:bg-slate-900/40 transition-colors">
                            <td class="py-3 px-3 font-bold text-white uppercase flex items-center gap-2.5">
                                @if(!empty($c->avatar))
                                    <img src="{{ asset('storage/'.$c->avatar) }}" alt="{{ $c->name }}" class="w-8 h-8 rounded-xl object-cover border border-red-500/40 shrink-0">
                                @else
                                    <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-red-600 to-rose-600 text-white flex items-center justify-center font-black text-[11px] shrink-0 shadow-sm">
                                        {{ strtoupper(substr($c->name ?? 'C', 0, 1)) }}
                                    </div>
                                @endif
                                <span class="truncate">{{ $c->name }}</span>
                            </td>

                            <td class="py-3 px-3 font-mono font-bold text-slate-200">
                                @if(!empty($c->phone))
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $c->phone) }}" target="_blank" class="text-emerald-400 hover:text-emerald-300 inline-flex items-center gap-1.5 transition-colors">
                                        <i class="fa-brands fa-whatsapp text-sm"></i>
                                        <span>{{ $c->phone }}</span>
                                    </a>
                                @else
                                    <span class="text-slate-500 font-normal">Belum diisi</span>
                                @endif
                            </td>

                            <td class="py-3 px-3 font-mono text-slate-400 truncate max-w-[180px]">
                                {{ $c->email }}
                            </td>

                            <td class="py-3 px-3">
                                <span class="text-white block font-bold truncate max-w-[140px]">{{ $c->team_name ?? 'Reguler Player' }}</span>
                                <span class="text-[10px] text-slate-500 block truncate max-w-[140px]">{{ $c->address ?? '-' }}</span>
                            </td>

                            <td class="py-3 px-3">
                                <span class="px-2 py-0.5 rounded-md bg-slate-900 border border-slate-800 text-white font-black text-[10px]">
                                    {{ $c->reservations_count }} Laga
                                </span>
                            </td>

                            <td class="py-3 px-3 font-medium text-slate-400">
                                {{ $c->created_at ? $c->created_at->translatedFormat('d M Y') : '-' }}
                            </td>

                            <td class="py-3 px-3 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    @if(!empty($c->phone))
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $c->phone) }}" 
                                           target="_blank" 
                                           class="w-7 h-7 rounded-lg bg-emerald-500/15 hover:bg-emerald-600 text-emerald-400 hover:text-white flex items-center justify-center transition-colors" 
                                           title="Chat WhatsApp">
                                            <i class="fa-brands fa-whatsapp text-[11px]"></i>
                                        </a>
                                    @endif

                                    <form method="POST" action="{{ route('customers.destroy', $c->id) }}" onsubmit="return confirm('Hapus data customer ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-7 h-7 rounded-lg bg-red-600/15 hover:bg-red-600 text-red-400 hover:text-white flex items-center justify-center transition-colors" title="Hapus">
                                            <i class="fa-solid fa-trash text-[11px]"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-10 text-center text-slate-500 font-bold">
                                <i class="fa-solid fa-user-xmark text-2xl mb-2 block opacity-30"></i>
                                Tidak ada data customer yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="pt-3 border-t border-slate-800">
            {{ $customers->links() }}
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