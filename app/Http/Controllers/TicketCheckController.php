<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketCheckController extends Controller
{
    public function form(Request $request) { return view('tickets.check', ['scannerAuthenticated' => $this->authenticated($request)]); }

    public function login(Request $request)
    {
        $data = $request->validate(['password' => 'required|string']);
        if (!hash_equals('febub2026', $data['password'])) return back()->withErrors(['password' => 'Password tidak valid.']);
        $request->session()->put(['scanner_authenticated_at' => now()->timestamp]);
        $request->session()->regenerate();
        return redirect(url('/cek-tiket'));
    }

    private function authenticated(Request $request): bool
    {
        $authenticatedAt = (int) $request->session()->get('scanner_authenticated_at', 0);
        if (!$authenticatedAt || $authenticatedAt < now()->subHours(6)->timestamp) {
            $request->session()->forget('scanner_authenticated_at');
            return false;
        }
        return true;
    }

    public function checkIn(Request $request)
    {
        if (!$this->authenticated($request)) return redirect(url('/cek-tiket'))->withErrors(['password' => 'Masukkan password petugas terlebih dahulu.']);
        $data = $request->validate(['barcode' => 'required|string|max:200']);
        $ticket = Ticket::where('barcode', trim($data['barcode']))->first();
        if (!$ticket) return back()->withErrors(['barcode' => 'Tiket tidak ditemukan.'])->withInput();
        if ($ticket->checked_in_at) return back()->withErrors(['barcode' => 'Tiket sudah dipindai pada '.$ticket->checked_in_at->timezone('Asia/Jakarta')->format('d M Y H:i').' WIB.'])->withInput();
        if (!Ticket::whereKey($ticket->id)->whereNull('checked_in_at')->update(['checked_in_at' => now()])) {
            return back()->withErrors(['barcode' => 'Tiket sudah dipindai.'])->withInput();
        }
        return redirect(url('/cek-tiket'))->with('success', 'Tiket berhasil dipindai dan ditandai hadir.');
    }

    public function lookup(Request $request)
    {
        if (!$this->authenticated($request)) return redirect(url('/cek-tiket'));
        $data = $request->validate(['barcode' => 'required|string|max:200']);
        $ticket = Ticket::with('studentRegistry')->where('barcode', trim($data['barcode']))->first();
        if (!$ticket) return back()->withErrors(['barcode' => 'Tiket tidak ditemukan.']);
        if ($ticket->checked_in_at) return view('tickets.check', ['ticket' => $ticket, 'scannerAuthenticated' => true, 'scanMessage' => 'Tiket sudah dipindai sebelumnya.']);
        if (!Ticket::whereKey($ticket->id)->whereNull('checked_in_at')->update(['checked_in_at' => now()])) return back()->withErrors(['barcode' => 'Tiket sudah dipindai.']);
        $ticket->refresh();
        return view('tickets.check', ['ticket' => $ticket, 'scannerAuthenticated' => true, 'scanMessage' => 'Tiket berhasil dipindai dan ditandai hadir.']);
    }
}
