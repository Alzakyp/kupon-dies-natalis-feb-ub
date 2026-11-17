<x-layouts.app>
<section class="auth-shell">
<p class="eyebrow">Validasi peserta</p><h1>Cek QR tiket</h1>
<p>Scan QR dari email peserta. Kolom akan tetap fokus untuk pemindaian berikutnya.</p>
<form method="post" action="{{ url('/cek-tiket') }}">@csrf
<label>Kode QR tiket<input id="public-ticket-barcode" name="barcode" autofocus required autocomplete="off" spellcheck="false"></label>
<button>Cek data peserta</button></form>
@if(isset($ticket))
<div class="summary-card" role="status">
<div><small>Nama</small><p>{{ $ticket->studentRegistry?->name ?? '—' }}</p></div>
<div><small>NIM</small><p>{{ $ticket->studentRegistry?->nim ?? '—' }}</p></div>
<div><small>Status peserta</small><p>{{ $ticket->registration_type === 'alumni' ? 'Alumni' : 'Mahasiswa Aktif' }}</p></div>
<div><small>Jenjang / Program Studi</small><p>{{ $ticket->studentRegistry?->education_level ?? '—' }} · {{ $ticket->studentRegistry?->study_program ?? '—' }}</p></div>
<div><small>Email</small><p>{{ $ticket->email }}</p></div>
<div><small>Nomor HP</small><p>{{ $ticket->phone }}</p></div>
</div>
@endif
<script>
(() => {
    const input = document.getElementById('public-ticket-barcode');
    input?.focus();
    document.addEventListener('click', event => {
        if (!event.target.closest('input,button,a')) input?.focus();
    });
    window.addEventListener('pageshow', () => input?.focus());
})();
</script>
</section>
</x-layouts.app>
