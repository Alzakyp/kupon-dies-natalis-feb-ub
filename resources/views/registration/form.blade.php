<x-layouts.app>
<section class="auth-shell">
    <div class="auth-header">
        <div class="poster-badge-row">
            <span class="eyebrow-tag">PENDAFTARAN PESERTA</span>
            <span class="private-event-stamp" title="Khusus Warga FEB UB">PRIVATE EVENT</span>
        </div>

        <div class="poster-title-box">
            <span class="event-brand-sub">FAKULTAS EKONOMI DAN BISNIS UNIVERSITAS BRAWIJAYA</span>
            <h1 class="poster-main-title">
                <span class="title-sub">FEB UB</span>
                <span class="title-highlight">GRAND FIESTA</span>
            </h1>
            <p class="poster-tagline">Fun Walk &amp; FEB Unity Concert</p>
        </div>

        <!-- Animated Cartoon Festival Illustration -->
        <div class="event-illustration-wrap">
            <img class="event-illustration" src="{{ asset('images/event-illustration.svg').'?v=4' }}" alt="Ilustrasi Festival Kartun FEB UB Grand Fiesta" width="760" height="300">
        </div>

        <!-- Poster-Style Event Information Showcase -->
        <div class="event-poster-card">
            <!-- Top Grid: Tanggal, Waktu & Lokasi -->
            <div class="poster-meta-grid">
                <!-- Date Badge (Desain Kalender Gantung ala Poster) -->
                <div class="meta-item calendar-card">
                    <div class="calendar-header">TANGGAL</div>
                    <div class="calendar-body">
                        <span class="cal-day">6</span>
                        <div class="cal-details">
                            <strong class="cal-month">DESEMBER</strong>
                            <span class="cal-year">2026</span>
                        </div>
                    </div>
                    <div class="calendar-time">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <span>05.30 WIB – Selesai</span>
                    </div>
                </div>

                <!-- Venue Location Badge -->
                <div class="meta-item venue-card">
                    <div class="venue-label">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                        <span>LOKASI ACARA</span>
                    </div>
                    <strong class="venue-name">Lapangan Rektorat</strong>
                    <span class="venue-sub">Universitas Brawijaya</span>
                    <div class="target-attendee-pill">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        <span>Khusus Warga FEB UB</span>
                    </div>
                </div>
            </div>

            <!-- Special Guest Star: Band KOTAK Spotlight Showcase -->
            <div class="guest-star-spotlight-card">
                <div class="spotlight-top-row">
                    <span class="spotlight-badge">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        SPECIAL GUEST STAR
                    </span>
                    <span class="concert-pill">FEB UNITY CONCERT • DIES NATALIS 65</span>
                </div>

                <!-- Band Kotak Center Stage Hero Visual -->
                <div class="band-spotlight-visual">
                    <div class="band-stage-glow" aria-hidden="true"></div>
                    <picture>
                        <source srcset="{{ asset('images/band-kotak-hd.webp') }}" type="image/webp">
                        <img src="{{ asset('images/band-kotak-hd.png') }}" alt="Band Kotak (Tantri, Cella, Chua)" class="band-hero-image" width="1154" height="866" loading="eager">
                    </picture>
                </div>

                <div class="band-headline-wrap">
                    <div class="band-star-group" aria-hidden="true">
                        <span class="gold-star">⭐</span>
                    </div>
                    <div class="band-name-box">
                        <h2 class="band-rock-title">BAND KOTAK</h2>
                        <span class="band-lineup">Tantri • Cella • Chua</span>
                    </div>
                    <div class="band-star-group" aria-hidden="true">
                        <span class="gold-star">⭐</span>
                    </div>
                </div>

                <p class="band-hits-caption">
                    🎸 Pelantun Lagu Hits: <strong>Beraksi • Pelan-Pelan Saja • Masih Cinta • Terbang</strong>
                </p>

                <!-- Interactive Backsound Music Player -->
                <div class="music-player-widget">
                    <div class="player-left">
                        <button type="button" id="btn-toggle-audio" class="btn-audio-play" aria-label="Putar Lagu Beraksi - Band Kotak">
                            <span class="play-icon" id="play-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                            </span>
                            <span class="pause-icon hidden" id="pause-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><rect x="6" y="4" width="4" height="16"/><rect x="14" y="4" width="4" height="16"/></svg>
                            </span>
                            <span id="btn-audio-text">Putar Backsound</span>
                        </button>
                        <div class="audio-info">
                            <div class="audio-title-row">
                                <strong class="audio-song-name">Kotak — Beraksi</strong>
                                <span class="audio-status-pill" id="audio-status-pill">Klik untuk memutar</span>
                            </div>
                            <div class="audio-lyrics" id="audio-lyrics">
                                <span>🎤 <em>"Yang ada di sana, yang ada di sini... Semua ikut bernyanyi! Kita beraksi!"</em></span>
                            </div>
                        </div>
                    </div>

                    <div class="equalizer-bars" id="equalizer-bars" aria-hidden="true">
                        <span class="bar bar-1"></span>
                        <span class="bar bar-2"></span>
                        <span class="bar bar-3"></span>
                        <span class="bar bar-4"></span>
                        <span class="bar bar-5"></span>
                    </div>

                    <audio id="event-audio" preload="auto" loop playsinline autoplay src="{{ asset('audio/kotak-beraksi.mp3') }}"></audio>
                </div>
            </div>

            <!-- Middle: Highlights Acara Lainnya ala Poster -->
            <div class="poster-highlights-box">
                <div class="highlights-header">
                    <div class="clipboard-icon" aria-hidden="true">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/></svg>
                    </div>
                    <span class="highlights-title">RANGKAIAN ACARA LAINNYA</span>
                </div>
                <div class="event-chips-grid">
                    <div class="event-chip chip-walk">
                        <span class="chip-icon">🚶</span>
                        <span>Morning Fun Walk &amp; Morning Groove Warm-Up</span>
                    </div>
                    <div class="event-chip chip-bazar">
                        <span class="chip-icon">🎪</span>
                        <span>Pop-Up Culinary Market (Bazar)</span>
                    </div>
                    <div class="event-chip chip-walk">
                        <span class="chip-icon">🤝</span>
                        <span>Scan for Impact: FEB UB Berbagi</span>
                    </div>
                    <div class="event-chip chip-prize">
                        <span class="chip-icon">🎁</span>
                        <span>Doorprize: Ratusan Hadiah Menarik</span>
                    </div>
                    <div class="event-chip chip-prize">
                        <span class="chip-icon">🎸</span>
                        <span>Special Performance</span>
                    </div>
                </div>
            </div>

            <!-- Bottom: Strict Requirements Banner (Tegas & Jelas) -->
            <div class="poster-requirement-banner">
                <div class="req-icon" aria-hidden="true">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <div class="req-content">
                    <strong>Ketentuan Wajib Peserta:</strong>
                    <p>Pengambilan kupon fisik di lokasi <u>wajib menunjukkan KTM atau KTP asli</u>. Kupon berlaku eksklusif untuk warga FEB UB (Mahasiswa Aktif, Alumni, Dosen &amp; Tendik).</p>
                </div>
            </div>
        </div>
    </div>

    @if(!config('app.registration_open') || !config('app.registration_mail_verified'))
        <div class="empty-state-notice">
            <div class="empty-icon-wrap" aria-hidden="true">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" x2="12" y1="8" y2="12"/>
                    <line x1="12" x2="12.01" y1="16" y2="16"/>
                </svg>
            </div>
            <p class="notice error">Pendaftaran belum dibuka.</p>
        </div>
    @elseif(session('existing_registration'))
        @php
            $registered = session('existing_registration');
        @endphp
        <div class="summary-card">
            <h2>Anda sudah terdaftar</h2>
            <div><small>Nama</small><p>{{ $registered['name'] }}</p></div>
            <div><small>NIM</small><p>{{ $registered['nim'] }}</p></div>
            <div><small>Kategori</small><p>{{ $registered['type'] === 'alumni' ? 'Alumni' : 'Mahasiswa Aktif' }}</p></div>
            <div><small>Program Studi</small><p>{{ $registered['program'] }}</p></div>
            <div><small>Email</small><p>{{ $registered['email'] }}</p></div>
            <div><small>Verifikasi OTP</small><p>Sudah diverifikasi</p></div>
            <div><small>Email QR</small><p>{{ $registered['mail_sent'] ? 'Sudah dikirim ke email tersebut. Silakan periksa Inbox dan Spam.' : 'Belum tercatat terkirim. Hubungi PSIK FEB UB.' }}</p></div>
        </div>
    @elseif(session('registration_pending'))
        <div class="flow-step-card otp-step-card">
            <div class="step-badge">Verifikasi OTP</div>
            <div class="otp-card-header">
                <div class="otp-icon-bubble" aria-hidden="true">
                    <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="20" height="16" x="2" y="4" rx="2"/>
                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                    </svg>
                </div>
                <h2>Verifikasi Kode OTP</h2>
                <p class="otp-subtitle">Kode verifikasi 6 digit telah dikirimkan ke email Anda. Silakan masukkan kode untuk mengonfirmasi penerimaan tiket.</p>
            </div>

            <form id="otp-form" method="post" action="{{ url('/daftar') }}" class="modern-form">
                @csrf
                <div class="form-group otp-form-group">
                    <label for="otp-input" class="form-label">
                        <span>Kode OTP email</span>
                        <span class="label-badge">6 Digit Angka</span>
                    </label>
                    <input id="otp-input" class="otp-input-field" name="otp" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" placeholder="••••••" required autofocus autocomplete="one-time-code" aria-describedby="otp-status">
                    <small id="otp-status" class="form-hint" role="status">Cek folder Inbox atau Spam email Anda. Form otomatis diproses setelah 6 digit terisi.</small>
                </div>
                <button id="otp-submit" type="submit" class="btn-primary btn-block">Verifikasi & Selesaikan Pendaftaran</button>
            </form>

            <div class="otp-footer-actions">
                <form method="post" action="{{ url('/daftar/otp/resend') }}" class="inline-action-form">
                    @csrf
                    @php
                        $resendAt = $pending?->otp_sent_at?->copy()->addSeconds(60)->timestamp ?? now()->timestamp;
                    @endphp
                    <button id="resend-otp" type="submit" class="btn-text" data-resend-at="{{ $resendAt }}" disabled>Kirim ulang dalam 60 detik</button>
                </form>
                <span class="action-divider" aria-hidden="true">•</span>
                <a href="{{ url('/daftar?reset=1') }}" class="btn-text text-danger">Ganti Data / Ulangi</a>
            </div>
        </div>
        <script>
        (() => {
            const input = document.getElementById('otp-input');
            const form = document.getElementById('otp-form');
            const button = document.getElementById('otp-submit');
            const status = document.getElementById('otp-status');
            const resend = document.getElementById('resend-otp');
            let submitted = false;
            const updateResend = () => {
                if (!resend) return;
                const remaining = Math.max(0, Number(resend.dataset.resendAt) - Math.floor(Date.now() / 1000));
                resend.disabled = remaining > 0;
                resend.textContent = remaining > 0 ? `Kirim ulang dalam ${remaining} detik` : 'Kirim ulang OTP';
                if (remaining > 0) setTimeout(updateResend, 1000);
            };
            updateResend();
            input?.addEventListener('input', () => {
                input.value = input.value.replace(/\D/g, '').slice(0, 6);
                if (input.value.length === 6 && !submitted && form.reportValidity()) {
                    submitted = true;
                    button.disabled = true;
                    button.textContent = 'Memverifikasi…';
                    status.textContent = 'Kode sedang diverifikasi. Mohon tunggu.';
                    form.requestSubmit();
                }
            });
        })();
        </script>
    @elseif($manualAlumni)
        <div class="flow-step-card verified-card">
            <div class="step-card-top-nav">
                <div class="step-badge step-badge-success">Data Alumni Manual</div>
                <a href="{{ url('/daftar?reset=1&type=alumni') }}" class="btn-change-nim" title="Ganti NIM jika salah input">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                    <span>Ganti NIM / Kembali</span>
                </a>
            </div>

            <h2>Lengkapi data alumni</h2>
            <p class="manual-alumni-desc">
                NIM <strong>{{ $manualAlumni['nim'] }}</strong> belum ditemukan. Isi data sesuai identitas akademik.<br>
                <span class="manual-alumni-highlight">Bagi Alumni angkatan 2003 ke bawah silahkan untuk mengisi data pendaftaran secara manual.</span>
            </p>
            <form method="post" action="{{ url('/daftar/otp') }}" class="modern-form">
                @csrf
                <div class="form-group">
                    <label for="manual-name" class="form-label">
                        <span>Nama lengkap</span>
                        <span class="label-badge">Sesuai Ijazah/KTP</span>
                    </label>
                    <input id="manual-name" name="name" value="{{ old('name') }}" required maxlength="150" placeholder="Masukkan nama lengkap Anda">
                </div>

                <div class="form-group">
                    <label for="manual-level" class="form-label">
                        <span>Jenjang</span>
                        <span class="label-badge">Wajib</span>
                    </label>
                    <select id="manual-level" name="education_level" required>
                        <option value="">Pilih jenjang</option>
                        @foreach(['Diploma','Sarjana S1','Magister S2','Doktor S3','Profesi'] as $level)
                            <option value="{{ $level }}" {{ old('education_level') === $level ? 'selected' : '' }}>{{ $level }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="manual-prodi" class="form-label">
                        <span>Program studi</span>
                        <span class="label-badge">Wajib</span>
                    </label>
                    <select id="manual-prodi" name="study_program" required>
                        <option value="">Pilih program studi</option>
                        @foreach($studyPrograms as $program)
                            <option value="{{ $program }}" {{ old('study_program') === $program ? 'selected' : '' }}>{{ $program }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="manual-email" class="form-label">
                        <span>Email aktif</span>
                        <span class="label-badge">Wajib</span>
                    </label>
                    <input type="email" id="manual-email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="nama@email.com">
                </div>

                <div class="form-group">
                    <label for="manual-phone" class="form-label">
                        <span>Nomor HP</span>
                        <span class="label-badge">WhatsApp Aktif</span>
                    </label>
                    <input type="tel" id="manual-phone" name="phone" value="{{ old('phone') }}" required autocomplete="tel" placeholder="081234567890">
                </div>

                <div class="form-actions-group">
                    <button type="submit" class="btn-primary btn-block">
                        <span>Kirim OTP</span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </button>
                    <a href="{{ url('/daftar?reset=1&type=alumni') }}" class="btn-back-secondary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M19 12H5M12 19l-7-7 7-7"/>
                        </svg>
                        <span>Kembali ke Pencarian NIM</span>
                    </a>
                </div>
            </form>
        </div>
    @elseif($student)
        <div class="flow-step-card verified-card">
            <div class="step-badge step-badge-success">Data Terverifikasi</div>
            
            <div class="verified-identity-box">
                <div class="verified-banner">
                    <div class="verified-badge-pill">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M20 6 9 17l-5-5"/>
                        </svg>
                        <span>Data Terverifikasi di Pangkalan Data FEB UB</span>
                    </div>
                    <a href="{{ url('/daftar?reset=1') }}" class="btn-change-nim" title="Ganti NIM jika bukan data Anda">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
                            <path d="M3 3v5h5"/>
                        </svg>
                        Ganti NIM
                    </a>
                </div>

                <div class="verified-header">
                    <span class="verified-label">Nama Lengkap</span>
                    <h2 class="participant-name">{{ $student->name }}</h2>
                </div>

                <div class="summary-card modern-summary-grid">
                    <div class="summary-item prodi-item highlight-prodi">
                        <small>Program Studi</small>
                        <p class="prodi-text">{{ $student->study_program ?? 'Fakultas Ekonomi dan Bisnis' }}</p>
                    </div>
                    <div class="summary-item nim-item">
                        <small>NIM</small>
                        <p><span class="badge-mono">{{ $student->nim }}</span></p>
                    </div>
                    <div class="summary-item category-item">
                        <small>Kategori</small>
                        <p><span class="badge-tag">{{ $student->registration_type === 'active_student' ? 'Mahasiswa Aktif' : 'Alumni' }}</span></p>
                    </div>
                    <div class="summary-item jenjang-item">
                        <small>Jenjang</small>
                        <p>{{ $student->education_level }}</p>
                    </div>
                </div>
            </div>

            <div class="contact-step-box">
                <div class="section-title-wrap">
                    <h3 class="section-title">Lengkapi Data Kontak</h3>
                    <p class="section-sub">Tiket QR dikirim ke email setelah verifikasi OTP. Saat pengambilan kupon, harap membawa KTM atau KTP asli.</p>
                </div>

                <form method="post" action="{{ url('/daftar/otp') }}" class="modern-form">
                    @csrf
                    <div class="form-group">
                        <label for="email-input" class="form-label">
                            <span>Email aktif</span>
                            <span class="label-badge">Wajib</span>
                        </label>
                        <div class="input-with-icon">
                            <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect width="20" height="16" x="2" y="4" rx="2"/>
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                            </svg>
                            <input type="email" id="email-input" name="email" required autocomplete="email" placeholder="nama@student.ub.ac.id atau email Anda" value="{{ old('email') }}">
                        </div>
                        <small class="form-hint">Kode OTP dan e-tiket resmi akan dikirim ke alamat email ini.</small>
                    </div>

                    <div class="form-group">
                        <label for="phone-input" class="form-label">
                            <span>Nomor HP</span>
                            <span class="label-badge">WhatsApp Aktif</span>
                        </label>
                        <div class="input-with-icon">
                            <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                            </svg>
                            <input type="tel" id="phone-input" name="phone" required autocomplete="tel" placeholder="081234567890" value="{{ old('phone') }}">
                        </div>
                        <small class="form-hint">Nomor telepon/WhatsApp aktif untuk keperluan koordinasi panitia.</small>
                    </div>

                    <button type="submit" class="btn-primary btn-block">
                        <span>Kirim OTP</span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    @else
        @php
            $selectedType = old('type', request('type', 'active_student'));
            $hasAlumni = $hasAlumniData ?? \App\Models\StudentRegistry::where('registration_type', 'alumni')->exists();
        @endphp

        <div class="registration-flow-container">
            <div class="category-selection-wrapper">
                <div class="category-header">
                    <h2 class="category-section-title">Pilih Kategori Kepesertaan</h2>
                    <p class="category-section-subtitle">Silakan pilih status kepesertaan Anda untuk memvalidasi NIM di pangkalan data FEB UB.</p>
                </div>

                <div class="filters category-cards-grid" aria-label="Kategori pendaftaran" role="tablist">
                    <a href="{{ url('/daftar').'?type=active_student' }}"
                       class="category-card {{ $selectedType === 'active_student' ? 'active' : '' }}"
                       data-category="active_student"
                       role="tab"
                       @if($selectedType === 'active_student') aria-current="page" aria-selected="true" @else aria-selected="false" @endif>
                        <div class="card-icon-badge" aria-hidden="true">
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/>
                                <path d="M6 6h10"/>
                                <path d="M6 10h10"/>
                                <path d="M6 14h6"/>
                            </svg>
                        </div>
                        <div class="card-content">
                            <span class="card-title">Mahasiswa Aktif FEB UB</span>
                        </div>
                        <div class="card-radio-indicator" aria-hidden="true">
                            <span class="radio-circle"></span>
                        </div>
                    </a>

                    <a href="{{ url('/daftar').'?type=civitas_ub' }}"
                       class="category-card {{ $selectedType === 'civitas_ub' ? 'active' : '' }}"
                       data-category="civitas_ub"
                       role="tab"
                       @if($selectedType === 'civitas_ub') aria-current="page" aria-selected="true" @else aria-selected="false" @endif>
                        <div class="card-icon-badge" aria-hidden="true">
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="18" height="14" x="3" y="5" rx="2"/>
                                <circle cx="9" cy="12" r="2"/>
                                <path d="M15 10h2"/>
                                <path d="M15 14h2"/>
                                <path d="M6.5 16.5c.7-1.2 1.6-1.5 2.5-1.5s1.8.3 2.5 1.5"/>
                            </svg>
                        </div>
                        <div class="card-content">
                            <span class="card-title">Civitas UB</span>
                        </div>
                        <div class="card-radio-indicator" aria-hidden="true">
                            <span class="radio-circle"></span>
                        </div>
                    </a>

                    <a href="{{ url('/daftar').'?type=alumni' }}"
                       class="category-card {{ $selectedType === 'alumni' ? 'active' : '' }}"
                       data-category="alumni"
                       role="tab"
                       @if($selectedType === 'alumni') aria-current="page" aria-selected="true" @else aria-selected="false" @endif>
                        <div class="card-icon-badge" aria-hidden="true">
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                                <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                            </svg>
                        </div>
                        <div class="card-content">
                            <span class="card-title">Alumni FEB UB</span>
                        </div>
                        <div class="card-radio-indicator" aria-hidden="true">
                            <span class="radio-circle"></span>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Panel for Active Student -->
            <div id="panel-active_student" class="category-panel {{ $selectedType === 'active_student' ? 'panel-visible' : 'panel-hidden' }}">
                <div class="lookup-card">
                    <div class="lookup-card-header">
                        <div class="lookup-badge-wrap">
                            <span class="lookup-badge">Validasi NIM Mahasiswa Aktif</span>
                        </div>
                        <p class="lookup-prompt">Masukkan NIM Anda untuk memeriksa data kepesertaan di sistem akademik FEB UB.</p>
                    </div>

                    <form method="post" action="{{ url('/daftar/lookup') }}" class="modern-form lookup-form">
                        @csrf
                        <input type="hidden" name="type" value="active_student">
                        <div class="form-group">
                            <label for="nim-input-active" class="form-label">
                                <span>NIM</span>
                                <span class="label-badge">Nomor Induk Mahasiswa</span>
                            </label>
                            <div class="input-with-icon">
                                <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <circle cx="11" cy="11" r="8"/>
                                    <path d="m21 21-4.3-4.3"/>
                                </svg>
                                <input id="nim-input-active" name="nim" value="{{ old('nim') }}" maxlength="30" required autocomplete="off" inputmode="numeric" placeholder="Contoh: 215020... atau 44000..." autofocus>
                            </div>
                            <small class="form-hint">Sistem akan mencocokkan data Nama, Jenjang, dan Program Studi dari database.</small>
                        </div>
                        <button type="submit" class="btn-primary btn-block btn-lookup">
                            <span>Cek NIM</span>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Panel for Civitas UB -->
            <div id="panel-civitas_ub" class="category-panel {{ $selectedType === 'civitas_ub' ? 'panel-visible' : 'panel-hidden' }}">
                <div class="lookup-card">
                    <div class="lookup-card-header">
                        <div class="lookup-badge-wrap">
                            <span class="lookup-badge">Pendaftaran Civitas UB</span>
                        </div>
                        <p class="lookup-prompt">Tiket peserta langsung dikirim ke email Anda setelah verifikasi kode OTP email UB.</p>
                    </div>

                    <form method="post" action="{{ url('/daftar/civitas/otp') }}" class="modern-form lookup-form">
                        @csrf
                        <div class="form-group">
                            <label for="civitas-name" class="form-label">
                                <span>Nama lengkap</span>
                                <span class="label-badge">Wajib</span>
                            </label>
                            <input id="civitas-name" name="name" value="{{ old('name') }}" required maxlength="150" autocomplete="name" placeholder="Masukkan nama lengkap Anda">
                        </div>

                        <div class="form-group">
                            <label for="civitas-email" class="form-label">
                                <span>Email UB</span>
                                <span class="label-badge">@ub.ac.id / @student.ub.ac.id</span>
                            </label>
                            <input type="email" id="civitas-email" name="email" value="{{ old('email') }}" required placeholder="nama@ub.ac.id atau nama@student.ub.ac.id" autocomplete="email">
                            <small class="form-hint">Khusus email resmi Universitas Brawijaya (@ub.ac.id atau @student.ub.ac.id).</small>
                        </div>

                        <div class="form-group">
                            <label for="civitas-phone" class="form-label">
                                <span>Nomor HP / WhatsApp</span>
                                <span class="label-badge">Aktif</span>
                            </label>
                            <input type="tel" id="civitas-phone" name="phone" value="{{ old('phone') }}" required autocomplete="tel" placeholder="081234567890">
                        </div>

                        <button type="submit" class="btn-primary btn-block btn-lookup">
                            <span>Kirim OTP</span>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Panel for Alumni -->
            <div id="panel-alumni" class="category-panel {{ $selectedType === 'alumni' ? 'panel-visible' : 'panel-hidden' }}">
                @if(!$hasAlumni)
                    <div class="lookup-card alumni-notice-card">
                        <div class="alumni-notice-icon" aria-hidden="true">
                            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="12" x2="12" y1="8" y2="12"/>
                                <line x1="12" x2="12.01" y1="16" y2="16"/>
                            </svg>
                        </div>
                        <h3 class="alumni-notice-title">Pendaftaran Alumni Segera Hadir</h3>
                        <p class="notice alumni-notice-text">Pendaftaran alumni belum tersedia. Data alumni sedang disiapkan.</p>
                        <p class="alumni-subnotice">Pangkalan data alumni sedang disiapkan dan disinkronisasi oleh panitia Dies Natalis FEB UB ke-65. Silakan pantau pengumuman resmi berkala.</p>
                    </div>
                @else
                    <div class="lookup-card">
                        <div class="lookup-card-header">
                            <div class="lookup-badge-wrap">
                                <span class="lookup-badge">Validasi NIM Alumni</span>
                            </div>
                            <p class="lookup-prompt">Masukkan NIM yang tertera pada Ijazah FEB UB Anda untuk mencocokkan data alumni.</p>
                        </div>

                        <form method="post" action="{{ url('/daftar/lookup') }}" class="modern-form lookup-form">
                            @csrf
                            <input type="hidden" name="type" value="alumni">
                            <div class="form-group">
                                <label for="nim-input-alumni" class="form-label">
                                    <span>NIM</span>
                                    <span class="label-badge">Nomor Induk Mahasiswa</span>
                                </label>
                                <div class="input-with-icon">
                                    <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <circle cx="11" cy="11" r="8"/>
                                        <path d="m21 21-4.3-4.3"/>
                                    </svg>
                                    <input id="nim-input-alumni" name="nim" value="{{ old('nim') }}" maxlength="30" required autocomplete="off" inputmode="numeric" placeholder="Masukkan NIM saat Anda kuliah di FEB UB">
                                </div>
                                <small class="form-hint">Sistem akan mencocokkan data Nama, Jenjang, dan Program Studi alumni. Bagi Alumni angkatan 2003 ke bawah silahkan untuk mengisi data pendaftaran secara manual jika NIM belum terdaftar.</small>
                            </div>
                            <button type="submit" class="btn-primary btn-block btn-lookup">
                                <span>Cek NIM</span>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function () {
            var cards = document.querySelectorAll('.category-card[data-category]');
            var panelActive = document.getElementById('panel-active_student');
            var panelAlumni = document.getElementById('panel-alumni');
            var panelCivitas = document.getElementById('panel-civitas_ub');

            cards.forEach(function (card) {
                card.addEventListener('click', function (e) {
                    if (e.metaKey || e.ctrlKey || e.shiftKey) return;
                    e.preventDefault();
                    var cat = card.getAttribute('data-category');
                    
                    cards.forEach(function (c) {
                        c.classList.remove('active');
                        c.removeAttribute('aria-current');
                        c.setAttribute('aria-selected', 'false');
                    });
                    card.classList.add('active');
                    card.setAttribute('aria-current', 'page');
                    card.setAttribute('aria-selected', 'true');

                    [panelActive, panelAlumni, panelCivitas].forEach(function (panel) { if (panel) { panel.classList.remove('panel-visible'); panel.classList.add('panel-hidden'); } });
                    var target = document.getElementById('panel-' + cat);
                    if (target) { target.classList.remove('panel-hidden'); target.classList.add('panel-visible'); }
                    if (cat === 'active_student') {
                        if (panelActive) {
                            panelActive.classList.remove('panel-hidden');
                            panelActive.classList.add('panel-visible');
                        }
                        if (panelAlumni) {
                            panelAlumni.classList.remove('panel-visible');
                            panelAlumni.classList.add('panel-hidden');
                        }
                        var inp = document.getElementById('nim-input-active');
                        if (inp) inp.focus();
                    } else {
                        var focusTarget = cat === 'alumni' ? document.getElementById('nim-input-alumni') : document.getElementById('civitas-name');
                        if (focusTarget) focusTarget.focus();
                    }

                    if (window.history && window.history.replaceState) {
                        var url = new URL(window.location.href);
                        url.searchParams.set('type', cat);
                        window.history.replaceState({}, '', url.toString());
                    }
                });
            });
        });
        </script>
    @endif

    <script src="{{ asset('js/event-audio.js') }}" defer></script>
</section>
</x-layouts.app>
