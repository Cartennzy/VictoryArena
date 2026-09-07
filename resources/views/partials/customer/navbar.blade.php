<header class="sticky top-0 z-30 bg-[#080d1a]/95 backdrop-blur-md border-b border-slate-800/80">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            
            {{-- Bagian Kiri: Tombol Hamburger (Hanya Tampil di Mobile) & Title --}}
            <div class="flex items-center gap-3">
                <button type="button" 
                        onclick="toggleCustomerSidebar()" 
                        class="md:hidden w-10 h-10 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-300 hover:text-white hover:border-red-600 transition-colors">
                    <i class="fa-solid fa-bars text-base"></i>
                </button>
                
                {{-- Logo hanya muncul di mobile karena desktop sudah ada di Sidebar --}}
                <div class="flex md:hidden items-center gap-2.5">
                    <div class="w-8 h-8 rounded-full overflow-hidden bg-slate-900 border border-red-600 p-0.5 shrink-0">
                        <img src="{{ asset('assets/logo-victory-arena.png') }}" alt="Victory Arena" class="w-full h-full object-cover rounded-full">
                    </div>
                    <span class="text-sm font-black uppercase text-white tracking-wide">VICTORY <span class="text-red-500">ARENA</span></span>
                </div>

                {{-- Indikator Portal Desktop --}}
                <div class="hidden md:flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400">
                    <span class="w-2 h-2 rounded-full bg-red-600"></span>
                    <span>Portal Reservasi Resmi</span>
                </div>
            </div>

            {{-- Bagian Kanan: Profil User Rapi & Logout --}}
            <div class="flex items-center gap-4">
                {{-- User Info Box --}}
                <div class="flex items-center gap-3">
                    <div class="text-right">
                        <p class="text-xs font-black text-white leading-tight uppercase tracking-wide truncate max-w-[160px]">
                            {{ Auth::user()->name ?? 'Member' }}
                        </p>
                        <span class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest block">
                            ACTIVE PLAYER
                        </span>
                    </div>

                    {{-- Avatar Bulat --}}
                    <div class="w-10 h-10 rounded-full bg-slate-900 border border-slate-750 flex items-center justify-center text-slate-300 text-sm font-bold shadow-inner">
                        <i class="fa-solid fa-user-shield text-slate-400"></i>
                    </div>
                </div>

                {{-- Tombol Logout --}}
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" 
                            class="btn-action px-4 py-2 rounded-xl bg-slate-900 border border-slate-750 text-slate-300 hover:text-white hover:bg-red-600 hover:border-red-600 text-xs font-bold tracking-wider uppercase transition-all duration-200">
                        <i class="fa-solid fa-arrow-right-from-bracket mr-1.5 text-xs"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>

        </div>
    </div>
</header>