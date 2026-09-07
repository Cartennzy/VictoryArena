{{-- ================= ADMIN SAAS SIDEBAR ================= --}}
<aside id="adminSidebar" 
       class="fixed top-0 left-0 z-50 h-screen w-72 bg-slate-950/95 backdrop-blur-xl border-r border-slate-800 flex flex-col justify-between transition-transform duration-300 -translate-x-full md:translate-x-0">
    
    <div>
        {{-- Brand Logo Bulat --}}
        <div class="h-20 px-6 border-b border-slate-800/80 flex items-center justify-between">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full overflow-hidden bg-slate-900 border-2 border-red-600 shadow-md shadow-red-600/30 flex items-center justify-center p-0.5 shrink-0">
                    <img src="{{ asset('assets/logo-victory-arena.png') }}" 
                         alt="Victory Arena" 
                         class="w-full h-full object-cover rounded-full">
                </div>
                <div>
                    <span class="text-base font-black uppercase tracking-wider text-white">VICTORY <span class="text-red-500">ARENA</span></span>
                    <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-widest leading-none">Admin Command Center</span>
                </div>
            </a>

            {{-- Mobile Close Button --}}
            <button type="button" 
                    onclick="toggleAdminSidebar()" 
                    class="md:hidden w-8 h-8 rounded-lg bg-slate-900 text-slate-400 hover:text-white flex items-center justify-center">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        {{-- Mini Admin Profile Card --}}
        <div class="p-4 mx-4 mt-5 rounded-2xl bg-slate-900/80 border border-slate-800/90">
            <div class="flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-red-600 to-rose-600 text-white flex items-center justify-center font-black text-sm shadow-md shadow-red-600/30 shrink-0">
                    <i class="fa-solid fa-shield-halved text-xs"></i>
                </div>
                <div class="overflow-hidden">
                    <h4 class="text-xs font-black uppercase text-white truncate">{{ Auth::user()->name ?? 'Administrator' }}</h4>
                    <div class="flex items-center gap-1.5 mt-0.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                        <span class="text-[10px] text-red-400 font-semibold uppercase tracking-wider">Super Administrator</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Navigation Menu Items --}}
        <nav class="px-4 mt-6 space-y-1.5">
            <p class="px-3 text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Navigation System</p>

            {{-- 1. Dashboard Utama --}}
            <a href="{{ route('dashboard') }}" 
               class="btn-action w-full px-3.5 py-3 rounded-xl text-xs font-bold uppercase tracking-wider transition-all {{ request()->routeIs('dashboard') ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'text-slate-400 hover:text-white hover:bg-slate-900' }} !justify-start">
                <i class="fa-solid fa-chart-pie w-6 text-center text-sm mr-2 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-slate-400' }}"></i>
                Dashboard
            </a>

            {{-- 2. Kelola Reservasi Lapangan --}}
            <a href="{{ route('reservations.index') }}" 
               class="btn-action w-full px-3.5 py-3 rounded-xl text-xs font-bold uppercase tracking-wider transition-all {{ request()->routeIs('reservations.*') ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'text-slate-400 hover:text-white hover:bg-slate-900' }} !justify-start">
                <i class="fa-solid fa-calendar-check w-6 text-center text-sm mr-2 {{ request()->routeIs('reservations.*') ? 'text-white' : 'text-slate-400' }}"></i>
                Kelola Booking
            </a>

            {{-- 3. Data Customer / Pemain --}}
            <a href="{{ route('customers.index') }}" 
               class="btn-action w-full px-3.5 py-3 rounded-xl text-xs font-bold uppercase tracking-wider transition-all {{ request()->routeIs('customers.*') ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'text-slate-400 hover:text-white hover:bg-slate-900' }} !justify-start">
                <i class="fa-solid fa-users w-6 text-center text-sm mr-2 {{ request()->routeIs('customers.*') ? 'text-white' : 'text-slate-400' }}"></i>
                Data Customer
            </a>

            {{-- 4. Laporan Keuangan & Rekap Transaksi --}}
            <a href="{{ route('laporan.index') }}" 
               class="btn-action w-full px-3.5 py-3 rounded-xl text-xs font-bold uppercase tracking-wider transition-all {{ request()->routeIs('laporan.*') ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'text-slate-400 hover:text-white hover:bg-slate-900' }} !justify-start">
                <i class="fa-solid fa-file-invoice-dollar w-6 text-center text-sm mr-2 {{ request()->routeIs('laporan.*') ? 'text-white' : 'text-slate-400' }}"></i>
                Laporan Keuangan
            </a>

            {{-- 5. Profil Akun Admin --}}
            <a href="{{ route('profile.edit') }}" 
               class="btn-action w-full px-3.5 py-3 rounded-xl text-xs font-bold uppercase tracking-wider transition-all {{ request()->routeIs('profile.*') ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'text-slate-400 hover:text-white hover:bg-slate-900' }} !justify-start">
                <i class="fa-solid fa-gear w-6 text-center text-sm mr-2 {{ request()->routeIs('profile.*') ? 'text-white' : 'text-slate-400' }}"></i>
                Profil & Keamanan
            </a>
        </nav>
    </div>

    {{-- Bottom Section / Logout Action --}}
    <div class="p-4 border-t border-slate-800/80 bg-slate-950">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" 
                    class="btn-action w-full py-3 rounded-xl bg-red-600/15 border border-red-600/40 text-red-400 hover:bg-red-600 hover:text-white font-bold text-xs uppercase tracking-wider transition-all">
                <i class="fa-solid fa-arrow-right-from-bracket mr-2"></i> Keluar Sistem
            </button>
        </form>
    </div>

</aside>

{{-- Mobile Backdrop Blur --}}
<div id="adminSidebarBackdrop" 
     onclick="toggleAdminSidebar()" 
     class="fixed inset-0 bg-black/75 backdrop-blur-sm z-40 hidden md:hidden"></div>

<script>
    function toggleAdminSidebar() {
        const sidebar = document.getElementById('adminSidebar');
        const backdrop = document.getElementById('adminSidebarBackdrop');
        if (sidebar.classList.contains('-translate-x-full')) {
            sidebar.classList.remove('-translate-x-full');
            backdrop.classList.remove('hidden');
        } else {
            sidebar.classList.add('-translate-x-full');
            backdrop.classList.add('hidden');
        }
    }
</script>