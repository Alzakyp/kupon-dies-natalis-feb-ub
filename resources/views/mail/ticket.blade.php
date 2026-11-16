<h1>Dies Natalis FEB UB ke-65 Lustrum XIII</h1>
<p>Nomor tiket: <strong>{{ $ticket->number }}</strong></p>
<p>Email: {{ $ticket->email }}</p>
<p>Tunjukkan kode ini kepada petugas di Ruang Kepegawaian Gedung Utama Lt. 2.</p>
<div>{!! $barcodeSvg !!}</div><p><strong>{{ $ticket->barcode }}</strong></p>
<p>Petugas memindai kode, mengonfirmasi check-in, lalu mencetak kupon Anda.</p>
