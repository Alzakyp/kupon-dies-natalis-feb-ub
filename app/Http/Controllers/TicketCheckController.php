<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketCheckController extends Controller
{
    public function form() { return view('tickets.check'); }

    public function checkIn(Request $request)
    {
        abort_unless(hash_equals('febub2026', (string) $request->input('password')), 403);
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
        $data = $request->validate(['barcode' => 'required|string|max:200']);
        $ticket = Ticket::with('studentRegistry')->where('barcode', trim($data['barcode']))->first();
        if (!$ticket) return back()->withErrors(['barcode' => 'Tiket tidak ditemukan.']);
        return view('tickets.check', compact('ticket'));
    }
}
