<?php
namespace App\Mail;
use App\Models\Ticket;
use Endroid\QrCode\Builder\Builder;
use Illuminate\Mail\Mailable;
class TicketIssued extends Mailable {
    public function __construct(public Ticket $ticket) {}
    public function build(): self {
        if ($this->ticket->registration_type === 'civitas_ub') return $this->subject('Tiket Grand Fiesta FEB UB')->view('mail.civitas-ticket');
        $png = (new Builder())->build(data: $this->ticket->barcode, size: 300, margin: 20)->getString();
        return $this->subject('Tiket Dies Natalis FEB UB ke-65')->view('mail.ticket', ['barcodePng' => $png]);
    }
}
