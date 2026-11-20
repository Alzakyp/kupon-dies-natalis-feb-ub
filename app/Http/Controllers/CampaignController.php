<?php

namespace App\Http\Controllers;

use App\Models\CampaignRecipient;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index(Request $request)
    {
        if ($request->session()->get('monitoring_authenticated') !== true) return view('campaign.login');
        return view('campaign.index', ['recipients' => CampaignRecipient::orderBy('id')->paginate(25), 'total' => CampaignRecipient::count()]);
    }

    public function authenticate(Request $request)
    {
        $data = $request->validate(['password' => 'required|string']);
        if (!hash_equals('febub2026', $data['password'])) return back()->withErrors(['password' => 'Password monitoring tidak valid.']);
        $request->session()->regenerate();
        $request->session()->put('monitoring_authenticated', true);
        return redirect(url('/monitoring/campaign'));
    }

    public function preview(Request $request)
    {
        if ($request->session()->get('monitoring_authenticated') !== true) return redirect(url('/monitoring/campaign'));
        return view('campaign.email');
    }
}
