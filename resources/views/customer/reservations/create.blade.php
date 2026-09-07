@extends('layouts.customer')

@section('title', 'Booking Lapangan Futsal | Victory Arena')

@section('content')

{{-- ================= CUSTOM STYLES & INTERACTION ANIMATIONS ================= --}}
<style>
    .saas-panel {
        background: rgba(13, 20, 36, 0.85);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 24px;
        box-shadow: 0 20px 45px -15px rgba(0, 0, 0, 0.65);
        transition: border-color 0.3s ease;
    }
    .saas-panel:hover {
        border-color: rgba(255, 255, 255, 0.14);
    }

    /* Court Card Radio */
    .court-card {
        cursor: pointer;
        transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .court-card:hover {
        transform: translateY(-4px);
        border-color: rgba(239, 68, 68, 0.5);
    }
    .court-radio:checked + .court-card {
        border-color: #ef4444;
        background: linear-gradient(180deg, rgba(239, 68, 68, 0.14) 0%, rgba(15, 23, 42, 0.95) 100%);
        box-shadow: 0 0 0 2px #ef4444, 0 16px 30px -8px rgba(220, 38, 38, 0.45);
    }

    /* Date Picker Input */
    .saas-date-picker {
        width: 100%;
        height: 52px;
        background: rgba(8, 13, 26, 0.85);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 14px;
        padding: 0 18px;
        color: #ffffff;
        font-weight: 700;
        font-size: 0.95rem;
        outline: none;
        transition: all 0.2s ease;
        color-scheme: dark;
    }
    .saas-date-picker:focus {
        border-color: #ef4444;
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.2);
    }

    /* Slot Jam Grid */
    .slot-cell {
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        user-select: none;
    }
    .slot-cell:hover:not(.slot-disabled) {
        transform: translateY(-2px);
    }
    .slot-radio:checked + .slot-cell {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
        border-color: #ef4444 !important;
        color: #ffffff !important;
        box-shadow: 0 10px 22px -4px rgba(239, 68, 68, 0.5);
    }
    .slot-radio:checked + .slot-cell * {
        color: #ffffff !important;
    }

    /* Payment Option Card */
    .pay-choice-card {
        transition: all 0.22s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
    }
    .pay-choice-card:hover {
        border-color: rgba(255, 255, 255, 0.2);
    }
    .pay-radio:checked + .pay-choice-card {
        border-color: #ef4444;
        background: rgba(239, 68, 68, 0.12);
        box-shadow: 0 0 0 2px #ef4444, 0 10px 20px -5px rgba(220, 38, 38, 0.35);
    }

    /* Primary SaaS Button with Press State */
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
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        user-select: none;
    }
    .btn-action-primary:hover:not(:disabled) {
        transform: translateY(-2px);
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        box-shadow: 0 20px 36px -6px rgba(220, 38, 38, 0.75);
    }
    .btn-action-primary:active:not(:disabled) {
        transform: translateY(2px) scale(0.98) !important;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.35) !important;
    }

    /* STATE DISABLED: KETIKA FORM BELUM LENGKAP */
    .btn-action-primary:disabled {
        background: #1e293b !important;
        border-color: rgba(255, 255, 255, 0.05) !important;
        color: #64748b !important;
        cursor: not-allowed !important;
        box-shadow: none !important;
        transform: none !important;
        opacity: 0.75;
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

<div class="max-w-7xl mx-auto py-4 sm:py-6 text-slate-100 font-sans">

    {{-- ================= HEADER ================= --}}
    <div class="flex flex-col md:flex-row justify-between md:items-center gap-4 mb-8 pb-6 border-b border-slate-800">
        <div>
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-red-950/50 border border-red-800/50 text-red-400 text-[11px] font-black tracking-widest uppercase mb-2">
                <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                Official Pricing Engine
            </div>
            <h1 class="text-3xl sm:text-4xl font-black uppercase tracking-tight text-white">
                Booking <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-rose-400">Arena Lapangan</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-400 mt-1">
                Tarif resmi: Slot Siang (08.00–16.00) Rp 120.000/jam • Prime Time Malam & Weekend Rp 175.000/jam
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('customer.dashboard') }}" 
               class="btn-action px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-slate-300 hover:text-white border border-slate-750 text-xs font-bold uppercase tracking-wider">
                <i class="fa-solid fa-arrow-left mr-2"></i> Dashboard
            </a>
        </div>
    </div>

    {{-- Error Notice --}}
    @if($errors->any())
        <div class="mb-8 p-4 sm:p-5 rounded-2xl bg-red-500/10 border border-red-500/30 text-red-400 text-xs font-bold flex items-start gap-3">
            <i class="fa-solid fa-circle-exclamation text-base mt-0.5 shrink-0"></i>
            <div>
                <p class="font-black uppercase tracking-wide">Pemesanan Belum Dapat Dilanjutkan:</p>
                <ul class="list-disc list-inside mt-1 space-y-0.5 font-normal">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- ================= FORM ================= --}}
    <form method="POST" action="{{ route('customer.booking.store') }}" id="bookingArenaForm">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            {{-- LEFT: SELECTION (8 COLS) --}}
            <div class="lg:col-span-8 space-y-8">

                {{-- 1. PILIH LAPANGAN --}}
                <div class="saas-panel p-6 sm:p-8">
                    <div class="flex items-center justify-between pb-4 mb-6 border-b border-slate-800">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-xl bg-red-600 text-white flex items-center justify-center font-black text-sm shadow-md shadow-red-600/40">1</span>
                            <div>
                                <h3 class="text-lg font-black uppercase tracking-wider text-white">Pilih Arena Futsal</h3>
                                <p class="text-xs text-slate-400">Seluruh lapangan dilengkapi lantai Vinyl Interlock turnamen & LED 500 Lux.</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                        @foreach($lapangan as $key => $item)
                            <label class="relative block">
                                <input type="radio" 
                                       name="field" 
                                       value="{{ $item['name'] }}" 
                                       class="court-radio peer sr-only" 
                                       {{ (old('field', request('field')) == $item['name'] || $loop->first) ? 'checked' : '' }}
                                       onchange="updateFieldSelection()">

                                <div class="court-card rounded-2xl bg-slate-900/90 border border-slate-800 p-4 relative overflow-hidden flex flex-col justify-between h-full">
                                    <div class="h-36 rounded-xl overflow-hidden relative mb-4">
                                        <img src="{{ asset($item['foto']) }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-transparent"></div>
                                        <span class="absolute bottom-2 left-2.5 px-2.5 py-0.5 rounded-md bg-red-600/90 backdrop-blur-sm text-white text-[9px] font-black tracking-widest uppercase">
                                            OFFICIAL ARENA
                                        </span>
                                    </div>

                                    <div>
                                        <h4 class="text-base font-black uppercase text-white">{{ $item['name'] }}</h4>
                                        <div class="flex flex-wrap gap-1.5 mt-2">
                                            <span class="px-2 py-0.5 rounded-md bg-slate-800 text-[10px] text-slate-300 font-medium">Vinyl Interlock</span>
                                            <span class="px-2 py-0.5 rounded-md bg-slate-800 text-[10px] text-slate-300 font-medium">Scoreboard</span>
                                        </div>
                                    </div>

                                    <div class="mt-4 pt-3 border-t border-slate-800/80 flex items-baseline justify-between">
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Tarif Mulai</span>
                                        <span class="text-sm font-black text-red-400">Rp 120.000<span class="text-[10px] text-slate-500 font-normal">/jam</span></span>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- 2. PILIH TANGGAL --}}
                <div class="saas-panel p-6 sm:p-8">
                    <div class="flex items-center gap-3 pb-4 mb-6 border-b border-slate-800">
                        <span class="w-8 h-8 rounded-xl bg-red-600 text-white flex items-center justify-center font-black text-sm shadow-md shadow-red-600/40">2</span>
                        <div>
                            <h3 class="text-lg font-black uppercase tracking-wider text-white">Tentukan Tanggal Pertandingan</h3>
                            <p class="text-xs text-slate-400">Weekend (Sabtu-Minggu) otomatis berlaku tarif Prime Time.</p>
                        </div>
                    </div>

                    <div class="max-w-md">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Tanggal Kick-off</label>
                        <input type="date" 
                               name="date" 
                               id="bookingDate" 
                               class="saas-date-picker"
                               value="{{ old('date', request('date', date('Y-m-d'))) }}"
                               min="{{ date('Y-m-d') }}"
                               onchange="updateSlotGrid()">
                    </div>
                </div>

                {{-- 3. PILIH JAM MAIN (SLOT HOURS) --}}
                <div class="saas-panel p-6 sm:p-8">
                    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 pb-4 mb-6 border-b border-slate-800">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-xl bg-red-600 text-white flex items-center justify-center font-black text-sm shadow-md shadow-red-600/40">3</span>
                            <div>
                                <h3 class="text-lg font-black uppercase tracking-wider text-white">Pilih Slot Jam Bermain</h3>
                                <p class="text-xs text-slate-400">Pilih 1 jam main. Tombol konfirmasi akan aktif setelah jam dipilih.</p>
                            </div>
                        </div>

                        {{-- Indicator Legends --}}
                        <div class="flex items-center gap-4 text-xs font-bold text-slate-300">
                            <div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-emerald-400 shadow-sm shadow-emerald-400/50"></span> Ready</div>
                            <div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span> Pending</div>
                            <div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-slate-700"></span> Terisi</div>
                        </div>
                    </div>

                    <input type="hidden" name="start_time" id="selectedStartTime" value="{{ old('start_time') }}">
                    <input type="hidden" name="end_time" id="selectedEndTime" value="{{ old('end_time') }}">

                    <div id="slotGridContainer" class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-5 gap-3">
                        <div class="col-span-full py-12 text-center text-slate-500 text-xs font-bold">
                            <i class="fa-solid fa-spinner fa-spin mr-2 text-sm text-red-500"></i> Mengambil status ketersediaan lapangan...
                        </div>
                    </div>
                </div>

                {{-- 4. METODE PEMBAYARAN --}}
                <div class="saas-panel p-6 sm:p-8">
                    <div class="flex items-center gap-3 pb-4 mb-6 border-b border-slate-800">
                        <span class="w-8 h-8 rounded-xl bg-red-600 text-white flex items-center justify-center font-black text-sm shadow-md shadow-red-600/40">4</span>
                        <div>
                            <h3 class="text-lg font-black uppercase tracking-wider text-white">Metode Pelunasan</h3>
                            <p class="text-xs text-slate-400">Pilih opsi pembayaran digital otomatis atau langsung di kasir.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <label class="relative block">
                            <input type="radio" 
                                   name="payment_method" 
                                   value="transfer" 
                                   class="pay-radio peer sr-only"
                                   {{ old('payment_method', 'transfer') === 'transfer' ? 'checked' : '' }}
                                   onchange="updatePaymentMethodText('Transfer Online (Midtrans)')">
                            
                            <div class="pay-choice-card rounded-2xl bg-slate-900 border border-slate-800 p-5 flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-red-600/15 border border-red-500/30 text-red-500 flex items-center justify-center text-xl shrink-0">
                                    <i class="fa-solid fa-bolt-lightning"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-black uppercase text-white">Transfer / Midtrans</h4>
                                    <p class="text-[11px] text-slate-400 mt-0.5">QRIS Instan, BCA, Mandiri, BNI, GoPay, ShopeePay.</p>
                                </div>
                            </div>
                        </label>

                        <label class="relative block">
                            <input type="radio" 
                                   name="payment_method" 
                                   value="cash" 
                                   class="pay-radio peer sr-only"
                                   {{ old('payment_method') === 'cash' ? 'checked' : '' }}
                                   onchange="updatePaymentMethodText('Bayar Tunai di Kasir')">
                            
                            <div class="pay-choice-card rounded-2xl bg-slate-900 border border-slate-800 p-5 flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-emerald-600/15 border border-emerald-500/30 text-emerald-400 flex items-center justify-center text-xl shrink-0">
                                    <i class="fa-solid fa-money-bill-wave"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-black uppercase text-white">Cash di Arena</h4>
                                    <p class="text-[11px] text-slate-400 mt-0.5">Pelunasan langsung kepada kasir sebelum peluit kick-off.</p>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

            </div>

            {{-- RIGHT: STICKY INVOICE (4 COLS) --}}
            <div class="lg:col-span-4 sticky top-24 space-y-6">
                
                <div class="saas-panel p-6 sm:p-7 border-red-500/30 bg-gradient-to-b from-slate-900/90 to-slate-950">
                    <div class="flex items-center justify-between pb-4 mb-5 border-b border-slate-800">
                        <span class="text-[10px] font-black uppercase tracking-widest text-red-500">Order Invoice Summary</span>
                        <span class="px-2.5 py-0.5 rounded-full bg-red-950 text-red-400 border border-red-800 text-[10px] font-black uppercase" id="badgeRateType">Slot Reguler</span>
                    </div>

                    {{-- Data Ringkasan --}}
                    <div class="space-y-4 text-xs">
                        <div class="flex justify-between items-center">
                            <span class="text-slate-400">Pemesan:</span>
                            <span class="font-bold text-white uppercase">{{ Auth::user()->name }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-400">Nomor WhatsApp:</span>
                            <span class="font-bold text-white">{{ Auth::user()->phone ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-400">Arena Lapangan:</span>
                            <span class="font-black text-white uppercase" id="summaryCourt">Lapangan 1</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-400">Tanggal:</span>
                            <span class="font-bold text-slate-200" id="summaryDate">{{ date('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-400">Durasi Kick-off:</span>
                            <span class="font-black text-red-400" id="summaryHours">Belum dipilih</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-400">Metode Bayar:</span>
                            <span class="font-bold text-slate-200" id="summaryPaymentMethod">Transfer Online (Midtrans)</span>
                        </div>
                    </div>

                    {{-- Rincian Tagihan --}}
                    <div class="mt-6 pt-5 border-t border-slate-800 space-y-2 text-xs">
                        <div class="flex justify-between text-slate-400">
                            <span id="labelTarifName">Sewa Slot Siang (1 Jam)</span>
                            <span class="font-bold text-white" id="summarySubtotal">Rp 120.000</span>
                        </div>
                        <div class="flex justify-between text-slate-400">
                            <span>Rompi & Peminjaman Bola</span>
                            <span class="font-bold text-emerald-400">Termasuk (Gratis)</span>
                        </div>
                        <div class="mt-4 pt-4 border-t border-slate-800/80 flex justify-between items-baseline">
                            <span class="text-xs font-black uppercase text-slate-300">Total Tagihan</span>
                            <span class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-rose-400" id="summaryGrandTotal">
                                Rp 120.000
                            </span>
                        </div>
                    </div>

                    {{-- Tombol Submit Validasi --}}
                    <div class="mt-6">
                        <button type="submit" id="btnSubmitBooking" class="btn-action-primary" disabled>
                            <span id="btnSubmitText">Pilih Slot Jam Main</span>
                            <i class="fa-solid fa-arrow-right text-xs" id="btnSubmitIcon"></i>
                        </button>
                    </div>

                    {{-- Info Validation Alert Helper --}}
                    <div class="mt-3 text-center" id="validationNotice">
                        <span class="text-[11px] text-amber-400/90 font-semibold flex items-center justify-center gap-1.5">
                            <i class="fa-solid fa-circle-info text-xs"></i>
                            <span id="validationText">Silakan tentukan slot jam terlebih dahulu</span>
                        </span>
                    </div>

                    <div class="mt-4 flex items-center justify-center gap-2 text-[10px] text-slate-500">
                        <i class="fa-solid fa-shield-halved text-emerald-500"></i>
                        <span>Enkripsi checkout aman & garansi jadwal terdaftar</span>
                    </div>
                </div>

            </div>

        </div>
    </form>

</div>

{{-- ================= CORE JS LOGIC & REAL-TIME VALIDATION ================= --}}
<script>
let currentPrice = 120000;

document.addEventListener("DOMContentLoaded", function () {
    updateFieldSelection();
    validateBookingForm();
});

function updateFieldSelection() {
    const fieldSelected = document.querySelector('input[name="field"]:checked');
    if (!fieldSelected) return;

    document.getElementById('summaryCourt').innerText = fieldSelected.value;
    
    // Reset pilihan jam jika berganti lapangan
    document.getElementById('selectedStartTime').value = '';
    document.getElementById('selectedEndTime').value = '';
    document.getElementById('summaryHours').innerText = 'Belum dipilih';

    validateBookingForm();
    updateSlotGrid();
}

function updateSlotGrid() {
    const fieldInput = document.querySelector('input[name="field"]:checked');
    const dateInput = document.getElementById('bookingDate');
    const container = document.getElementById('slotGridContainer');

    if (!fieldInput || !dateInput) return;

    const field = fieldInput.value;
    const date = dateInput.value;

    const d = new Date(date);
    if (!isNaN(d.getTime())) {
        const options = { day: '2-digit', month: 'short', year: 'numeric' };
        document.getElementById('summaryDate').innerText = d.toLocaleDateString('id-ID', options);
    }

    container.innerHTML = `
        <div class="col-span-full py-12 text-center text-slate-500 text-xs font-bold">
            <i class="fa-solid fa-spinner fa-spin mr-2 text-red-500 text-sm"></i> Mengecek ketersediaan ${field}...
        </div>
    `;

    fetch(`{{ route('jadwal.grid') }}?lapangan=${encodeURIComponent(field)}&date=${encodeURIComponent(date)}`)
        .then(res => res.json())
        .then(data => {
            container.innerHTML = '';

            data.hours.forEach(h => {
                const startTime = `${h < 10 ? '0' + h : h}:00`;
                const nextHour = h + 1;
                const endTime = `${nextHour < 10 ? '0' + nextHour : nextHour}:00`;

                let isBlocked = data.blocked.includes(h);
                let isPending = data.pending.includes(h);

                const isWeekendDay = (d.getDay() === 0 || d.getDay() === 6);
                const rateThisHour = (isWeekendDay || h >= 16) ? 175000 : 120000;
                const rateLabel = (isWeekendDay || h >= 16) ? 'Prime' : 'Reguler';

                let btnClass = 'bg-slate-900 border-slate-800 text-emerald-400 hover:border-emerald-500/60';
                let disabled = false;
                let dotClass = 'bg-emerald-400 shadow-sm shadow-emerald-400/60';
                let statusDesc = `Rp ${(rateThisHour/1000)}k • ${rateLabel}`;

                if (isBlocked) {
                    btnClass = 'bg-slate-950/70 border-slate-850 text-slate-600 cursor-not-allowed opacity-40 slot-disabled';
                    disabled = true;
                    dotClass = 'bg-slate-600';
                    statusDesc = 'Terisi';
                } else if (isPending) {
                    btnClass = 'bg-slate-900 border-amber-600/40 text-amber-400 hover:border-amber-500/80';
                    dotClass = 'bg-amber-400';
                    statusDesc = 'Pending';
                }

                const radioId = `slot_${h}`;
                const isChecked = document.getElementById('selectedStartTime').value === startTime ? 'checked' : '';

                container.innerHTML += `
                    <label class="block relative" for="${radioId}">
                        <input type="radio" 
                               name="slot_radio" 
                               id="${radioId}" 
                               class="slot-radio sr-only peer"
                               ${disabled ? 'disabled' : ''}
                               ${isChecked}
                               onchange="chooseSlot('${startTime}', '${endTime}', ${rateThisHour}, '${rateLabel}')">

                        <div class="slot-cell p-3.5 rounded-xl border text-center font-bold text-xs flex flex-col items-center justify-center gap-1.5 ${btnClass}">
                            <div class="flex items-center gap-1.5 text-xs font-black">
                                <span class="w-1.5 h-1.5 rounded-full ${dotClass}"></span>
                                <span>${startTime}</span>
                            </div>
                            <span class="text-[10px] text-slate-400 font-semibold tracking-wide">${statusDesc}</span>
                        </div>
                    </label>
                `;
            });

            validateBookingForm();
        })
        .catch(err => {
            container.innerHTML = `
                <div class="col-span-full py-6 text-center text-red-400 text-xs font-bold">
                    Koneksi terputus. Silakan klik reload kembali.
                </div>
            `;
            validateBookingForm();
        });
}

function chooseSlot(start, end, rate, rateLabel) {
    document.getElementById('selectedStartTime').value = start;
    document.getElementById('selectedEndTime').value = end;

    currentPrice = rate;
    document.getElementById('summaryHours').innerText = `${start} - ${end} WIB`;
    document.getElementById('badgeRateType').innerText = rateLabel === 'Prime' ? 'Prime Time' : 'Slot Reguler';
    document.getElementById('labelTarifName').innerText = `Sewa Slot ${rateLabel} (1 Jam)`;
    document.getElementById('summarySubtotal').innerText = 'Rp ' + rate.toLocaleString('id-ID');
    document.getElementById('summaryGrandTotal').innerText = 'Rp ' + rate.toLocaleString('id-ID');

    validateBookingForm();
}

function updatePaymentMethodText(methodName) {
    document.getElementById('summaryPaymentMethod').innerText = methodName;
    validateBookingForm();
}

/**
 * ==================================================
 * REAL-TIME FORM VALIDATION FUNCTION
 * ==================================================
 */
function validateBookingForm() {
    const fieldSelected = document.querySelector('input[name="field"]:checked');
    const dateInput     = document.getElementById('bookingDate');
    const startTime     = document.getElementById('selectedStartTime').value;
    const endTime       = document.getElementById('selectedEndTime').value;
    const paymentMethod = document.querySelector('input[name="payment_method"]:checked');

    const submitBtn     = document.getElementById('btnSubmitBooking');
    const btnText       = document.getElementById('btnSubmitText');
    const noticeBox     = document.getElementById('validationNotice');
    const noticeText    = document.getElementById('validationText');

    if (!fieldSelected) {
        setBtnDisabled(submitBtn, btnText, noticeBox, noticeText, 'Pilih Arena Lapangan');
        return;
    }

    if (!dateInput || !dateInput.value) {
        setBtnDisabled(submitBtn, btnText, noticeBox, noticeText, 'Tentukan Tanggal Pertandingan');
        return;
    }

    if (!startTime || !endTime) {
        setBtnDisabled(submitBtn, btnText, noticeBox, noticeText, 'Pilih Slot Jam Main');
        return;
    }

    if (!paymentMethod) {
        setBtnDisabled(submitBtn, btnText, noticeBox, noticeText, 'Pilih Metode Pembayaran');
        return;
    }

    // Seluruh Form Valid
    submitBtn.removeAttribute('disabled');
    btnText.innerText = 'Konfirmasi & Bayar';
    noticeBox.innerHTML = `
        <span class="text-[11px] text-emerald-400 font-bold flex items-center justify-center gap-1.5">
            <i class="fa-solid fa-circle-check text-xs"></i>
            Formulir lengkap! Siap konfirmasi pesanan.
        </span>
    `;
}

function setBtnDisabled(btn, btnText, noticeBox, noticeText, reason) {
    btn.setAttribute('disabled', 'disabled');
    btnText.innerText = reason;
    noticeBox.innerHTML = `
        <span class="text-[11px] text-amber-400/90 font-semibold flex items-center justify-center gap-1.5">
            <i class="fa-solid fa-circle-info text-xs"></i>
            <span>Silakan lengkapi: ${reason}</span>
        </span>
    `;
}

// Universal Button Ripple Effect
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

    setTimeout(() => {
        ripple.remove();
    }, 650);
});
</script>

@endsection