<x-layouts.app>
    <div class="page-heading">
        <div>
            <p class="eyebrow">Portal administrasi</p>
            <h1>Batch kupon</h1>
            <p>Buat, pantau, dan distribusikan kupon Dies Natalis FEB UB.</p>
        </div>
        <div class="header-stat-badge">
            <span class="stat-count">{{ $batches->where('active', true)->count() }}</span>
            <span class="stat-label">Batch Aktif</span>
        </div>
    </div>

    <!-- Metrics Cards Summary -->
    <div class="batch-metrics-grid">
        <div class="metric-card">
            <div class="metric-icon-wrap" aria-hidden="true">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="20" height="14" x="2" y="5" rx="2"/>
                    <line x1="2" x2="22" y1="10" y2="10"/>
                </svg>
            </div>
            <div class="metric-details">
                <span class="metric-label">Total Kupon Terbit</span>
                <strong class="metric-value">{{ number_format($batches->sum('coupons_count'), 0, ',', '.') }}</strong>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-icon-wrap icon-success" aria-hidden="true">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <path d="m9 11 3 3L22 4"/>
                </svg>
            </div>
            <div class="metric-details">
                <span class="metric-label">Kupon Digunakan</span>
                <strong class="metric-value">{{ number_format($batches->sum('redeemed_count'), 0, ',', '.') }}</strong>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-icon-wrap icon-gold" aria-hidden="true">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                    <polyline points="3.29 7 12 12 20.71 7"/>
                    <line x1="12" x2="12" y1="22" y2="12"/>
                </svg>
            </div>
            <div class="metric-details">
                <span class="metric-label">Total Batch</span>
                <strong class="metric-value">{{ $batches->count() }}</strong>
            </div>
        </div>
    </div>

    <!-- Create Batch Panel -->
    <section class="batch-create-panel">
        <div class="panel-header-row">
            <div class="panel-header-icon" aria-hidden="true">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
            </div>
            <div>
                <h2>Buat batch baru</h2>
                <p class="panel-desc">Tentukan nama batch peruntukan dan kuota kupon yang akan digenerate otomatis.</p>
            </div>
        </div>

        <form method="post" action="{{ url('/admin/batches') }}" class="modern-inline-form">
            @csrf
            <div class="form-group flex-2">
                <label for="batch-name" class="form-label">
                    <span>Nama batch</span>
                    <span class="label-badge">Wajib</span>
                </label>
                <input id="batch-name" name="name" value="{{ old('name') }}" placeholder="Contoh: Dosen dan Tendik" required autocomplete="off">
            </div>

            <div class="form-group flex-1">
                <label for="batch-qty" class="form-label">
                    <span>Jumlah kupon</span>
                    <span class="label-badge">Maks. 1.000</span>
                </label>
                <input id="batch-qty" name="quantity" type="number" min="1" max="1000" placeholder="100" value="{{ old('quantity', 100) }}" required inputmode="numeric">
            </div>

            <div class="form-action-wrap">
                <button type="submit" class="btn-primary btn-submit-batch">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12 5v14M5 12h14"/>
                    </svg>
                    <span>Buat Batch</span>
                </button>
            </div>
        </form>
    </section>

    <!-- Batch History Section -->
    <section class="batch-history-section">
        <div class="section-heading">
            <div>
                <h2>Riwayat batch</h2>
                <p class="section-subtext">Daftar semua batch kupon yang pernah diterbitkan beserta riwayat dan statusnya.</p>
            </div>
            <span class="badge-count">{{ $batches->count() }} batch</span>
        </div>

        <div class="batch-list-cards">
            @forelse($batches as $b)
                @php
                    $percentUsed = $b->coupons_count > 0 ? round(($b->redeemed_count / $b->coupons_count) * 100) : 0;
                @endphp
                <div class="batch-item-card {{ $b->active ? 'batch-active' : 'batch-inactive' }}">
                    <div class="batch-item-main">
                        <div class="batch-title-row">
                            <a href="{{ url('/admin/batches/'.$b->id) }}" class="batch-link-name">
                                {{ $b->name }}
                            </a>
                            @if($b->active)
                                <span class="status-pill status-active">
                                    <span class="status-dot"></span> Aktif
                                </span>
                            @else
                                <span class="status-pill status-disabled">
                                    <span class="status-dot-disabled"></span> Nonaktif
                                </span>
                            @endif
                        </div>

                        <div class="batch-progress-wrap">
                            <div class="progress-info-row">
                                <span class="progress-text">
                                    <strong>{{ number_format($b->redeemed_count, 0, ',', '.') }}</strong>/<strong>{{ number_format($b->coupons_count, 0, ',', '.') }}</strong> kupon digunakan
                                </span>
                                <span class="progress-percent">{{ $percentUsed }}%</span>
                            </div>
                            <div class="progress-track" aria-hidden="true">
                                <div class="progress-bar" style="width: {{ $percentUsed }}%;"></div>
                            </div>
                        </div>

                        <div class="batch-meta-row">
                            <span class="meta-item">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                                    <line x1="16" x2="16" y1="2" y2="6"/>
                                    <line x1="8" x2="8" y1="2" y2="6"/>
                                    <line x1="3" x2="21" y1="10" y2="10"/>
                                </svg>
                                Dibuat {{ $b->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB
                            </span>
                            <span class="meta-separator" aria-hidden="true">•</span>
                            <span class="meta-item">
                                Kedaluwarsa {{ $b->expires_at->timezone('Asia/Jakarta')->format('d M Y') }}
                            </span>
                        </div>
                    </div>

                    <div class="batch-item-actions">
                        <a href="{{ url('/admin/batches/'.$b->id) }}" class="btn-action-outline" title="Lihat detail dan daftar kupon">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            <span>Detail</span>
                        </a>

                        <a href="{{ url('/admin/batches/'.$b->id.'/export') }}" class="btn-action-download" title="Unduh arsip ZIP kupon dan barcode">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                <polyline points="7 10 12 15 17 10"/>
                                <line x1="12" x2="12" y1="15" y2="3"/>
                            </svg>
                            <span>Unduh ZIP</span>
                        </a>

                        @if($b->active)
                            <form method="post" action="{{ url('/admin/batches/'.$b->id.'/deactivate') }}" onsubmit="return confirm('Apakah Anda yakin ingin menonaktifkan batch {{ $b->name }}? Kupon pada batch ini tidak akan bisa ditukarkan lagi.');" class="inline-action-form">
                                @csrf
                                <button type="submit" class="btn-action-deactivate" title="Nonaktifkan batch ini">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"/>
                                        <line x1="4.93" x2="19.07" y1="4.93" y2="19.07"/>
                                    </svg>
                                    <span>Nonaktifkan</span>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="empty-batch-state">
                    <div class="empty-icon-wrap" aria-hidden="true">
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="20" height="14" x="2" y="5" rx="2"/>
                            <line x1="2" x2="22" y1="10" y2="10"/>
                        </svg>
                    </div>
                    <h3>Belum Ada Batch Kupon</h3>
                    <p class="muted">Gunakan formulir di atas untuk membuat batch kupon pertama Anda.</p>
                </div>
            @endforelse
        </div>
    </section>
</x-layouts.app>
