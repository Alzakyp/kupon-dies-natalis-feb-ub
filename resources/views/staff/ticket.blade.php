<x-layouts.app>
    <div class="ticket-detail-container">
        <div class="ticket-header-nav">
            <a href="{{ url('/staff/scan') }}" class="btn-back-scanner">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <line x1="19" y1="12" x2="5" y2="12"/>
                    <polyline points="12 19 5 12 12 5"/>
                </svg>
                <span>Kembali ke Scanner QR</span>
            </a>
            <span class="ticket-nav-badge">Meja Registrasi</span>
        </div>

        <div class="ticket-title-header">
            <p class="eyebrow">Detail peserta</p>
            <div class="ticket-num-row">
                <h1>{{ $ticket->number }}</h1>
                @if($ticket->checked_in_at)
                    <span class="status-pill status-active">
                        <span class="status-dot"></span> Sudah check-in
                    </span>
                @else
                    <span class="status-pill status-warning">
                        <span class="status-dot-warning"></span> Belum check-in
                    </span>
                @endif
            </div>
        </div>

        <!-- Status Alert Banner -->
        @if(!$ticket->checked_in_at)
            <div class="checkin-notice-banner notice-pending">
                <div class="notice-icon" aria-hidden="true">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" x2="12" y1="8" y2="12"/>
                        <line x1="12" x2="12.01" y1="16" y2="16"/>
                    </svg>
                </div>
                <div class="notice-content">
                    <strong>Tiket Belum Dikonfirmasi Check-in</strong>
                    <p>Periksa identitas peserta di bawah ini. Jika data sesuai, tekan tombol <strong>"Konfirmasi check-in"</strong> untuk mencatat kehadiran peserta dan membuka akses cetak kupon fisik.</p>
                </div>
            </div>
        @else
            <div class="checkin-notice-banner notice-success">
                <div class="notice-icon icon-success" aria-hidden="true">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                </div>
                <div class="notice-content">
                    <strong>Check-in Berhasil Divalidasi</strong>
                    <p>Peserta telah check-in pada <strong>{{ $ticket->checked_in_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB</strong>{{ $ticket->checkedInBy ? ' oleh '.$ticket->checkedInBy->name : '' }}. Kupon dapat dicetak langsung ke printer registrasi.</p>
                </div>
            </div>
        @endif

        <!-- Card Identitas Peserta -->
        <div class="ticket-card participant-card">
            <div class="ticket-card-header">
                <div class="card-header-left">
                    <div class="header-icon-bubble" aria-hidden="true">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                    <div>
                        <h2>Identitas Peserta Terdaftar</h2>
                        <p class="card-subtitle">Data resmi peserta yang tersinkronisasi dari pangkalan data FEB UB.</p>
                    </div>
                </div>
                <span class="badge-tag">{{ $ticket->registration_type === 'active_student' ? 'Mahasiswa Aktif' : ($ticket->registration_type === 'alumni' ? 'Alumni' : 'Umum') }}</span>
            </div>

            <div class="participant-name-banner">
                <span class="verified-subcaption">Nama Lengkap</span>
                <h3 class="participant-fullname">{{ $ticket->studentRegistry?->name ?? 'Nama Belum Terdata' }}</h3>
            </div>

            <div class="summary-card participant-details-grid">
                <!-- Program Studi Highlight -->
                <div class="summary-item highlight-prodi">
                    <small>Program Studi</small>
                    <p class="prodi-text">{{ $ticket->studentRegistry?->study_program ?? 'Fakultas Ekonomi dan Bisnis' }}</p>
                </div>

                <!-- NIM -->
                <div class="summary-item">
                    <small>NIM</small>
                    <p><span class="badge-mono">{{ $ticket->studentRegistry?->nim ?? '—' }}</span></p>
                </div>

                <!-- Jenjang -->
                <div class="summary-item">
                    <small>Jenjang</small>
                    <p>{{ $ticket->studentRegistry?->education_level ?? '—' }}</p>
                </div>

                <!-- Kategori -->
                <div class="summary-item">
                    <small>Kategori</small>
                    <p>{{ $ticket->registration_type === 'active_student' ? 'Mahasiswa Aktif' : 'Alumni' }}</p>
                </div>

                <!-- Email -->
                <div class="summary-item">
                    <small>Email</small>
                    <p class="mono-truncate">{{ $ticket->email }}</p>
                </div>

                <!-- Nomor HP -->
                <div class="summary-item">
                    <small>Nomor HP</small>
                    <p>{{ $ticket->phone }}</p>
                </div>

                <!-- Status Check-in -->
                <div class="summary-item">
                    <small>Status</small>
                    <p>{{ $ticket->checked_in_at ? 'Sudah check-in · '.$ticket->checked_in_at->timezone('Asia/Jakarta')->format('d M Y H:i').' WIB' : 'Belum check-in' }}</p>
                </div>

                <!-- Permintaan Cetak -->
                <div class="summary-item">
                    <small>Permintaan cetak</small>
                    <p><strong>{{ $ticket->print_requests }}</strong> kali cetak</p>
                </div>
            </div>
        </div>

        <!-- Kupon Fisik Allocation Card -->
        <div class="ticket-card coupon-info-card">
            <div class="ticket-card-header">
                <div class="card-header-left">
                    <div class="header-icon-bubble icon-gold" aria-hidden="true">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="20" height="14" x="2" y="5" rx="2"/>
                            <line x1="2" x2="22" y1="10" y2="10"/>
                        </svg>
                    </div>
                    <div>
                        <h2>Alokasi Kupon Acara</h2>
                        <p class="card-subtitle">Kupon fisik yang terikat secara unik dengan tiket peserta ini.</p>
                    </div>
                </div>
                <span class="badge-tag">{{ $ticket->coupon->batch->name ?? 'Batch Acara' }}</span>
            </div>

            <div class="coupon-code-display">
                <small>Kupon</small>
                <div class="coupon-code-pill">{{ $ticket->coupon->code }}</div>
            </div>
        </div>

        <!-- Tombol Aksi Check-in & Cetak -->
        <div class="ticket-action-box">
            @if(!$ticket->checked_in_at)
                <form method="post" action="{{ url('/staff/tickets/'.$ticket->id.'/check-in') }}" class="action-submit-form">
                    @csrf
                    <button type="submit" class="btn-primary btn-block btn-checkin">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        <span>Konfirmasi check-in</span>
                    </button>
                </form>
            @else
                <div class="checkedin-actions-row">
                    <form method="post" action="{{ url('/staff/tickets/'.$ticket->id.'/print') }}" class="action-submit-form flex-1">
                        @csrf
                        <button type="submit" class="btn-primary btn-block btn-print">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <polyline points="6 9 6 2 18 2 18 9"/>
                                <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                                <rect width="12" height="8" x="6" y="14"/>
                            </svg>
                            <span>{{ $ticket->print_requests ? 'Konfirmasi cetak ulang' : 'Siapkan cetak kupon' }}</span>
                        </button>
                    </form>

                    <a href="{{ url('/staff/tickets/'.$ticket->id.'/print') }}" class="btn-action-outline btn-view-print">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                        <span>Pratinjau Cetak</span>
                    </a>
                </div>
            @endif

            <div class="scan-next-wrap">
                <a href="{{ url('/staff/scan') }}" class="link-scan-next">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="12" r="10"/>
                        <polygon points="10 8 16 12 10 16 10 8"/>
                    </svg>
                    <span>Scan tiket berikutnya</span>
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
