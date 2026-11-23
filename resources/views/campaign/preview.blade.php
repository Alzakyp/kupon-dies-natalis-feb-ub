<x-layouts.app>
<section class="monitoring-container">
    <!-- Header Section -->
    <div class="monitoring-header">
        <div class="header-left">
            <a href="{{ url('/monitoring/campaign') }}" class="btn-back-nav" title="Kembali ke Dashboard Kampanye">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <line x1="19" y1="12" x2="5" y2="12"/>
                    <polyline points="12 19 5 12 12 5"/>
                </svg>
                <span>Kembali ke Dashboard Kampanye</span>
            </a>
            <h1 class="monitoring-title" style="margin-top: 10px;">Pratinjau Email Blast</h1>
            <p class="monitoring-desc">Tampilan email resmi FEB UB Grand Fiesta yang dikirimkan ke kotak masuk sivitas akademika dan alumni.</p>
        </div>
        <div class="header-actions">
            <a href="{{ url('/monitoring/campaign') }}" class="btn-refresh">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect width="20" height="16" x="2" y="4" rx="2"/>
                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                </svg>
                <span>Dashboard Kampanye</span>
            </a>
        </div>
    </div>

    <!-- Email Client Frame Mockup -->
    <div class="email-preview-wrapper">
        <div class="email-preview-meta">
            <div class="email-meta-row">
                <span class="meta-label">Subjek</span>
                <strong class="meta-subject">FEB UB Grand Fiesta — Fun Walk &amp; FEB Unity Concert</strong>
            </div>
            <div class="email-meta-row">
                <span class="meta-label">Pengirim</span>
                <span class="meta-value">Fakultas Ekonomi dan Bisnis Universitas Brawijaya</span>
            </div>
            <div class="email-meta-row">
                <span class="meta-label">Penerima</span>
                <span class="meta-value">&lt;nama.mahasiswa@student.ub.ac.id / alumni&gt;</span>
            </div>
            <div class="email-meta-row">
                <span class="meta-label">Jadwal</span>
                <span class="meta-value">Minggu, 6 Desember 2026 · Lapangan Rektorat Universitas Brawijaya</span>
            </div>
        </div>

        <div class="email-preview-body-container">
            @include('campaign.email')
        </div>
    </div>
</section>
</x-layouts.app>
