<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CustomerProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('customer.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name'      => 'required|string|max:255',
            'phone'     => 'required|string|min:9|max:20',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'team_name' => 'nullable|string|max:100',
            'address'   => 'nullable|string|max:255',
            'avatar'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ], [
            'name.required'  => 'Nama lengkap tidak boleh kosong.',
            'phone.required' => 'Nomor WhatsApp wajib diisi.',
            'email.unique'   => 'Email ini sudah digunakan oleh akun lain.',
            'avatar.max'     => 'Ukuran foto maksimal adalah 2MB.'
        ]);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->name  = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;

        if (Schema::hasColumn('users', 'team_name')) {
            $user->team_name = $request->team_name;
        }
        if (Schema::hasColumn('users', 'address')) {
            $user->address = $request->address;
        }

        $user->save();

        return redirect()->route('customer.profile')->with('success', 'Data profil & tim berhasil disimpan!');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:6|confirmed'
        ], [
            'current_password.required' => 'Password saat ini harus diisi.',
            'new_password.min'          => 'Password baru minimal 6 karakter.',
            'new_password.confirmed'    => 'Konfirmasi password baru tidak cocok.'
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('customer.profile')->with('success', 'Kata sandi akun berhasil diperbarui!');
    }
}