<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'email_subject',
        'description',
        'discount_code',
        'start_date',
        'end_date',
        'is_active',
        'email_sent',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
        'email_sent' => 'boolean',
    ];
}