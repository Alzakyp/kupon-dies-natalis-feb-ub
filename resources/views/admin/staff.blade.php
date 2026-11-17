<x-layouts.app>
    <div class="page-heading">
        <div>
            <p class="eyebrow">Portal Administrasi</p>
            <h1>Akun petugas</h1>
            <p>Kelola akun petugas meja registrasi untuk pemindaian QR tiket dan verifikasi kupon peserta.</p>
        </div>
        <div class="header-stat-badge">
            <span class="stat-count">{{ $staff->count() }}</span>
            <span class="stat-label">Petugas Aktif</span>
        </div>
    </div>

    <div class="staff-admin-grid">
        <!-- Form Tambah Petugas -->
        <section class="staff-card staff-create-panel">
            <div class="staff-card-header">
                <div class="header-icon-wrap" aria-hidden="true">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <line x1="19" x2="19" y1="8" y2="14"/>
                        <line x1="22" x2="16" y1="11" y2="11"/>
                    </svg>
                </div>
                <div>
                    <h2>Buat Akun Petugas</h2>
                    <p class="card-desc">Tambahkan petugas baru untuk bertugas di lokasi acara.</p>
                </div>
            </div>

            <form method="post" action="{{ url('/admin/staff') }}" class="staff-form">
                @csrf
                <div class="form-group">
                    <label for="staff-name" class="form-label">
                        <span>Nama</span>
                        <span class="label-badge">Wajib</span>
                    </label>
                    <div class="input-with-icon">
                        <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        <input id="staff-name" name="name" value="{{ old('name') }}" placeholder="Contoh: Ahmad Fauzi" required autocomplete="name">
                    </div>
                </div>

                <div class="form-group">
                    <label for="staff-email" class="form-label">
                        <span>Email</span>
                        <span class="label-badge">Unik</span>
                    </label>
                    <div class="input-with-icon">
                        <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect width="20" height="16" x="2" y="4" rx="2"/>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                        </svg>
                        <input id="staff-email" type="email" name="email" value="{{ old('email') }}" placeholder="petugas@feb.ub.ac.id" required autocomplete="email">
                    </div>
                </div>

                <div class="form-group">
                    <label for="staff-password" class="form-label">
                        <span>Password sementara</span>
                        <span class="label-badge">Kombinasi</span>
                    </label>
                    <div class="input-with-icon">
                        <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        <input id="staff-password" type="password" name="password" minlength="8" required autocomplete="new-password" placeholder="Minimal 8 karakter">
                    </div>
                    <div class="password-req-hints">
                        <span class="req-chip">8+ Karakter</span>
                        <span class="req-chip">Huruf & Angka</span>
                        <span class="req-chip">Simbol (@$!%*#?&)</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="staff-password-conf" class="form-label">
                        <span>Ulangi password</span>
                        <span class="label-badge">Konfirmasi</span>
                    </label>
                    <div class="input-with-icon">
                        <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M21.8 17.5 19 14.7l-1.4 1.4 2.8 2.8"/>
                            <path d="m15.5 14.5 1.4-1.4"/>
                            <circle cx="8" cy="12" r="5"/>
                        </svg>
                        <input id="staff-password-conf" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ketik ulang password">
                    </div>
                </div>

                <button type="submit" class="btn-primary btn-block">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <line x1="19" x2="19" y1="8" y2="14"/>
                        <line x1="22" x2="16" y1="11" y2="11"/>
                    </svg>
                    <span>Buat akun petugas</span>
                </button>
            </form>
        </section>

        <!-- Daftar Petugas Aktif -->
        <section class="staff-card staff-list-panel">
            <div class="staff-card-header">
                <div>
                    <h2>Daftar Petugas Aktif</h2>
                    <p class="card-desc">Petugas yang memiliki hak akses untuk memindai tiket peserta.</p>
                </div>
                <span class="badge-count">{{ $staff->count() }} Petugas</span>
            </div>

            <div class="staff-members-list">
                @forelse($staff as $user)
                    <div class="staff-member-item">
                        <div class="staff-member-left">
                            <div class="avatar-bubble" aria-hidden="true">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                            <div class="staff-info">
                                <h3 class="staff-name">{{ $user->name }}</h3>
                                <p class="staff-email">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <rect width="20" height="16" x="2" y="4" rx="2"/>
                                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                                    </svg>
                                    {{ $user->email }}
                                </p>
                                <div class="staff-meta-row">
                                    <span class="status-pill status-active">
                                        <span class="status-dot"></span> Aktif
                                    </span>
                                    <span class="role-pill">Petugas Scan</span>
                                    @if($user->created_at)
                                        <span class="meta-date">Dibuat {{ $user->created_at->format('d M Y') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="staff-member-action">
                            <form method="post" action="{{ url('/admin/staff/'.$user->id.'/disable') }}" onsubmit="return confirm('Apakah Anda yakin ingin menonaktifkan akun petugas {{ $user->name }}? Petugas tidak akan bisa login lagi.');">
                                @csrf
                                <button type="submit" class="btn-disable">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"/>
                                        <line x1="4.93" x2="19.07" y1="4.93" y2="19.07"/>
                                    </svg>
                                    <span>Nonaktifkan</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="empty-staff-state">
                        <div class="empty-icon-wrap" aria-hidden="true">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>
                        </div>
                        <h3>Belum Ada Petugas</h3>
                        <p class="muted">Silakan gunakan formulir di sebelah kiri untuk membuat akun petugas meja registrasi.</p>
                    </div>
                @endforelse
            </div>
        </section>
    </div>
</x-layouts.app>
