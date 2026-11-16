<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class RedemptionAttempt extends Model { public $timestamps = false; protected $fillable = ['coupon_id','ip_address']; }
