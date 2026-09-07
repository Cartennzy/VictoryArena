@extends('layouts.customer')

@section('title', 'Jadwal Ketersediaan Lapangan | Victory Arena')

@section('content')

<style>
    .saas-box {
        background: rgba(13, 20, 36, 0.85);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 26px;
        box-shadow: 0 20px 45px -15px rgba(0, 0, 0, 0.7);
    }

    .court-tab-btn {
        padding: 10px 22px;
        border-radius: 14px;
        font-size: 0.85rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #94a3b8;
        border: 1px solid transparent;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .court-tab-btn.active {
        background: #dc2626;
        color: #ffffff;
        box-shadow: 0 8px 20px -4px rgba(220, 38, 38, 0.5);
    }

    .slot-card {
        padding: 14px;
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        text-align: center;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .slot-card.available {
        background: rgba(16, 185, 129, 0.1);
        border-color: rgba(16, 185, 129, 0.3);
        color: #34d399;
    }
    .slot-card.pending {
        background: rgba(245, 158, 11, 0.1);
        border-color: rgba(245, 158, 11, 0.3);
        color: #fbbf24;
    }
    .slot-card.booked {
        background: rgba(15, 23, 42, 0.6);
        border-color: rgba(255, 255, 255, 0.05);
        color: #64748b;
        opacity: 0.6;
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
    }
    .btn-action-primary:active {
        transform: translateY(2px) scale(0.98) !important;
    }
</style>

<div class="max-w-7xl mx-auto py-4 sm:py-6 space-y-6 text-slate-100 font-sans">

    {{-- Header Banner --}}
    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 pb-4 border-b border-slate-800">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-0.5 rounded-full bg-red-950/60 border border-red-800/60 text-red-400 text-[10px] font-black tracking-widest uppercase mb-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                Live Availability Engine
            </div>
            <h1 class="text-2xl sm:text-3xl font-black uppercase tracking-tight text-white">Kalender Jadwal Lapangan</h1>
            <p class="text-xs text-slate-400 mt-0.5">Pantau ketersediaan slot waktu bermain secara real-time di seluruh arena.</p>
        </div>

        <a href="{{ route('customer.booking') }}" 
           class="btn-action-primary self-start sm:self-auto px-6">
            <i class="fa-solid fa-bolt text-xs"></i>
            <span>Booking Sekarang</span>
        </a>
    </div>

    {{-- Filter Panel: Pilihan Lapangan & Tanggal --}}
    <div class="saas-box p-6 flex flex-col md:flex-row items-center justify-between gap-5">
        <div class="flex flex-wrap items-center gap-2 p-1.5 rounded-2xl bg-slate-900/80 border border-slate-800 w-full md:w-auto">
            @foreach($lapangan as $item)
                <button type="button" 
                        onclick="selectCourt('{{ $item['name'] }}', this)" 
                        class="court-tab-btn {{ $loop->first ? 'active' : '' }}">
                    {{ $item['name'] }}
                </button>
            @endforeach
        </div>

        <div class="flex items-center gap-3 w-full md:w-auto">
            <span class="text-xs font-bold uppercase text-slate-400">Pilih Hari:</span>
            <input type="date" 
                   id="scheduleDate" 
                   class="bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-xs font-bold text-white outline-none focus:border-red-600"
                   value="{{ date('Y-m-d') }}" 
                   min="{{ date('Y-m-d') }}"
                   onchange="fetchLiveGrid()">
        </div>
    </div>

    {{-- Matrix Slot Hours --}}
    <div class="saas-box p-6 sm:p-8 space-y-6">
        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-3 pb-4 border-b border-slate-800">
            <div>
                <h3 class="text-base font-black uppercase text-white" id="courtTitle">LAPANGAN 1</h3>
                <p class="text-xs text-slate-400 mt-0.5" id="dateTitle">{{ date('d M Y') }}</p>
            </div>

            <div class="flex items-center gap-4 text-xs font-bold">
                <div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span> Tersedia</div>
                <div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span> Pending</div>
                <div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-slate-600"></span> Terisi (Booked)</div>
            </div>
        </div>

        <div id="gridContainer" class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-7 gap-3.5">
            <div class="col-span-full py-12 text-center text-slate-500 text-xs font-bold">
                <i class="fa-solid fa-spinner fa-spin mr-2 text-red-500"></i> Memuat jadwal lapangan...
            </div>
        </div>
    </div>

</div>

<script>
let currentSelectedCourt = 'Lapangan 1';

document.addEventListener("DOMContentLoaded", function () {
    fetchLiveGrid();
});

function selectCourt(courtName, btn) {
    currentSelectedCourt = courtName;
    document.querySelectorAll('.court-tab-btn').forEach(el => el.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('courtTitle').innerText = courtName.toUpperCase();
    fetchLiveGrid();
}

function fetchLiveGrid() {
    const date = document.getElementById('scheduleDate').value;
    const container = document.getElementById('gridContainer');

    const d = new Date(date);
    if (!isNaN(d.getTime())) {
        document.getElementById('dateTitle').innerText = d.toLocaleDateString('id-ID', { weekday: 'long', day: '2-digit', month: 'long', year: 'numeric' });
    }

    container.innerHTML = `
        <div class="col-span-full py-12 text-center text-slate-500 text-xs font-bold">
            <i class="fa-solid fa-spinner fa-spin mr-2 text-red-500"></i> Memuat data ${currentSelectedCourt}...
        </div>
    `;

    fetch(`{{ route('jadwal.grid') }}?lapangan=${encodeURIComponent(currentSelectedCourt)}&date=${encodeURIComponent(date)}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        container.innerHTML = '';

        data.hours.forEach(h => {
            const startTime = `${h < 10 ? '0' + h : h}:00`;
            const nextHour = h + 1;
            const endTime = `${nextHour < 10 ? '0' + nextHour : nextHour}:00`;

            let isBlocked = data.blocked.includes(h);
            let isPending = data.pending.includes(h);

            let statusClass = 'available';
            let statusText = 'Ready (Kosong)';
            let actionBtn = `<a href="/booking?field=${encodeURIComponent(currentSelectedCourt)}&date=${date}&start_time=${startTime}&end_time=${endTime}" class="mt-2 inline-block px-3 py-1 rounded-lg bg-emerald-500/20 hover:bg-emerald-500 text-emerald-300 hover:text-white text-[10px] font-black uppercase tracking-wider transition-colors">Book Slot</a>`;

            if (isBlocked) {
                statusClass = 'booked';
                statusText = 'Terisi (Penuh)';
                actionBtn = `<span class="mt-2 inline-block px-2.5 py-1 text-[10px] font-bold text-slate-500 uppercase">Booked</span>`;
            } else if (isPending) {
                statusClass = 'pending';
                statusText = 'Menunggu';
                actionBtn = `<span class="mt-2 inline-block px-2.5 py-1 text-[10px] font-bold text-amber-500 uppercase">Pending</span>`;
            }

            container.innerHTML += `
                <div class="slot-card ${statusClass} flex flex-col justify-between">
                    <div>
                        <span class="text-xs font-black block text-white">${startTime} - ${endTime}</span>
                        <span class="text-[10px] font-bold block mt-1">${statusText}</span>
                    </div>
                    <div>
                        ${actionBtn}
                    </div>
                </div>
            `;
        });
    })
    .catch(err => {
        container.innerHTML = `<div class="col-span-full py-8 text-center text-red-400 text-xs font-bold">Gagal mengambil jadwal. Silakan refresh halaman.</div>`;
    });
}
</script>

@endsection