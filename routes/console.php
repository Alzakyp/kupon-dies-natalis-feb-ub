<?php

use App\Models\PendingRegistration;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(fn () => PendingRegistration::where('created_at', '<', now()->subDay())->delete())->hourly();
Schedule::call(fn () => \App\Models\EmailDeliveryLog::whereNotNull('otp_expires_at')->where('otp_expires_at', '<', now())->update(['otp_plaintext' => null]))->hourly();
