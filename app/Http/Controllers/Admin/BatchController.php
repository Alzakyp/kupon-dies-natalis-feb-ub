<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Services\CouponBatchGenerator;
use Illuminate\Http\Request;
class BatchController extends Controller { public function index(){return view('admin.batches.index',['batches'=>Batch::withCount(['coupons','coupons as redeemed_count'=>fn($q)=>$q->whereNotNull('redeemed_at')])->latest()->get()]);} public function store(Request $r,CouponBatchGenerator $g){$d=$r->validate(['name'=>'required|string|max:100','quantity'=>'required|integer|min:1|max:1000']);return redirect(url('/admin/batches/'.$g->create($d['name'],$d['quantity'])->id));} public function show(Batch $batch){return view('admin.batches.show',compact('batch'));} public function deactivate(Batch $batch){$batch->update(['active'=>false]);return back();} }
