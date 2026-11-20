<x-layouts.app>
<section class="auth-shell">
    <div class="monitoring-auth-card">
        <div class="auth-card-badge">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <rect width="20" height="16" x="2" y="4" rx="2"/>
                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
            </svg>
            <span>AKSES PANITIA</span>
        </div>
        <h1 class="auth-card-title">Kampanye Email Grand Fiesta</h1>
        <p class="auth-card-desc">Masukkan password monitoring panitia untuk mengelola broadcast email massal, kuota SMTP, dan daftar penerima.</p>

        @if($errors->has('password'))
            <div class="notice error auth-alert" role="alert">
                {{ $errors->first('password') }}
            </div>
        @endif

        <form method="post" action="{{ url('/monitoring/campaign') }}" class="auth-card-form">
            @csrf
            <div class="form-field-group">
                <label for="campaign-password" class="auth-field-label">Password Monitoring</label>
                <div class="input-with-icon-wrap">
                    <svg class="field-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                    <input id="campaign-password" type="password" name="password" placeholder="Masukkan password monitoring..." required autocomplete="current-password" autofocus>
                </div>
            </div>
            <button type="submit" class="btn-auth-submit">
                <span>Buka Dashboard Kampanye</span>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <line x1="5" y1="12" x2="19" y2="12"/>
                    <polyline points="12 5 19 12 12 19"/>
                </svg>
            </button>
        </form>

        <div class="auth-card-footer">
            <a href="{{ url('/monitoring') }}" class="auth-alt-link">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                </svg>
                <span>Buka Monitoring Peserta Registrasi</span>
            </a>
        </div>
    </div>
</section>
</x-layouts.app>
