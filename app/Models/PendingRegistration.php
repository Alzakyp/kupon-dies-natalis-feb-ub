<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingRegistration extends Model
{
    public function studentRegistry(): \Illuminate\Database\Eloquent\Relations\BelongsTo { return $this->belongsTo(StudentRegistry::class); }
    protected $guarded = ['id'];
    protected $casts = ['otp_expires_at' => 'datetime', 'otp_sent_at' => 'datetime'];
}
