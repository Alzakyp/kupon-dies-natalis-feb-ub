<?php
namespace App\Mail;
use App\Models\Ticket;
use App\Services\BarcodeSvg;
use Illuminate\Mail\Mailable;
class TicketIssued extends Mailable {
    public function __construct(public Ticket $ticket) {}
    public function build(): self { return $this->subject('Tiket Dies Natalis FEB UB ke-65')->view('mail.ticket',['barcodeSvg'=>BarcodeSvg::render($this->ticket->barcode)]); }
}
