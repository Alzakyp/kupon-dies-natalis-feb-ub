<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
class StaffController extends Controller {
    public function index() { return view('admin.staff',['staff'=>User::where('role','staff')->get()]); }
    public function store(Request $request) {
        $data=$request->validate(['name'=>'required|string|max:100','email'=>'required|email|unique:users,email','password'=>'required|string|min:12|confirmed']);
        User::create([...$data,'role'=>'staff']);
        return back()->with('success','Akun petugas dibuat.');
    }
    public function disable(User $user) {
        abort_unless($user->role==='staff',403);
        $user->update(['role'=>'disabled']);
        return back()->with('success','Akun petugas dinonaktifkan.');
    }
}
