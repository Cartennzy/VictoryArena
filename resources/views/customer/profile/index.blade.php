@extends('layouts.customer')

@section('title', 'Profil Akun Member | Victory Arena')

@section('content')

<style>
    .clean-card {
        background: rgba(13, 20, 36, 0.9);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 24px;
        box-shadow: 0 20px 45px -12px rgba(0, 0, 0, 0.7);
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

    .btn-action-primary {
        position: relative;
        overflow: hidden;
        height: 52px;
        border-radius: 14px;
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #ffffff;
        font-weight: 800;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        box-shadow: 0 12px 26px -6px rgba(220, 38, 38, 0.55);
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        user-select: none;
    }
    .btn-action-primary:hover {
        transform: translateY(-2px);
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        box-shadow: 0 16px 32px -6px rgba(220, 38, 38, 0.7);
    }
    .btn-action-primary:active {
        transform: translateY(2px) scale(0.98) !important;
        box-shadow: 0 4px 10px rgba(220, 38, 38, 0.3) !important;
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

<div class="max-w-5xl mx-auto py-6 space-y-6 text-slate-100 font-sans">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 pb-4 border-b border-slate-800">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-0.5 rounded-full bg-red-950/60 border border-red-800/60 text-red-400 text-[10px] font-black tracking-widest uppercase mb-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                Member Hub
            </div>
            <h1 class="text-2xl sm:text-3xl font-black uppercase tracking-tight text-white">Profil Pengguna</h1>
            <p class="text-xs text-slate-400 mt-0.5">Kelola informasi kontak pemain, foto avatar tim, dan pengaturan kata sandi.</p>
        </div>

        <a href="{{ route('customer.reservations.index') }}" 
           class="btn-action self-start sm:self-auto px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-slate-300 hover:text-white border border-slate-750 text-xs font-bold uppercase tracking-wider">
            <i class="fa-solid fa-receipt mr-1.5 text-red-500"></i> Riwayat Reservasi
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
        <button type="button" onclick="switchProfileTab('tab-biodata', this)" class="tab-pill active">
            <i class="fa-solid fa-user mr-1.5"></i> Identitas & Tim
        </button>
        <button type="button" onclick="switchProfileTab('tab-security', this)" class="tab-pill">
            <i class="fa-solid fa-lock mr-1.5"></i> Kata Sandi
        </button>
    </div>

    {{-- TAB 1: BIODATA & AVATAR --}}
    <div id="tab-biodata" class="clean-card p-6 sm:p-8 space-y-6">
        <form method="POST" action="{{ route('customer.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="p-5 rounded-2xl bg-slate-900/60 border border-slate-800 flex flex-col sm:flex-row items-center gap-5">
                <div class="relative group cursor-pointer shrink-0" onclick="document.getElementById('avatarInput').click()">
                    <div class="w-20 h-20 rounded-2xl overflow-hidden border-2 border-red-600 bg-slate-950 flex items-center justify-center shadow-lg shadow-red-600/30">
                        <img id="avatarPreview" 
                             src="{{ !empty($user->avatar) ? asset('storage/'.$user->avatar) : '' }}" 
                             alt="{{ $user->name }}" 
                             class="w-full h-full object-cover {{ empty($user->avatar) ? 'hidden' : '' }}">
                        
                        <div id="avatarFallback" class="w-full h-full bg-gradient-to-tr from-red-600 to-rose-500 text-white font-black text-2xl flex items-center justify-center {{ !empty($user->avatar) ? 'hidden' : '' }}">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    </div>
                    <div class="absolute inset-0 bg-black/60 rounded-2xl opacity-0 group-hover:opacity-100 flex flex-col items-center justify-center text-white transition-opacity">
                        <i class="fa-solid fa-camera text-sm"></i>
                        <span class="text-[8px] font-bold uppercase mt-0.5">Ubah</span>
                    </div>
                </div>

                <input type="file" id="avatarInput" name="avatar" accept="image/*" class="hidden" onchange="previewImage(event)">

                <div class="text-center sm:text-left flex-grow">
                    <h3 class="text-sm font-black uppercase text-white">{{ $user->name }}</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Pilih foto dari komputer untuk memperbarui avatar (PNG, JPG, maks 2MB).</p>
                    <button type="button" onclick="document.getElementById('avatarInput').click()" class="mt-2 px-3.5 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-700 text-[11px] font-bold uppercase tracking-wider transition-colors inline-flex items-center gap-1.5">
                        <i class="fa-solid fa-upload"></i> Unggah Gambar
                    </button>
                </div>

                <div class="hidden sm:block text-right">
                    <span class="px-3 py-1 rounded-full bg-emerald-500/15 border border-emerald-500/30 text-emerald-400 text-[10px] font-black uppercase">
                        Active Player
                    </span>
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-300 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fa-solid fa-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-sm"></i>
                        <input type="text" name="name" class="clean-input" value="{{ old('name', $user->name) }}" required>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-300 mb-2">Nomor WhatsApp <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fa-brands fa-whatsapp absolute left-4 top-1/2 -translate-y-1/2 text-emerald-400 text-base"></i>
                        <input type="tel" name="phone" class="clean-input" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 081234567890" required>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-300 mb-2">Alamat Email <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fa-solid fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-sm"></i>
                        <input type="email" name="email" class="clean-input" value="{{ old('email', $user->email) }}" required>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-300 mb-2">Nama Tim / Komunitas</label>
                    <div class="relative">
                        <i class="fa-solid fa-shield-halved absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-sm"></i>
                        <input type="text" name="team_name" class="clean-input" value="{{ old('team_name', $user->team_name ?? '') }}" placeholder="Contoh: Garuda FC">
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-black uppercase tracking-wider text-slate-300 mb-2">Domisili / Kota</label>
                <div class="relative">
                    <i class="fa-solid fa-location-dot absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-sm"></i>
                    <input type="text" name="address" class="clean-input" value="{{ old('address', $user->address ?? '') }}" placeholder="Contoh: Tambun Selatan, Bekasi">
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="btn-action-primary w-full sm:w-auto px-8">
                    <span>Simpan Perubahan Data</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </div>
        </form>
    </div>

    {{-- TAB 2: KEAMANAN KATA SANDI --}}
    <div id="tab-security" class="clean-card p-6 sm:p-8 space-y-6 hidden">
        <div class="pb-4 mb-2 border-b border-slate-800">
            <h3 class="text-base font-black uppercase text-white">Ganti Kata Sandi Akun</h3>
            <p class="text-xs text-slate-400 mt-0.5">Gunakan kombinasi minimal 6 karakter demi menjaga keamanan akun reservasi Anda.</p>
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

<script>
function switchProfileTab(tabId, btn) {
    document.getElementById('tab-biodata').classList.add('hidden');
    document.getElementById('tab-security').classList.add('hidden');

    document.querySelectorAll('.tab-pill').forEach(el => el.classList.remove('active'));
    document.getElementById(tabId).classList.remove('hidden');
    btn.classList.add('active');
}

function previewImage(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('avatarPreview');
            const fallback = document.getElementById('avatarFallback');
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            if (fallback) fallback.classList.add('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
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