<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailDeliveryLog extends Model
{
    protected $guarded = ['id'];
    protected $casts = ['otp_expires_at' => 'datetime', 'sent_at' => 'datetime'];
}
