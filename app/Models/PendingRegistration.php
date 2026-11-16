<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingRegistration extends Model
{
    protected $guarded = ['id'];
    protected $casts = ['otp_expires_at' => 'datetime', 'otp_sent_at' => 'datetime'];
}
