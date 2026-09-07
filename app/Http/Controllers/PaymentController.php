<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class PaymentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN PEMBAYARAN
    |--------------------------------------------------------------------------
    */
    public function payReservation($id)
    {
        $reservation = Reservation::findOrFail($id);

        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = false; // SANDBOX
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $orderId = 'RES-' . $reservation->id . '-' . time();

        // Simpan payment record
        $payment = Payment::create([
            'reservation_id' => $reservation->id,
            'order_id'       => $orderId,
            'amount'         => $reservation->total_price,
            'status'         => 'pending',
        ]);

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => $reservation->total_price,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email'      => Auth::user()->email,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        // 🔥 FIX SINKRONISASI KE resources/views/customer/payments/pay.blade.php
        return view('customer.payments.pay', compact('snapToken', 'reservation', 'orderId'));
    }

    /*
    |--------------------------------------------------------------------------
    | CALLBACK MIDTRANS
    |--------------------------------------------------------------------------
    */
    public function callback(Request $request)
    {
        $notif = new Notification();

        $payment = Payment::where('order_id', $notif->order_id)->first();

        if (!$payment) {
            return response()->json(['message' => 'Payment not found'], 404);
        }

        // SUCCESS
        if ($notif->transaction_status === 'settlement') {

            $payment->update([
                'status'       => 'paid',
                'payment_type' => $notif->payment_type,
                'paid_at'      => now(),
            ]);

            $payment->reservation->update([
                'payment_status' => 'paid',      // 🔥 FIXED
                'status'         => 'approved',
            ]);
        }

        // EXPIRED
        if ($notif->transaction_status === 'expire') {

            $payment->update([
                'status' => 'expired'
            ]);

            $payment->reservation->update([
                'payment_status' => 'expired',
                'status'         => 'expired',
            ]);
        }

        // CANCEL
        if ($notif->transaction_status === 'cancel') {

            $payment->update([
                'status' => 'failed'
            ]);
        }

        return response()->json(['success' => true]);
    }

    /*
    |--------------------------------------------------------------------------
    | HALAMAN SUCCESS
    |--------------------------------------------------------------------------
    */
    public function success($orderId)
    {
        $payment = Payment::where('order_id', $orderId)->firstOrFail();
        
        // 🔥 FIX SINKRONISASI KE resources/views/customer/payments/pay-success.blade.php
        return view('customer.payments.pay-success', compact('payment'));
    }

    /*
    |--------------------------------------------------------------------------
    | SIMULATE PAYMENT (SANDBOX)
    |--------------------------------------------------------------------------
    */
    public function simulatePayment($orderId)
    {
        $payment = Payment::where('order_id', $orderId)->firstOrFail();

        if ($payment->status === 'paid') {
            return redirect()
                ->route('payment.success', $orderId)
                ->with('info', 'Pembayaran sudah dilakukan.');
        }

        $payment->update([
            'status'       => 'paid',
            'payment_type' => 'simulation',
            'paid_at'      => now(),
        ]);

        $payment->reservation->update([
            'payment_status' => 'paid',   // 🔥 FIXED
            'status'         => 'approved',
        ]);

        return redirect()->route('payment.success', $orderId);
    }

    /*
    |--------------------------------------------------------------------------
    | UPLOAD BUKTI TRANSFER
    |--------------------------------------------------------------------------
    */
    public function uploadProof(Request $request, Reservation $reservation)
    {
        $request->validate([
            'payment_proof' => 'required|image|max:2048',
        ]);

        $file = $request->file('payment_proof');
        $filename = 'bukti_' . time() . '.' . $file->getClientOriginalExtension();

        $path = $file->storeAs('payment_proofs', $filename, 'public');

        $reservation->update([
            'payment_proof'  => $path,
            'payment_status' => 'paid',
            'status'         => 'approved',
        ]);

        return redirect()
            ->route('customer.dashboard')
            ->with('success', 'Bukti pembayaran berhasil diupload.');
    }
}