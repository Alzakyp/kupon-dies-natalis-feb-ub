<?php
namespace App\Services;
use App\Models\Coupon;
use App\Models\RedemptionAttempt;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class CouponRedemptionService {
    public function redeem(string $code,string $password,string $ip): string {
        return DB::transaction(function () use ($code,$password,$ip) {
            $coupon=Coupon::where('code',$code)->lockForUpdate()->firstOrFail(); $coupon->load('batch');
            if ($coupon->status() !== 'VALID') return $coupon->status();
            if (RedemptionAttempt::where('coupon_id',$coupon->id)->where('created_at','>=',now()->subMinutes(15))->count() >= 5) return 'TERKUNCI';
            $hash=Setting::where('key','redemption_password')->value('value');
            if (!$hash) return 'TERKUNCI';
            if (!Hash::check($password,$hash)) { RedemptionAttempt::create(['coupon_id'=>$coupon->id,'ip_address'=>$ip]); return 'PASSWORD SALAH'; }
            $coupon->update(['redeemed_at'=>now(),'redeemed_ip'=>$ip]); return 'DIGUNAKAN';
        });
    }
}
