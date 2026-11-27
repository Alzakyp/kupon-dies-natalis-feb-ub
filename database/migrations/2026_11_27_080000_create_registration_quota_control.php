<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up():void { Schema::create('registration_quota_controls',fn(Blueprint $t)=>$t->id()); DB::table('registration_quota_controls')->insert(['id'=>1]); }
 public function down():void { Schema::dropIfExists('registration_quota_controls'); }
};
