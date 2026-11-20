<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('email_delivery_logs', function (Blueprint $table) {
            $table->id();
            $table->string('type', 20); // otp or ticket_qr
            $table->string('recipient_email');
            $table->foreignId('pending_registration_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('ticket_id')->nullable()->constrained()->nullOnDelete();
            $table->string('otp_plaintext', 6)->nullable();
            $table->timestamp('otp_expires_at')->nullable();
            $table->string('status', 20); // sent or failed
            $table->text('error_message')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
            $table->index(['type', 'recipient_email']);
        });
    }
    public function down(): void { Schema::dropIfExists('email_delivery_logs'); }
};
