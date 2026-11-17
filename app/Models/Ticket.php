<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    protected $guarded = ['id'];
    protected $hidden = ['barcode'];
    protected $casts = ['checked_in_at' => 'datetime', 'emailed_at' => 'datetime'];

    public function studentRegistry(): BelongsTo { return $this->belongsTo(StudentRegistry::class); }
    public function coupon(): BelongsTo { return $this->belongsTo(Coupon::class); }
    public function checkedInBy(): BelongsTo { return $this->belongsTo(User::class, 'checked_in_by'); }
}
