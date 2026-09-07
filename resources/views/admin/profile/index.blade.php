@extends('layouts.admin')

@section('title', 'Profil & Keamanan Admin | Victory Arena')

@section('content')

{{-- ================= ULTRA-CLEAN SAAS STYLES ================= --}}
<style>
    .clean-panel {
        background: rgba(13, 20, 36, 0.85);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 26px;
        box-shadow: 0 20px 45px -15px rgba(0, 0, 0, 0.7);
        transition: border-color 0.25s ease;
    }
    .clean-panel:hover {
        border-color: rgba(255, 255, 255, 0.14);
    }

    .clean-input {
        width: 100%;
        height: 50px;
        background: rgba(8, 13, 26, 0.85);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 14px;
        padding: 0 16px 0 46px;
        color: #ffffff;
        font-weight: 600;
        font-size: 0.92rem;
        outline: none;
        transition: all 0.2s ease;
    }
    .clean-input:focus {
        background: rgba(10, 16, 30, 0.98);
        border-color: #ef4444;
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.2);
    }

    /* Primary SaaS Button with Push-Down State & Ripple */
    .btn-action-primary {
        position: relative;
        overflow: hidden;
        height: 50px;
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
        cursor: pointer;
        user-select: none;
    }
    .btn-action-primary:hover {
        transform: translateY(-2px);
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        box-shadow: 0 14px 28px -5px rgba(220, 38, 38, 0.7);
    }
    .btn-action-primary:active {
        transform: translateY(2px) scale(0.98) !important;
        box-shadow: 0 4px 8px rgba(220, 38, 38, 0.3) !important;
    }

    .tab-pill {
        padding: 10px 20px;
        border-radius: 14px;
        font-size: 0.82rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #94a3b8;
        border: 1px solid transparent;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .tab-pill.active {
        background: rgba(239, 68, 68, 0.15);
        border-color: rgba(239, 68, 68, 0.4);
        color: #ef4444;
        box-shadow: 0 4px 16px -2px rgba(220, 38, 38, 0.25);
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

<div class="max-w-4xl mx-auto py-4 space-y-6 text-slate-100 font-sans">

    {{-- Top Header --}}
    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 pb-4 border-b border-slate-800">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-0.5 rounded-full bg-red-950/60 border border-red-800/60 text-red-400 text-[10px] font-black tracking-widest uppercase mb-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                Admin Command Security
            </div>
            <h1 class="text-2xl sm:text-3xl font-black uppercase tracking-tight text-white">Profil & Keamanan Admin</h1>
            <p class="text-xs text-slate-400 mt-0.5">Kelola kredensial akun master administrator dan keamanan akses command center.</p>
        </div>

        <a href="{{ route('dashboard') }}" 
           class="btn-action self-start sm:self-auto px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-slate-300 hover:text-white border border-slate-750 text-xs font-bold uppercase tracking-wider">
            <i class="fa-solid fa-chart-pie mr-1.5 text-red-500"></i> Dashboard
        </a>
    </div>

    {{-- Feedback Notifications --}}
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-bold flex items-center gap-2.5 shadow-lg shadow-emerald-950/30">
            <i class="fa-solid fa-circle-check text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 rounded-2xl bg-red-500/10 border border-red-500/30 text-red-400 text-xs font-bold flex items-start gap-2.5 shadow-lg shadow-red-950/30">
            <i class="fa-solid fa-circle-exclamation text-base mt-0.5 shrink-0"></i>
            <div>
                <span class="block uppercase tracking-wide font-black mb-0.5">Gagal Menyimpan:</span>
                <ul class="list-disc list-inside space-y-0.5 font-semibold text-[11px]">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- Tab Switches --}}
    <div class="flex items-center gap-2 p-1.5 rounded-2xl bg-slate-900/80 border border-slate-800 w-fit">
        <button type="button" onclick="switchAdminTab('tab-admin-info', this)" class="tab-pill active">
            <i class="fa-solid fa-user-shield mr-1.5"></i> Identitas Admin
        </button>
        <button type="button" onclick="switchAdminTab('tab-admin-pass', this)" class="tab-pill">
            <i class="fa-solid fa-lock mr-1.5"></i> Ubah Password
        </button>
    </div>

    {{-- TAB 1: IDENTITAS ADMIN --}}
    <div id="tab-admin-info" class="clean-panel p-6 sm:p-8 space-y-6">
        <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
            @csrf

            <div class="p-4 rounded-2xl bg-slate-900/60 border border-slate-800 flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-red-600/20 border border-red-500/40 text-red-500 flex items-center justify-center font-black text-xl shrink-0 shadow-md">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <div>
                    <h3 class="text-sm font-black uppercase text-white">{{ $user->name }}</h3>
                    <span class="text-[10px] font-bold text-red-400 uppercase tracking-widest">Master Administrator Account</span>
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-300 mb-2">Nama Administrator <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fa-solid fa-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-sm"></i>
                        <input type="text" name="name" class="clean-input" value="{{ old('name', $user->name) }}" required>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-300 mb-2">Alamat Email Master <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fa-solid fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-sm"></i>
                        <input type="email" name="email" class="clean-input" value="{{ old('email', $user->email) }}" required>
                    </div>
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="btn-action-primary w-full sm:w-auto px-8">
                    <span>Simpan Perubahan</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </div>
        </form>
    </div>

    {{-- TAB 2: UBAH PASSWORD --}}
    <div id="tab-admin-pass" class="clean-panel p-6 sm:p-8 space-y-6 hidden">
        <div class="pb-4 mb-2 border-b border-slate-800">
            <h3 class="text-base font-black uppercase text-white">Keamanan & Sandi Admin</h3>
            <p class="text-xs text-slate-400 mt-0.5">Pastikan menggunakan kombinasi sandi yang kuat untuk melindungi sistem command center.</p>
        </div>

        <form method="POST" action="{{ route('customer.profile.password') }}" class="space-y-5 max-w-xl">
            @csrf

            <div>
                <label class="block text-xs font-black uppercase tracking-wider text-slate-300 mb-2">Kata Sandi Saat Ini</label>
                <div class="relative">
                    <i class="fa-solid fa-key absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-sm"></i>
                    <input type="password" name="current_password" class="clean-input" placeholder="••••••••" required>
                </div>
            </div>

            <div>
                <label class="block text-xs font-black uppercase tracking-wider text-slate-300 mb-2">Kata Sandi Baru</label>
                <div class="relative">
                    <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-sm"></i>
                    <input type="password" name="new_password" class="clean-input" placeholder="Minimal 6 karakter" required>
                </div>
            </div>

            <div>
                <label class="block text-xs font-black uppercase tracking-wider text-slate-300 mb-2">Konfirmasi Kata Sandi Baru</label>
                <div class="relative">
                    <i class="fa-solid fa-check-double absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-sm"></i>
                    <input type="password" name="new_password_confirmation" class="clean-input" placeholder="Ulangi password baru" required>
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="btn-action-primary w-full sm:w-auto px-8">
                    <span>Perbarui Kata Sandi</span>
                    <i class="fa-solid fa-shield text-xs"></i>
                </button>
            </div>
        </form>
    </div>

</div>

{{-- Scripts: Tab Switcher & Ripple Effect --}}
<script>
function switchAdminTab(tabId, btn) {
    document.getElementById('tab-admin-info').classList.add('hidden');
    document.getElementById('tab-admin-pass').classList.add('hidden');

    document.querySelectorAll('.tab-pill').forEach(el => el.classList.remove('active'));
    document.getElementById(tabId).classList.remove('hidden');
    btn.classList.add('active');
}

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
    setTimeout(() => ripple.remove(), 650);
});
</script>

@endsection