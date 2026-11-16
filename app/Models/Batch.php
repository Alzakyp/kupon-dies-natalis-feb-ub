<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Batch extends Model {
    protected $fillable = ['name', 'expires_at', 'active'];
    protected $casts = ['expires_at' => 'datetime', 'active' => 'boolean'];
    public function coupons(): HasMany { return $this->hasMany(Coupon::class); }
}
