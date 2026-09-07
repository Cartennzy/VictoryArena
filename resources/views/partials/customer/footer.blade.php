{{-- ================= CUSTOMER SAAS FOOTER ================= --}}
<footer class="mt-auto border-t border-slate-800/80 bg-slate-950/80 backdrop-blur-xl py-6 px-6 sm:px-8 text-xs text-slate-500">
    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-2.5">
            <span class="w-2 h-2 rounded-full bg-red-600 animate-pulse"></span>
            <span class="font-black uppercase tracking-wider text-slate-400">Victory Arena Futsal System</span>
        </div>

        <p>© {{ date('Y') }} All Rights Reserved. Official Member Portal.</p>

        <div class="flex items-center gap-5 font-semibold text-slate-400">
            <a href="{{ route('landing') }}" class="hover:text-white transition-colors">Beranda</a>
            <a href="{{ route('customer.schedules.index') }}" class="hover:text-white transition-colors">Jadwal</a>
            <a href="{{ route('customer.profile') }}" class="hover:text-white transition-colors">Profil</a>
        </div>
    </div>
</footer>