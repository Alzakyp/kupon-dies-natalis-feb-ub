<x-layouts.app>
<section class="auth-shell"><p class="eyebrow">Pendaftaran peserta</p><h1>Dies Natalis FEB UB ke-65</h1><p>Ruang Kepegawaian Gedung Utama Lt. 2</p>
@if(!config('app.registration_open') || !config('app.registration_mail_verified') || !$available)<p class="notice error">Pendaftaran belum dibuka atau kupon acara habis.</p>@elseif(!session('registration_pending'))
<form method="post" action="{{ url('/daftar/otp') }}">@csrf<label>Email aktif<input type="email" name="email" required autocomplete="email"></label><label>Nomor HP<input type="tel" name="phone" required autocomplete="tel" placeholder="0812..."></label><button>Kirim OTP</button></form>
@else
<form method="post" action="{{ url('/daftar') }}">@csrf<label>Kode OTP email<input name="otp" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" required autofocus></label><button>Daftar & Kirim Tiket</button></form><form method="post" action="{{ url('/daftar/otp/resend') }}">@csrf<button type="submit" class="link-button">Kirim ulang OTP</button></form>
@endif</section></x-layouts.app>
