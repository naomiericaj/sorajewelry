<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
    'user_id',
    'order_number',

    'subtotal',
    'shipping_cost',

    'voucher_code',
    'discount_amount',

    'total_price',

    'order_status',

    'receiver_name',
    'receiver_phone',
    'shipping_address',
];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}