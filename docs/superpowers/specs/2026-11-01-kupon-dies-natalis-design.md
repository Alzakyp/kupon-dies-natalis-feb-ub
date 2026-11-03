# Kupon Dies Natalis FEB UB — Desain

## Tujuan

Membuat kupon fisik tanpa fitur anti-pemalsuan cetak mahal. Admin menghasilkan QR unik untuk dimasukkan ke desain kupon di luar sistem. Pemegang kupon menunjukkan QR; petugas memindai dengan kamera HP biasa, memeriksa status, lalu menukarkan kupon menggunakan password. Pemakaian kedua ditolak.

## Batasan

- Satu proyek Laravel dengan Blade dan MySQL; tanpa React atau aplikasi petugas.
- Tidak ada nominal, identitas penerima, desain kupon, ataupun PDF cetak.
- Kupon anonim: orang yang mendapatkan QR lebih dahulu dapat menggunakannya bila mengetahui password penukaran. QR bukan bukti kepemilikan.
- Diperlukan internet dan HTTPS untuk lingkungan produksi.

## Alur admin

Admin login dengan akun terpisah, memasukkan nama batch dan jumlah kupon, lalu sistem membuat kode acak kuat dengan prefix `FEB65-LUSTRUM-`. Kode tidak berurutan dan unik dalam database. Masa berlaku setiap kupon adalah tujuh hari sejak batch dibuat. Admin melihat batch dan ringkasan status, mengunduh ZIP berisi PNG QR bernama sesuai kode serta CSV daftar kode, dapat mengganti password penukaran, dan dapat menonaktifkan batch. Batch yang pernah digunakan tidak dihapus agar riwayat tetap tersedia. Jumlah batch dibatasi oleh validasi input dan batas operasional ekspor agar server tidak kehabisan sumber daya.

## Alur penukaran

QR mengandung URL HTTPS `/c/{kode}`. Halaman publik menampilkan judul `Dies Natalis FEB UB ke-65 Lustrum XIII`, kode, masa berlaku, dan status `VALID`, `SUDAH DIGUNAKAN`, `KEDALUWARSA`, atau `NONAKTIF`. Hanya kupon valid yang menampilkan formulir password dan tombol `Gunakan Kupon`. Password awal yang diminta: `febub65`, disimpan sebagai hash, dapat diganti admin. Password tidak ditanam dalam kode sumber atau HTML. Form memakai CSRF; lima percobaan salah per kupon mengunci percobaan selama 15 menit, dengan pembatasan tambahan per alamat IP untuk menahan percobaan ke banyak kupon. Pesan gagal tidak membocorkan password. Permintaan penukaran memeriksa status, masa berlaku, dan password di server; pembaruan atomik memastikan hanya satu permintaan bersamaan berhasil. Catat waktu penukaran dan alamat IP. Status halaman tidak pernah dianggap bukti penukaran sampai transaksi berhasil.

## Data dan keamanan

- `users`: akun admin, password hash.
- `batches`: nama, waktu dibuat, waktu kedaluwarsa, status aktif.
- `coupons`: batch, kode unik acak, waktu dipakai, IP penukar.
- Password penukaran: satu nilai hash yang dikelola admin; rotasi berlaku langsung pada semua kupon.
- Semua fitur admin dilindungi autentikasi; semua perubahan memakai POST/CSRF; ekspor hanya admin.
- Kode QR adalah bearer token: tidak menaruh nomor urut atau informasi rahasia lain di URL. Nonaktifkan indeks mesin pencari pada halaman kupon dan batasi log URL bila lingkungan hosting mendukung.
- Unduhan ZIP dibuat saat diminta dan tidak disimpan sebagai file publik permanen. CSV memuat kode; perlakukan sebagai rahasia operasional.

## Pengujian dan operasi

Feature test: admin tidak terautentikasi ditolak; batch dan kode unik; tanggal kedaluwarsa; ekspor hanya admin; status publik; password benar/salah dan rate limit; kupon terpakai tidak bisa dipakai ulang; batch nonaktif; pembaruan bersamaan tidak menebus dua kali. Jalankan suite dengan SQLite untuk pengujian cepat bila tersedia, lalu uji alur transaksi pada MySQL karena semantik kunci berbeda. Konfigurasi produksi memakai `APP_URL` HTTPS, kredensial MySQL lewat `.env`, dan password admin awal dibuat melalui perintah provisioning, bukan hardcode.

## Yang tidak dibuat

Aplikasi mobile/PWA petugas, React, akun masing-masing petugas, nominal, identitas penerima, desain/PDF kupon, pengiriman lewat email/WhatsApp, mode offline. Tambahkan hanya bila kebutuhan lapangan berubah.
