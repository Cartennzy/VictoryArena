<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Tampilkan Halaman Login Tunggal (Admin & Customer)
     */
    public function showLogin()
    {
        // Jika sudah login sebelumnya, langsung arahkan sesuai rolenya
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        return view('auth.login');
    }

    /**
     * Proses Autentikasi Login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'Alamat email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Pastikan jika email admin@victory.com login, ia otomatis diperlakukan sebagai admin
            if (strtolower($user->email) === 'admin@victory.com' && $user->role !== 'admin') {
                $user->role = 'admin';
                $user->save();
            }

            return $this->redirectBasedOnRole($user);
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan tidak sesuai.',
        ])->onlyInput('email');
    }

    /**
     * Logout Universal
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing')->with('success', 'Anda telah berhasil keluar.');
    }

    /**
     * Redirect Berdasarkan Role
     */
    private function redirectBasedOnRole($user)
    {
        if (strtolower($user->email) === 'admin@victory.com' || $user->role === 'admin') {
            return redirect()->intended(route('dashboard'));
        }

        return redirect()->intended(route('customer.dashboard'));
    }
}