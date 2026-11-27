<x-layouts.app>
<section class="monitoring-container">
    <!-- Navigation Tabs between Monitoring and Campaign -->
    <div class="monitoring-nav-tabs">
        <a href="{{ url('/monitoring') }}" class="nav-tab-item active">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            <span>Data Peserta Registrasi</span>
        </a>
        <a href="{{ url('/monitoring/campaign') }}" class="nav-tab-item">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <rect width="20" height="16" x="2" y="4" rx="2"/>
                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
            </svg>
            <span>Kampanye Email Blast</span>
        </a>
    </div>

    <!-- Header Section -->
    <div class="monitoring-header">
        <div class="header-left">
            <h1 class="monitoring-title">Peserta Terdaftar</h1>
            <p class="monitoring-desc">Data pendaftaran peserta Dies Natalis FEB UB ke-65, status verifikasi OTP, dan pengiriman tiket QR.</p>
        </div>
        <div class="header-actions">
            <a href="{{ url('/monitoring') }}" class="btn-refresh" title="Muat ulang data">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
                    <path d="M3 3v5h5"/>
                    <path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"/>
                    <path d="M16 21h5v-5"/>
                </svg>
                <span>Muat Ulang</span>
            </a>
            <form method="post" action="{{ url('/monitoring/logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="btn-logout" title="Keluar dari sesi monitoring">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </div>

    <!-- 5 KPI Stat Cards Grid -->
    <div class="monitoring-stats-grid">
        <!-- 1. Total Terdaftar -->
        <div class="stat-card stat-total">
            <div class="stat-card-icon icon-navy">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <div class="stat-card-body">
                <span class="stat-label">Total Terdaftar</span>
                <strong class="stat-number">{{ number_format($total) }}</strong>
                <span class="stat-sub">Seluruh pendaftar</span>
            </div>
        </div>

        <!-- 2. Mahasiswa Aktif -->
        <div class="stat-card stat-active">
            <div class="stat-card-icon icon-blue">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/>
                    <path d="M6 6h10"/>
                    <path d="M6 10h10"/>
                    <path d="M6 14h6"/>
                </svg>
            </div>
            <div class="stat-card-body">
                <span class="stat-label">Mahasiswa Aktif</span>
                <strong class="stat-number">{{ number_format($active) }}</strong>
                <span class="stat-sub">Civitas akademika</span>
            </div>
        </div>

        <!-- 3. Alumni -->
        <div class="stat-card stat-alumni">
            <div class="stat-card-icon icon-purple">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                    <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                </svg>
            </div>
            <div class="stat-card-body">
                <span class="stat-label">Alumni</span>
                <strong class="stat-number">{{ number_format($alumni) }}</strong>
                <span class="stat-sub">Lulusan FEB UB</span>
            </div>
        </div>

        <!-- 4. Total Civitas UB -->
        <div class="stat-card stat-sent">
            <div class="stat-card-icon icon-green">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect width="20" height="16" x="2" y="4" rx="2"/>
                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                    <path d="m16 19 2 2 4-4"/>
                </svg>
            </div>
            <div class="stat-card-body">
                <span class="stat-label">Total Terdaftar Civitas UB</span>
                <strong class="stat-number">{{ number_format($civitas) }}</strong>
                <span class="stat-sub">Pendaftaran terverifikasi</span>
            </div>
        </div>

        <!-- 5. Menunggu OTP -->
        <div class="stat-card stat-pending">
            <div class="stat-card-icon icon-amber">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                </svg>
            </div>
            <div class="stat-card-body">
                <span class="stat-label">Menunggu OTP</span>
                <strong class="stat-number">{{ number_format($pendingOtp) }}</strong>
                <span class="stat-sub">Belum selesai verifikasi</span>
            </div>
        </div>
    </div>

    <!-- Filter Card: Auto-filter tanpa perlu tombol submit -->
    <div class="monitoring-filter-card">
        <form method="get" action="{{ url('/monitoring') }}" class="filter-form-grid" id="monitoring-filter-form">
            <div class="filter-field search-field">
                <label for="filter-q" class="filter-label">Cari Peserta</label>
                <div class="input-with-icon-wrap">
                    <svg class="field-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="11" cy="11" r="8"/>
                        <path d="m21 21-4.3-4.3"/>
                    </svg>
                    <input id="filter-q" type="search" name="q" value="{{ request('q') }}" placeholder="Ketik nama, NIM, atau email untuk memfilter..." autocomplete="off">
                </div>
            </div>

            <div class="filter-field">
                <label for="filter-type" class="filter-label">Kategori</label>
                <select id="filter-type" name="type" class="filter-select" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    <option value="active_student" @selected(request('type') === 'active_student')>Mahasiswa Aktif</option>
                    <option value="alumni" @selected(request('type') === 'alumni')>Alumni</option>
                    <option value="civitas_ub" @selected(request('type') === 'civitas_ub')>Civitas UB</option>
                </select>
            </div>

            <div class="filter-field">
                <label for="filter-mail" class="filter-label">Status Email Tiket</label>
                <select id="filter-mail" name="mail" class="filter-select" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="sent" @selected(request('mail') === 'sent')>Terkirim</option>
                    <option value="pending" @selected(request('mail') === 'pending')>Belum/gagal</option>
                </select>
            </div>

            @if(request('q') || request('type') || request('mail'))
                <div class="filter-actions-wrap">
                    <a href="{{ url('/monitoring') }}" class="btn-filter-reset" title="Hapus semua filter">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <line x1="18" y1="6" x2="6" y2="18"/>
                            <line x1="6" y1="6" x2="18" y2="18"/>
                        </svg>
                        <span>Reset Filter</span>
                    </a>
                </div>
            @endif
        </form>
    </div>

    <!-- Table Card: Fit layar tanpa scroll horizontal kanan-kiri -->
    <div class="monitoring-table-card">
        <div class="table-card-header">
            <div class="table-header-left">
                <h2 class="table-title">Daftar Peserta</h2>
                <span class="table-count-badge">Total {{ number_format($tickets->total()) }} peserta</span>
            </div>
        </div>

        <div class="modern-table-wrap">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">No.</th>
                        <th style="width: 15%;">Peserta</th>
                        <th style="width: 12%;">NIM</th>
                        <th style="width: 13%;">Kategori</th>
                        <th style="width: 17%;">Program Studi</th>
                        <th style="width: 18%;">Kontak</th>
                        <th style="width: 10%;">Status OTP</th>
                        <th style="width: 10%;">Status Email</th>
                        <th>Status Scan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $ticket)
                        <tr class="{{ $ticket->verified && $ticket->checked_in_at ? 'ticket-scanned' : '' }}">
                            <td>{{ $loop->iteration + (($tickets->currentPage() - 1) * $tickets->perPage()) }}</td>
                            <td>
                                <div class="participant-col">
                                    <strong class="participant-name-text">{{ $ticket->name }}</strong>
                                </div>
                            </td>
                            <td>
                                <span class="nim-pill">{{ $ticket->nim }}</span>
                            </td>
                            <td>
                                @if($ticket->registration_type === 'alumni')<span class="category-pill pill-alumni">Alumni FEB UB</span>@elseif($ticket->registration_type === 'civitas_ub')<span class="category-pill pill-student">Civitas UB</span>@else<span class="category-pill pill-student">Mahasiswa Aktif FEB UB</span>@endif
                            </td>
                            <td>
                                <span class="prodi-name">{{ $ticket->study_program }}</span>
                            </td>
                            <td>
                                <div class="contact-col">
                                    <span class="contact-email">{{ $ticket->email }}</span>
                                    <span class="contact-phone">{{ $ticket->phone }}</span>
                                </div>
                            </td>
                            <td>
                                @if($ticket->verified)
                                    <span class="status-pill-badge pill-verified">Sudah diverifikasi</span>
                                @elseif($ticket->otp_expires_at->isPast())
                                    <span class="status-pill-badge pill-failed">OTP kedaluwarsa</span>
                                @else
                                    <span class="status-pill-badge">Menunggu OTP</span>
                                @endif
                            </td>
                            <td>
                                @if(!$ticket->verified)
                                    <span class="status-pill-badge">Belum diterbitkan</span>
                                @elseif($ticket->emailed_at)
                                    <div class="mail-status-wrap">
                                        <span class="status-pill-badge pill-sent">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                                            <span>Terkirim</span>
                                        </span>
                                        <small class="mail-date">{{ $ticket->emailed_at->timezone('Asia/Jakarta')->format('d M H:i') }}</small>
                                    </div>
                                @else
                                    <span class="status-pill-badge pill-failed">
                                        <span>Belum/gagal</span>
                                    </span>
                                @endif
                            </td>
                            <td>@if(!$ticket->verified)<span>—</span>@elseif($ticket->checked_in_at)<span class="status-pill-badge pill-verified">Sudah dipindai</span><small class="mail-date">{{ $ticket->checked_in_at->timezone('Asia/Jakarta')->format('d M H:i') }}</small>@else<span class="status-pill-badge">Belum dipindai</span>@endif</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="empty-table-state">
                                <div class="empty-wrap">
                                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <circle cx="11" cy="11" r="8"/>
                                        <path d="m21 21-4.3-4.3"/>
                                    </svg>
                                    <strong>Tidak ada data peserta</strong>
                                    <p>Belum ada peserta yang cocok dengan kriteria pencarian atau filter.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-pagination-footer">
            <div class="table-footer-info">
                @if($tickets->total() > 0)
                    @if($tickets->firstItem() === $tickets->lastItem())
                        Menampilkan <strong>{{ $tickets->firstItem() }}</strong> dari <strong>{{ $tickets->total() }}</strong> data peserta
                    @else
                        Menampilkan <strong>{{ $tickets->firstItem() }}–{{ $tickets->lastItem() }}</strong> dari <strong>{{ $tickets->total() }}</strong> data peserta
                    @endif
                @else
                    Menampilkan <strong>0</strong> data peserta
                @endif
            </div>

            @if($tickets->hasPages())
                <div class="table-footer-pagination">
                    {{ $tickets->links('pagination::default') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Script auto-filter saat user mengetik di pencarian -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var searchInput = document.getElementById('filter-q');
        if (!searchInput) return;
        var timer;
        searchInput.addEventListener('input', function () {
            clearTimeout(timer);
            timer = setTimeout(function () {
                searchInput.form.submit();
            }, 500);
        });
        searchInput.addEventListener('search', function () {
            searchInput.form.submit();
        });
    });
    </script>
</section>
</x-layouts.app>
