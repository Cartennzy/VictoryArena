<aside id="customerSidebar" 
       class="fixed top-0 left-0 z-50 h-screen w-72 bg-slate-950/95 backdrop-blur-xl border-r border-slate-800 flex flex-col justify-between transition-transform duration-300 -translate-x-full md:translate-x-0">
    
    <div>
        {{-- Brand Logo Bulat --}}
        <div class="h-20 px-6 border-b border-slate-800/80 flex items-center justify-between">
            <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full overflow-hidden bg-slate-900 border-2 border-red-600 shadow-md shadow-red-600/30 flex items-center justify-center p-0.5 shrink-0">
                    <img src="{{ asset('assets/logo-victory-arena.png') }}" alt="Victory Arena" class="w-full h-full object-cover rounded-full">
                </div>
                <div>
                    <span class="text-base font-black uppercase tracking-wider text-white">VICTORY <span class="text-red-500">ARENA</span></span>
                    <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-widest leading-none">Member Dashboard</span>
                </div>
            </a>

            <button type="button" onclick="toggleCustomerSidebar()" class="md:hidden w-8 h-8 rounded-lg bg-slate-900 text-slate-400 hover:text-white flex items-center justify-center">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        {{-- Mini Profile Card --}}
        <a href="{{ route('customer.profile') }}" class="block p-4 mx-4 mt-5 rounded-2xl bg-slate-900/80 border border-slate-800/90 hover:border-red-600/50 transition-colors">
            <div class="flex items-center gap-3.5">
                @if(!empty(Auth::user()->avatar))
                    <img src="{{ asset('storage/'.Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="w-10 h-10 rounded-xl object-cover border border-red-500 shrink-0">
                @else
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-red-600 to-rose-500 text-white flex items-center justify-center font-bold text-sm shadow-md shadow-red-600/30 shrink-0">
                        {{ strtoupper(substr(Auth::user()->name ?? 'C', 0, 1)) }}
                    </div>
                @endif
                <div class="overflow-hidden">
                    <h4 class="text-xs font-black uppercase text-white truncate">{{ Auth::user()->name ?? 'Customer' }}</h4>
                    <div class="flex items-center gap-1.5 mt-0.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span class="text-[10px] text-emerald-400 font-semibold uppercase tracking-wider">Active Member</span>
                    </div>
                </div>
            </div>
        </a>

        {{-- Navigation Menu --}}
        <nav class="px-4 mt-6 space-y-1.5">
            <p class="px-3 text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Main Menu</p>

            <a href="{{ route('customer.dashboard') }}" 
               class="btn-action w-full px-3.5 py-3 rounded-xl text-xs font-bold uppercase tracking-wider transition-all {{ request()->routeIs('customer.dashboard') ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'text-slate-400 hover:text-white hover:bg-slate-900' }} !justify-start">
                <i class="fa-solid fa-chart-pie w-6 text-center text-sm mr-2 {{ request()->routeIs('customer.dashboard') ? 'text-white' : 'text-slate-400' }}"></i>
                Dashboard
            </a>

            <a href="{{ route('customer.booking') }}" 
               class="btn-action w-full px-3.5 py-3 rounded-xl text-xs font-bold uppercase tracking-wider transition-all {{ request()->routeIs('customer.booking*') ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'text-slate-400 hover:text-white hover:bg-slate-900' }} !justify-start">
                <i class="fa-solid fa-futbol w-6 text-center text-sm mr-2 {{ request()->routeIs('customer.booking*') ? 'text-white' : 'text-slate-400' }}"></i>
                Booking Lapangan
            </a>

            <a href="{{ route('customer.reservations.index') }}" 
               class="btn-action w-full px-3.5 py-3 rounded-xl text-xs font-bold uppercase tracking-wider transition-all {{ request()->routeIs('customer.reservations.*') ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'text-slate-400 hover:text-white hover:bg-slate-900' }} !justify-start">
                <i class="fa-solid fa-receipt w-6 text-center text-sm mr-2 {{ request()->routeIs('customer.reservations.*') ? 'text-white' : 'text-slate-400' }}"></i>
                Riwayat Booking
            </a>

            {{-- Link Kalender Jadwal --}}
            <a href="{{ route('customer.schedules.index') }}" 
               class="btn-action w-full px-3.5 py-3 rounded-xl text-xs font-bold uppercase tracking-wider transition-all {{ (request()->routeIs('customer.schedules.*') || request()->is('jadwal-grid')) ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'text-slate-400 hover:text-white hover:bg-slate-900' }} !justify-start">
                <i class="fa-solid fa-calendar-days w-6 text-center text-sm mr-2 {{ (request()->routeIs('customer.schedules.*') || request()->is('jadwal-grid')) ? 'text-white' : 'text-slate-400' }}"></i>
                Jadwal Tersedia
            </a>

            <a href="{{ route('customer.profile') }}" 
               class="btn-action w-full px-3.5 py-3 rounded-xl text-xs font-bold uppercase tracking-wider transition-all {{ request()->routeIs('customer.profile*') ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'text-slate-400 hover:text-white hover:bg-slate-900' }} !justify-start">
                <i class="fa-solid fa-id-card w-6 text-center text-sm mr-2 {{ request()->routeIs('customer.profile*') ? 'text-white' : 'text-slate-400' }}"></i>
                Profil Member
            </a>
        </nav>
    </div>

    {{-- Logout --}}
    <div class="p-4 border-t border-slate-800/80 bg-slate-950">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-action w-full py-3 rounded-xl bg-red-600/15 border border-red-600/40 text-red-400 hover:bg-red-600 hover:text-white font-bold text-xs uppercase tracking-wider transition-all">
                <i class="fa-solid fa-arrow-right-from-bracket mr-2"></i> Keluar / Logout
            </button>
        </form>
    </div>

</aside>

<div id="sidebarBackdrop" onclick="toggleCustomerSidebar()" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-40 hidden md:hidden"></div>

<script>
    function toggleCustomerSidebar() {
        const sidebar = document.getElementById('customerSidebar');
        const backdrop = document.getElementById('sidebarBackdrop');
        if (sidebar.classList.contains('-translate-x-full')) {
            sidebar.classList.remove('-translate-x-full');
            backdrop.classList.remove('hidden');
        } else {
            sidebar.classList.add('-translate-x-full');
            backdrop.classList.add('hidden');
        }
    }
</script>