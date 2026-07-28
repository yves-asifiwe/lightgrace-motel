<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'room_id',
        'user_id',
        'check_in',
        'check_out',
        'total_price',
        'payment_status',
        'payment_date',
        'booking_status',
        'customer_name',
        'customer_email',
        'customer_phone',
        'notes',
    ];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
        'payment_date' => 'date',
        'total_price' => 'decimal:2',
    ];

    public function room()
    {
        return $this->belongsTo(motelmodel::class, 'room_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
