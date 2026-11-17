<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketCheckController extends Controller
{
    public function form() { return view('tickets.check'); }

    public function lookup(Request $request)
    {
        $data = $request->validate(['barcode' => 'required|string|max:200']);
        $ticket = Ticket::with('studentRegistry')->where('barcode', trim($data['barcode']))->first();
        if (!$ticket) return back()->withErrors(['barcode' => 'Tiket tidak ditemukan.']);
        return view('tickets.check', compact('ticket'));
    }
}
