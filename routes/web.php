<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\Admin\{AuthController,BatchController,ExportController,SettingController};
Route::fallback(fn () => abort(404));
Route::get('/c/{code}',[CouponController::class,'show'])->name('coupons.show');
Route::post('/c/{code}',[CouponController::class,'redeem'])->middleware('throttle:30,15');
Route::get('/admin/login',[AuthController::class,'form'])->name('login');
Route::post('/admin/login',[AuthController::class,'login'])->middleware('throttle:5,1');
Route::middleware('auth')->prefix('admin')->group(function(){
 Route::post('/logout',[AuthController::class,'logout']);
 Route::get('/batches',[BatchController::class,'index']);
 Route::post('/batches',[BatchController::class,'store']);
 Route::get('/batches/{batch}',[BatchController::class,'show']);
 Route::post('/batches/{batch}/deactivate',[BatchController::class,'deactivate']);
 Route::get('/batches/{batch}/export',[ExportController::class,'download']);
 Route::get('/settings',[SettingController::class,'show']);
 Route::post('/settings',[SettingController::class,'update']);
});
