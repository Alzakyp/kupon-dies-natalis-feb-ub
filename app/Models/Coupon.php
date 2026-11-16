<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
class Coupon extends Model {
    protected $fillable = ['batch_id', 'code', 'redeemed_at', 'redeemed_ip'];
    protected $casts = ['redeemed_at' => 'datetime'];
    public function batch(): BelongsTo { return $this->belongsTo(Batch::class); }
    public function attempts(): HasMany { return $this->hasMany(RedemptionAttempt::class); }
    public function ticket(): HasOne { return $this->hasOne(Ticket::class); }
    public function status(): string {
        if ($this->redeemed_at) return 'SUDAH DIGUNAKAN';
        if (!$this->batch->active) return 'NONAKTIF';
        if ($this->batch->expires_at->isPast()) return 'KEDALUWARSA';
        return 'VALID';
    }
}
