<x-layouts.app>
<section class="auth-shell">
    <div class="auth-header">
        <div class="auth-eyebrow-wrap">
            <p class="eyebrow">Pendaftaran peserta</p>
            <span class="edition-badge">Lustrum XIII</span>
        </div>
        <h1 class="auth-title">Dies Natalis FEB UB ke-65</h1>
        <p class="auth-location">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                <circle cx="12" cy="10" r="3"/>
            </svg>
            Ruang Kepegawaian Gedung Utama Lt. 2
        </p>
    </div>

    @if(!config('app.registration_open') || !config('app.registration_mail_verified') || !$available)
        <div class="empty-state-notice">
            <div class="empty-icon-wrap" aria-hidden="true">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" x2="12" y1="8" y2="12"/>
                    <line x1="12" x2="12.01" y1="16" y2="16"/>
                </svg>
            </div>
            <p class="notice error">Pendaftaran belum dibuka atau kupon acara habis.</p>
        </div>
    @elseif(session('registration_pending'))
        <div class="flow-step-card otp-step-card">
            <div class="step-badge">Langkah 3 dari 3 • Verifikasi OTP</div>
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
                    <p class="section-sub">Kupon dan tiket kegiatan Dies Natalis FEB UB ke-65 akan dikirimkan langsung ke email Anda setelah verifikasi OTP.</p>
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
                    <span class="step-pill">Langkah 1 dari 3</span>
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
                            <span class="card-title">Mahasiswa Aktif</span>
                            <span class="card-desc">Civitas Akademika Aktif FEB UB</span>
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
                            <span class="card-title">Alumni</span>
                            <span class="card-desc">Lulusan / Alumni FEB UB</span>
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
                            <p class="lookup-prompt">Masukkan NIM Anda saat menempuh studi di FEB UB untuk mencocokkan data alumni.</p>
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
                                <small class="form-hint">Sistem akan mencocokkan data Nama, Jenjang, dan Program Studi alumni.</small>
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
                        if (panelActive) {
                            panelActive.classList.remove('panel-visible');
                            panelActive.classList.add('panel-hidden');
                        }
                        if (panelAlumni) {
                            panelAlumni.classList.remove('panel-hidden');
                            panelAlumni.classList.add('panel-visible');
                        }
                        var inpAlumni = document.getElementById('nim-input-alumni');
                        if (inpAlumni) inpAlumni.focus();
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
</section>
</x-layouts.app>
