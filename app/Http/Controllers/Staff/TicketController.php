<?php
namespace App\Http\Controllers\Staff;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
class TicketController extends Controller {
    public function index() { return view('staff.scan', ['total'=>Ticket::count(), 'checkedIn'=>Ticket::whereNotNull('checked_in_at')->count(), 'recent'=>Ticket::with('studentRegistry')->latest()->limit(10)->get()]); }
    public function lookup(Request $request) {
        $data=$request->validate(['barcode'=>'required|string|max:200']);
        $ticket=Ticket::where('barcode',trim($data['barcode']))->first();
        if (!$ticket) return back()->withErrors(['barcode'=>'Tiket tidak ditemukan.']);
        return redirect(url('/staff/tickets/'.$ticket->id));
    }
    public function show(Ticket $ticket) { return view('staff.ticket',['ticket'=>$ticket->load('coupon.batch')]); }
    public function checkIn(Request $request, Ticket $ticket) {
        Ticket::whereKey($ticket->id)->whereNull('checked_in_at')->update(['checked_in_at'=>now(),'checked_in_by'=>$request->user()->id]);
        return redirect(url('/staff/tickets/'.$ticket->id))->with('success','Check-in tercatat.');
    }
    public function print(Ticket $ticket) {
        abort_unless($ticket->checked_in_at,403);
        return view('staff.print',['ticket'=>$ticket->load('coupon.batch')]);
    }
    public function recordPrint(Ticket $ticket) {
        abort_unless($ticket->checked_in_at,403);
        $ticket->increment('print_requests');
        return redirect(url('/staff/tickets/'.$ticket->id.'/print'));
    }
}
