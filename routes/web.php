<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\Staff\TicketController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\{AuthController,BatchController,ExportController,SettingController};
Route::fallback(fn () => abort(404));
Route::get('/daftar',[RegistrationController::class,'form']);
Route::post('/daftar/lookup',[RegistrationController::class,'lookup']);
Route::post('/daftar/otp',[RegistrationController::class,'otp']);
Route::post('/daftar/otp/resend',[RegistrationController::class,'resendOtp'])->middleware('throttle:5,10');
Route::post('/daftar',[RegistrationController::class,'complete']);
Route::get('/c/{code}',[CouponController::class,'show'])->name('coupons.show');
Route::post('/c/{code}',[CouponController::class,'redeem'])->middleware('throttle:30,15');
Route::get('/admin/login',[AuthController::class,'form'])->name('login');
Route::post('/admin/login',[AuthController::class,'login'])->middleware('throttle:5,1');
Route::middleware(['auth','role:admin'])->prefix('admin')->group(function(){
 Route::get('/staff',[StaffController::class,'index']);
 Route::post('/staff',[StaffController::class,'store']);
 Route::post('/staff/{user}/disable',[StaffController::class,'disable']);
 Route::post('/logout',[AuthController::class,'logout']);
 Route::get('/batches',[BatchController::class,'index']);
 Route::post('/batches',[BatchController::class,'store']);
 Route::get('/batches/{batch}',[BatchController::class,'show']);
 Route::post('/batches/{batch}/deactivate',[BatchController::class,'deactivate']);
 Route::get('/batches/{batch}/export',[ExportController::class,'download']);
 Route::get('/settings',[SettingController::class,'show']);
 Route::post('/settings',[SettingController::class,'update']);
});
Route::middleware(['auth','role:admin,staff'])->prefix('staff')->group(function(){
 Route::get('/scan',[TicketController::class,'index']);
 Route::post('/lookup',[TicketController::class,'lookup']);
 Route::get('/tickets/{ticket}',[TicketController::class,'show']);
 Route::post('/tickets/{ticket}/check-in',[TicketController::class,'checkIn']);
 Route::get('/tickets/{ticket}/print',[TicketController::class,'print']);
 Route::post('/tickets/{ticket}/print',[TicketController::class,'recordPrint']);
});
