<x-layouts.app>
<section class="auth-shell">
    <p class="eyebrow">Keamanan</p>
    <h1>Password penukaran</h1>
    <p>Password ini digunakan petugas saat verifikasi kupon fisik di lokasi.</p>
    <form method="post" action="{{ url('/admin/settings') }}">
        @csrf
        <label>Password baru
            <input type="password" name="password" minlength="8" required>
        </label>
        <label>Ulangi password
            <input type="password" name="password_confirmation" required>
        </label>
        <button>Ganti Password</button>
    </form>
</section>
</x-layouts.app>
