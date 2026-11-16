<x-layouts.app>
<section class="auth-shell coupon-shell">
    <div class="coupon-identity">
        <div class="institution-logos">
            <img class="coupon-logo-ub" src="{{ asset('images/logo-ub.svg').'?v=2' }}" alt="Universitas Brawijaya" width="1149" height="1155">
            <img class="coupon-logo-feb" src="{{ asset('images/wordmark-feb.png').'?v=1' }}" alt="Fakultas Ekonomi dan Bisnis" width="975" height="377">
        </div>
        <img class="coupon-logo-lustrum" src="{{ asset('images/logo-lustrum-65-clean.png').'?v=3' }}" alt="Dies Natalis FEB UB ke-65 Lustrum XIII" width="1254" height="1254">
    </div>
    <p class="eyebrow">Dies Natalis FEB UB ke-65 Lustrum XIII</p>
    <h1>Kupon resmi</h1>
    <div class="summary-card">
        <div><small>Kode kupon</small><p class="code-badge"><strong>{{ $coupon->code }}</strong></p></div>
        <div><small>Masa berlaku</small><p>{{ $coupon->batch->expires_at->format('d M Y H:i') }} UTC</p></div>
        <div><small>Status</small><p><strong class="status-badge {{ strtolower($coupon->status()) }}">{{ $coupon->status() }}</strong></p></div>
    </div>
    @if($coupon->status()==='VALID' && !$locked)
    <form method="post" action="{{ url('/c/'.$coupon->code) }}">
        @csrf
        <label>Password petugas penukaran
            <input type="password" name="password" autocomplete="off" required>
        </label>
        <button>Gunakan Kupon</button>
    </form>
    @elseif($locked)
    <p class="notice error" role="alert">Status: <strong>TERKUNCI</strong> (percobaan salah terlalu banyak, silakan coba 15 menit lagi)</p>
    @endif
</section>
</x-layouts.app>
