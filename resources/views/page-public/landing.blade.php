@extends('layouts.public')
@section('title', 'Victory Arena | Reservasi Futsal')

@section('content')

{{-- ================= STYLES SAAS & INTERACTION ANIMATIONS ================= --}}
<style>
    .font-sports {
        font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, -apple-system, sans-serif;
        letter-spacing: -0.02em;
    }

    @keyframes heroFadeUp {
        0% { opacity: 0; transform: translateY(24px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulseGlow {
        0%, 100% { opacity: 0.25; transform: scale(1); }
        50% { opacity: 0.55; transform: scale(1.08); }
    }

    @keyframes rippleAnim {
        0% { transform: scale(0); opacity: 0.55; }
        100% { transform: scale(3.5); opacity: 0; }
    }

    .animate-hero {
        animation: heroFadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    /* Production Button System with Active State & Elevation */
    .btn-action {
        position: relative;
        overflow: hidden;
        user-select: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
    }
    .btn-action:hover {
        transform: translateY(-2px);
    }
    .btn-action:active {
        transform: translateY(1.5px) scale(0.97) !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.4) !important;
    }

    /* Ripple Wave Animation */
    .ripple-wave {
        position: absolute;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.4);
        pointer-events: none;
        transform: scale(0);
        animation: rippleAnim 0.65s cubic-bezier(0, 0, 0.2, 1);
    }

    /* Card Micro-interactions */
    .saas-card {
        background: #0f1523;
        border: 1px solid rgba(255, 255, 255, 0.07);
        transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1), 
                    border-color 0.25s ease, 
                    box-shadow 0.25s ease;
    }
    .saas-card:hover {
        transform: translateY(-5px);
        border-color: rgba(229, 9, 20, 0.5);
        box-shadow: 0 20px 35px -10px rgba(0, 0, 0, 0.8), 
                    0 0 25px 0 rgba(229, 9, 20, 0.15);
    }

    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #0b0f19; border-radius: 8px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #242c3d; border-radius: 8px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #e50914; }
</style>

<div class="bg-[#080d1a] text-slate-100 font-sports min-h-screen selection:bg-red-600 selection:text-white flex flex-col justify-between">

    {{-- ================= TOP BANNER & NAVBAR ================= --}}
    <header class="sticky top-0 z-40 bg-[#080d1a]/95 backdrop-blur-xl border-b border-slate-800/80">
        {{-- Banner Atas --}}
        <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-800 text-[10px] sm:text-xs font-black uppercase tracking-widest text-white py-1.5 px-4 text-center shadow-md">
            <i class="fa-solid fa-trophy mr-1.5 text-yellow-300"></i> The Official Booking Portal of Victory Arena &bull; One Team, One Dream
        </div>

        {{-- Nav Utama --}}
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 py-3 flex items-center justify-between">
            {{-- Brand & Logo Bundar --}}
            <a href="#" class="flex items-center gap-2.5 sm:gap-3.5 shrink-0 group">
                <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-full overflow-hidden bg-slate-900 border-2 border-red-600 shadow-md shadow-red-600/30 flex items-center justify-center p-0.5 shrink-0 group-hover:scale-105 transition-transform duration-300">
                    <img src="{{ asset('assets/logo-victory-arena.png') }}" 
                         alt="Victory Arena Logo" 
                         class="w-full h-full object-cover rounded-full"
                         onerror="this.onerror=null; this.parentElement.innerHTML='<i class=\'fa-solid fa-futbol text-red-500 text-lg\'></i>';">
                </div>
                <div>
                    <span class="text-base sm:text-xl font-black uppercase tracking-wider text-white">VICTORY <span class="text-red-500">ARENA</span></span>
                    <span class="block text-[8px] sm:text-[9px] font-bold text-slate-400 uppercase tracking-widest leading-none">Futsal Stadium & Booking</span>
                </div>
            </a>

            {{-- Menu Desktop --}}
            <div class="hidden md:flex items-center gap-8 text-xs font-black uppercase tracking-wider text-slate-300">
                <a href="#" class="hover:text-red-500 transition-colors duration-200">Home</a>
                <a href="#lapangan" class="hover:text-red-500 transition-colors duration-200">Arena & Jadwal</a>
                <a href="#harga" class="hover:text-red-500 transition-colors duration-200">Daftar Harga</a>
                <a href="#fasilitas" class="hover:text-red-500 transition-colors duration-200">Fasilitas</a>
                <a href="#kontak" class="hover:text-red-500 transition-colors duration-200">Kontak</a>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center gap-2">
                <a href="{{ route('login') }}" 
                   class="btn-action px-3.5 py-2 sm:px-5 sm:py-2.5 rounded-full bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white font-black text-[11px] sm:text-xs uppercase tracking-wider shadow-lg shadow-red-600/30">
                    <i class="fa fa-user mr-1.5 sm:mr-2 text-xs"></i> 
                    <span>Masuk</span><span class="hidden sm:inline">&nbsp;/ Login</span>
                </a>

                {{-- Hamburger Menu Mobile Button --}}
                <button type="button" 
                        onclick="toggleMobileMenu()" 
                        class="md:hidden w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-slate-900 border border-slate-700 flex items-center justify-center text-slate-200 hover:text-white hover:border-red-600 transition-colors focus:outline-none"
                        aria-label="Toggle Navigation">
                    <i id="menuIcon" class="fa fa-bars text-sm"></i>
                </button>
            </div>
        </nav>

        {{-- Mobile Dropdown Menu --}}
        <div id="mobileMenu" class="hidden md:hidden border-t border-slate-800/90 bg-[#090e1c] px-5 py-4 space-y-2 transition-all duration-300 shadow-2xl">
            <a href="#" onclick="toggleMobileMenu()" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-black uppercase tracking-wider text-slate-300 hover:text-white hover:bg-slate-800/60 transition-colors">
                <i class="fa fa-home w-4 text-red-500"></i> Home
            </a>
            <a href="#lapangan" onclick="toggleMobileMenu()" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-black uppercase tracking-wider text-slate-300 hover:text-white hover:bg-slate-800/60 transition-colors">
                <i class="fa fa-futbol w-4 text-red-500"></i> Arena & Jadwal
            </a>
            <a href="#harga" onclick="toggleMobileMenu()" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-black uppercase tracking-wider text-slate-300 hover:text-white hover:bg-slate-800/60 transition-colors">
                <i class="fa fa-tags w-4 text-red-500"></i> Daftar Harga
            </a>
            <a href="#fasilitas" onclick="toggleMobileMenu()" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-black uppercase tracking-wider text-slate-300 hover:text-white hover:bg-slate-800/60 transition-colors">
                <i class="fa fa-shield-halved w-4 text-red-500"></i> Fasilitas
            </a>
            <a href="#kontak" onclick="toggleMobileMenu()" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-black uppercase tracking-wider text-slate-300 hover:text-white hover:bg-slate-800/60 transition-colors">
                <i class="fa fa-phone w-4 text-red-500"></i> Kontak
            </a>
            
            <div class="pt-3 border-t border-slate-800/80">
                <a href="{{ route('login') }}" class="btn-action w-full py-3 rounded-xl bg-red-600 hover:bg-red-700 text-white font-black text-xs uppercase tracking-wider shadow-md shadow-red-600/30">
                    <i class="fa fa-arrow-right-to-bracket mr-2 text-xs"></i> Masuk ke Portal Akun
                </a>
            </div>
        </div>
    </header>

    <div>
        {{-- ================= HERO SECTION ================= --}}
        <section class="relative pt-12 sm:pt-20 pb-16 sm:pb-24 overflow-hidden border-b border-slate-800/80">
            <div class="absolute -top-40 left-1/2 -translate-x-1/2 w-[760px] h-[500px] bg-red-600/15 rounded-full blur-[140px] pointer-events-none" style="animation: pulseGlow 7s ease-in-out infinite;"></div>
            <div class="absolute top-1/2 -left-32 w-80 h-80 bg-blue-900/15 rounded-full blur-[120px] pointer-events-none"></div>

            <div class="max-w-5xl mx-auto px-5 sm:px-6 relative z-10 text-center">
                <div class="space-y-6 sm:space-y-8 animate-hero">
                    
                    <div class="inline-flex items-center gap-2.5 px-3.5 py-1.5 rounded-full bg-red-950/60 border border-red-800/60 text-red-400 text-[10px] sm:text-[11px] font-black tracking-widest uppercase mx-auto shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-red-500 animate-ping"></span>
                        Victory Arena &bull; Official Booking Platform
                    </div>

                    <h1 class="text-4xl sm:text-6xl md:text-7xl lg:text-8xl font-black uppercase tracking-tight leading-[1.05] sm:leading-[0.95] text-white">
                        Together <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-600 via-red-500 to-rose-400">
                            We Rise & Play!
                        </span>
                    </h1>

                    <p class="text-sm sm:text-lg md:text-xl text-slate-300 max-w-2xl mx-auto font-normal leading-relaxed px-2">
                        Sistem reservasi lapangan futsal berstandar turnamen resmi dengan pengecekan jadwal real-time, instan, transparan, dan terintegrasi penuh.
                    </p>

                    <div class="flex flex-col sm:flex-row items-center justify-center gap-3.5 sm:gap-4 pt-2">
                        <a href="#lapangan" 
                           class="btn-action w-full sm:w-auto px-8 py-4 rounded-xl bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white font-black text-xs sm:text-sm uppercase tracking-wider shadow-lg shadow-red-600/35">
                            Pilih Lapangan & Jadwal
                            <i class="fa fa-arrow-right ml-3 text-xs"></i>
                        </a>

                        <a href="#harga" 
                           class="btn-action w-full sm:w-auto px-8 py-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-slate-200 border border-slate-700 font-bold text-xs sm:text-sm hover:border-slate-500">
                            <i class="fa fa-tags mr-2 text-red-500"></i> Cek Tarif Sewa
                        </a>
                    </div>

                    <div class="max-w-xl mx-auto pt-4">
                        <div class="bg-slate-900/80 border border-slate-800/90 backdrop-blur-md rounded-2xl p-4 sm:p-5 flex items-center justify-center gap-4 shadow-xl text-left">
                            <div class="w-10 h-10 rounded-xl bg-red-600/20 text-red-500 flex items-center justify-center shrink-0 border border-red-500/30">
                                <i class="fa-solid fa-shield-halved text-base sm:text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-white text-xs sm:text-sm md:text-base">Kenapa Victory Arena?</h4>
                                <p class="text-[11px] sm:text-xs text-slate-400 mt-0.5 leading-relaxed">
                                    Booking praktis tanpa tabrakan jadwal, status live availability, dan fasilitas pro.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        {{-- ================= STATS BAR ================= --}}
        <section class="border-b border-slate-800/80 bg-slate-950/70">
            <div class="max-w-7xl mx-auto px-5 sm:px-6 py-6 sm:py-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center divide-x divide-slate-800/60">
                    <div class="flex items-center justify-center gap-3">
                        <i class="fa fa-trophy text-red-500 text-xl sm:text-2xl"></i>
                        <div class="text-left">
                            <p class="text-2xl sm:text-3xl font-black text-white leading-tight">3</p>
                            <p class="text-[10px] sm:text-[11px] uppercase tracking-wider font-semibold text-slate-400">Arena Courts</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-center gap-3 pl-3 sm:pl-4">
                        <i class="fa fa-futbol text-red-500 text-xl sm:text-2xl"></i>
                        <div class="text-left">
                            <p class="text-2xl sm:text-3xl font-black text-white leading-tight">1.5K+</p>
                            <p class="text-[10px] sm:text-[11px] uppercase tracking-wider font-semibold text-slate-400">Matches Played</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-center gap-3 pl-3 sm:pl-4">
                        <i class="fa fa-users text-red-500 text-xl sm:text-2xl"></i>
                        <div class="text-left">
                            <p class="text-2xl sm:text-3xl font-black text-white leading-tight">100+</p>
                            <p class="text-[10px] sm:text-[11px] uppercase tracking-wider font-semibold text-slate-400">Active Squads</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-center gap-3 pl-3 sm:pl-4">
                        <i class="fa fa-calendar-check text-red-500 text-xl sm:text-2xl"></i>
                        <div class="text-left">
                            <p class="text-2xl sm:text-3xl font-black text-white leading-tight">EST.</p>
                            <p class="text-[10px] sm:text-[11px] uppercase tracking-wider font-semibold text-slate-400">2024 Built</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ================= LAPANGAN SECTION ================= --}}
        <section class="py-16 sm:py-24 bg-[#080d1a]" id="lapangan">
            <div class="max-w-7xl mx-auto px-5 sm:px-6">
                <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16">
                    <span class="text-red-500 text-xs font-black tracking-widest uppercase mb-2 block">Arenas Selection</span>
                    <h2 class="text-3xl sm:text-5xl font-black uppercase tracking-tight text-white">
                        Pilih Arena Bermainmu
                    </h2>
                    <p class="text-slate-400 text-xs sm:text-base mt-3">
                        Setiap lapangan dilengkapi fasilitas turnamen terawat, pencahayaan LED pro-lux, dan permukaan lantai anti slip.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
                    @for($i=1; $i<=3; $i++)
                    <div class="saas-card group rounded-3xl overflow-hidden flex flex-col justify-between">
                        
                        <div>
                            <div class="relative h-56 sm:h-64 overflow-hidden bg-slate-950">
                                <img src="{{ asset('assets/lapangan'.$i.'.jpg') }}"
                                     alt="Victory Field {{ $i }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                     onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1529900241451-b8622e283128?w=800&q=80';">
                                <div class="absolute inset-0 bg-gradient-to-t from-[#0f1523] via-transparent to-black/30"></div>

                                <div class="absolute top-4 left-4 z-10">
                                    <span class="px-3 py-1 bg-red-600 text-white font-black text-[11px] uppercase tracking-wider rounded-lg shadow-md">
                                        ARENA {{ $i }}
                                    </span>
                                </div>
                                <div class="absolute top-4 right-4 z-10">
                                    <span class="flex items-center gap-1.5 bg-slate-950/80 backdrop-blur-md text-amber-400 px-3 py-1 rounded-full text-xs font-bold border border-slate-700">
                                        <i class="fa fa-star text-xs"></i> 4.{{ 6+$i }}
                                    </span>
                                </div>
                            </div>

                            <div class="p-5 sm:p-6">
                                <div class="flex items-baseline justify-between mb-2">
                                    <h3 class="text-xl sm:text-2xl font-black uppercase tracking-wide text-white group-hover:text-red-500 transition-colors">
                                        Victory Field {{ $i }}
                                    </h3>
                                </div>

                                <div class="mb-4 inline-flex items-baseline gap-1.5 px-3 py-1 rounded-lg bg-red-950/50 border border-red-800/40 text-red-400">
                                    <span class="text-[11px] font-bold">Mulai</span>
                                    <span class="text-sm sm:text-base font-black text-white">Rp 120.000</span>
                                    <span class="text-[10px] text-slate-400 font-medium">/ jam</span>
                                </div>

                                <p class="text-xs text-slate-400 mt-1 mb-4 flex items-center gap-2">
                                    <i class="fa fa-check-circle text-red-500"></i> Vinyl Interlock &bull; High Lux LED &bull; Digital Scoreboard
                                </p>

                                <div class="space-y-2 py-3 border-t border-b border-slate-800 text-xs text-slate-300">
                                    <div class="flex justify-between">
                                        <span class="text-slate-500">Kapasitas:</span>
                                        <span class="font-bold">5 vs 5 (Maks 12 Orang)</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-slate-500">Blower Cooler:</span>
                                        <span class="text-emerald-400 font-semibold">Tersedia</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-5 sm:p-6 pt-0">
                            <button onclick="openJadwal('Lapangan {{ $i }}')"
                                    class="btn-action w-full py-3.5 rounded-xl bg-red-600/15 border border-red-600/40 text-red-400 hover:bg-red-600 hover:text-white font-black text-xs uppercase tracking-wider shadow-sm">
                                <i class="fa fa-calendar-check mr-2"></i> Lihat Jadwal & Booking
                            </button>
                        </div>

                    </div>
                    @endfor
                </div>
            </div>
        </section>

        {{-- ================= SECTION: CTA & PRICELIST ================= --}}
        <section class="py-16 sm:py-20 bg-slate-950 border-t border-b border-slate-800/80 relative overflow-hidden" id="harga">
            <div class="absolute -right-24 top-1/2 -translate-y-1/2 w-96 h-96 bg-red-600/10 blur-[130px] pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-5 sm:px-6 relative z-10">
                <div class="text-center max-w-2xl mx-auto mb-12 sm:mb-16">
                    <span class="text-red-500 text-xs font-black tracking-widest uppercase mb-2 block">Clear & Fair Pricing</span>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black uppercase tracking-tight text-white">
                        Tarif Sewa & Membership
                    </h2>
                    <p class="text-slate-400 text-xs sm:text-sm mt-3">
                        Harga transparan tanpa biaya tersembunyi. Sudah termasuk peminjaman bola resmi, rompi tanding, dan scoreboard digital.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8 items-stretch">
                    
                    {{-- Slot Siang --}}
                    <div class="rounded-3xl bg-[#0f1523] border border-slate-800 p-6 sm:p-8 flex flex-col justify-between hover:border-slate-700 transition-all">
                        <div>
                            <span class="text-[11px] font-black uppercase tracking-widest text-slate-400">Regular Hours</span>
                            <h3 class="text-xl font-black uppercase text-white mt-1 mb-4">Slot Siang</h3>
                            
                            <div class="flex items-baseline gap-1 mb-6">
                                <span class="text-3xl sm:text-4xl font-black text-white">Rp 120.000</span>
                                <span class="text-xs text-slate-400 font-bold uppercase">/ Jam</span>
                            </div>
                            
                            <p class="text-xs text-slate-400 pb-6 border-b border-slate-800">
                                Berlaku Senin – Minggu pada jam operasional reguler siang hari (08.00 – 16.00 WIB).
                            </p>

                            <ul class="space-y-3 py-6 text-xs text-slate-300 font-semibold">
                                <li class="flex items-center gap-3"><i class="fa fa-check text-emerald-400"></i> Free 1 Set Rompi Latihan</li>
                                <li class="flex items-center gap-3"><i class="fa fa-check text-emerald-400"></i> Peminjaman 2 Bola Futsal Pro</li>
                                <li class="flex items-center gap-3"><i class="fa fa-check text-emerald-400"></i> Akses Kamar Mandi & Loker</li>
                                <li class="flex items-center gap-3 text-slate-500"><i class="fa fa-times"></i> Tanpa Operator Scoreboard</li>
                            </ul>
                        </div>

                        <a href="#lapangan" class="btn-action w-full py-3.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-black text-xs uppercase tracking-wider">
                            Pilih Slot Siang
                        </a>
                    </div>

                    {{-- Prime Time --}}
                    <div class="rounded-3xl bg-gradient-to-b from-[#141b2c] via-[#0f1523] to-red-950/40 border-2 border-red-600 p-6 sm:p-8 flex flex-col justify-between relative shadow-2xl shadow-red-600/15">
                        <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-red-600 text-white font-black text-[10px] uppercase tracking-widest px-4 py-1 rounded-full shadow-md whitespace-nowrap">
                            MOST POPULAR &bull; PRIME TIME
                        </div>

                        <div>
                            <span class="text-[11px] font-black uppercase tracking-widest text-red-400">Night Match</span>
                            <h3 class="text-xl font-black uppercase text-white mt-1 mb-4">Slot Malam & Weekend</h3>
                            
                            <div class="flex items-baseline gap-1 mb-6">
                                <span class="text-3xl sm:text-4xl font-black text-white">Rp 175.000</span>
                                <span class="text-xs text-slate-400 font-bold uppercase">/ Jam</span>
                            </div>
                            
                            <p class="text-xs text-slate-400 pb-6 border-b border-slate-800">
                                Waktu terbaik mabar malam hari (16.00 – 22.00 WIB) dengan lighting LED penuh dan tensi kompetisi.
                            </p>

                            <ul class="space-y-3 py-6 text-xs text-slate-200 font-semibold">
                                <li class="flex items-center gap-3"><i class="fa fa-check text-red-500"></i> Pencahayaan Maksimal LED High-Lux</li>
                                <li class="flex items-center gap-3"><i class="fa fa-check text-red-500"></i> Free 2 Set Rompi Tim Lengkap</li>
                                <li class="flex items-center gap-3"><i class="fa fa-check text-red-500"></i> Operator Papan Skor Digital</li>
                                <li class="flex items-center gap-3"><i class="fa fa-check text-red-500"></i> Air Mineral Galon / Tim</li>
                            </ul>
                        </div>

                        <a href="#lapangan" class="btn-action w-full py-3.5 rounded-xl bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white font-black text-xs uppercase tracking-wider shadow-lg shadow-red-600/40">
                            Book Slot Malam Sekarang
                        </a>
                    </div>

                    {{-- Member Bulanan --}}
                    <div class="rounded-3xl bg-[#0f1523] border border-slate-800 p-6 sm:p-8 flex flex-col justify-between hover:border-slate-700 transition-all">
                        <div>
                            <span class="text-[11px] font-black uppercase tracking-widest text-slate-400">Community Squad</span>
                            <h3 class="text-xl font-black uppercase text-white mt-1 mb-4">Member Bulanan</h3>
                            
                            <div class="flex items-baseline gap-1 mb-6">
                                <span class="text-3xl sm:text-4xl font-black text-white">Rp 600.000</span>
                                <span class="text-xs text-slate-400 font-bold uppercase">/ 4 Pertemuan</span>
                            </div>
                            
                            <p class="text-xs text-slate-400 pb-6 border-b border-slate-800">
                                Solusi hemat untuk tim rutin yang ingin jaminan slot mingguan tetap tanpa takut diserobot lawan.
                            </p>

                            <ul class="space-y-3 py-6 text-xs text-slate-300 font-semibold">
                                <li class="flex items-center gap-3"><i class="fa fa-check text-emerald-400"></i> Kunci Jam Main Tetap per Minggu</li>
                                <li class="flex items-center gap-3"><i class="fa fa-check text-emerald-400"></i> Hemat s/d Rp 100.000 per Bulan</li>
                                <li class="flex items-center gap-3"><i class="fa fa-check text-emerald-400"></i> Prioritas Jadwal Turnamen</li>
                                <li class="flex items-center gap-3"><i class="fa fa-check text-emerald-400"></i> Fasilitas Rompi + Bola Eksklusif</li>
                            </ul>
                        </div>

                        <a href="https://wa.me/628996602425?text=Halo%20Admin%20Victory%20Arena,%20saya%20ingin%20daftar%20Member%20Bulanan%20Futsal" 
                           target="_blank" 
                           class="btn-action w-full py-3.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-black text-xs uppercase tracking-wider">
                            <i class="fab fa-whatsapp mr-2 text-sm"></i> Hubungi via WhatsApp
                        </a>
                    </div>

                </div>
            </div>
        </section>

        {{-- ================= HIGHLIGHT CARDS (CLEAN TANPA CTA) ================= --}}
        <section class="py-16 sm:py-20 border-b border-slate-800/80 bg-[#070b16]" id="fasilitas">
            <div class="max-w-7xl mx-auto px-5 sm:px-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    
                    {{-- Facility Spotlight --}}
                    <div class="lg:col-span-6 rounded-3xl bg-[#0f1523] border border-slate-800 p-6 sm:p-8 flex flex-col justify-between relative overflow-hidden group">
                        <div class="absolute top-0 left-0 bg-red-600 text-white text-[10px] sm:text-[11px] font-black uppercase tracking-wider px-3 sm:px-4 py-1 rounded-br-xl">
                            FACILITY SPOTLIGHT
                        </div>
                        <div class="pt-4">
                            <div class="rounded-2xl overflow-hidden mb-6 h-52 sm:h-56 border border-slate-800 bg-slate-950">
                                <img src="{{ asset('assets/lapangan1.jpg') }}" 
                                     alt="Venue Highlight" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                     onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=800&q=80';">
                            </div>
                            <h3 class="text-xl sm:text-2xl font-black uppercase text-white mb-2">Standar Lantai Vinyl Anti-Selip</h3>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                Dirancang khusus untuk meredam benturan sendi dan mempercepat akselerasi lari. Dilengkapi blower silang agar sirkulasi udara lapangan tetap sejuk saat tensi laga memanas.
                            </p>
                        </div>
                    </div>

                    {{-- Reservation Experience --}}
                    <div class="lg:col-span-6 rounded-3xl bg-[#0f1523] border border-slate-800 p-6 sm:p-8 flex flex-col justify-between relative overflow-hidden group">
                        <div class="absolute top-0 left-0 bg-red-600 text-white text-[10px] sm:text-[11px] font-black uppercase tracking-wider px-3 sm:px-4 py-1 rounded-br-xl">
                            RESERVATION EXPERIENCE
                        </div>
                        <div class="pt-4 flex flex-col sm:flex-row gap-6 items-center">
                            <div class="w-full sm:w-1/2 rounded-2xl overflow-hidden h-52 sm:h-56 border border-slate-800 bg-slate-950">
                                <img src="{{ asset('assets/lapangan2.jpg') }}" 
                                     alt="Match Management" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                     onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1529900241451-b8622e283128?w=800&q=80';">
                            </div>
                            <div class="w-full sm:w-1/2">
                                <p class="text-red-500 text-xs font-black uppercase tracking-widest mb-1">Instant Access</p>
                                <h3 class="text-xl sm:text-2xl font-black uppercase text-white mb-2">Papan Skor & Timer Digital</h3>
                                <p class="text-slate-400 text-xs leading-relaxed mb-4">
                                    Nikmati atmosfer turnamen resmi dengan operator scoreboard digital, ruang bilas higienis, dan tribun penonton.
                                </p>
                                <div class="flex items-center gap-2 text-xs font-semibold text-slate-300">
                                    <i class="fa fa-check text-red-500"></i> Wasit & Rompi Tersedia
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        {{-- ================= UPCOMING MATCH BANNER ================= --}}
        <section class="py-12 bg-gradient-to-r from-red-950/40 via-slate-900 to-slate-950 border-b border-slate-800/80">
            <div class="max-w-7xl mx-auto px-5 sm:px-6">
                <div class="rounded-3xl border border-red-600/30 bg-slate-950/70 p-6 md:p-8 flex flex-col lg:flex-row items-center justify-between gap-6 sm:gap-8 shadow-2xl relative overflow-hidden">
                    <div class="flex items-center gap-4 sm:gap-6">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-red-600/20 border border-red-500/40 text-red-500 flex items-center justify-center shrink-0">
                            <i class="fa fa-calendar-alt text-xl sm:text-2xl"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded bg-red-600 text-[10px] font-black uppercase tracking-wider text-white">NEXT SLOT</span>
                                <p class="text-[11px] sm:text-xs text-slate-400 uppercase tracking-wider">TODAY SCHEDULE</p>
                            </div>
                            <h3 class="text-xl sm:text-3xl font-black uppercase text-white mt-1">Pilih Jam & Langsung Kick-Off</h3>
                            <p class="text-xs sm:text-sm text-slate-400">08:00 - 22:00 WIB &bull; Grand Wisata Tambun Selatan</p>
                        </div>
                    </div>

                    <div class="flex items-center w-full lg:w-auto">
                        <a href="#lapangan" class="btn-action w-full lg:w-auto px-8 py-4 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white font-black text-xs sm:text-sm uppercase tracking-wider rounded-xl shadow-lg shadow-red-600/30">
                            Cek Ketersediaan Jam <i class="fa fa-chevron-right ml-2 text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        {{-- ================= BENEFIT / PILLARS ================= --}}
        <section class="py-12 sm:py-14 bg-slate-950 border-t border-b border-slate-800/80">
            <div class="max-w-7xl mx-auto px-5 sm:px-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                    <div class="flex items-center gap-4 p-4 rounded-2xl bg-slate-900/60 border border-slate-800">
                        <i class="fa fa-bolt text-red-500 text-2xl"></i>
                        <div>
                            <h4 class="font-extrabold text-sm uppercase text-white">Instant Booking</h4>
                            <p class="text-xs text-slate-400">Verifikasi langsung tanpa tunggu</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 p-4 rounded-2xl bg-slate-900/60 border border-slate-800">
                        <i class="fa-solid fa-shield-halved text-red-500 text-2xl"></i>
                        <div>
                            <h4 class="font-extrabold text-sm uppercase text-white">Anti Ganda</h4>
                            <p class="text-xs text-slate-400">Sistem slot sinkron real-time</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 p-4 rounded-2xl bg-slate-900/60 border border-slate-800">
                        <i class="fa fa-shower text-red-500 text-2xl"></i>
                        <div>
                            <h4 class="font-extrabold text-sm uppercase text-white">Clean Locker</h4>
                            <p class="text-xs text-slate-400">Kamar mandi & musholla higienis</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 p-4 rounded-2xl bg-slate-900/60 border border-slate-800">
                        <i class="fa fa-award text-red-500 text-2xl"></i>
                        <div>
                            <h4 class="font-extrabold text-sm uppercase text-white">Official Standard</h4>
                            <p class="text-xs text-slate-400">Ukuran turnamen bersertifikat</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- ================= FOOTER ================= --}}
    <footer class="bg-[#050811] border-t border-slate-800/80 pt-12 sm:pt-16 pb-8" id="kontak">
        <div class="max-w-7xl mx-auto px-5 sm:px-6">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 sm:gap-10 pb-10 sm:pb-12 border-b border-slate-800/80">
                
                <div class="md:col-span-5 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-full overflow-hidden bg-slate-900 border-2 border-red-600 shadow-md shadow-red-600/30 flex items-center justify-center p-0.5 shrink-0">
                            <img src="{{ asset('assets/logo-victory-arena.png') }}" 
                                 alt="Victory Arena Logo" 
                                 class="w-full h-full object-cover rounded-full"
                                 onerror="this.onerror=null; this.parentElement.innerHTML='<i class=\'fa-solid fa-futbol text-red-500 text-xl\'></i>';">
                        </div>
                        <div>
                            <span class="text-lg sm:text-xl font-black uppercase tracking-wider text-white">VICTORY <span class="text-red-500">ARENA</span></span>
                            <p class="text-[9px] sm:text-[10px] text-slate-400 font-bold uppercase tracking-widest leading-none">One Team, One Dream</p>
                        </div>
                    </div>
                    <p class="text-xs text-slate-400 max-w-sm leading-relaxed">
                        Pusat pelatihan dan arena futsal modern di Grand Wisata. Menyediakan fasilitas terbaik untuk mabar komunitas maupun turnamen profesional antar-klub.
                    </p>
                    <div class="flex items-center gap-3 pt-2">
                        <a href="#" class="btn-action w-9 h-9 rounded-full bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-400 hover:text-white hover:bg-red-600 transition-colors"><i class="fab fa-facebook-f text-xs"></i></a>
                        <a href="#" class="btn-action w-9 h-9 rounded-full bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-400 hover:text-white hover:bg-red-600 transition-colors"><i class="fab fa-instagram text-xs"></i></a>
                        <a href="#" class="btn-action w-9 h-9 rounded-full bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-400 hover:text-white hover:bg-red-600 transition-colors"><i class="fab fa-whatsapp text-xs"></i></a>
                        <a href="#" class="btn-action w-9 h-9 rounded-full bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-400 hover:text-white hover:bg-red-600 transition-colors"><i class="fab fa-youtube text-xs"></i></a>
                    </div>
                </div>

                <div class="md:col-span-3 space-y-3">
                    <h5 class="text-xs font-black uppercase tracking-widest text-white">Quick Links</h5>
                    <ul class="space-y-2 text-xs font-semibold text-slate-400">
                        <li><a href="#lapangan" class="hover:text-red-500 transition-colors">Booking Lapangan</a></li>
                        <li><a href="#harga" class="hover:text-red-500 transition-colors">Daftar Harga</a></li>
                        <li><a href="#fasilitas" class="hover:text-red-500 transition-colors">Spesifikasi Fasilitas</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-red-500 transition-colors">Masuk / Login Akun</a></li>
                    </ul>
                </div>

                <div class="md:col-span-4 space-y-3">
                    <h5 class="text-xs font-black uppercase tracking-widest text-white">Contact Us</h5>
                    <div class="space-y-2.5 text-xs text-slate-400">
                        <div class="flex items-start gap-2.5">
                            <i class="fa fa-map-marker-alt text-red-500 mt-0.5"></i>
                            <span>Grand Wisata – Tambun Selatan, Bekasi</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i class="fa fa-phone text-red-500"></i>
                            <span>0899-6602-425</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i class="fa fa-clock text-red-500"></i>
                            <span>Setiap Hari (08.00 – 22.00 WIB)</span>
                        </div>
                    </div>
                </div>

            </div>

            <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-[11px] text-slate-500 text-center sm:text-left">
                <p>&copy; {{ date('Y') }} Victory Arena Futsal. All Rights Reserved.</p>
                <div class="flex gap-4 sm:gap-6 justify-center">
                    <a href="#" class="hover:text-slate-400">Privacy Policy</a>
                    <a href="#" class="hover:text-slate-400">Terms of Use</a>
                    <a href="#" class="hover:text-slate-400">Rules & Regulations</a>
                </div>
            </div>
        </div>
    </footer>

</div>

{{-- ================= MODAL JADWAL ================= --}}
<div id="jadwalModal"
     class="fixed inset-0 bg-black/85 backdrop-blur-md hidden items-center justify-center z-50 transition-all p-4">

    <div class="bg-slate-900 border border-slate-800 rounded-3xl w-full max-w-2xl p-6 sm:p-8 shadow-2xl transform scale-95 transition-transform duration-200" id="modalContent">
        
        <div class="flex justify-between items-start mb-6 border-b border-slate-800 pb-4">
            <div>
                <span class="px-2.5 py-0.5 rounded bg-red-600 text-white font-black text-[10px] uppercase tracking-wider">LIVE SCHEDULE</span>
                <h3 class="font-black text-xl sm:text-2xl uppercase tracking-tight text-white mt-1">Jadwal Lapangan</h3>
                <p class="text-xs text-slate-400" id="modalSubtitle">Pilih slot waktu yang tersedia</p>
            </div>
            <button onclick="closeModal()" class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-slate-800 text-slate-400 hover:bg-red-600 hover:text-white transition-colors flex items-center justify-center">
                <i class="fa fa-times text-xs sm:text-sm"></i>
            </button>
        </div>

        <div class="mb-5">
            <label class="block text-xs uppercase font-extrabold tracking-wider text-slate-400 mb-2">Pilih Tanggal Main</label>
            <input type="date" id="jadwalTanggal"
                   class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white font-medium focus:ring-2 focus:ring-red-600 focus:border-red-600 outline-none transition-all text-xs sm:text-sm">
        </div>

        <div class="flex flex-wrap gap-4 mb-6 text-xs font-semibold text-slate-300">
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-emerald-500 shadow-sm shadow-emerald-500/50"></span> Tersedia
            </div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-amber-500 shadow-sm shadow-amber-500/50"></span> Pending
            </div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-red-600 shadow-sm shadow-red-600/50"></span> Terisi (Penuh)
            </div>
        </div>

        <div id="jadwalGrid"
             class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 sm:gap-3 max-h-[42vh] overflow-y-auto pr-2 custom-scrollbar">
        </div>

        <p class="text-[11px] text-slate-500 text-center mt-5">
            Klik pada jam yang bertanda hijau untuk langsung melanjutkan proses booking.
        </p>
    </div>
</div>

{{-- ================= SCRIPTS ================= --}}
<script>
function toggleMobileMenu() {
    const menu = document.getElementById('mobileMenu');
    const icon = document.getElementById('menuIcon');
    if (menu.classList.contains('hidden')) {
        menu.classList.remove('hidden');
        icon.classList.remove('fa-bars');
        icon.classList.add('fa-times');
    } else {
        menu.classList.add('hidden');
        icon.classList.remove('fa-times');
        icon.classList.add('fa-bars');
    }
}

let selectedLapangan = '';

function openJadwal(lapangan) {
    selectedLapangan = lapangan;
    document.getElementById('modalSubtitle').innerText = `Menampilkan jadwal aktif untuk: ${lapangan}`;
    const modal = document.getElementById('jadwalModal');
    const modalContent = document.getElementById('modalContent');
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(() => {
        modalContent.classList.remove('scale-95');
        modalContent.classList.add('scale-100');
    }, 10);

    document.getElementById('jadwalTanggal').valueAsDate = new Date();
    loadGrid();
}

function closeModal() {
    const modal = document.getElementById('jadwalModal');
    const modalContent = document.getElementById('modalContent');
    
    modalContent.classList.remove('scale-100');
    modalContent.classList.add('scale-95');
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 200);
}

document.getElementById('jadwalTanggal').addEventListener('change', loadGrid);

function loadGrid() {
    fetch(`{{ route('jadwal.grid') }}?lapangan=${selectedLapangan}&date=${jadwalTanggal.value}`)
        .then(res => res.json())
        .then(data => {
            const grid = document.getElementById('jadwalGrid');
            grid.innerHTML = '';

            data.hours.forEach(h => {
                let cls = 'bg-emerald-600 hover:bg-emerald-500 text-white shadow-md shadow-emerald-950/40 border border-emerald-500/40';
                let btnAttr = '';
                
                if (data.blocked.includes(h)) {
                    cls = 'bg-slate-800 text-slate-500 cursor-not-allowed border border-slate-750 opacity-60';
                    btnAttr = 'disabled';
                } else if (data.pending.includes(h)) {
                    cls = 'bg-amber-600 hover:bg-amber-500 text-white border border-amber-500/40 shadow-md shadow-amber-950/40';
                }

                grid.innerHTML += `
                    <button ${btnAttr}
                            class="btn-action px-3 py-3 rounded-xl font-bold text-xs transition-all ${cls}"
                            ${!btnAttr ? `onclick="confirmBooking('${h}:00','${h+1}:00')"` : ''}>
                        ${h}:00 - ${h+1}:00
                    </button>
                `;
            });
        })
        .catch(err => {
            console.error("Gagal mengambil jadwal:", err);
        });
}

function confirmBooking(start, end) {
    if (!confirm(`Konfirmasi Reservasi ${selectedLapangan}\nJam: ${start} - ${end}?`)) return;
    location.href = `/booking?field=${selectedLapangan}&start_time=${start}&end_time=${end}`;
}
</script>

@endsection