<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>Kupon FEB UB</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<header class="site-header">
    <div class="brand" aria-label="FEB UB dan Dies Natalis ke-65">
        <img class="logo-ub" src="{{ asset('images/logo-ub.svg').'?v=2' }}" alt="Universitas Brawijaya" width="1149" height="1155">
        <img class="logo-feb" src="{{ asset('images/wordmark-feb.png').'?v=1' }}" alt="Fakultas Ekonomi dan Bisnis" width="975" height="377">
        <span class="brand-divider" aria-hidden="true"></span>
        <img class="logo-lustrum" src="{{ asset('images/logo-lustrum-65-clean.png').'?v=3' }}" alt="Dies Natalis FEB UB ke-65 Lustrum XIII" width="1254" height="1254">
    </div>
    @auth
    <nav aria-label="Navigasi pengguna">
        @if(auth()->user()->role === 'admin')
        <a href="{{ url('/admin/batches') }}">Batch</a>
        <a href="{{ url('/admin/staff') }}">Petugas</a>
        <a href="{{ url('/admin/settings') }}">Pengaturan</a>
        @else
        <a href="{{ url('/staff/scan') }}">Scan tiket</a>
        @endif
        <form method="post" action="{{ url('/admin/logout') }}">@csrf<button class="link-button">Keluar</button></form>
    </nav>
    @endauth
</header>
<main>
    @if(session('success'))<p class="notice success" role="status">{{ session('success') }}</p>@endif
    @if($errors->any())<p class="notice error" role="alert">{{ $errors->first() }}</p>@endif
    {{ $slot }}
</main>
<div id="submit-loading" class="submit-loading" hidden role="status" aria-live="polite" aria-label="Permintaan sedang diproses"><div class="submit-loading-box"><span class="submit-spinner" aria-hidden="true"></span><strong>Memproses…</strong><small>Mohon tunggu dan jangan tutup halaman.</small></div></div>
<footer>Fakultas Ekonomi dan Bisnis Universitas Brawijaya</footer>
<script src="{{ asset('js/submit-loading.js') }}" defer></script>
</body>
</html>
