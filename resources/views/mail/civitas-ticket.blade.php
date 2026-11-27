<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="color-scheme" content="light">
  <meta name="supported-color-schemes" content="light">
  <title>Tiket Grand Fiesta FEB UB — Civitas UB</title>
  <style>
    :root { color-scheme: light; supported-color-schemes: light; }
    @media only screen and (max-width: 600px) {
      .email-wrap { padding: 14px 8px !important; }
      .email-body-pad { padding: 20px 16px 14px !important; }
      .ticket-wrap-pad { padding: 6px 12px 18px !important; }
      .info-box-pad { padding: 0 12px 18px !important; }
      .ticket-col { display: block !important; width: 100% !important; max-width: 100% !important; box-sizing: border-box !important; }
      .ticket-stub { border-left: none !important; border-top: 2px dashed #94a3b8 !important; padding: 16px 18px !important; }
      .hero-stack { display: block !important; width: 100% !important; text-align: left !important; padding-right: 0 !important; }
      .hero-kotak-img { width: 190px !important; margin: 0 auto 12px !important; }
      .ticket-top-id { font-size: 11px !important; }
    }
  </style>
</head>
<body style="margin:0;padding:0;background:#eef2f6;color:#0f172a;font-family:Arial,Helvetica,sans-serif;-webkit-font-smoothing:antialiased;">
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#eef2f6;">
    <tr>
      <td align="center" class="email-wrap" style="padding:28px 12px;">
        <!-- Email Container -->
        <table role="presentation" width="680" cellpadding="0" cellspacing="0" border="0" style="max-width:680px;width:100%;background:#f8fafc;border:1px solid #d5dce2;border-radius:10px;overflow:hidden;box-shadow:0 4px 18px rgba(9,43,76,0.06);">

          <!-- Top Email Body Greeting & Context -->
          <tr>
            <td class="email-body-pad" style="padding:28px 24px 18px;background:#ffffff;">
              <div style="font-size:11.5px;font-weight:800;letter-spacing:0.08em;text-transform:uppercase;color:#8a5d10;margin-bottom:6px;">
                Fakultas Ekonomi dan Bisnis Universitas Brawijaya
              </div>
              <h1 style="margin:0 0 14px;font-size:21px;line-height:1.3;font-weight:800;color:#092b4c;">
                Tiket Grand Fiesta — Civitas UB
              </h1>
              <p style="margin:0 0 10px;font-size:14.5px;line-height:1.6;color:#1e293b;">
                Yth. <strong>{{ $ticket->manual_identity['name'] ?? 'Civitas UB' }}</strong>,
              </p>
              <p style="margin:0 0 10px;font-size:14px;line-height:1.6;color:#334155;">
                Terima kasih telah mendaftarkan diri pada rangkaian acara <strong>Grand Fiesta — Dies Natalis ke-65 FEB UB</strong> (<em>Fun Walk &amp; FEB Unity Concert</em>).
              </p>
              <p style="margin:0;font-size:14px;line-height:1.6;color:#334155;">
                Berikut adalah tiket resmi kepesertaan Anda yang <strong>berlaku untuk 2 orang</strong>. Simpan email ini sebagai bukti kepesertaan Anda di lokasi acara.
              </p>
            </td>
          </tr>

          <!-- Horizontal Concert Ticket / Boarding Pass (Stacks cleanly on Mobile) -->
          <tr>
            <td align="center" class="ticket-wrap-pad" style="padding:12px 20px 22px;background:#ffffff;">
              <table role="presentation" width="640" cellpadding="0" cellspacing="0" border="0" style="max-width:640px;width:100%;border-radius:10px;overflow:hidden;box-shadow:0 14px 30px rgba(9,21,38,0.2);background:#0b1320;">
                <tr>
                  <!-- LEFT: Dark Main Ticket Body -->
                  <td width="445" valign="top" class="ticket-col" style="background:#0b1320;background-image:linear-gradient(135deg,#071426 0%,#0d1f38 55%,#09111e 100%);padding:18px 20px 14px;color:#f1f5f9;">
                    <!-- Top Row: FEB UB White-Text Logo + Ticket ID -->
                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:14px;">
                      <tr>
                        <td valign="middle" style="padding-right:8px;">
                          <img src="{{ asset('images/logo-feb-ub.png') }}" alt="Fakultas Ekonomi dan Bisnis Universitas Brawijaya" height="30" style="display:block;height:30px;width:auto;max-width:170px;">
                        </td>
                        <td valign="middle" align="right" class="ticket-top-id" style="font-family:'Courier New',Courier,monospace;font-size:12px;font-weight:700;letter-spacing:0.04em;color:#f1f5f9;white-space:nowrap;">
                          {{ $ticket->number }}
                        </td>
                      </tr>
                    </table>

                    <!-- Middle Row: Band KOTAK + Event Title -->
                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td width="175" valign="bottom" class="hero-stack" style="padding-right:12px;">
                          <img src="{{ asset('images/band-kotak-hd.png') }}" alt="Band KOTAK" width="175" class="hero-kotak-img" style="display:block;width:175px;max-width:100%;height:auto;">
                        </td>
                        <td valign="middle" class="hero-stack" style="padding-bottom:6px;">
                          <div style="font-size:10.5px;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;color:#f43f5e;margin-bottom:2px;">
                            DIES NATALIS KE-65 FEB UB
                          </div>
                          <div style="font-family:Georgia,'Times New Roman',serif;font-style:italic;font-size:32px;font-weight:700;line-height:1.05;color:#f8fafc;margin-bottom:4px;">
                            Grand Fiesta
                          </div>
                          <div style="font-size:12px;font-weight:900;letter-spacing:0.06em;text-transform:uppercase;color:#facc15;margin-bottom:12px;">
                            FEB UNITY CONCERT · BAND KOTAK
                          </div>

                          <div style="font-size:16px;font-weight:800;letter-spacing:0.04em;color:#facc15;margin-bottom:3px;">
                            06.12.2026
                          </div>
                          <div style="font-size:10.5px;font-weight:600;letter-spacing:0.03em;color:#e2e8f0;line-height:1.45;text-transform:uppercase;">
                            LAPANGAN REKTORAT UB · 05.30 WIB<br>
                            BERLAKU 2 ORANG · CIVITAS UB
                          </div>
                        </td>
                      </tr>
                    </table>

                    <!-- Bottom Strip inside Dark Section -->
                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top:10px;padding-top:10px;border-top:1px solid rgba(226,232,240,0.2);">
                      <tr>
                        <td valign="middle" style="font-size:11px;font-weight:600;color:#cbd5e1;letter-spacing:0.03em;">
                          PESERTA: <strong style="color:#f1f5f9;">{{ $ticket->manual_identity['name'] ?? 'Civitas UB' }}</strong>
                        </td>
                      </tr>
                    </table>
                  </td>

                  <!-- RIGHT: Light Cool-Grey Tear-Off Stub -->
                  <td width="195" valign="top" class="ticket-col ticket-stub" style="background:#e2e6ec;border-left:2px dashed #94a3b8;padding:16px 16px 14px;color:#0f172a;">
                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td style="padding-bottom:10px;border-bottom:1px solid #cbd5e1;">
                          <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                              <td valign="top">
                                <div style="font-size:9px;font-weight:800;letter-spacing:0.08em;text-transform:uppercase;color:#475569;">
                                  DIES NATALIS KE-65
                                </div>
                                <div style="font-size:14.5px;font-weight:900;letter-spacing:-0.01em;color:#091526;margin-top:2px;line-height:1.15;">
                                  FEB UB<br>GRAND FIESTA
                                </div>
                              </td>
                              <td width="38" valign="top" align="right">
                                <div style="background:#f8fafc;border-radius:6px;padding:2px;display:inline-block;">
                                  <img src="{{ asset('images/logo-lustrum-65-clean.png') }}" alt="65 FEB UB" width="34" height="34" style="display:block;width:34px;height:34px;object-fit:contain;">
                                </div>
                              </td>
                            </tr>
                          </table>
                          <div style="font-size:9.5px;font-weight:800;letter-spacing:0.04em;text-transform:uppercase;color:#8a5d10;margin-top:5px;">
                            FUN WALK &amp; FEB UNITY CONCERT
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td style="padding:10px 0;">
                          <div style="font-size:9px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:#64748b;">
                            NAMA PESERTA
                          </div>
                          <div style="font-size:12px;font-weight:800;color:#0f172a;margin-top:2px;line-height:1.3;">
                            {{ $ticket->manual_identity['name'] ?? 'Civitas UB' }}
                          </div>

                          <div style="font-size:9px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:#64748b;margin-top:8px;">
                            KETENTUAN MASUK
                          </div>
                          <div style="font-size:12px;font-weight:800;color:#092b4c;margin-top:2px;">
                            BERLAKU 2 ORANG
                          </div>

                          <div style="font-size:9px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:#64748b;margin-top:8px;">
                            TANGGAL · PUKUL
                          </div>
                          <div style="font-size:11px;font-weight:700;color:#1e293b;margin-top:2px;">
                            06 DES 2026 · 05.30 WIB
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td style="padding-top:8px;border-top:1px solid #cbd5e1;text-align:center;">
                          <div style="font-size:8.5px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:#64748b;margin-bottom:4px;">
                            NOMOR TIKET
                          </div>
                          <div style="background:#f8fafc;border:1px solid #94a3b8;border-radius:4px;padding:6px 6px;font-family:'Courier New',Courier,monospace;font-size:11.5px;font-weight:800;letter-spacing:0.05em;color:#091526;">
                            {{ $ticket->number }}
                          </div>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Bottom Info Notes -->
          <tr>
            <td class="info-box-pad" style="padding:0 24px 24px;background:#ffffff;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:6px;">
                <tr>
                  <td style="padding:14px 18px;font-size:13px;line-height:1.6;color:#334155;">
                    <strong style="color:#092b4c;">Informasi Pelaksanaan:</strong><br>
                    • <strong>Hari, Tanggal:</strong> Minggu, 6 Desember 2026 · Pukul 05.30 WIB – Selesai<br>
                    • <strong>Lokasi:</strong> Lapangan Rektorat, Universitas Brawijaya<br>
                    • <strong>Ketentuan Tiket:</strong> Berlaku untuk <strong>2 orang</strong>. Tunjukkan email tiket ini kepada panitia FEB UB di lokasi acara bila diperlukan.
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td style="padding:16px 24px;background:#f7f7f4;border-top:1px solid #e2e8f0;font-size:12px;line-height:1.55;color:#5b6876;text-align:center;">
              Pesan otomatis <strong>Fakultas Ekonomi dan Bisnis Universitas Brawijaya (FEB UB)</strong><br>
              Jl. MT. Haryono No. 165, Malang · <a href="https://feb.ub.ac.id" style="color:#092b4c;text-decoration:none;font-weight:700;">feb.ub.ac.id</a>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
