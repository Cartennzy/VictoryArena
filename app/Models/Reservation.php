<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
    'user_id',
    'field',
    'date',
    'start_time',
    'end_time',
    'total_price',
    'status',
    'payment_status',
    'payment_method',
    'payment_proof',
];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
