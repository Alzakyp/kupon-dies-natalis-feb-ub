<?php

use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\TicketCheckController;
use Illuminate\Support\Facades\Route;

Route::get('/daftar', [RegistrationController::class, 'form']);
Route::post('/daftar/lookup', [RegistrationController::class, 'lookup']);
Route::post('/daftar/otp', [RegistrationController::class, 'otp']);
Route::post('/daftar/otp/resend', [RegistrationController::class, 'resendOtp'])->middleware('throttle:5,10');
Route::post('/daftar', [RegistrationController::class, 'complete']);
Route::get('/cek-tiket', [TicketCheckController::class, 'form']);
Route::post('/cek-tiket', [TicketCheckController::class, 'lookup'])->middleware('throttle:20,1');
Route::fallback(fn () => abort(404));
