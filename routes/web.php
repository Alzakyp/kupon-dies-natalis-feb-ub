<?php

use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\TicketCheckController;
use Illuminate\Support\Facades\Route;

Route::get('/daftar', [RegistrationController::class, 'form']);
Route::post('/daftar/lookup', [RegistrationController::class, 'lookup']);
Route::post('/daftar/otp', [RegistrationController::class, 'otp']);
Route::post('/daftar/otp/resend', [RegistrationController::class, 'resendOtp'])->middleware('throttle:5,10');
Route::post('/daftar', [RegistrationController::class, 'complete']);
Route::get('/cek-tiket', [TicketCheckController::class, 'form']);
Route::post('/cek-tiket', [TicketCheckController::class, 'lookup'])->middleware('throttle:20,1');
Route::get('/monitoring', [MonitoringController::class, 'dashboard']);
Route::post('/monitoring', [MonitoringController::class, 'authenticate'])->middleware('throttle:5,1');
Route::post('/monitoring/logout', [MonitoringController::class, 'logout']);
Route::get('/monitoring/campaign', [CampaignController::class, 'index']);
Route::post('/monitoring/campaign', [CampaignController::class, 'authenticate'])->middleware('throttle:5,1');
Route::post('/monitoring/campaign/control', [CampaignController::class, 'control']);
Route::get('/monitoring/campaign/stats', [CampaignController::class, 'stats']);
Route::get('/monitoring/campaign/preview', [CampaignController::class, 'preview']);
Route::fallback(fn () => abort(404));
