<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Reservation;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'field',
        'date',
        'start_time',
        'end_time',
        'status'
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    /* =========================
       ACCESSOR BAHASA INDONESIA
    ==========================*/
    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'active' => 'Aktif',
            'finished' => 'Selesai',
            'cancelled' => 'Batal',
            default => '-',
        };
    }
}
