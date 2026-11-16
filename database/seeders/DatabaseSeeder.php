<?php
namespace Database\Seeders;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder { public function run(): void { if (env('ADMIN_EMAIL') && env('ADMIN_PASSWORD')) User::firstOrCreate(['email'=>env('ADMIN_EMAIL')],['name'=>'Admin','password'=>Hash::make(env('ADMIN_PASSWORD'))]); Setting::firstOrCreate(['key'=>'redemption_password'],['value'=>Hash::make('febub65')]); } }
