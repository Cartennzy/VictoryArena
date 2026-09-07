@extends('layouts.customer')

@section('title', 'Riwayat Reservasi Lapangan | Victory Arena')

@section('content')

<style>
    .saas-panel {
        background: rgba(13, 20, 36, 0.85);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 26px;
        box-shadow: 0 20px 45px -15px rgba(0, 0, 0, 0.7);
        transition: border-color 0.25s ease;
    }
    .saas-panel:hover {
        border-color: rgba(255, 255, 255, 0.14);
    }

    .match-card {
        background: rgba(10, 16, 32, 0.75);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 20px;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
    }
    .match-card:hover {
        transform: translateY(-2px);
        border-color: rgba(239, 68, 68, 0.5);
        background: rgba(15, 23, 42, 0.95);
        box-shadow: 0 14px 30px -8px rgba(220, 38, 38, 0.25);
    }

    .btn-action-primary {
        position: relative;
        overflow: hidden;
        height: 48px;
        border-radius: 14px;
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #ffffff;
        font-weight: 800;
        font-size: 0.88rem;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 10px 22px -5px rgba(220, 38, 38, 0.55);
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        user-select: none;
    }
    .btn-action-primary:hover {
        transform: translateY(-2px);
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        box-shadow: 0 14px 28px -5px rgba(220, 38, 38, 0.7);
    }
    .btn-action-primary:active {
        transform: translateY(2px) scale(0.98) !important;
        box-shadow: 0 4px 8px rgba(220, 38, 38, 0.3) !important;
    }

    .filter-pill {
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .filter-pill.active {
        background: #dc2626;
        color: #ffffff;
        border-color: #dc2626;
        box-shadow: 0 4px 14px rgba(220, 38, 38, 0.4);
    }

    .ripple-wave {
        position: absolute;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.5);
        pointer-events: none;
        transform: scale(0);
        animation: rippleAnim 0.65s cubic-bezier(0, 0, 0.2, 1);
    }
    @keyframes rippleAnim {
        0% { transform: scale(0); opacity: 0.7; }
        100% { transform: scale(3.5); opacity: 0; }
    }
</style>

<div class="max-w-7xl mx-auto py-4 sm:py-6 space-y-8 text-slate-100 font-sans">

    {{-- Header Banner --}}
    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 pb-6 border-b border-slate-800">
        <div>
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-red-950/60 border border-red-800/60 text-red-400 text-xs font-black tracking-widest uppercase mb-2">
                <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                Official Match Center
            </div>
            <h1 class="text-3xl sm:text-4xl font-black uppercase tracking-tight text-white">Riwayat Reservasi Lapangan</h1>
            <p class="text-xs sm:text-sm text-slate-400 mt-1">Klik pada tiket pertandingan untuk melihat bukti reservasi digital yang dapat ditunjukkan ke operator arena.</p>
        </div>

        <a href="{{ route('customer.booking') }}" class="btn-action-primary px-6 self-start sm:self-auto">
            <i class="fa-solid fa-futbol text-xs"></i>
            <span>Booking Lapangan Baru</span>
        </a>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-5">
        <div class="saas-panel p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-slate-900 border border-slate-800 text-slate-300 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-list-check"></i>
            </div>
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Total Booking</span>
                <p class="text-2xl font-black text-white mt-0.5">{{ $totalCount }}</p>
            </div>
        </div>

        <div class="saas-panel p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-400 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Jadwal Approved</span>
                <p class="text-2xl font-black text-emerald-400 mt-0.5">{{ $approvedCount }}</p>
            </div>
        </div>

        <div class="saas-panel p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-500/15 border border-amber-500/30 text-amber-400 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-hourglass-half"></i>
            </div>
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Menunggu Konfirmasi</span>
                <p class="text-2xl font-black text-amber-400 mt-0.5">{{ $pendingCount }}</p>
            </div>
        </div>

        <div class="saas-panel p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-red-600/15 border border-red-500/30 text-red-500 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-wallet"></i>
            </div>
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Total Pengeluaran</span>
                <p class="text-xl font-black text-white mt-0.5">Rp {{ number_format($totalSpent, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    {{-- Main Container List --}}
    <div class="saas-panel p-6 sm:p-8 space-y-6">

        {{-- Filter Tabs --}}
        <div class="flex flex-wrap items-center justify-between gap-4 pb-5 border-b border-slate-800">
            <div class="flex items-center gap-2">
                <button type="button" onclick="filterMatch('all')" class="filter-pill active px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider bg-slate-900 border border-slate-800 text-slate-300">
                    Semua ({{ $totalCount }})
                </button>
                <button type="button" onclick="filterMatch('approved')" class="filter-pill px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider bg-slate-900 border border-slate-800 text-slate-300">
                    Approved ({{ $approvedCount }})
                </button>
                <button type="button" onclick="filterMatch('pending')" class="filter-pill px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider bg-slate-900 border border-slate-800 text-slate-300">
                    Pending ({{ $pendingCount }})
                </button>
            </div>

            <span class="text-xs text-slate-400 font-semibold">Klik kartu reservasi untuk membuka Digital Pass</span>
        </div>

        @if($reservations->isEmpty())
            <div class="text-center py-16 px-4">
                <div class="w-16 h-16 rounded-2xl bg-slate-900 border border-slate-800 text-slate-600 flex items-center justify-center text-2xl mx-auto mb-4">
                    <i class="fa-solid fa-calendar-xmark"></i>
                </div>
                <h4 class="text-base font-black uppercase text-white">Belum Ada Riwayat Reservasi</h4>
                <p class="text-xs text-slate-400 max-w-sm mx-auto mt-1 mb-6">
                    Anda belum memesan lapangan futsal. Pilih arena dan slot waktu bermain sekarang!
                </p>
                <a href="{{ route('customer.booking') }}" class="btn-action-primary px-8">
                    <i class="fa-solid fa-futbol text-xs"></i>
                    <span>Booking Lapangan Sekarang</span>
                </a>
            </div>
        @else
            <div class="space-y-4" id="matchContainer">
                @foreach($reservations as $res)
                    @php
                        $formattedDate = \Carbon\Carbon::parse($res->date)->translatedFormat('l, d F Y');
                        $jamStart = substr($res->start_time, 0, 5);
                        $jamEnd = substr($res->end_time, 0, 5);
                        $bookingCode = 'VA-' . str_pad($res->id, 5, '0', STR_PAD_LEFT);
                    @endphp

                    <div class="match-card p-5 sm:p-6 flex flex-col md:flex-row md:items-center justify-between gap-5" 
                         data-status="{{ $res->status }}"
                         onclick="openDetailModal({
                            id: '{{ $res->id }}',
                            code: '{{ $bookingCode }}',
                            field: '{{ $res->field }}',
                            date: '{{ $formattedDate }}',
                            time: '{{ $jamStart }} - {{ $jamEnd }} WIB',
                            price: 'Rp {{ number_format($res->total_price, 0, ',', '.') }}',
                            status: '{{ $res->status }}',
                            payment_status: '{{ $res->payment_status }}',
                            payment_method: '{{ $res->payment_method === 'transfer' ? 'Transfer Online (Midtrans)' : 'Cash di Kasir' }}',
                            user: '{{ Auth::user()->name }}',
                            phone: '{{ Auth::user()->phone ?? '-' }}'
                         })">
                        
                        <div class="flex items-start gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-red-600/20 to-slate-900 border border-red-500/30 text-red-500 flex items-center justify-center text-2xl shrink-0 mt-0.5">
                                <i class="fa-solid fa-futbol"></i>
                            </div>
                            <div>
                                <div class="flex flex-wrap items-center gap-2.5">
                                    <h3 class="text-base font-black uppercase text-white tracking-wide">{{ $res->field }}</h3>

                                    @if($res->status === 'approved')
                                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/15 border border-emerald-500/30 text-emerald-400 text-[10px] font-black uppercase tracking-wider flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Approved
                                        </span>
                                    @elseif($res->status === 'pending')
                                        <span class="px-2.5 py-0.5 rounded-full bg-amber-500/15 border border-amber-500/30 text-amber-400 text-[10px] font-black uppercase tracking-wider flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span> Menunggu Konfirmasi
                                        </span>
                                    @else
                                        <span class="px-2.5 py-0.5 rounded-full bg-slate-800 border border-slate-700 text-slate-400 text-[10px] font-black uppercase tracking-wider">
                                            {{ $res->status }}
                                        </span>
                                    @endif

                                    @if($res->payment_status === 'paid')
                                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-950/60 border border-emerald-800 text-emerald-400 text-[10px] font-black uppercase">
                                            Lunas
                                        </span>
                                    @else
                                        <span class="px-2.5 py-0.5 rounded-full bg-red-950/60 border border-red-800 text-red-400 text-[10px] font-black uppercase">
                                            Belum Lunas
                                        </span>
                                    @endif
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-1 mt-2.5 text-xs">
                                    <p class="text-slate-300 font-semibold flex items-center gap-2">
                                        <i class="fa-regular fa-calendar text-red-500"></i>
                                        {{ $formattedDate }}
                                    </p>
                                    <p class="text-slate-300 font-semibold flex items-center gap-2">
                                        <i class="fa-regular fa-clock text-red-500"></i>
                                        {{ $jamStart }} - {{ $jamEnd }} WIB (1 Jam)
                                    </p>
                                    <p class="text-slate-400 flex items-center gap-2 sm:col-span-2 mt-0.5">
                                        <i class="fa-solid fa-receipt text-slate-500"></i>
                                        Kode: <span class="font-mono font-bold text-slate-200">{{ $bookingCode }}</span> • Metode: <span class="text-slate-300 uppercase font-bold">{{ $res->payment_method === 'transfer' ? 'Transfer Midtrans' : 'Cash di Kasir' }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="flex sm:flex-col items-center sm:items-end justify-between border-t sm:border-t-0 pt-3 sm:pt-0 border-slate-800/80 gap-3 shrink-0">
                            <div class="text-left sm:text-right">
                                <span class="text-[10px] text-slate-500 uppercase font-bold tracking-wider block">Total Tagihan</span>
                                <p class="text-lg font-black text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-rose-400">
                                    Rp {{ number_format($res->total_price, 0, ',', '.') }}
                                </p>
                            </div>

                            <div class="flex items-center gap-2">
                                @if($res->payment_status === 'paid')
                                    <button type="button" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-400 font-bold text-xs uppercase tracking-wider">
                                        <i class="fa-solid fa-qrcode"></i>
                                        <span>Lihat Tiket</span>
                                    </button>
                                @elseif($res->payment_method === 'transfer')
                                    <a href="{{ route('payment.midtrans', $res->id) }}" 
                                       onclick="event.stopPropagation()" 
                                       class="btn-action-primary px-5 !h-10 !text-xs">
                                        <i class="fa-solid fa-credit-card text-xs"></i>
                                        <span>Bayar</span>
                                    </a>
                                @else
                                    <button type="button" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-500/15 border border-amber-500/30 text-amber-400 font-bold text-xs">
                                        <i class="fa-solid fa-hand-holding-dollar"></i>
                                        <span>Bayar di Kasir</span>
                                    </button>
                                @endif
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif

    </div>

</div>

{{-- MODAL DETAIL TIKET MATCH PASS --}}
<div id="ticketModal" class="fixed inset-0 z-50 bg-black/80 backdrop-blur-md hidden items-center justify-center p-4">
    <div class="relative w-full max-w-lg bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden shadow-2xl transform transition-all scale-95 duration-200" id="ticketModalCard">
        
        <div class="bg-gradient-to-r from-red-600 to-rose-600 p-6 text-white relative">
            <button type="button" onclick="closeDetailModal()" class="absolute top-5 right-5 w-8 h-8 rounded-full bg-black/20 hover:bg-black/40 text-white flex items-center justify-center transition-colors">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
            <span class="text-[10px] font-black uppercase tracking-widest px-2.5 py-0.5 rounded-md bg-black/25">
                Official Arena Pass
            </span>
            <h3 class="text-2xl font-black uppercase tracking-tight mt-2" id="modalCourt">LAPANGAN 1</h3>
            <p class="text-xs opacity-90 mt-0.5 font-medium" id="modalBookingCode">KODE: VA-00001</p>
        </div>

        <div class="p-6 sm:p-7 space-y-5 bg-[#0b1120]">
            
            <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-950 border border-slate-800 text-xs">
                <span class="text-slate-400 font-bold uppercase text-[10px]">Status Reservasi:</span>
                <span id="modalStatusBadge" class="font-black uppercase tracking-wider px-2.5 py-0.5 rounded-md text-[10px]">APPROVED</span>
            </div>

            <div class="space-y-3 text-xs">
                <div class="flex justify-between items-center py-1.5 border-b border-slate-800/80">
                    <span class="text-slate-400">Nama Pemesan:</span>
                    <span class="font-bold text-white uppercase" id="modalCustomerName">-</span>
                </div>
                <div class="flex justify-between items-center py-1.5 border-b border-slate-800/80">
                    <span class="text-slate-400">Nomor WhatsApp:</span>
                    <span class="font-bold text-slate-200" id="modalPhone">-</span>
                </div>
                <div class="flex justify-between items-center py-1.5 border-b border-slate-800/80">
                    <span class="text-slate-400">Hari & Tanggal:</span>
                    <span class="font-bold text-white" id="modalDate">-</span>
                </div>
                <div class="flex justify-between items-center py-1.5 border-b border-slate-800/80">
                    <span class="text-slate-400">Jam Kick-Off:</span>
                    <span class="font-black text-red-400" id="modalTime">-</span>
                </div>
                <div class="flex justify-between items-center py-1.5 border-b border-slate-800/80">
                    <span class="text-slate-400">Metode Bayar:</span>
                    <span class="font-bold text-slate-300" id="modalPaymentMethod">-</span>
                </div>
                <div class="flex justify-between items-baseline pt-2">
                    <span class="text-xs font-black uppercase text-slate-300">Total Biaya Sewa:</span>
                    <span class="text-2xl font-black text-emerald-400" id="modalPrice">Rp 0</span>
                </div>
            </div>

            <div class="p-4 rounded-2xl bg-slate-950 border border-slate-800 text-center space-y-2">
                <div class="flex justify-center items-center gap-1.5 opacity-70">
                    <i class="fa-solid fa-barcode text-3xl tracking-widest text-slate-400"></i>
                    <i class="fa-solid fa-barcode text-3xl tracking-widest text-slate-400"></i>
                </div>
                <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">Tunjukkan kode tiket ini kepada staf operasional lapangan</p>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="button" onclick="window.print()" class="btn-action w-1/2 py-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-black uppercase tracking-wider border border-slate-700">
                    <i class="fa-solid fa-print mr-1.5"></i> Cetak Bukti
                </button>
                <button type="button" onclick="closeDetailModal()" class="btn-action-primary w-1/2 !h-11 !text-xs">
                    <i class="fa-solid fa-check mr-1.5"></i> Tutup Pass
                </button>
            </div>

        </div>

    </div>
</div>

<script>
function filterMatch(status) {
    document.querySelectorAll('.filter-pill').forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');

    const cards = document.querySelectorAll('#matchContainer .match-card');
    cards.forEach(card => {
        if (status === 'all' || card.getAttribute('data-status') === status) {
            card.style.display = 'flex';
        } else {
            card.style.display = 'none';
        }
    });
}

function openDetailModal(data) {
    document.getElementById('modalCourt').innerText = data.field;
    document.getElementById('modalBookingCode').innerText = `KODE RESMI: ${data.code}`;
    document.getElementById('modalCustomerName').innerText = data.user;
    document.getElementById('modalPhone').innerText = data.phone;
    document.getElementById('modalDate').innerText = data.date;
    document.getElementById('modalTime').innerText = data.time;
    document.getElementById('modalPaymentMethod').innerText = data.payment_method;
    document.getElementById('modalPrice').innerText = data.price;

    const badge = document.getElementById('modalStatusBadge');
    if (data.status === 'approved') {
        badge.className = 'font-black uppercase tracking-wider px-2.5 py-0.5 rounded-md text-[10px] bg-emerald-500/20 text-emerald-400 border border-emerald-500/30';
        badge.innerText = 'APPROVED (JADWAL SIAP)';
    } else {
        badge.className = 'font-black uppercase tracking-wider px-2.5 py-0.5 rounded-md text-[10px] bg-amber-500/20 text-amber-400 border border-amber-500/30';
        badge.innerText = 'MENUNGGU KONFIRMASI';
    }

    const modal = document.getElementById('ticketModal');
    const card = document.getElementById('ticketModalCard');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(() => {
        card.classList.remove('scale-95');
        card.classList.add('scale-100');
    }, 10);
}

function closeDetailModal() {
    const modal = document.getElementById('ticketModal');
    const card = document.getElementById('ticketModalCard');
    card.classList.remove('scale-100');
    card.classList.add('scale-95');
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 180);
}

document.addEventListener('click', function (e) {
    const btn = e.target.closest('.btn-action-primary, .btn-action');
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