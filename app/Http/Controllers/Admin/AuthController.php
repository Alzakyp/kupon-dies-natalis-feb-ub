<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller { public function form(){return view('admin.login');} public function login(Request $r){$data=$r->validate(['email'=>'required|email','password'=>'required']);if(!Auth::attempt($data))return back()->withErrors(['email'=>'Kredensial tidak valid.']);$r->session()->regenerate();return redirect(url('/admin/batches'));} public function logout(Request $r){Auth::logout();$r->session()->invalidate();return redirect(url('/admin/login'));} }
