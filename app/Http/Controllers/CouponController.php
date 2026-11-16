<?php
namespace App\Http\Controllers;
use App\Models\Coupon;
use App\Models\RedemptionAttempt;
use App\Services\CouponRedemptionService;
use Illuminate\Http\Request;
class CouponController extends Controller {
    public function show(string $code){
        $coupon=Coupon::with('batch')->where('code',$code)->firstOrFail();
        $locked=RedemptionAttempt::where('coupon_id',$coupon->id)->where('created_at','>=',now()->subMinutes(15))->count() >= 5;
        return view('coupons.show',compact('coupon','locked'));
    }
    public function redeem(Request $r,string $code,CouponRedemptionService $s){
        $r->validate(['password'=>'required|string']);
        $res=$s->redeem($code,$r->password,$r->ip());
        if ($res==='DIGUNAKAN') return back()->with('success','Kupon berhasil digunakan.');
        return back()->withErrors(['password'=>'Penukaran gagal: '.$res]);
    }
}
