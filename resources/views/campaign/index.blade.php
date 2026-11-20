<x-layouts.app>
<section class="monitoring-container">
    <!-- Navigation Tabs between Monitoring and Campaign -->
    <div class="monitoring-nav-tabs">
        <a href="{{ url('/monitoring') }}" class="nav-tab-item">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            <span>Data Peserta Registrasi</span>
        </a>
        <a href="{{ url('/monitoring/campaign') }}" class="nav-tab-item active">
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
            <div class="monitoring-badge">
                <span class="live-dot"></span>
                <span>SISTEM EMAIL BLAST · DIES NATALIS 65</span>
            </div>
            <h1 class="monitoring-title">Kampanye Email Grand Fiesta</h1>
            <p class="monitoring-desc">Pusat kendali broadcast email massal, pemantauan kuota harian SMTP, antrean pengiriman, dan status penerimaan.</p>
        </div>
        <div class="header-actions">
            <a href="{{ url('/monitoring/campaign/preview') }}" class="btn-refresh" title="Lihat pratinjau template email">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>
                <span>Pratinjau Email</span>
            </a>
            <a href="{{ url('/monitoring/campaign') }}" class="btn-refresh" title="Muat ulang data">
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

    <!-- Control & 24-Hour SMTP Quota Card -->
    <div class="campaign-control-card">
        <div class="control-card-main">
            <div class="control-status-header">
                <span class="control-eyebrow">Kendali Pengiriman Batch</span>
                <div id="campaign-status" class="campaign-status-pill {{ $metrics['running'] ? 'status-running' : 'status-paused' }}" role="status">
                    @if($metrics['running'])
                        <span class="live-dot"></span>
                        <span>Pengiriman Aktif</span>
                    @else
                        <span class="pause-dot"></span>
                        <span>Pengiriman Dijeda</span>
                    @endif
                </div>
            </div>

            <p class="control-description">
                @if($metrics['running'])
                    Sistem otomatisasi sedang berjalan via background scheduler per menit. Pesan diproses maksimal 50 penerima per batch dengan jeda 3 detik.
                @else
                    Pengiriman saat ini dijeda (pause). Klik tombol di bawah untuk mengaktifkan pengiriman bertahap ke antrean email sivitas akademika &amp; alumni.
                @endif
            </p>

            <div class="control-actions-row">
                @if($metrics['running'])
                    <form method="post" action="{{ url('/monitoring/campaign/control') }}" class="control-action-form" onsubmit="return confirm('Apakah Anda yakin ingin menjeda (pause) pengiriman kampanye? Pengiriman batch berikutnya akan dihentikan; email yang sedang dikirim tetap diselesaikan.')">
                        @csrf
                        <input type="hidden" name="running" value="0">
                        <button type="submit" class="btn-campaign-ctrl btn-ctrl-pause">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect width="4" height="16" x="6" y="4"/>
                                <rect width="4" height="16" x="14" y="4"/>
                            </svg>
                            <span>Jeda Pengiriman (Pause)</span>
                        </button>
                    </form>
                @else
                    <form method="post" action="{{ url('/monitoring/campaign/control') }}" class="control-action-form" onsubmit="return confirm('Mulai jalankan pengiriman batch kampanye email sekarang?')">
                        @csrf
                        <input type="hidden" name="running" value="1">
                        <button type="submit" class="btn-campaign-ctrl btn-ctrl-start">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" stroke="none" aria-hidden="true">
                                <polygon points="6 3 20 12 6 21 6 3"/>
                            </svg>
                            <span>Mulai / Lanjutkan Pengiriman</span>
                        </button>
                    </form>
                @endif

                <a href="{{ url('/monitoring/campaign/preview') }}" class="btn-campaign-preview-card">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                    <span>Pratinjau Email</span>
                </a>
            </div>
        </div>

        <div class="control-card-quota">
            <div class="quota-header">
                <div class="quota-title-wrap">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                    <span class="quota-title">Kuota SMTP 24 Jam</span>
                </div>
                @php
                    $pct = min(100, (int) round(($metrics['attemptsToday'] / max(1, $metrics['limit'])) * 100));
                @endphp
                <span class="quota-badge {{ $pct >= 85 ? 'badge-quota-danger' : ($pct >= 60 ? 'badge-quota-warning' : 'badge-quota-safe') }}">
                    {{ $pct >= 85 ? 'Hampir Penuh' : ($pct >= 60 ? 'Waspada' : 'Aman') }}
                </span>
            </div>

            <div class="quota-meter">
                <div class="quota-bar-track">
                    <div id="quota-progress-bar" class="quota-bar-fill {{ $pct >= 85 ? 'fill-danger' : ($pct >= 60 ? 'fill-warning' : 'fill-safe') }}" style="width: {{ $pct }}%;"></div>
                </div>
                <div class="quota-meter-labels">
                    <span class="quota-meter-used">Terpakai: <strong id="quota-progress-text">{{ number_format($metrics['attemptsToday']) }} / {{ number_format($metrics['limit']) }} ({{ $pct }}%)</strong></span>
                    <span class="quota-meter-limit">Limit: 1.800 / hari</span>
                </div>
            </div>

            <div class="quota-footnote">
                <p>Maksimal 1.800 percobaan dalam rentang waktu 24 jam bergulir (termasuk retry) untuk menjaga reputasi pengiriman email domain FEB UB.</p>
                <div class="quota-live-status">
                    <span id="campaign-updated">Diperbarui {{ now()->timezone('Asia/Jakarta')->format('H.i.s') }} WIB · Diterima SMTP bukan bukti masuk Inbox.</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 6 KPI Stat Cards Grid -->
    <div class="campaign-stats-grid">
        <!-- 1. Total Sasaran -->
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
                <span class="stat-label">Total Sasaran</span>
                <strong class="stat-number" data-metric="total">{{ number_format($metrics['total']) }}</strong>
                <span class="stat-sub">Database penerima blast</span>
            </div>
        </div>

        <!-- 2. Diterima SMTP -->
        <div class="stat-card stat-sent">
            <div class="stat-card-icon icon-green">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
            </div>
            <div class="stat-card-body">
                <span class="stat-label">Diterima SMTP</span>
                <strong class="stat-number" data-metric="sent">{{ number_format($metrics['sent']) }}</strong>
                <span class="stat-sub">Email berhasil keluar relay</span>
            </div>
        </div>

        <!-- 3. Antrean / Mengirim -->
        <div class="stat-card stat-active">
            <div class="stat-card-icon icon-blue">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <line x1="22" y1="2" x2="11" y2="13"/>
                    <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                </svg>
            </div>
            <div class="stat-card-body">
                <span class="stat-label">Antrean &amp; Proses</span>
                <strong class="stat-number" data-metric="queued">{{ number_format($metrics['queued']) }}</strong>
                <span class="stat-sub">Dalam queue worker aktif</span>
            </div>
        </div>

        <!-- 4. Belum Terkirim -->
        <div class="stat-card stat-alumni">
            <div class="stat-card-icon icon-purple">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                </svg>
            </div>
            <div class="stat-card-body">
                <span class="stat-label">Belum Terkirim</span>
                <strong class="stat-number" data-metric="remaining">{{ number_format($metrics['remaining']) }}</strong>
                <span class="stat-sub">Draft &amp; jadwal antrean</span>
            </div>
        </div>

        <!-- 5. Gagal Kirim -->
        <div class="stat-card stat-failed-card">
            <div class="stat-card-icon icon-red">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            </div>
            <div class="stat-card-body">
                <span class="stat-label">Gagal Kirim</span>
                <strong class="stat-number" data-metric="failed">{{ number_format($metrics['failed']) }}</strong>
                <span class="stat-sub">Maks. 3x retry otomatis</span>
            </div>
        </div>

        <!-- 6. Percobaan 24 Jam -->
        <div class="stat-card stat-pending">
            <div class="stat-card-icon icon-amber">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect width="20" height="14" x="2" y="5" rx="2"/>
                    <line x1="2" y1="10" x2="22" y2="10"/>
                </svg>
            </div>
            <div class="stat-card-body">
                <span class="stat-label">Percobaan 24 Jam</span>
                <strong class="stat-number" data-metric="attemptsToday">{{ number_format($metrics['attemptsToday']) }}</strong>
                <span class="stat-sub">Batas: {{ number_format($metrics['limit']) }} / hari</span>
            </div>
        </div>
    </div>

    <!-- Filter Card: Auto-filter pencarian & status penerima -->
    <div class="monitoring-filter-card">
        <form method="get" action="{{ url('/monitoring/campaign') }}" class="filter-form-grid" id="campaign-filter-form">
            <div class="filter-field search-field">
                <label for="filter-q" class="filter-label">Cari Penerima</label>
                <div class="input-with-icon-wrap">
                    <svg class="field-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="11" cy="11" r="8"/>
                        <path d="m21 21-4.3-4.3"/>
                    </svg>
                    <input id="filter-q" type="search" name="q" value="{{ request('q') }}" placeholder="Ketik nama, NIM, atau email penerima..." autocomplete="off">
                </div>
            </div>

            <div class="filter-field">
                <label for="filter-status" class="filter-label">Status Pengiriman</label>
                <select id="filter-status" name="status" class="filter-select" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="draft" @selected(request('status') === 'draft')>Draft (Menunggu)</option>
                    <option value="queued" @selected(request('status') === 'queued')>Antrean &amp; Sedang Kirim</option>
                    <option value="sent" @selected(request('status') === 'sent')>Diterima SMTP</option>
                    <option value="failed" @selected(request('status') === 'failed')>Gagal Kirim</option>
                </select>
            </div>

            @if(request('q') || request('status'))
                <div class="filter-actions-wrap">
                    <a href="{{ url('/monitoring/campaign') }}" class="btn-filter-reset" title="Hapus semua filter">
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
                <h2 class="table-title">Daftar Penerima Kampanye</h2>
                <span class="table-count-badge">Total {{ number_format($recipients->total()) }} penerima</span>
            </div>
        </div>

        <div class="modern-table-wrap">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">No.</th>
                        <th style="width: 26%;">Penerima</th>
                        <th style="width: 27%;">Alamat Email</th>
                        <th style="width: 17%;">Status</th>
                        <th style="width: 10%;">Percobaan</th>
                        <th style="width: 15%;">Kirim Terakhir</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recipients as $recipient)
                        <tr>
                            <td>{{ $recipients->firstItem() + $loop->index }}</td>
                            <td>
                                <div class="participant-col">
                                    <strong class="participant-name-text">{{ $recipient->name ?: '—' }}</strong>
                                    @if($recipient->nim)
                                        <span class="participant-ticket-no">NIM: {{ $recipient->nim }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="contact-email">{{ $recipient->email }}</span>
                            </td>
                            <td>
                                @if($recipient->status === 'sent')
                                    <span class="status-pill-badge pill-sent">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                                        <span>Diterima SMTP</span>
                                    </span>
                                @elseif($recipient->status === 'queued')
                                    <span class="status-pill-badge pill-queued">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        <span>Antrean</span>
                                    </span>
                                @elseif($recipient->status === 'sending')
                                    <span class="status-pill-badge pill-sending">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                                        <span>Mengirim...</span>
                                    </span>
                                @elseif($recipient->status === 'failed')
                                    <span class="status-pill-badge pill-failed" title="{{ $recipient->last_error }}">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                        <span>Gagal</span>
                                    </span>
                                @else
                                    <span class="status-pill-badge pill-draft">
                                        <span>Draft (Menunggu)</span>
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="nim-pill">{{ $recipient->attempts }}x</span>
                            </td>
                            <td>
                                @if($recipient->sent_at)
                                    <span class="mail-date">{{ $recipient->sent_at->timezone('Asia/Jakarta')->format('d M H:i') }}</span>
                                @elseif($recipient->attempted_at)
                                    <span class="mail-date muted">Coba: {{ $recipient->attempted_at->timezone('Asia/Jakarta')->format('d M H:i') }}</span>
                                @else
                                    <span class="muted">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-table-state">
                                <div class="empty-wrap">
                                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <circle cx="11" cy="11" r="8"/>
                                        <path d="m21 21-4.3-4.3"/>
                                    </svg>
                                    <strong>Tidak ada data penerima</strong>
                                    <p>Belum ada penerima yang cocok dengan kriteria pencarian atau filter.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-pagination-footer">
            <div class="table-footer-info">
                @if($recipients->total() > 0)
                    @if($recipients->firstItem() === $recipients->lastItem())
                        Menampilkan <strong>{{ $recipients->firstItem() }}</strong> dari <strong>{{ number_format($recipients->total()) }}</strong> data penerima
                    @else
                        Menampilkan <strong>{{ $recipients->firstItem() }}–{{ $recipients->lastItem() }}</strong> dari <strong>{{ number_format($recipients->total()) }}</strong> data penerima
                    @endif
                @else
                    Menampilkan <strong>0</strong> data penerima
                @endif
            </div>

            @if($recipients->hasPages())
                <div class="table-footer-pagination">
                    {{ $recipients->links('pagination::default') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Hidden polling node & script -->
    <div id="campaign-poll" data-url="{{ url('/monitoring/campaign/stats') }}"></div>
    <script src="{{ asset('js/campaign-stats.js') }}" defer></script>

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
