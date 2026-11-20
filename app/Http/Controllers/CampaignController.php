<?php

namespace App\Http\Controllers;

use App\Models\CampaignRecipient;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index(Request $request)
    {
        abort_unless($request->session()->get('monitoring_authenticated') === true, 403);
        return view('campaign.index', ['recipients' => CampaignRecipient::orderBy('id')->paginate(25), 'total' => CampaignRecipient::count()]);
    }

    public function preview(Request $request)
    {
        abort_unless($request->session()->get('monitoring_authenticated') === true, 403);
        return view('campaign.email');
    }
}
