<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('student_registries', function (Blueprint $table) {
            $table->id();
            $table->string('nim');
            $table->string('name');
            $table->string('education_level', 30);
            $table->string('study_program')->nullable();
            $table->string('registration_type', 30);
            $table->timestamps();
            $table->unique(['nim', 'registration_type']);
        });
        Schema::table('pending_registrations', function (Blueprint $table) {
            $table->string('registration_type', 30)->nullable()->after('phone');
            $table->foreignId('student_registry_id')->nullable()->after('registration_type')->constrained()->nullOnDelete();
        });
        Schema::table('tickets', function (Blueprint $table) {
            $table->string('registration_type', 30)->nullable()->after('phone');
            $table->foreignId('student_registry_id')->nullable()->after('registration_type')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('tickets', fn (Blueprint $table) => $table->dropConstrainedForeignId('student_registry_id'));
        Schema::table('tickets', fn (Blueprint $table) => $table->dropColumn('registration_type'));
        Schema::table('pending_registrations', fn (Blueprint $table) => $table->dropConstrainedForeignId('student_registry_id'));
        Schema::table('pending_registrations', fn (Blueprint $table) => $table->dropColumn('registration_type'));
        Schema::dropIfExists('student_registries');
    }
};
