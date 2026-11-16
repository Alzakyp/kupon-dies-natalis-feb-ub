<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class SettingController extends Controller { public function show(){return view('admin.settings');} public function update(Request $r){$d=$r->validate(['password'=>'required|string|min:8|confirmed']);Setting::updateOrCreate(['key'=>'redemption_password'],['value'=>Hash::make($d['password'])]);return back()->with('success','Password diperbarui.');} }
