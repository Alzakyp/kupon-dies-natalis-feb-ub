<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        foreach (['pending_registrations', 'tickets'] as $name) {
            Schema::table($name, function (Blueprint $table) {
                $table->string('nim', 30)->nullable();
                $table->json('manual_identity')->nullable();
            });
        }
        foreach (['pending_registrations', 'tickets'] as $name) {
            \Illuminate\Support\Facades\DB::table($name)->whereNotNull('student_registry_id')->orderBy('id')->each(function ($row) use ($name) {
                $nim = \Illuminate\Support\Facades\DB::table('student_registries')->where('id', $row->student_registry_id)->value('nim');
                \Illuminate\Support\Facades\DB::table($name)->where('id', $row->id)->update(['nim' => $nim]);
            });
        }
        Schema::table('tickets', fn (Blueprint $table) => $table->unique('nim'));
    }

    public function down(): void
    {
        Schema::table('tickets', fn (Blueprint $table) => $table->dropUnique(['nim']));
        foreach (['pending_registrations', 'tickets'] as $name) Schema::table($name, fn (Blueprint $table) => $table->dropColumn(['nim', 'manual_identity']));
    }
};
