<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CustomerDataController extends Controller
{
    /**
     * Tampilkan form data customer
     */
    public function create()
    {
        $user = Auth::user();
        return view('customer.customer-data', compact('user'));
    }

    /**
     * Simpan data customer langsung ke user yang login
     */
    public function store(Request $request)
    {
        $request->validate([
            'phone'     => 'required|string|max:20',
            'team_name' => 'nullable|string|max:100',
            'address'   => 'nullable|string|max:255',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->phone = $request->phone;

        // Simpan jika kolom tersedia di tabel users
        if (\Schema::hasColumn('users', 'team_name')) {
            $user->team_name = $request->team_name;
        }
        if (\Schema::hasColumn('users', 'address')) {
            $user->address = $request->address;
        }

        $user->save();

        return redirect()->route('customer.booking')->with('success', 'Data profil tim berhasil disimpan!');
    }
}