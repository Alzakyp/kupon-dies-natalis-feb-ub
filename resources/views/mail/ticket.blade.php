<!doctype html><html lang="id"><body style="margin:0;padding:0;background:#f3f5f7;color:#14263a;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td align="center" style="padding:24px 12px;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width:600px;background:#ffffff;border:1px solid #d5dce2;">
<tr><td>@include('mail.partials.brand')</td></tr>
<tr><td style="padding:32px;font-family:Arial,sans-serif;">
<p style="margin:0 0 8px;color:#77500e;font-size:12px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;">Tiket peserta</p>
<h1 style="margin:0 0 16px;color:#092b4c;font-size:26px;line-height:1.25;">Tiket Anda siap</h1>

<p style="margin:0 0 20px;font-size:15px;line-height:1.6;">Grand Fiesta — Fun Walk &amp; FEB Unity Concert<br><strong>6 Desember 2026 · 05.30 WIB–selesai · Lapangan Rektorat UB</strong></p><p style="font-size:15px;line-height:1.6;">Tunjukkan QR kepada petugas. Pengambilan kupon wajib membawa <strong>KTM atau KTP asli</strong>.</p><div style="margin-top:20px;padding:16px;background:#fbf4df;border-left:4px solid #d3a128;font-size:14px;line-height:1.7;"><strong>Pengambilan kupon undian jalan sehat</strong><br>30 November–4 Desember 2026<br>1. Mahasiswa aktif angkatan 2025 &amp; 2026: Ruang Tata Usaha (Gedung Utama Lt. 2)<br>2. Mahasiswa aktif angkatan lainnya: Security Command Center (Gedung Dekanat Lama Lt. 1)<br>3. Alumni: Ruang Kemahasiswaan Lt. 2</div>
<div style="padding:18px;text-align:center;background:#ffffff;border:1px solid #d5dce2;"><img src="{{ $message->embedData($barcodePng, 'ticket-qr.png', 'image/png') }}" width="300" height="300" alt="QR barcode tiket {{ $ticket->number }}" style="display:block;width:300px;height:300px;max-width:100%;margin:0 auto;"></div>
<p style="margin:18px 0 0;text-align:center;color:#5b6876;font-family:Courier New,monospace;font-size:12px;overflow-wrap:anywhere;">{{ $ticket->barcode }}</p>
<p style="margin:22px 0 0;font-size:14px;line-height:1.6;">Petugas akan memindai QR untuk memeriksa data peserta. Kupon diserahkan secara manual.</p>
</td></tr>
<tr><td style="padding:18px 32px;background:#f7f7f4;color:#5b6876;font-family:Arial,sans-serif;font-size:12px;line-height:1.5;">Pesan otomatis Fakultas Ekonomi dan Bisnis Universitas Brawijaya.</td></tr>
</table></td></tr></table></body></html>
