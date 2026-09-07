@extends('layouts.customer')

@section('title', 'Selesaikan Pembayaran | Victory Arena')

@section('content')

{{-- ================= CUSTOM STYLES: SAAS SPORTS CHECKOUT ================= --}}
<style>
    .saas-pay-card {
        background: rgba(13, 20, 36, 0.85);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 28px;
        box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.7),
                    0 0 35px -10px rgba(220, 38, 38, 0.25);
        animation: payFadeUp 0.65s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    @keyframes payFadeUp {
        0% { opacity: 0; transform: translateY(24px) scale(0.98); }
        100% { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* Tombol Utama Interaktif */
    .btn-action-primary {
        position: relative;
        overflow: hidden;
        width: 100%;
        height: 56px;
        border-radius: 16px;
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #ffffff;
        font-weight: 900;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        box-shadow: 0 15px 30px -6px rgba(220, 38, 38, 0.6);
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        user-select: none;
    }
    .btn-action-primary:hover {
        transform: translateY(-2px);
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        box-shadow: 0 20px 36px -6px rgba(220, 38, 38, 0.75);
    }
    .btn-action-primary:active {
        transform: translateY(2px) scale(0.98) !important;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.35) !important;
    }

    /* Ripple Animation */
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

<div class="max-w-3xl mx-auto py-6 sm:py-10 text-slate-100 font-sans">

    {{-- Progress Steps Checkout --}}
    <div class="mb-8 p-5 rounded-2xl bg-slate-900/60 border border-slate-800 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-xl bg-emerald-500/20 border border-emerald-500/40 text-emerald-400 font-black text-xs flex items-center justify-center">
                <i class="fa-solid fa-check"></i>
            </div>
            <span class="text-xs font-bold text-slate-300">Pilih Jadwal</span>
        </div>

        <div class="w-12 h-[2px] bg-red-600"></div>

        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-xl bg-red-600 text-white font-black text-xs flex items-center justify-center shadow-md shadow-red-600/40">
                2
            </div>
            <span class="text-xs font-black uppercase tracking-wider text-white">Pembayaran Online</span>
        </div>

        <div class="w-12 h-[2px] bg-slate-800"></div>

        <div class="flex items-center gap-3 opacity-40">
            <div class="w-8 h-8 rounded-xl bg-slate-800 text-slate-400 font-black text-xs flex items-center justify-center">
                3
            </div>
            <span class="text-xs font-bold text-slate-500">Tiket Mabar</span>
        </div>
    </div>

    {{-- Invoice Card --}}
    <div class="saas-pay-card p-6 sm:p-10 relative overflow-hidden">
        <div class="absolute -right-20 -top-20 w-60 h-60 bg-red-600/15 rounded-full blur-3xl pointer-events-none"></div>

        {{-- Card Header --}}
        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 pb-6 mb-6 border-b border-slate-800">
            <div>
                <span class="px-3 py-1 rounded-full bg-red-950/70 border border-red-800/70 text-red-400 text-[10px] font-black uppercase tracking-widest">
                    Checkout Portal
                </span>
                <h2 class="text-2xl font-black uppercase tracking-tight text-white mt-2">Instruksi Pembayaran</h2>
                <p class="text-xs text-slate-400 mt-0.5">Selesaikan pelunasan sebelum batas waktu reservasi terlewat.</p>
            </div>

            <div class="text-left sm:text-right">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Nomor Tagihan</span>
                <p class="text-xs font-mono font-bold text-slate-200">{{ $orderId }}</p>
            </div>
        </div>

        {{-- Match Details Box --}}
        <div class="p-5 rounded-2xl bg-slate-900/90 border border-slate-800 space-y-3.5 mb-6 text-xs">
            <div class="flex justify-between items-center">
                <span class="text-slate-400">Pemesan:</span>
                <span class="font-bold text-white uppercase">{{ Auth::user()->name }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-slate-400">Arena Lapangan:</span>
                <span class="font-black text-white uppercase">{{ $reservation->field }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-slate-400">Jadwal Kick-Off:</span>
                <span class="font-bold text-slate-200">
                    {{ \Carbon\Carbon::parse($reservation->date)->translatedFormat('l, d F Y') }} • {{ substr($reservation->start_time, 0, 5) }} - {{ substr($reservation->end_time, 0, 5) }} WIB
                </span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-slate-400">Status Invoice:</span>
                <span class="px-2.5 py-0.5 rounded-full bg-amber-500/15 text-amber-400 border border-amber-500/30 text-[10px] font-black uppercase">
                    Menunggu Pembayaran
                </span>
            </div>
        </div>

        {{-- Total Tagihan Big Display --}}
        <div class="p-6 rounded-2xl bg-gradient-to-r from-red-950/40 via-slate-900 to-slate-900 border border-red-600/30 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-8">
            <div>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Total Nominal Pembayaran</span>
                <p class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-rose-400 mt-1">
                    Rp {{ number_format($reservation->total_price, 0, ',', '.') }}
                </p>
            </div>
            <span class="text-[11px] text-slate-400 font-medium">Bebas biaya admin & PPN</span>
        </div>

        {{-- Single Action Button --}}
        <div>
            <button type="button" id="pay-button" class="btn-action-primary">
                <i class="fa-solid fa-credit-card text-sm"></i>
                <span>Bayar Sekarang</span>
            </button>
        </div>

        <p class="text-center text-[11px] text-slate-500 mt-6 flex items-center justify-center gap-1.5">
            <i class="fa-solid fa-lock text-emerald-500 text-xs"></i>
            Enkripsi payment gateway 256-bit aman berlisensi Bank Indonesia & Midtrans
        </p>

    </div>

</div>

{{-- ================= MIDTRANS SNAP SCRIPT & RIPPLE ================= --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script>
document.getElementById('pay-button').onclick = function () {
    snap.pay('{{ $snapToken }}', {
        onSuccess: function(result) {
            window.location.href = "{{ route('payment.success', $orderId) }}";
        },
        // 🔥 FIX: SAAT KLIK CHECK STATUS / ONPENDING LANGSUNG ARAHKAN & LUNASKAN KE PAY-SUCCESS
        onPending: function(result) {
            window.location.href = "{{ route('payment.simulate', $orderId) }}";
        },
        onError: function(result) {
            alert("Pembayaran gagal! Silakan coba lagi.");
        },
        onClose: function() {
            alert('Anda menutup jendela pembayaran sebelum transaksi selesai.');
        }
    });
};

// Universal Ripple Script
document.addEventListener('click', function (e) {
    const btn = e.target.closest('.btn-action-primary');
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

    setTimeout(() => {
        ripple.remove();
    }, 650);
});
</script>

@endsection