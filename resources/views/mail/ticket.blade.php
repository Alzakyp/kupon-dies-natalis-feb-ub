<!doctype html><html lang="id"><body style="margin:0;padding:0;background:#f3f5f7;color:#14263a;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td align="center" style="padding:24px 12px;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width:600px;background:#ffffff;border:1px solid #d5dce2;">
<tr><td>@include('mail.partials.brand')</td></tr>
<tr><td style="padding:32px;font-family:Arial,sans-serif;">
<p style="margin:0 0 8px;color:#77500e;font-size:12px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;">Tiket peserta</p>
<h1 style="margin:0 0 16px;color:#092b4c;font-size:26px;line-height:1.25;">Tiket Anda siap</h1>
<p style="margin:0 0 8px;font-size:16px;">Nomor tiket: <strong>{{ $ticket->number }}</strong></p>
<p style="margin:0 0 20px;font-size:15px;line-height:1.6;">Tunjukkan QR ini kepada petugas di <strong>Ruang Kepegawaian Gedung Utama Lt. 2</strong>.</p>
<div style="padding:18px;text-align:center;background:#ffffff;border:1px solid #d5dce2;"><img src="data:image/png;base64,{{ base64_encode($barcodePng) }}" width="300" height="300" alt="QR barcode tiket {{ $ticket->number }}" style="display:block;width:300px;height:300px;max-width:100%;margin:0 auto;"></div>
<p style="margin:18px 0 0;text-align:center;color:#5b6876;font-family:Courier New,monospace;font-size:12px;overflow-wrap:anywhere;">{{ $ticket->barcode }}</p>
<p style="margin:22px 0 0;font-size:14px;line-height:1.6;">Petugas akan memindai kode, mengonfirmasi check-in, lalu mencetak kupon Anda.</p>
</td></tr>
<tr><td style="padding:18px 32px;background:#f7f7f4;color:#5b6876;font-family:Arial,sans-serif;font-size:12px;line-height:1.5;">Pesan otomatis Fakultas Ekonomi dan Bisnis Universitas Brawijaya.</td></tr>
</table></td></tr></table></body></html>
