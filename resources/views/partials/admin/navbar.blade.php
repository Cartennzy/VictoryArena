{{-- ================= ADMIN SAAS TOP NAVBAR ================= --}}
<header class="sticky top-0 z-30 h-20 border-b border-slate-800/80 bg-slate-950/80 backdrop-blur-xl px-4 sm:px-8 flex items-center justify-between">
    
    {{-- Left Section: Hamburger & Status Badge --}}
    <div class="flex items-center gap-4">
        {{-- Mobile Hamburger Trigger --}}
        <button type="button" 
                onclick="toggleAdminSidebar()" 
                class="md:hidden w-10 h-10 rounded-xl bg-slate-900 border border-slate-800 text-slate-300 hover:text-white flex items-center justify-center">
            <i class="fa-solid fa-bars text-base"></i>
        </button>

        <div class="hidden sm:flex items-center gap-2.5 px-3 py-1.5 rounded-full bg-slate-900/80 border border-slate-800">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
            <span class="text-[11px] font-black uppercase tracking-wider text-slate-300">Live Operating Center</span>
        </div>
    </div>

    {{-- Right Section: Live Time & Admin Action Dropdown --}}
    <div class="flex items-center gap-4">
        
        {{-- Jam Live WIB --}}
        <div class="hidden md:flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-slate-900 border border-slate-800 text-xs font-mono font-bold text-slate-300">
            <i class="fa-regular fa-clock text-red-500"></i>
            <span id="adminLiveClock">00:00:00 WIB</span>
        </div>

        {{-- Quick Link ke Beranda Publik --}}
        <a href="{{ route('landing') }}" 
           target="_blank" 
           title="Buka Halaman Publik" 
           class="btn-action w-10 h-10 rounded-xl bg-slate-900 hover:bg-slate-850 border border-slate-800 text-slate-400 hover:text-white transition-colors">
            <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
        </a>

        {{-- Profile Mini Capsule --}}
        <div class="flex items-center gap-3 pl-3 border-l border-slate-800">
            <div class="text-right hidden sm:block">
                <p class="text-xs font-black uppercase text-white leading-tight truncate max-w-[140px]">
                    {{ Auth::user()->name ?? 'Administrator' }}
                </p>
                <span class="text-[10px] text-red-400 font-bold uppercase tracking-wider leading-none">
                    Master Admin
                </span>
            </div>

            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-red-600 to-rose-600 text-white flex items-center justify-center font-black text-sm shadow-md shadow-red-600/30 shrink-0">
                <i class="fa-solid fa-user-shield text-xs"></i>
            </div>
        </div>

    </div>

</header>

<script>
    function updateAdminClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const clockEl = document.getElementById('adminLiveClock');
        if (clockEl) {
            clockEl.innerText = `${hours}:${minutes}:${seconds} WIB`;
        }
    }
    setInterval(updateAdminClock, 1000);
    updateAdminClock();
</script>