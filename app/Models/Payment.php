<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'payment_method',
        'payment_status',
        'midtrans_order_id',
        'transaction_id',
        'amount',
        'payment_response',
        'paid_at',
    ];

    protected $casts = [
        'payment_response' => 'array',
        'paid_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}