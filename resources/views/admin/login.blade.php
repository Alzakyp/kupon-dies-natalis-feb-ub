<x-layouts.app>
<section class="auth-shell">
    <p class="eyebrow">Portal administrasi</p>
    <h1>Kelola kupon acara</h1>
    <p>Masuk untuk membuat batch, memantau penggunaan, dan mengunduh QR kupon.</p>
    <form method="post" action="{{ url('/admin/login') }}">
        @csrf
        <label>Email
            <input name="email" type="email" autocomplete="username" required autofocus>
        </label>
        <label>Password
            <input name="password" type="password" autocomplete="current-password" required>
        </label>
        <button>Masuk ke Dashboard</button>
    </form>
</section>
</x-layouts.app>
