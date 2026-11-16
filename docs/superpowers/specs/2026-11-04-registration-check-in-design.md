# Pendaftaran, Barcode Email, dan Check-in FEB UB

Status: rancangan percakapan disetujui; menunggu review dokumen sebelum implementation plan.

## Tujuan dan batas

Tambahkan pendaftaran publik dan check-in ke Laravel Blade + MySQL yang ada. Satu peserta memperoleh satu kupon yang sudah dibuat admin. Barcode email mengidentifikasi tiket; QR kupon fisik tetap dipakai untuk penukaran sekali pakai. Tidak ada nama peserta, pembayaran, kamera, aplikasi mobile, atau layanan SMS/WhatsApp.

Route aplikasi tetap memakai prefix deployment `/kupon`. `/kupon/` dan `/kupon/admin` tetap berakhir 404; login tersedia di `/kupon/admin/login`. Tidak ada halaman tiket publik.

## Alur peserta

1. Buka `/kupon/daftar`, isi email aktif dan nomor HP wajib.
2. Kirim OTP email enam digit. Berlaku 10 menit, maksimal lima percobaan, cooldown kirim ulang 60 detik. Kirim ulang membatalkan kode sebelumnya. Batasi permintaan per email, nomor HP, dan IP; pesan netral untuk mencegah enumerasi peserta.
3. Masukkan OTP dan tekan `Daftar & Kirim Tiket`. Validasi OTP dan finalisasi harus server-side, atomik dan idempoten.
4. Setelah OTP cocok, buat nomor tiket dan alokasikan tepat satu kupon dari batch aktif, belum kedaluwarsa, belum digunakan, belum dialokasikan. Email dan nomor HP masing-masing unik; normalisasi konsisten di trust boundary.
5. Kirim email tiket berisi nomor tiket, barcode token acak khusus check-in, email peserta, judul acara, instruksi, dan lokasi `Ruang Kepegawaian Gedung Utama Lt. 2`. Barcode bukan URL dan tidak mengandung email/HP. Barcode berbeda dari kode QR kupon. Tidak ada tombol check-in publik.
6. Tampilkan barcode juga pada respons sukses. Jika pengiriman tiket gagal, tiket tetap ada; kirim ulang menggunakan tiket yang sama, bukan alokasi baru.

Tidak ada kuota numerik pendaftaran. Stok kupon membatasi pendaftaran: tutup form jika tidak ada kupon tersedia; race terakhir harus ditangani tanpa menggandakan alokasi. Pendaftaran belum selesai dibersihkan setelah 24 jam; identitas peserta terdaftar tidak dihapus oleh pembersihan pending.

## Alur admin dan petugas

Admin tetap akun yang ada; admin membuat akun petugas dari dashboard. Otorisasi server-side membatasi petugas pada pencarian peserta, detail, scan, check-in, cetak, dan cetak ulang. Petugas tidak mengelola akun, batch, password penukaran, atau konfigurasi acara. Admin dapat mengakses semuanya.

Scanner USB mengetik token barcode ke kolom scan dashboard dan mengirim Enter otomatis. Server memvalidasi token. Scan hanya membuka preview: nomor tiket, email, HP, kupon terkait, status dan waktu check-in. Pencarian email/HP dan kirim ulang email tersedia untuk penanganan tiket hilang.

Tombol `Konfirmasi check-in` mencatat waktu dan petugas sekali secara atomik. Tidak perlu password tambahan pada check-in. Scan ulang menunjukkan sudah check-in; tidak mengalokasikan kupon baru. Setelah check-in, tampilkan halaman siap cetak melalui dialog browser. Cetak ulang memakai nomor dan kupon sama, memerlukan konfirmasi, menampilkan `CETAK ULANG`, dan mencatat jumlah/permintaan cetak. Browser tidak dapat membuktikan kertas berhasil keluar; audit adalah permintaan cetak, bukan keberhasilan printer.

Preview cetak sementara memuat nomor tiket dan QR kupon yang telah dialokasikan. Ukuran, desain, dan komposisi final menunggu desain pengguna; jangan mengunci 31×47 cm. Identitas visual memakai aset resmi UB, FEB, dan Lustrum yang ada, responsif dan aksesibel.

## Kupon dan data lama

Batch tetap dibuat admin secara manual. Kupon tanpa peserta tersedia untuk peserta berikutnya. Alokasi saat pendaftaran bukan penukaran: status alokasi, check-in, dan `redeemed_at` terpisah. Kupon tetap kedaluwarsa tujuh hari sejak batch dibuat. Cetak tidak memperpanjang masa berlaku.

Route `/c/{kode}`, password penukaran, proteksi single-use, dan audit penukaran lama dipertahankan. Jangan merusak QR yang sudah diterbitkan. Tidak ada migration destruktif atau penghapusan otomatis kupon lama. Pengguna melakukan penghapusan data lama sendiri, bukan agent.

Dashboard admin perlu daftar peserta/tiket, pencarian, status alokasi/check-in, filter semua/belum/sudah check-in. Detail batch tetap menyediakan kode kupon, status belum/sudah dipakai, waktu penukaran Asia/Jakarta dan IP; status redeemed berbeda dari check-in.

## Penyimpanan dan konsistensi

Gunakan tabel pending OTP dan pendaftaran/tiket terpisah dari kupon. OTP hanya disimpan hash; kode tidak masuk log. Nomor tiket, email ternormalisasi, HP ternormalisasi, token barcode, dan relasi kupon memakai unique constraint yang relevan. Kupon hanya boleh terhubung ke satu pendaftaran. Identitas tiket dan waktu/petugas check-in disimpan sebagai audit.

Finalisasi OTP, alokasi stok dan pencatatan peserta berada dalam transaksi MySQL dengan row lock dan constraint. Request bersamaan/retry tidak menghasilkan tiket atau kupon ganda. Pengiriman email dilakukan setelah transaksi commit, bukan sambil memegang lock. Retry pengiriman tidak mengubah tiket.

## SMTP dan operasi

Siapkan MAIL_* di `.env.example`, tanpa kredensial nyata. Pengguna mengisi `.env` server. Pendaftaran default tertutup sampai konfigurasi SMTP diisi dan email OTP serta tiket benar-benar diterima dalam uji inbox. SMTP acceptance bukan jaminan inbox; kegagalan harus terlihat dan dapat di-retry tanpa menghilangkan pendaftaran.

Judul acara default `Dies Natalis FEB UB ke-65 Lustrum XIII`; lokasi seperti di atas. Admin dapat mengatur informasi acara dan buka/tutup pendaftaran. Tanggal/jam acara belum ditentukan; jangan mengarang tanggal. Tidak ada kredensial petugas hardcode.

Pertahankan cookie session scoped `/kupon`, nama khusus, Secure, HttpOnly, SameSite=Lax pada HTTPS deployment. Semua operasi perubahan authenticated/CSRF sesuai perannya. Hindari token dan PII di log/error publik. Rahasiakan SMTP dan kredensial DB.

## Acceptance dan verifikasi

- OTP benar/salah/kedaluwarsa/batas percobaan/cooldown/kirim ulang; pending cleanup dan rate limits.
- Validasi email/HP, keunikan setelah normalisasi, stok habis, batch nonaktif/kedaluwarsa, transaksi concurrent dan retry finalisasi.
- Email verifikasi dan tiket benar; barcode dapat dibaca scanner USB; kegagalan email tidak mengalokasikan ulang.
- Pemisahan otorisasi admin/petugas/guest; tidak ada check-in publik.
- Scan tidak mengubah status; check-in hanya sekali; cetak ulang mempertahankan kupon dan audit.
- Penukaran kupon lama, expiry batch, dan semua test existing tetap valid.
- Semua form/redirect/assets bekerja di subpath `/kupon`; 404 root/admin-prefix tetap berlaku.
- Test lokal dengan mail fake; uji MySQL untuk row locking. Uji SMTP inbox nyata hanya setelah pengguna mengisi kredensial, bukan klaim sukses dari fake.
- Uji printer nyata setelah ukuran/desain diberikan; sebelum itu hanya preview/dialog print yang diverifikasi.
