# Pendaftaran dan Check-in FEB UB Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Peserta mendaftar lewat OTP email, menerima barcode tiket yang terhubung ke kupon batch, lalu petugas melakukan check-in dan cetak kupon fisik.

**Architecture:** Laravel Blade dan MySQL tetap satu aplikasi. OTP pending, tiket, dan kupon dipisah; alokasi dilakukan di transaksi dengan lock. Email dikirim sesudah commit; browser menangani cetak. Role admin/petugas dibatasi middleware server-side.

**Tech Stack:** Laravel 12, PHP 8.5, MySQL, Blade, CSS, Laravel Mail/RateLimiter, PHPUnit, endroid/qr-code yang sudah terpasang.

**Spec:** `docs/superpowers/specs/2026-11-04-registration-check-in-design.md`

## Global Constraints

- Deployment URL memakai `/kupon`; semua URL dibuat melalui `url()`/`asset()`, bukan path absolut hardcoded pada form/link/redirect.
- `/kupon/` dan `/kupon/admin` tetap 404. `/admin/login` tetap tersedia.
- Tidak ada migration destruktif; jangan hapus kupon/batch existing atau ubah route `/c/{code}` dan proteksi penukaran.
- Barcode email adalah token acak, bukan URL, email, HP, atau QR kupon.
- Kupon dibuat admin, berlaku tujuh hari sejak batch dibuat. Alokasi saat pendaftaran setelah OTP benar; check-in dan penukaran adalah event berbeda.
- Pendaftaran tertutup secara default sampai SMTP diverifikasi nyata. Kredensial tidak masuk repo.
- Tidak ada desain/ukuran cetak final, kamera, SMS/WhatsApp, atau dependency baru.
- Setiap task mulai dengan test gagal, jalankan test target lalu seluruh suite, commit setelah lolos. Jangan deploy sebelum pengujian MySQL + SMTP nyata.

## File map

- `database/migrations/*registration*.php`: tabel pending dan tickets, FK unik kupon, kolom role user, setting acara; additive saja.
- `app/Models/PendingRegistration.php`, `Ticket.php`, `Coupon.php`, `User.php`: state dan relasi.
- `app/Services/RegistrationService.php`: OTP/finalisasi/alokasi atomik.
- `app/Mail/RegistrationOtp.php`, `TicketIssued.php`: email plain Blade.
- `app/Http/Controllers/RegistrationController.php`, `Staff/TicketController.php`, `Admin/StaffController.php`: HTTP boundary.
- `app/Http/Middleware/RequireRole.php`, `bootstrap/app.php`, `routes/web.php`: otorisasi/route.
- `resources/views/registration/*`, `staff/*`, `admin/*`, `mail/*`, `public/css/app.css`: UI.
- `tests/Feature/*Test.php`: HTTP, concurrency, role, email, status.

---

### Task 1: Additive schema and domain model

**Files:** Create `database/migrations/2026_11_05_000001_create_registration_tables.php`, `app/Models/PendingRegistration.php`, `app/Models/Ticket.php`; modify `app/Models/Coupon.php`, `app/Models/User.php`; test `tests/Feature/RegistrationSchemaTest.php`.

**Interfaces:** `Ticket::coupon(): BelongsTo`, `Ticket::checkedInBy(): BelongsTo`, `Coupon::ticket(): HasOne`. `PendingRegistration` stores normalized email/phone and hashed OTP. `tickets` stores unique `number`, `barcode`, `email`, `phone`, `coupon_id`, nullable `checked_in_at`, `checked_in_by`, and `print_requests` integer default 0.

- [ ] Write schema test with `RefreshDatabase`: insert pending; insert ticket attached to batch coupon; assert second ticket on same coupon/email/phone fails unique constraint. Assert existing coupon and redemption data survives migrations.
- [ ] Run `php artisan test --filter=RegistrationSchemaTest`; expect failure: missing tables/model.
- [ ] Create migration: `pending_registrations(email unique, phone unique, otp_hash, otp_expires_at, otp_attempts default 0, otp_sent_at, timestamps)`; `tickets` columns above with unique constraints and `foreignId('coupon_id')->unique()->constrained()`, `foreignId('checked_in_by')->nullable()->constrained('users')->nullOnDelete()`; `users.role` string default `admin`. Define casts and relations. Do not change existing migration.
- [ ] Rerun target/full tests; commit `feat: add ticket and OTP schema`.

### Task 2: OTP request, resend and pending cleanup

**Files:** Create `app/Services/RegistrationService.php`, `app/Mail/RegistrationOtp.php`, `resources/views/mail/otp.blade.php`, `app/Http/Controllers/RegistrationController.php`, `resources/views/registration/form.blade.php`; modify `routes/web.php`, `.env.example`; test `tests/Feature/RegistrationOtpTest.php`.

**Interfaces:** `RegistrationService::requestOtp(string $email, string $phone): void`; controller GET `/daftar`, POST `/daftar/otp`, POST `/daftar/otp/resend`. Session holds only pending ID, not raw OTP. `MAIL_*` configured via Laravel defaults.

- [ ] Tests with `Mail::fake()`, `RateLimiter::clear()` and `RefreshDatabase`: required/invalid email/phone; normalized values; OTP mail queued/sent; hash not plaintext; expiry 10 minutes; cooldown 60 seconds; resend rotates hash; request IP/email/phone throttled; existing ticket yields neutral response; no-stock disables registration. Freeze time using `travelTo()`.
- [ ] Run `php artisan test --filter=RegistrationOtpTest`; expect 404/missing service.
- [ ] Implement numeric OTP via `random_int(0, 999999)` padded to six digits, store `Hash::make($otp)`, expiry `now()->addMinutes(10)`. Normalize email lowercase/trim; phone to canonical Indonesian digits beginning `62` (reject non-Indonesian/invalid length); validate both before storage. RateLimiter keys hashed for PII. Do not log OTP. Resend increments per-key limits and invalidates old OTP. Pending records older than 24 hours removed with scheduled `DB::table('pending_registrations')->where('created_at','<',now()->subDay())->delete()` in `routes/console.php`; cron documented later.
- [ ] Add mail-safe gate `REGISTRATION_OPEN=false` AND `REGISTRATION_MAIL_VERIFIED=false` by default; form displays closed state unless both true and available stock. `.env.example` includes SMTP placeholders; never set `MAIL_MAILER=log` on deployed registration.
- [ ] Target/full test, commit `feat: request and rotate registration OTP`.

### Task 3: Atomic finalization, ticket mail and barcode

**Files:** Modify `app/Services/RegistrationService.php`, `app/Http/Controllers/RegistrationController.php`, `routes/web.php`; create `app/Mail/TicketIssued.php`, `resources/views/mail/ticket.blade.php`, `resources/views/registration/success.blade.php`; test `tests/Feature/RegistrationFinalizationTest.php`.

**Interfaces:** `RegistrationService::complete(int $pendingId, string $otp): Ticket`; POST `/daftar` validates OTP and sends mail after commit. `Ticket::barcode` is random opaque 32+ bytes encoded printable; `Ticket::number` unique stable printable ID. QR/barcode in email represents `ticket.barcode` only (not coupon code).

- [ ] Tests: wrong OTP increments attempts and blocks after five; expired OTP rejected; verified OTP allocates exactly one active/unexpired/unassigned coupon; no stock leaves no ticket; duplicate submit returns same ticket; email/phone unique; email ticket content includes number, participant email, barcode, location `Ruang Kepegawaian Gedung Utama Lt. 2`; mail transport exception leaves ticket intact and resend uses same number/coupon; no raw phone in barcode. Test concurrent finalization against MySQL using two DB connections/processes; SQLite unit tests alone are insufficient proof of row locking.
- [ ] Run `php artisan test --filter=RegistrationFinalizationTest`; expect failure.
- [ ] In transaction lock pending row (`lockForUpdate()`), verify attempts/expiry using `Hash::check`, then select eligible coupon joined active/unexpired batch, `whereDoesntHave('ticket')->orderBy('coupons.id')->lockForUpdate()->first()`; create ticket with database unique constraints, delete pending; retry DB deadlocks only using Laravel transaction attempts; never reallocate for already-created ticket. Dispatch/send mail after commit; persist delivery failure indicator to allow retry without duplication. Do not convert failed mail to failed registration.
- [ ] Render success with barcode and retry email action rate-limited. Run target/full tests and MySQL test; commit `feat: allocate coupons after verified OTP`.

### Task 4: Roles, staff management and scanner

**Files:** Create `app/Http/Middleware/RequireRole.php`, `app/Http/Controllers/Admin/StaffController.php`, `app/Http/Controllers/Staff/TicketController.php`, `resources/views/admin/staff.blade.php`, `resources/views/staff/scan.blade.php`, `resources/views/staff/ticket.blade.php`; modify `bootstrap/app.php`, `routes/web.php`, `app/Models/User.php`, `resources/views/components/layouts/app.blade.php`; test `tests/Feature/StaffAccessTest.php`.

**Interfaces:** admin may create/revoke staff accounts, staff may GET `/staff/scan`, POST `/staff/lookup`, GET `/staff/tickets/{ticket}`. `role` only `admin` or `staff`. Staff scanner accepts exact barcode token or scanner string (trim CR/LF), not URL; Enter submits form.

- [ ] Tests: guest denied; staff cannot access admin batch/settings/export/staff management; admin can create/revoke staff; scanner lookup shows ticket email, phone, number, coupon code, status but does not change state; invalid token generic error; PII never visible on public route. Existing admin tests remain green.
- [ ] Run `php artisan test --filter=StaffAccessTest`; expect failure.
- [ ] Add `RequireRole` alias and attach `role:admin` to admin routes; staff routes `auth` + `role:admin,staff`; guard Admin login redirect based on role. Validate account create fields and hash password; revoke by disable/role restriction, never reuse initial hardcoded `password`. Scanner form `autofocus`, Enter via native form submit. No camera JS.
- [ ] Target/full tests, commit `feat: restrict and equip staff scanner`.

### Task 5: Check-in, print audit and coupon detail

**Files:** Modify `app/Http/Controllers/Staff/TicketController.php`, `routes/web.php`, `app/Http/Controllers/Admin/BatchController.php`, `resources/views/staff/ticket.blade.php`, `resources/views/staff/print.blade.php`, `resources/views/admin/batches/show.blade.php`, `public/css/app.css`; test `tests/Feature/CheckInPrintTest.php` and `tests/Feature/AdminCouponDetailTest.php`.

**Interfaces:** POST `/staff/tickets/{ticket}/check-in` atomically sets `checked_in_at`/`checked_in_by` once. GET `/staff/tickets/{ticket}/print` shows assigned coupon QR using existing `/c/{code}` URL. POST `/staff/tickets/{ticket}/print` records one print request; print page calls browser `window.print()` only after explicit button. Batch detail accepts `filter=all|unredeemed|redeemed`.

- [ ] Tests: preview is read-only; double check-in keeps first timestamp and staff; guest forbidden; print before check-in forbidden; repeated print preserves ticket and coupon while incrementing print audit and showing `CETAK ULANG`; QR uses coupon URL and separate from email barcode; batch listing shows code/status/redeemed_at Asia/Jakarta/IP; filters isolate `redeemed_at` null/not null with pagination; role access enforced.
- [ ] Run both target tests; expect failure.
- [ ] Use guarded `whereNull('checked_in_at')->update(...)` or locked transaction for check-in. Print audit records request count, not printer success. Browser print CSS hides controls; maintain visible accessible print trigger. Batch detail is read-only and escapes PII; no filters on check-in mistakenly substituted for redeemed status.
- [ ] Target/full tests, commit `feat: check in and print assigned coupons`.

### Task 6: Operational configuration, end-to-end verification and deploy gate

**Files:** Modify `README.md`, `.env.example`, admin settings controller/view, `routes/console.php`; create `tests/Feature/RegistrationJourneyTest.php`.

**Interfaces:** admin manages title/location/registration-open setting; no event date required. Existing setting key `redemption_password` unchanged.

- [ ] Test full journey: batch generation, OTP, ticket issuance, scanner lookup, check-in, print, QR redemption once, status history. Verify `APP_URL=https://devel.feb.ub.ac.id/kupon` generates correct URLs, session cookie scoped `/kupon` with Secure/HttpOnly/SameSite=Lax. Test closed registration default.
- [ ] Run `php artisan test --filter=RegistrationJourneyTest`; expect failure.
- [ ] Implement admin-only event settings and `README.md` runbook: SMTP `.env` placeholders, verified-gate procedure, `php artisan schedule:run` every minute, MySQL migrations/backup, HTTPS, session settings, manual inbox OTP/ticket test, queue worker only if mail is queued, rollback by closing registration. Do not include credentials. Preserve existing data.
- [ ] Run `php artisan test`, `php artisan route:list`, `php artisan config:clear`; run MySQL concurrency suite and real SMTP inbox check with supplied credentials. If SMTP unavailable, leave registration closed and report blocked; do not claim delivery. Verify real USB scanner and printer with device access when available, otherwise state unverified.
- [ ] Commit `feat: document and verify registration operations`. Deploy only after explicit authorization and verified mail configuration.

## Self-review

Spec coverage: OTP, allocation, barcode, roles, scan, check-in, print, resend, batch detail, preservation, SMTP gate, subpath, session, MySQL concurrency, printer boundary mapped above. No automatic deletion of legacy coupons. External SMTP credentials, final print art, event time, and real hardware are deliberately outside code scope until supplied.
