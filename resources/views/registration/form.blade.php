<x-layouts.app>
<section class="auth-shell">
<p class="eyebrow">Pendaftaran peserta</p><h1>Dies Natalis FEB UB ke-65</h1>
<p>Ruang Kepegawaian Gedung Utama Lt. 2</p>
@if(!config('app.registration_open') || !config('app.registration_mail_verified') || !$available)
<p class="notice error">Pendaftaran belum dibuka atau kupon acara habis.</p>
@elseif(session('registration_pending'))
<form method="post" action="{{ url('/daftar') }}">@csrf
<label>Kode OTP email<input name="otp" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" required autofocus></label>
<button>Daftar & Kirim Tiket</button></form>
<form method="post" action="{{ url('/daftar/otp/resend') }}">@csrf<button type="submit">Kirim ulang OTP</button></form>
@elseif($student)
<div class="summary-card">
<div><small>Kategori</small><p>{{ $student->registration_type === 'active_student' ? 'Mahasiswa Aktif' : 'Alumni' }}</p></div>
<div><small>NIM</small><p>{{ $student->nim }}</p></div>
<div><small>Nama</small><p>{{ $student->name }}</p></div>
<div><small>Jenjang</small><p>{{ $student->education_level }}</p></div>
<div><small>Program Studi</small><p>{{ $student->study_program ?? '—' }}</p></div>
</div>
<form method="post" action="{{ url('/daftar/otp') }}">@csrf
<label>Email aktif<input type="email" name="email" required autocomplete="email"></label>
<label>Nomor HP<input type="tel" name="phone" required autocomplete="tel" placeholder="0812..."></label>
<button>Kirim OTP</button></form>
@else
<div class="filters" aria-label="Kategori pendaftaran">
<a href="{{ url('/daftar').'?type=active_student' }}" @if(request('type') === 'active_student') aria-current="page" @endif>Mahasiswa Aktif</a>
<a href="{{ url('/daftar').'?type=alumni' }}" @if(request('type') === 'alumni') aria-current="page" @endif>Alumni</a>
</div>
@if(in_array(request('type'), ['active_student', 'alumni'], true))
@if(request('type') === 'alumni' && !\App\Models\StudentRegistry::where('registration_type', 'alumni')->exists())
<p class="notice">Pendaftaran alumni belum tersedia. Data alumni sedang disiapkan.</p>
@else
<form method="post" action="{{ url('/daftar/lookup') }}">@csrf
<input type="hidden" name="type" value="{{ request('type') }}">
<label>NIM<input name="nim" value="{{ old('nim') }}" maxlength="30" required autocomplete="off" inputmode="numeric"></label>
<button>Cek NIM</button></form>
@endif
@endif
@endif
</section>
</x-layouts.app>
