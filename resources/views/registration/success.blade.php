<x-layouts.app>
<section class="auth-shell">
<p class="eyebrow">Pendaftaran berhasil</p>
<h1>Tiket Anda siap</h1>
<div class="summary-card">
<div><small>Nomor tiket</small><p><strong>{{ $ticket->number }}</strong></p></div>
<div><small>Langkah berikutnya</small><p>Cek email Anda untuk tiket dan QR check-in.</p></div>
<div><small>Lokasi check-in</small><p>Tunjukkan QR dari email kepada petugas di Ruang Kepegawaian Gedung Utama Lt. 2.</p></div>
</div>
<p class="muted">Belum menerima email? Periksa folder Spam atau hubungi petugas dengan nomor tiket di atas.</p>
</section>
</x-layouts.app>
