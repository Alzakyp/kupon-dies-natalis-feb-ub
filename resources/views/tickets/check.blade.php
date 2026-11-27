<x-layouts.app>
<section class="auth-shell">
<p class="eyebrow">Validasi peserta</p><h1>Cek QR tiket</h1>
<p>Scan QR dari email peserta. Kolom akan tetap fokus untuk pemindaian berikutnya.</p>
@if(!$scannerAuthenticated)<form method="post" action="{{ url('/cek-tiket/login') }}">@csrf<label>Password petugas<input type="password" name="password" required autofocus></label><button>Masuk</button></form>@else<p class="notice success">Mode scan aktif selama 6 jam.</p>@endif
@if(session('success'))<p class="notice success" role="status">{{ session('success') }}</p>@endif
<form method="post" action="{{ url('/cek-tiket') }}">@csrf
<label>Kode QR tiket<input id="public-ticket-barcode" name="barcode" autofocus required autocomplete="off" spellcheck="false"></label>
<button>Cek data peserta</button></form>
@if(isset($ticket))
<div class="summary-card" role="status">
<div><small>Nama</small><p>{{ $ticket->studentRegistry?->name ?? data_get($ticket->manual_identity, 'name', '—') }}</p></div>
<div><small>NIM</small><p>{{ $ticket->nim ?? $ticket->studentRegistry?->nim ?? '—' }}</p></div>
<div><small>Status peserta</small><p>{{ $ticket->registration_type === 'alumni' ? 'Alumni FEB UB' : ($ticket->registration_type === 'civitas_ub' ? 'Civitas UB' : 'Mahasiswa Aktif FEB UB') }}</p></div>
<div><small>Status scan</small><p>{{ $ticket->checked_in_at ? 'Sudah dipindai pada '.$ticket->checked_in_at->timezone('Asia/Jakarta')->format('d M Y H:i').' WIB' : 'Belum dipindai' }}</p></div>
<div><small>Jenjang / Program Studi</small><p>{{ $ticket->studentRegistry?->education_level ?? data_get($ticket->manual_identity, 'education_level', '—') }} · {{ $ticket->studentRegistry?->study_program ?? data_get($ticket->manual_identity, 'study_program', '—') }}</p></div>
<div><small>Email</small><p>{{ $ticket->email }}</p></div>
<div><small>Nomor HP</small><p>{{ $ticket->phone }}</p></div>
</div>
@if(!$ticket->checked_in_at)<form method="post" action="{{ url('/cek-tiket/check-in') }}" style="margin-top:16px">@csrf<input type="hidden" name="barcode" value="{{ $ticket->barcode }}"><button>Konfirmasi Scan</button></form>@endif
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
