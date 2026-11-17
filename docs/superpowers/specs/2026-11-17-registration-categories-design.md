# Kategori Pendaftaran: Mahasiswa Aktif dan Alumni

## Tujuan
Pendaftaran membedakan mahasiswa aktif dan alumni tanpa mengubah alokasi kupon, OTP, tiket, check-in, atau kupon lama. Kedua kategori wajib tervalidasi berdasarkan NIM sebelum dapat meminta OTP.

## Data referensi
Tambahkan tabel `student_registries`:

- `nim` string unik, disimpan sebagai teks
- `name`
- `education_level`
- `study_program`
- `registration_type` enum/string: `active_student` atau `alumni`
- timestamps

Data sumber mahasiswa aktif berasal dari Excel lokal yang disediakan. Seeder/command impor melakukan `upsert` berdasarkan NIM, menormalisasi header/nilai teks, dan tidak memasukkan file Excel atau data pribadi ke Git. Baris berstatus tidak aktif tidak diimpor untuk jalur mahasiswa aktif.

Data alumni belum tersedia. Tombol alumni tampil, tetapi form NIM alumni menjelaskan pendaftaran belum tersedia dan tidak dapat melewati validasi sampai registry alumni diimpor.

## Alur publik
1. Halaman `/daftar` menunjukkan dua pilihan: `Mahasiswa Aktif` dan `Alumni`.
2. Pilihan menentukan `registration_type` di sesi/form.
3. Peserta memasukkan NIM.
4. Endpoint lookup mencari registry dengan NIM dan kategori yang dipilih.
5. Bila cocok, halaman menampilkan nama, jenjang, program studi secara readonly.
6. Peserta mengisi email dan HP, lalu meneruskan alur OTP yang ada.
7. OTP/finalisasi menyimpan tipe pendaftar dan identitas registry terverifikasi pada pending registration/ticket. Data identitas tidak boleh berasal dari input browser setelah lookup.

NIM tidak ditemukan, kategori salah, atau registry alumni belum diimpor menghasilkan pesan generik tanpa mengungkap data mahasiswa lain.

## Perubahan data
Tambahkan kolom nullable/additive:

- `pending_registrations.registration_type`
- `pending_registrations.student_registry_id`
- `tickets.registration_type`
- `tickets.student_registry_id`

Finalisasi memerlukan registry yang sama dengan kategori pilihan. Unik email/HP/tiket lama tetap berlaku. Tidak ada migrasi destruktif.

## Operasional dan keamanan
- File Excel hanya dipakai lokal untuk menghasilkan/impor data; tidak di-commit atau diunggah publik.
- Impor dilakukan di server dengan command Artisan dan path file eksplisit, kemudian file sumber dihapus/diamankan.
- Halaman publik tidak dapat mencari NIM bebas untuk mengenumerasi data: lookup dibatasi rate limiter dan hanya mengembalikan record exact-match bagi sesi pilihan kategori.
- Pendaftaran tetap membutuhkan `REGISTRATION_OPEN=true` dan `REGISTRATION_MAIL_VERIFIED=true`.
- Alumni hanya diaktifkan ketika dataset alumni tersedia dan diimpor.

## Verifikasi
- Seeder mengimpor/upsert sampel Excel dengan NIM string, nama, jenjang, prodi, kategori.
- Mahasiswa aktif valid dapat melanjutkan OTP; NIM kategori salah/tidak ada ditolak.
- Alumni ditolak sebelum registry alumni tersedia.
- Identitas ticket mengikuti registry, bukan request yang dimodifikasi.
- Test pendaftaran/tiket lama tetap lulus.
