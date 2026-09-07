<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckCustomerData
{
    /**
     * Cek apakah customer sudah isi data
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (empty($user->phone)) {
            return redirect()
                ->route('customer.customer.form')
                ->with('warning', 'Silakan isi data diri terlebih dahulu sebelum booking.');
        }

        return $next($request);
    }
}