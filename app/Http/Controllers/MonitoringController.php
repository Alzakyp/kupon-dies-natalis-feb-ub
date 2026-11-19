<?php

namespace App\Http\Controllers;

use App\Models\PendingRegistration;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MonitoringController extends Controller
{
    public function authenticate(Request $request)
    {
        $data = $request->validate(['password' => 'required|string']);
        if (!hash_equals('febub2026', $data['password']))
            return back()->withErrors(['password' => 'Password monitoring tidak valid.']);
        $request->session()->regenerate();
        $request->session()->put('monitoring_authenticated', true);
        return redirect(url('/monitoring'));
    }

    public function dashboard(Request $request)
    {
        if ($request->session()->get('monitoring_authenticated') !== true) return view('monitoring.login');
        $query = Ticket::with('studentRegistry')->latest();
        if ($request->filled('q')) {
            $term = trim($request->string('q')->value());
            $query->where(function ($q) use ($term) {
                $q->where('email', 'like', "%{$term}%")->orWhere('nim', 'like', "%{$term}%")
                    ->orWhereHas('studentRegistry', fn ($r) => $r->where('name', 'like', "%{$term}%"));
            });
        }
        if ($request->get('type') === 'alumni') $query->where('registration_type', 'alumni');
        if ($request->get('type') === 'active_student') $query->where('registration_type', 'active_student');
        if ($request->get('mail') === 'sent') $query->whereNotNull('emailed_at');
        if ($request->get('mail') === 'pending') $query->whereNull('emailed_at');
        return view('monitoring.dashboard', [
            'tickets' => $query->paginate(10)->withQueryString(),
            'total' => Ticket::count(), 'active' => \App\Models\StudentRegistry::where('registration_type', 'active_student')->count(),
            'alumni' => \App\Models\StudentRegistry::where('registration_type', 'alumni')->count(), 'sent' => Ticket::whereNotNull('emailed_at')->count(),
            'pendingOtp' => PendingRegistration::count(),
        ]);
    }

    public function logout(Request $request)
    {
        $request->session()->forget('monitoring_authenticated');
        return redirect(url('/monitoring'));
    }
}
