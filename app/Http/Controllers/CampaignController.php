<?php

namespace App\Http\Controllers;

use App\Models\CampaignRecipient;
use App\Services\CampaignDelivery;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index(Request $request)
    {
        if ($request->session()->get('monitoring_authenticated') !== true) return view('campaign.login');
        return view('campaign.index', $this->dashboardData());
    }

    public function authenticate(Request $request)
    {
        $data = $request->validate(['password' => 'required|string']);
        if (!hash_equals('febub2026', $data['password'])) return back()->withErrors(['password' => 'Password monitoring tidak valid.']);
        $request->session()->regenerate();
        $request->session()->put('monitoring_authenticated', true);
        return redirect(url('/monitoring/campaign'));
    }

    public function control(Request $request)
    {
        abort_unless($request->session()->get('monitoring_authenticated') === true, 403);
        DB::table('campaign_controls')->where('id',1)->update(['running' => $request->boolean('running')]);
        return redirect(url('/monitoring/campaign'));
    }

    public function stats(Request $request)
    {
        abort_unless($request->session()->get('monitoring_authenticated') === true, 403);
        return response()->json($this->metrics());
    }

    private function dashboardData(): array
    {
        $recipients = CampaignRecipient::orderBy('id')->paginate(25);
        $metrics = $this->metrics();
        return compact('recipients','metrics');
    }

    private function metrics(): array
    {
        return ['total'=>CampaignRecipient::count(),'sent'=>CampaignRecipient::where('status','sent')->count(),'queued'=>CampaignRecipient::whereIn('status',['queued','sending'])->count(),'failed'=>CampaignRecipient::where('status','failed')->count(),'remaining'=>CampaignRecipient::whereIn('status',['draft','failed'])->count(),'attemptsToday'=>DB::table('campaign_attempts')->where('attempted_at','>',now()->subDay())->count(),'limit'=>CampaignDelivery::LIMIT,'running'=>(bool)DB::table('campaign_controls')->where('id',1)->value('running')];
    }

    public function preview(Request $request)
    {
        if ($request->session()->get('monitoring_authenticated') !== true) return redirect(url('/monitoring/campaign'));
        return view('campaign.email');
    }
}
