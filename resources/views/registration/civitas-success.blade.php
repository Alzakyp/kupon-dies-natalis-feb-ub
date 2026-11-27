<x-layouts.app>
    <section class="auth-shell success-shell">
        <div class="success-hero-header">
            <div class="success-icon-wrapper">
                <div class="success-badge-circle">
                    <svg class="success-check-svg" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="4.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <polyline class="success-check-path" points="14 25 21 32 34 17"></polyline>
                    </svg>
                </div>
            </div>

            <div class="success-eyebrow-pill">
                <span>Tiket Civitas UB Terbit</span>
            </div>
            <h1 class="success-title">Pendaftaran Civitas UB berhasil</h1>
            <p class="success-subtitle">Terima kasih, {{ $ticket->manual_identity['name'] ?? 'Civitas UB' }}. Kepesertaan Anda untuk Grand Fiesta — Dies Natalis FEB UB ke-65 telah tercatat di sistem.</p>
        </div>

        <div class="ticket-success-card">
            <div class="ticket-header-strip">
                <span>BOARDING PASS · GRAND FIESTA 2026</span>
                <span class="lustrum-tag">CIVITAS UB · 2 ORANG</span>
            </div>
            <div class="ticket-body-content">
                <div class="ticket-participant-info">
                    <div class="participant-item">
                        <small>Nama Peserta</small>
                        <strong>{{ $ticket->manual_identity['name'] ?? 'Civitas UB' }}</strong>
                    </div>
                    <div class="participant-item">
                        <small>Nomor Tiket</small>
                        <strong>{{ $ticket->number }}</strong>
                    </div>
                    <div class="participant-item">
                        <small>Ketentuan Masuk</small>
                        <strong>Berlaku untuk 2 Orang</strong>
                    </div>
                </div>

                <div class="email-dispatch-notice">
                    <div class="icon-box" aria-hidden="true">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="20" height="16" x="2" y="4" rx="2"/>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                        </svg>
                    </div>
                    <div>
                        @if($ticket->emailed_at)
                            Tiket resmi (format <strong>boarding pass</strong>) sudah dikirim ke: <strong>{{ $ticket->email }}</strong>. Silakan periksa Inbox dan Spam.
                        @else
                            Pendaftaran berhasil, tetapi email tiket belum berhasil dikirim ke <strong>{{ $ticket->email }}</strong>. Hubungi PSIK FEB UB untuk bantuan.
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="success-guide-grid">
            <div class="guide-step-card">
                <div class="guide-icon-badge guide-badge-next" aria-hidden="true">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"/>
                        <path d="M13 5v2"/>
                        <path d="M13 17v2"/>
                        <path d="M13 11v2"/>
                    </svg>
                </div>
                <div class="guide-step-body">
                    <small>Tiket Langsung (Tanpa QR)</small>
                    <h4>Simpan Email Boarding Pass Anda</h4>
                    <p>Untuk kategori Civitas UB, Anda tidak perlu menukar kupon fisik maupun memindai QR. Simpan email tiket dan tunjukkan kepada panitia di lokasi bila diperlukan.</p>
                </div>
            </div>

            <div class="guide-step-card">
                <div class="guide-icon-badge guide-badge-event" aria-hidden="true">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                        <line x1="16" x2="16" y1="2" y2="6"/>
                        <line x1="8" x2="8" y1="2" y2="6"/>
                        <line x1="3" x2="21" y1="10" y2="10"/>
                    </svg>
                </div>
                <div class="guide-step-body">
                    <small>Hari Acara</small>
                    <h4>Grand Fiesta — Fun Walk &amp; FEB Unity Concert</h4>
                    <p>Minggu, 6 Desember 2026 · Pukul 05.30 WIB–selesai · Lapangan Rektorat Universitas Brawijaya.</p>
                </div>
            </div>
        </div>

        <div class="success-action-buttons">
            <button type="button" class="button btn-print-action" onclick="window.print()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect width="12" height="8" x="6" y="14"/></svg>
                <span>Cetak / Simpan Bukti</span>
            </button>
            <a href="{{ url('/daftar?reset=1') }}" class="button btn-print-action">Kembali ke Pendaftaran</a>
        </div>
    </section>
</x-layouts.app>
