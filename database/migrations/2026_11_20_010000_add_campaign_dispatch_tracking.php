<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('campaign_controls', function (Blueprint $t) {
            $t->id();
            $t->boolean('running')->default(false);
            $t->timestamp('last_batch_at')->nullable();
        });
        DB::table('campaign_controls')->insert(['id'=>1,'running'=>false]);
        Schema::table('campaign_recipients', function (Blueprint $t) {
            $t->unsignedTinyInteger('attempts')->default(0);
            $t->timestamp('queued_at')->nullable();
            $t->timestamp('attempted_at')->nullable();
            $t->timestamp('sent_at')->nullable();
            $t->timestamp('retry_at')->nullable();
            $t->text('last_error')->nullable();
            $t->index(['status','retry_at']);
        });
        Schema::create('campaign_attempts', function (Blueprint $t) {
            $t->id();
            $t->foreignId('campaign_recipient_id')->constrained();
            $t->string('status',20);
            $t->timestamp('attempted_at')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaign_attempts');
        Schema::table('campaign_recipients', function (Blueprint $t) {
            $t->dropIndex(['status','retry_at']);
            $t->dropColumn(['attempts','queued_at','attempted_at','sent_at','retry_at','last_error']);
        });
        Schema::dropIfExists('campaign_controls');
    }
};
