@extends('layouts.admin')

@section('title', 'Kelola Tiket & Reservasi Lapangan | Victory Arena')

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
                Ticket Master & Court Management
            </div>
            <h1 class="text-2xl sm:text-3xl font-black uppercase tracking-tight text-white">
                Kelola Reservasi Lapangan
            </h1>
            <p class="text-xs text-slate-400 mt-0.5">
                Validasi status pembayaran kasir/Midtrans, konfirmasi jadwal bermain, dan terbitkan izin kick-off.
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

    {{-- ================= 4 SPACIOUS METRIC CARDS ================= --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        {{-- Card 1: Total Booking --}}
        <div class="metric-card flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-slate-900 border border-slate-800 text-slate-300 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-list-ol"></i>
            </div>
            <div class="min-w-0 flex-1">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block truncate">Total Booking</span>
                <p class="text-xl font-black text-white mt-0.5 truncate">{{ $totalReservasi }} <span class="text-xs font-normal text-slate-400">Match</span></p>
                <span class="text-[10px] text-slate-500 font-semibold block mt-0.5">Keseluruhan Data</span>
            </div>
        </div>

        {{-- Card 2: Menunggu Konfirmasi --}}
        <div class="metric-card flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-500/15 border border-amber-500/30 text-amber-400 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-hourglass-half"></i>
            </div>
            <div class="min-w-0 flex-1">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block truncate">Menunggu Konfirmasi</span>
                <p class="text-xl font-black text-amber-400 mt-0.5 truncate">{{ $reservasiPending }} <span class="text-xs font-normal text-amber-400/80">Pending</span></p>
                <span class="text-[10px] text-amber-500/80 font-semibold block mt-0.5">Perlu Validasi</span>
            </div>
        </div>

        {{-- Card 3: Jadwal Approved --}}
        <div class="metric-card flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-400 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div class="min-w-0 flex-1">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block truncate">Jadwal Approved</span>
                <p class="text-xl font-black text-emerald-400 mt-0.5 truncate">{{ $reservasiApproved }} <span class="text-xs font-normal text-emerald-400/80">Laga</span></p>
                <span class="text-[10px] text-emerald-500 font-semibold block mt-0.5">Siap Bertanding</span>
            </div>
        </div>

        {{-- Card 4: Total Pemasukan --}}
        <div class="metric-card flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-red-600/15 border border-red-500/30 text-red-500 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-wallet"></i>
            </div>
            <div class="min-w-0 flex-1">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block truncate">Total Pemasukan</span>
                <p class="text-base font-black text-white mt-0.5 truncate">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                <span class="text-[10px] text-slate-400 font-semibold block mt-0.5">Akumulasi Omset</span>
            </div>
        </div>

    </div>

    {{-- ================= INLINE COMPACT FILTER BAR & TABLE ================= --}}
    <div class="clean-panel p-6 sm:p-7 space-y-5">
        
        {{-- Search & Filter Bar --}}
        <form method="GET" action="{{ route('reservations.index') }}" class="flex flex-col sm:flex-row items-center justify-between gap-3 pb-4 border-b border-slate-800/80">
            <div class="w-full sm:w-80 relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-500 text-xs"></i>
                <input type="text" 
                       name="q" 
                       class="clean-input w-full" 
                       placeholder="Cari nama pemesan atau arena..." 
                       value="{{ request('q') }}">
            </div>

            <div class="flex items-center gap-2.5 w-full sm:w-auto justify-end">
                <select name="status" class="clean-select w-40">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>

                <button type="submit" class="btn-clean-primary">
                    <i class="fa-solid fa-filter text-xs"></i>
                    <span>Terapkan</span>
                </button>
            </div>
        </form>

        {{-- Table Container --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-slate-500 uppercase font-black text-[10px] border-b border-slate-800">
                        <th class="pb-3 px-3">Kode / ID</th>
                        <th class="pb-3 px-3">Nama Customer</th>
                        <th class="pb-3 px-3">Arena</th>
                        <th class="pb-3 px-3">Jadwal Tanding</th>
                        <th class="pb-3 px-3">Tagihan</th>
                        <th class="pb-3 px-3">Metode & Bayar</th>
                        <th class="pb-3 px-3">Status</th>
                        <th class="pb-3 px-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 font-semibold text-slate-300">
                    @forelse($reservations as $item)
                        @php
                            $bookingCode = 'VA-' . str_pad($item->id, 5, '0', STR_PAD_LEFT);
                        @endphp
                        <tr class="hover:bg-slate-900/40 transition-colors">
                            <td class="py-3 px-3 font-mono font-bold text-slate-400">
                                {{ $bookingCode }}
                            </td>
                            <td class="py-3 px-3 font-bold text-white uppercase flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-lg bg-red-600/15 border border-red-500/30 text-red-400 flex items-center justify-center font-black text-[11px] shrink-0">
                                    {{ strtoupper(substr($item->user->name ?? 'C', 0, 1)) }}
                                </div>
                                <div class="truncate">
                                    <span class="truncate block">{{ $item->user->name ?? 'Guest' }}</span>
                                    <span class="text-[10px] text-slate-500 font-mono font-normal">{{ $item->user->phone ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-3">
                                <span class="px-2 py-0.5 rounded-md bg-slate-900 border border-slate-800 text-white font-black text-[10px] uppercase">
                                    {{ $item->field }}
                                </span>
                            </td>
                            <td class="py-3 px-3 font-medium">
                                <span class="text-white block">{{ \Carbon\Carbon::parse($item->date)->format('d M Y') }}</span>
                                <span class="text-[10px] text-slate-500 font-mono">{{ substr($item->start_time, 0, 5) }} - {{ substr($item->end_time, 0, 5) }}</span>
                            </td>
                            <td class="py-3 px-3 font-black text-white">
                                Rp {{ number_format($item->total_price, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-3">
                                <span class="text-[10px] uppercase font-bold text-slate-400 block">
                                    {{ $item->payment_method === 'transfer' ? 'Midtrans' : 'Kasir' }}
                                </span>
                                @if($item->payment_status === 'paid')
                                    <span class="text-[10px] font-black uppercase text-emerald-400">Lunas</span>
                                @else
                                    <span class="text-[10px] font-black uppercase text-red-400">Belum Lunas</span>
                                @endif
                            </td>
                            <td class="py-3 px-3">
                                @if($item->status === 'approved')
                                    <span class="px-2 py-0.5 rounded-md bg-emerald-500/15 text-emerald-400 border border-emerald-500/30 text-[9px] font-black uppercase">
                                        Approved
                                    </span>
                                @elseif($item->status === 'pending')
                                    <span class="px-2 py-0.5 rounded-md bg-amber-500/15 text-amber-400 border border-amber-500/30 text-[9px] font-black uppercase">
                                        Pending
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded-md bg-slate-800 text-slate-400 text-[9px] font-black uppercase">
                                        {{ $item->status }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-3 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <button type="button" 
                                            onclick="openUpdateModal({
                                                id: '{{ $item->id }}',
                                                code: '{{ $bookingCode }}',
                                                customer: '{{ $item->user->name ?? 'Customer' }}',
                                                field: '{{ $item->field }}',
                                                status: '{{ $item->status }}',
                                                payment_status: '{{ $item->payment_status }}'
                                            })"
                                            class="w-7 h-7 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white flex items-center justify-center transition-colors"
                                            title="Ubah Status">
                                        <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                                    </button>

                                    <form method="POST" action="{{ route('reservations.destroy', $item->id) }}" onsubmit="return confirm('Hapus data reservasi ini?')">
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
                            <td colspan="8" class="py-10 text-center text-slate-500 font-bold">
                                <i class="fa-solid fa-inbox text-2xl mb-2 block opacity-30"></i>
                                Belum ada data reservasi yang tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="pt-3 border-t border-slate-800">
            {{ $reservations->links() }}
        </div>

    </div>

</div>

{{-- ================= MODAL UPDATE STATUS ================= --}}
<div id="updateModal" class="fixed inset-0 z-50 bg-black/80 backdrop-blur-md hidden items-center justify-center p-4">
    <div class="relative w-full max-w-md clean-panel p-6 sm:p-7 space-y-5 shadow-2xl">
        
        <div class="flex items-center justify-between pb-3 border-b border-slate-800">
            <div>
                <span class="text-[10px] font-black uppercase tracking-widest text-red-500 block">Admin Override</span>
                <h3 class="text-lg font-black uppercase text-white" id="modalTitle">Ubah Status Reservasi</h3>
            </div>
            <button type="button" onclick="closeUpdateModal()" class="w-7 h-7 rounded-full bg-slate-800 text-slate-400 hover:text-white flex items-center justify-center">
                <i class="fa-solid fa-xmark text-xs"></i>
            </button>
        </div>

        <form id="updateForm" method="POST" action="" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-[11px] font-black uppercase tracking-wider text-slate-300 mb-1.5">Status Pertandingan</label>
                <select name="status" id="modalSelectStatus" class="clean-select w-full">
                    <option value="approved">Approved (Jadwal Terkunci & Siap)</option>
                    <option value="pending">Pending (Menunggu Konfirmasi)</option>
                    <option value="cancelled">Cancelled (Dibatalkan)</option>
                </select>
            </div>

            <div>
                <label class="block text-[11px] font-black uppercase tracking-wider text-slate-300 mb-1.5">Status Pembayaran</label>
                <select name="payment_status" id="modalSelectPayment" class="clean-select w-full">
                    <option value="paid">Lunas (Paid)</option>
                    <option value="pending">Menunggu Pembayaran (Pending)</option>
                    <option value="failed">Gagal (Failed)</option>
                </select>
            </div>

            <div class="pt-2 flex gap-3">
                <button type="button" onclick="closeUpdateModal()" class="btn-clean-secondary w-1/2">
                    Batal
                </button>
                <button type="submit" class="btn-clean-primary w-1/2">
                    Simpan
                </button>
            </div>
        </form>

    </div>
</div>

<script>
function openUpdateModal(data) {
    document.getElementById('modalTitle').innerText = `${data.code} - ${data.field}`;
    document.getElementById('modalSelectStatus').value = data.status;
    document.getElementById('modalSelectPayment').value = data.payment_status;
    document.getElementById('updateForm').action = `/admin/reservations/${data.id}`;

    const modal = document.getElementById('updateModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeUpdateModal() {
    const modal = document.getElementById('updateModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

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