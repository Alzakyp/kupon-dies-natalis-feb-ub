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
    <nav aria-label="Navigasi admin">
        <a href="{{ url('/admin/batches') }}">Batch</a>
        <a href="{{ url('/admin/settings') }}">Pengaturan</a>
        <form method="post" action="{{ url('/admin/logout') }}">@csrf<button class="link-button">Keluar</button></form>
    </nav>
    @endauth
</header>
<main>
    @if(session('success'))<p class="notice success" role="status">{{ session('success') }}</p>@endif
    @if($errors->any())<p class="notice error" role="alert">{{ $errors->first() }}</p>@endif
    {{ $slot }}
</main>
<footer>Fakultas Ekonomi dan Bisnis Universitas Brawijaya</footer>
</body>
</html>
