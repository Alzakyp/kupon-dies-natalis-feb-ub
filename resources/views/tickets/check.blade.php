<x-layouts.app>
<section class="auth-shell">
<p class="eyebrow">Validasi tiket</p><h1>Cek QR tiket</h1>
<p>Scan QR dari email peserta atau tempel kode tiket.</p>
<form method="post" action="{{ url('/cek-tiket') }}">@csrf
<label>Kode QR tiket<input name="barcode" autofocus required autocomplete="off" spellcheck="false"></label>
<button>Cek tiket</button></form>
@if(isset($ticket))
<div class="summary-card" role="status">
<div><small>Nomor tiket</small><p><strong>{{ $ticket->number }}</strong></p></div>
<div><small>Nama</small><p>{{ $ticket->studentRegistry?->name ?? '—' }}</p></div>
<div><small>NIM</small><p>{{ $ticket->studentRegistry?->nim ?? '—' }}</p></div>
<div><small>Jenjang / Program Studi</small><p>{{ $ticket->studentRegistry?->education_level ?? '—' }} · {{ $ticket->studentRegistry?->study_program ?? '—' }}</p></div>
<div><small>Email</small><p>{{ $ticket->email }}</p></div>
<div><small>Nomor HP</small><p>{{ $ticket->phone }}</p></div>
<div><small>Status</small><p>{{ $ticket->checked_in_at ? 'Sudah check-in' : 'Belum check-in' }}</p></div>
</div>
@endif
</section>
</x-layouts.app>
