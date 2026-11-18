<x-layouts.app>
    <canvas id="success-confetti-canvas" class="confetti-canvas" aria-hidden="true"></canvas>

    <section class="auth-shell success-shell">
        <!-- Hero Animated Header -->
        <div class="success-hero-header">
            <div class="success-icon-wrapper" onclick="window.launchCelebration &amp;&amp; window.launchCelebration()" title="Klik untuk merayakan lagi! 🎉" role="button" tabindex="0" aria-label="Animasi perayaan">
                <div class="success-pulse-ring" aria-hidden="true"></div>
                <div class="success-badge-circle">
                    <svg class="success-check-svg" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="4.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <polyline class="success-check-path" points="14 25 21 32 34 17"></polyline>
                    </svg>
                </div>
                <span class="badge-sparkle badge-sparkle-1" aria-hidden="true">✨</span>
                <span class="badge-sparkle badge-sparkle-2" aria-hidden="true">🎉</span>
            </div>

            <div class="success-eyebrow-pill">
                <span>Pendaftaran Berhasil</span>
            </div>
            <h1 class="success-title">Grand Fiesta — Pendaftaran berhasil</h1>
            <p class="success-subtitle">Selamat! Tiket dan registrasi Anda untuk rangkaian acara Dies Natalis FEB UB ke-65 telah resmi tercatat di sistem.</p>
        </div>

        @if(isset($ticket))
            <!-- Digital Ticket Card Preview -->
            <div class="ticket-success-card">
                <div class="ticket-header-strip">
                    <span>Dies Natalis FEB UB Ke-65</span>
                    <span class="lustrum-tag">★ Grand Fiesta 2026</span>
                </div>
                <div class="ticket-body-content">
                    <div class="ticket-participant-info">
                        <div class="participant-item">
                            <small>Nama Peserta</small>
                            <strong>{{ $ticket->studentRegistry?->name ?? data_get($ticket->manual_identity, 'name', 'Peserta FEB UB') }}</strong>
                        </div>
                        @if($ticket->nim ?? $ticket->studentRegistry?->nim ?? data_get($ticket->manual_identity, 'nim'))
                            <div class="participant-item">
                                <small>NIM</small>
                                <strong>{{ $ticket->nim ?? $ticket->studentRegistry?->nim ?? data_get($ticket->manual_identity, 'nim') }}</strong>
                            </div>
                        @endif
                        <div class="participant-item">
                            <small>Kategori</small>
                            <strong>{{ $ticket->registration_type === 'active_student' ? 'Mahasiswa Aktif' : ($ticket->registration_type === 'alumni' ? 'Alumni FEB UB' : 'Umum') }}</strong>
                        </div>
                    </div>

                    <div class="email-dispatch-notice">
                        <div class="icon-box" aria-hidden="true">✉️</div>
                        <div>
                            Tiket elektronik beserta <strong>kode QR check-in resmi</strong> telah dikirim ke: <strong>{{ $ticket->email }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Staggered Next Steps & Event Information -->
        <div class="success-guide-grid">
            <!-- Langkah Berikutnya -->
            <div class="guide-step-card">
                <div class="guide-icon-badge guide-badge-next" aria-hidden="true">📬</div>
                <div class="guide-step-body">
                    <small>Langkah berikutnya</small>
                    <h4>Periksa Kotak Masuk Email Anda</h4>
                    <p>Cek email Anda untuk tiket dan QR check-in. Bila tidak ditemukan di kotak masuk utama, mohon periksa folder <em>Spam</em> atau <em>Promosi</em>.</p>
                </div>
            </div>

            <!-- Pengambilan Kupon Undian Jalan Sehat -->
            <div class="guide-step-card">
                <div class="guide-icon-badge guide-badge-coupon" aria-hidden="true">🎟️</div>
                <div class="guide-step-body">
                    <small>Pengambilan kupon undian jalan sehat</small>
                    <h4>Lokasi &amp; Jadwal Penukaran Kupon Fisik</h4>
                    <p>30 November–4 Desember 2026. Tunjukkan QR dari email dan bawa KTM atau KTP asli.</p>
                    <ol class="pickup-locations-list">
                        <li><strong>Mahasiswa aktif angkatan 2025 &amp; 2026:</strong> Ruang Tata Usaha (Gedung Utama Lt. 2)</li>
                        <li><strong>Mahasiswa aktif angkatan lainnya:</strong> Security Command Center (Gedung Dekanat Lama Lt. 1)</li>
                        <li><strong>Alumni:</strong> Ruang Kemahasiswaan Lt. 2</li>
                    </ol>
                </div>
            </div>

            <!-- Hari Acara -->
            <div class="guide-step-card">
                <div class="guide-icon-badge guide-badge-event" aria-hidden="true">🚩</div>
                <div class="guide-step-body">
                    <small>Hari acara</small>
                    <h4>Grand Fiesta &amp; FEB Unity Concert</h4>
                    <p>6 Desember 2026 · 05.30 WIB–selesai · Lapangan Rektorat UB.</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="success-action-buttons">
            <button type="button" class="button btn-celebrate-again" onclick="window.launchCelebration &amp;&amp; window.launchCelebration()">
                <span>🎉</span>
                <span>Rayakan Lagi!</span>
            </button>
            <button type="button" class="button btn-print-action" onclick="window.print()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect width="12" height="8" x="6" y="14"/></svg>
                <span>Cetak / Simpan Bukti</span>
            </button>
            <a href="{{ url('/') }}" class="button btn-print-action">
                <span>← Selesai</span>
            </a>
        </div>

        <div class="success-help-footer">
            <p class="muted">Belum menerima email? Periksa folder Spam atau hubungi petugas.</p>
        </div>
    </section>

    <script src="{{ asset('js/success-confetti.js') }}" defer></script>
</x-layouts.app>
