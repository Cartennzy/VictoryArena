<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerAuthController extends Controller
{
    public function showRegister()
    {
        // Path disinkronkan dengan folder: resources/views/auth/customer/register.blade.php
        return view('auth.customer.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'customer',
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil');
    }

    public function showLogin()
    {
        // Path disinkronkan dengan folder: resources/views/auth/customer/login.blade.php
        return view('auth.customer.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return back()->withErrors(['email' => 'Login gagal']);
        }

        if (Auth::user()->role !== 'customer') {
            Auth::logout();
            return back()->withErrors(['email' => 'Akun ini bukan customer']);
        }

        // 🔥 FIX UTAMA: MASUK DASHBOARD
        return redirect()->route('customer.dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}