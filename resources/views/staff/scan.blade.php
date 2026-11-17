<x-layouts.app>
    <div class="page-heading">
        <div>
            <p class="eyebrow">Meja check-in</p>
            <h1>Dashboard petugas</h1>
            <p>Scan QR e-tiket peserta untuk memverifikasi kehadiran dan mencetak kupon fisik.</p>
        </div>
        <div class="header-stat-badge">
            <span class="stat-count">{{ $checkedIn }}</span>
            <span class="stat-label">Sudah Check-in</span>
        </div>
    </div>

    <!-- Dashboard Quick Stats -->
    <div class="dashboard-stats">
        <div class="stat-box">
            <small>Total tiket</small>
            <strong>{{ number_format($total, 0, ',', '.') }}</strong>
        </div>
        <div class="stat-box stat-box-success">
            <small>Sudah check-in</small>
            <strong>{{ number_format($checkedIn, 0, ',', '.') }}</strong>
        </div>
        <div class="stat-box stat-box-warning">
            <small>Belum check-in</small>
            <strong>{{ number_format($total - $checkedIn, 0, ',', '.') }}</strong>
        </div>
    </div>

    <!-- Scanner Panel -->
    <section class="panel scanner-panel">
        <div class="scanner-header-row">
            <div class="scanner-header-icon" aria-hidden="true">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 7V5a2 2 0 0 1 2-2h2"/>
                    <path d="M17 3h2a2 2 0 0 1 2 2v2"/>
                    <path d="M21 17v2a2 2 0 0 1-2 2h-2"/>
                    <path d="M7 21H5a2 2 0 0 1-2-2v-2"/>
                    <rect width="10" height="10" x="7" y="7" rx="1"/>
                </svg>
            </div>
            <div>
                <h2>Scan QR tiket</h2>
                <p>Arahkan barcode scanner USB ke QR tiket di email peserta. Scanner akan otomatis mengisi dan menekan Enter.</p>
            </div>
        </div>

        <form method="post" action="{{ url('/staff/lookup') }}" class="scanner-form">
            @csrf
            <div class="form-group flex-1">
                <label for="barcode-input" class="form-label">
                    <span>Kode tiket</span>
                    <span class="label-badge">Barcode / QR String</span>
                </label>
                <div class="input-with-icon">
                    <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M3 7V5a2 2 0 0 1 2-2h2"/>
                        <path d="M17 3h2a2 2 0 0 1 2 2v2"/>
                        <path d="M21 17v2a2 2 0 0 1-2 2h-2"/>
                        <path d="M7 21H5a2 2 0 0 1-2-2v-2"/>
                    </svg>
                    <input id="barcode-input" name="barcode" autofocus required autocomplete="off" spellcheck="false" placeholder="Klik di sini lalu scan QR atau masukkan kode tiket...">
                </div>
            </div>
            <button type="submit" class="btn-primary btn-scanner-submit">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="11" cy="11" r="8"/>
                    <path d="m21 21-4.3-4.3"/>
                </svg>
                <span>Cari tiket</span>
            </button>
        </form>
    </section>

    <!-- Recent Tickets Table -->
    <section class="recent-tickets-section">
        <div class="section-heading">
            <div>
                <h2>10 tiket terbaru</h2>
                <p class="section-subtext">Aktivitas penerbitan dan check-in tiket registrasi terkini.</p>
            </div>
            <span class="badge-count">{{ $recent->count() }} tiket</span>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Tiket</th>
                        <th>Nama Peserta</th>
                        <th>Program Studi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recent as $ticket)
                        <tr>
                            <td class="code-badge">
                                <a href="{{ url('/staff/tickets/'.$ticket->id) }}" class="ticket-link">{{ $ticket->number }}</a>
                            </td>
                            <td>
                                <strong>{{ $ticket->studentRegistry?->name ?? '—' }}</strong>
                                <div class="muted small-text">{{ $ticket->email }}</div>
                            </td>
                            <td>
                                @if($ticket->studentRegistry?->study_program)
                                    <span class="prodi-pill">{{ $ticket->studentRegistry->study_program }}</span>
                                @else
                                    <span class="muted">—</span>
                                @endif
                            </td>
                            <td>
                                @if($ticket->checked_in_at)
                                    <span class="status-pill status-active">
                                        <span class="status-dot"></span> Sudah check-in
                                    </span>
                                @else
                                    <span class="status-pill status-warning">
                                        <span class="status-dot-warning"></span> Belum check-in
                                    </span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ url('/staff/tickets/'.$ticket->id) }}" class="btn-sm-action">Buka Tiket →</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center muted">Belum ada tiket.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</x-layouts.app>
