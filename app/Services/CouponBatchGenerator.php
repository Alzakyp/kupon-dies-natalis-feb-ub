<?php
namespace App\Services;
use App\Models\Batch;
use Illuminate\Support\Facades\DB;
class CouponBatchGenerator {
    public function create(string $name, int $quantity): Batch {
        return DB::transaction(function () use ($name,$quantity) {
            $batch = Batch::create(['name'=>$name,'expires_at'=>now()->addDays(7),'active'=>true]);
            for ($i=0;$i<$quantity;$i++) {
                do { $code = 'FEB65-LUSTRUM-'.strtoupper(bin2hex(random_bytes(16))); } while (\App\Models\Coupon::where('code',$code)->exists());
                $batch->coupons()->create(['code'=>$code]);
            }
            return $batch;
        });
    }
}
