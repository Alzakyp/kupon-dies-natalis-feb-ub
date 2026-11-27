<?php

namespace App\Http\Controllers;

use App\Models\PendingRegistration;
use App\Models\StudentRegistry;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class MonitoringController extends Controller
{
    public function authenticate(Request $request)
    {
        $data = $request->validate(['password' => 'required|string']);
        if (!hash_equals('febub2026', $data['password'])) return back()->withErrors(['password' => 'Password monitoring tidak valid.']);
        $request->session()->regenerate();
        $request->session()->put('monitoring_authenticated', true);
        return redirect(url('/monitoring'));
    }

    public function dashboard(Request $request)
    {
        if ($request->session()->get('monitoring_authenticated') !== true) return view('monitoring.login');
        $term = strtolower(trim($request->string('q')->value()));
        $type = $request->get('type'); $mail = $request->get('mail');
        $tickets = Ticket::with('studentRegistry')->get()->map(fn ($row) => $this->item($row, true));
        $pending = PendingRegistration::with('studentRegistry')->get()->map(fn ($row) => $this->item($row, false));
        $items = $tickets->concat($pending)->filter(function ($item) use ($term, $type, $mail) {
            if ($term && !str_contains(strtolower($item->name.' '.$item->nim.' '.$item->email), $term)) return false;
            if (in_array($type, ['alumni', 'active_student'], true) && $item->registration_type !== $type) return false;
            if ($mail === 'sent' && !$item->emailed_at) return false;
            if ($mail === 'pending' && $item->emailed_at) return false;
            return true;
        })->sortByDesc(fn ($item) => sprintf('%s-%010d', $item->created_at->format('Y-m-d H:i:s.u'), $item->id))->values();
        $page = LengthAwarePaginator::resolveCurrentPage();
        $participants = new LengthAwarePaginator($items->forPage($page, 10), $items->count(), 10, $page, ['path' => $request->url(), 'query' => $request->query()]);
        return view('monitoring.dashboard', [
            'tickets' => $participants, 'total' => Ticket::count(),
            'active' => StudentRegistry::where('registration_type', 'active_student')->count(),
            'alumni' => StudentRegistry::where('registration_type', 'alumni')->count(),
            'sent' => Ticket::whereNotNull('emailed_at')->count(), 'pendingOtp' => PendingRegistration::count(),
        ]);
    }

    private function item(Ticket|PendingRegistration $row, bool $verified): object
    {
        return (object) [
            'id' => $row->id, 'name' => $row->studentRegistry?->name ?? data_get($row->manual_identity, 'name', '—'),
            'nim' => $row->nim ?? $row->studentRegistry?->nim ?? '—', 'registration_type' => $row->registration_type,
            'study_program' => $row->studentRegistry?->study_program ?? data_get($row->manual_identity, 'study_program', '—'),
            'email' => $row->email, 'phone' => $row->phone, 'verified' => $verified,
            'emailed_at' => $verified ? $row->emailed_at : null, 'otp_expires_at' => $verified ? null : $row->otp_expires_at,
            'checked_in_at' => $verified ? $row->checked_in_at : null, 'created_at' => $row->created_at,
        ];
    }

    public function logout(Request $request) { $request->session()->forget('monitoring_authenticated'); return redirect(url('/monitoring')); }
}
