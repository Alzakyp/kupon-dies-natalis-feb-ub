<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tiket Grand Fiesta FEB UB — Civitas UB</title>
</head>
<body style="margin:0;padding:0;background:#e6eaf0;color:#0f172a;font-family:Arial,Helvetica,sans-serif;-webkit-font-smoothing:antialiased;">
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#e6eaf0;">
    <tr>
      <td align="center" style="padding:32px 12px;">
        <!-- Subtle Intro Header above Ticket -->
        <table role="presentation" width="640" cellpadding="0" cellspacing="0" border="0" style="max-width:640px;width:100%;margin-bottom:14px;">
          <tr>
            <td style="font-size:13px;color:#334155;line-height:1.5;">
              <strong style="color:#092b4c;">Tiket Resmi Civitas UB</strong> · Berlaku untuk <strong>2 Orang</strong>
            </td>
            <td align="right" style="font-size:12px;font-weight:700;color:#092b4c;">
              FEB UB · Dies Natalis 65
            </td>
          </tr>
        </table>

        <!-- Horizontal Concert Ticket / Boarding Pass (No Yellow Border) -->
        <table role="presentation" width="640" cellpadding="0" cellspacing="0" border="0" style="max-width:640px;width:100%;border-radius:10px;overflow:hidden;box-shadow:0 18px 38px rgba(9,21,38,0.22);background:#0b1320;">
          <tr>
            <!-- LEFT: Dark Main Ticket Body -->
            <td width="445" valign="top" style="background:#0b1320;background-image:linear-gradient(135deg,#071426 0%,#0d1f38 55%,#09111e 100%);padding:18px 20px 14px;color:#ffffff;">
              <!-- Top Row: FEB UB White-Text Logo + Ticket ID -->
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:12px;">
                <tr>
                  <td valign="middle">
                    <img src="{{ asset('images/logo-feb-ub.png') }}" alt="Fakultas Ekonomi dan Bisnis Universitas Brawijaya" height="32" style="display:block;height:32px;width:auto;">
                  </td>
                  <td valign="middle" align="right" style="font-family:'Courier New',Courier,monospace;font-size:12.5px;font-weight:700;letter-spacing:0.06em;color:#f1f5f9;">
                    {{ $ticket->number }}
                  </td>
                </tr>
              </table>

              <!-- Middle Row: Band KOTAK + Event Title -->
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td width="175" valign="bottom" style="padding-right:12px;">
                    <img src="{{ asset('images/band-kotak-hd.png') }}" alt="Band KOTAK" width="175" style="display:block;width:175px;max-width:100%;height:auto;">
                  </td>
                  <td valign="middle" style="padding-bottom:6px;">
                    <div style="font-size:10.5px;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;color:#f43f5e;margin-bottom:2px;">
                      DIES NATALIS KE-65 FEB UB
                    </div>
                    <div style="font-family:Georgia,'Times New Roman',serif;font-style:italic;font-size:32px;font-weight:700;line-height:1.05;color:#ffffff;margin-bottom:4px;">
                      Grand Fiesta
                    </div>
                    <div style="font-size:12px;font-weight:900;letter-spacing:0.06em;text-transform:uppercase;color:#facc15;margin-bottom:12px;">
                      FEB UNITY CONCERT · BAND KOTAK
                    </div>

                    <div style="font-size:16px;font-weight:800;letter-spacing:0.04em;color:#facc15;margin-bottom:3px;">
                      06.12.2026
                    </div>
                    <div style="font-size:10.5px;font-weight:600;letter-spacing:0.03em;color:#e2e8f0;line-height:1.4;text-transform:uppercase;">
                      LAPANGAN REKTORAT UB · 05.30 WIB<br>
                      BERLAKU 2 ORANG · CIVITAS UB
                    </div>
                  </td>
                </tr>
              </table>

              <!-- Bottom Strip inside Dark Section -->
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top:10px;padding-top:10px;border-top:1px solid rgba(255,255,255,0.14);">
                <tr>
                  <td valign="middle" style="font-size:10.5px;font-weight:600;color:#cbd5e1;letter-spacing:0.03em;">
                    PESERTA: <strong style="color:#ffffff;">{{ $ticket->manual_identity['name'] ?? 'Civitas UB' }}</strong>
                  </td>
                </tr>
              </table>
            </td>

            <!-- RIGHT: Light Cool-Grey Tear-Off Stub -->
            <td width="195" valign="top" style="background:#e2e6ec;border-left:2px dashed #94a3b8;padding:16px 16px 14px;color:#0f172a;">
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
                          <img src="{{ asset('images/logo-lustrum-65-clean.png') }}" alt="65 FEB UB" width="36" height="36" style="display:block;width:36px;height:36px;object-fit:contain;">
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
                    <div style="background:#ffffff;border:1px solid #94a3b8;border-radius:4px;padding:6px 6px;font-family:'Courier New',Courier,monospace;font-size:11.5px;font-weight:800;letter-spacing:0.05em;color:#091526;">
                      {{ $ticket->number }}
                    </div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>

        <!-- Clean Footer Below Ticket -->
        <table role="presentation" width="640" cellpadding="0" cellspacing="0" border="0" style="max-width:640px;width:100%;margin-top:16px;">
          <tr>
            <td style="font-size:12px;line-height:1.55;color:#475569;text-align:center;">
              Simpan email tiket ini dan tunjukkan kepada panitia <strong>FEB UB</strong> di lokasi acara bila diperlukan.<br>
              Fakultas Ekonomi dan Bisnis Universitas Brawijaya · <a href="https://feb.ub.ac.id" style="color:#092b4c;text-decoration:none;font-weight:700;">feb.ub.ac.id</a>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
