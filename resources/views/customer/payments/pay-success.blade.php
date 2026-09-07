@extends('layouts.customer')

@section('title', 'Pembayaran Sukses | Victory Arena')

@section('content')

{{-- ================= CUSTOM STYLES: SAAS SPORTS SUCCESS TICKET ================= --}}
<style>
    .saas-success-card {
        background: rgba(13, 20, 36, 0.88);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(16, 185, 129, 0.25);
        border-radius: 30px;
        box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.75),
                    0 0 35px -10px rgba(16, 185, 129, 0.25);
        animation: successScaleUp 0.65s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        position: relative;
        overflow: hidden;
    }

    @keyframes successScaleUp {
        0% { opacity: 0; transform: scale(0.95) translateY(20px); }
        100% { opacity: 1; transform: scale(1) translateY(0); }
    }

    /* Ticket Perforation Notch */
    .ticket-notch-left, .ticket-notch-right {
        position: absolute;
        top: 55%;
        width: 24px;
        height: 24px;
        background: #080d1a;
        border-radius: 50%;
        z-index: 10;
    }
    .ticket-notch-left { left: -12px; border-right: 1px solid rgba(255, 255, 255, 0.1); }
    .ticket-notch-right { right: -12px; border-left: 1px solid rgba(255, 255, 255, 0.1); }

    /* Tombol Interaktif */
    .btn-action-primary {
        position: relative;
        overflow: hidden;
        width: 100%;
        height: 54px;
        border-radius: 16px;
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #ffffff;
        font-weight: 800;
        font-size: 0.92rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        box-shadow: 0 14px 28px -6px rgba(220, 38, 38, 0.55);
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        user-select: none;
    }
    .btn-action-primary:hover {
        transform: translateY(-2px);
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        box-shadow: 0 18px 32px -6px rgba(220, 38, 38, 0.7);
    }
    .btn-action-primary:active {
        transform: translateY(2px) scale(0.98) !important;
        box-shadow: 0 4px 10px rgba(220, 38, 38, 0.3) !important;
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

<div class="max-w-2xl mx-auto py-8 sm:py-12 text-slate-100 font-sans">
    
    <div class="saas-success-card p-8 sm:p-10 text-center">
        
        <div class="ticket-notch-left"></div>
        <div class="ticket-notch-right"></div>

        {{-- Icon Lunas Beranimasi --}}
        <div class="w-20 h-20 rounded-3xl bg-emerald-500/15 border-2 border-emerald-500/40 text-emerald-400 flex items-center justify-center text-4xl mx-auto mb-6 shadow-xl shadow-emerald-500/20">
            <i class="fa-solid fa-check-double"></i>
        </div>

        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/15 border border-emerald-500/30 text-emerald-400 text-[10px] font-black uppercase tracking-widest">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
            Pembayaran Lunas & Terverifikasi
        </span>

        <h2 class="text-3xl font-black uppercase tracking-tight text-white mt-3">Match Booking Confirmed!</h2>
        <p class="text-xs text-slate-400 mt-2 max-w-md mx-auto">
            Reservasi lapangan resmi Victory Arena Anda telah aktif dan tercatat pada sistem operator arena.
        </p>

        {{-- Tiket Digital Box --}}
        <div class="my-8 p-6 rounded-2xl bg-slate-900/90 border border-slate-800 text-left text-xs space-y-3.5">
            <div class="flex justify-between items-center pb-3 border-b border-slate-800/80">
                <span class="text-slate-400 uppercase font-bold text-[10px] tracking-wider">Order ID / Kode Tiket</span>
                <span class="font-mono font-black text-white text-sm tracking-wide">{{ $payment->order_id }}</span>
            </div>

            <div class="flex justify-between items-center">
                <span class="text-slate-400">Pemesan Lapangan:</span>
                <span class="font-bold text-white uppercase">{{ Auth::user()->name }}</span>
            </div>

            <div class="flex justify-between items-center">
                <span class="text-slate-400">Arena Lapangan:</span>
                <span class="font-black text-red-400 uppercase">{{ $payment->reservation->field }}</span>
            </div>

            <div class="flex justify-between items-center">
                <span class="text-slate-400">Waktu Kick-Off:</span>
                <span class="font-bold text-slate-200">
                    {{ \Carbon\Carbon::parse($payment->reservation->date)->translatedFormat('l, d F Y') }} • {{ substr($payment->reservation->start_time, 0, 5) }} - {{ substr($payment->reservation->end_time, 0, 5) }} WIB
                </span>
            </div>

            <div class="flex justify-between items-center">
                <span class="text-slate-400">Metode Pelunasan:</span>
                <span class="font-bold text-slate-300 uppercase">{{ $payment->payment_type ?? 'Midtrans QRIS/Online' }}</span>
            </div>

            <div class="flex justify-between items-center pt-3 border-t border-slate-800/80">
                <span class="text-xs font-black uppercase text-slate-300">Total Nominal Lunas:</span>
                <span class="text-lg font-black text-emerald-400">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- Action Return to Dashboard --}}
        <div class="space-y-3">
            <a href="{{ route('customer.dashboard') }}" class="btn-action-primary">
                <i class="fa-solid fa-chart-pie mr-1.5"></i>
                <span>Kembali ke Dashboard Member</span>
            </a>
            <p class="text-[10px] text-slate-500 uppercase tracking-wider font-semibold">Tunjukkan halaman ini kepada staf arena saat tiba di lokasi</p>
        </div>

    </div>

</div>

{{-- Universal Ripple Script --}}
<script>
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