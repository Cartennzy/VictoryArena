<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'reservation_id',
        'order_id',
        'amount',
        'status',
        'payment_type',
        'paid_at',
    ];

    // 🔑 FIX UTAMA: CAST paid_at JADI DATETIME (CARBON)
    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
