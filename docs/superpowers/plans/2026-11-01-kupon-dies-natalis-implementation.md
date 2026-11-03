# Kupon Dies Natalis FEB UB Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Build a Laravel Blade + MySQL coupon generator and single-use QR redemption flow.

**Architecture:** One Laravel application serves admin pages and public coupon pages. MySQL stores batches, coupons, settings, failed redemption attempts, and redemption audit fields. QR PNGs and CSV are generated into an in-memory ZIP response; no public export files persist.

**Tech Stack:** Laravel 12, PHP 8.5, Blade, Bootstrap-free CSS, MySQL, PHPUnit/Pest feature tests, `endroid/qr-code` for PNG QR generation.

**Spec:** `docs/superpowers/specs/2026-11-01-kupon-dies-natalis-design.md`

## Global Constraints

- No React, API, mobile app, nominal, recipient identity, PDF, or offline redemption.
- Initial redemption password is `febub65`; store only its hash and permit admin rotation.
- Coupon lifetime is 7 days from batch creation.
- Coupon redemption must be atomic and single-use under concurrent requests.
- Admin-only routes require authentication and CSRF protection.
- QR code uses a cryptographically random, non-sequential code with prefix `FEB65-LUSTRUM-`.

---

### Task 1: Scaffold Laravel application

**Files:**
- Create: Laravel application files under repository root
- Modify: `.env.example`, `composer.json`, `README.md`

- [ ] **Step 1: Create Laravel app**

Run:
```bash
composer create-project laravel/laravel:^12.0 .
composer require endroid/qr-code
```
Expected: Laravel app boots and dependency lock files exist.

- [ ] **Step 2: Configure database and app defaults**

Set `.env.example` placeholders for MySQL and `APP_URL`; set `SESSION_DRIVER=database`; retain secrets out of version control.

- [ ] **Step 3: Run baseline checks**

Run:
```bash
php artisan about
php artisan test
```
Expected: application initializes; baseline tests pass.

- [ ] **Step 4: Commit**

```bash
git add . && git commit -m "chore: scaffold coupon application"
```

### Task 2: Add database schema and models

**Files:**
- Create: `database/migrations/*_create_batches_table.php`
- Create: `database/migrations/*_create_coupons_table.php`
- Create: `database/migrations/*_create_settings_table.php`
- Create: `database/migrations/*_create_redemption_attempts_table.php`
- Create: `app/Models/Batch.php`, `app/Models/Coupon.php`, `app/Models/Setting.php`, `app/Models/RedemptionAttempt.php`
- Create: `database/seeders/DatabaseSeeder.php`
- Test: `tests/Feature/SchemaTest.php`

**Interfaces:** `Batch hasMany Coupon`; `Coupon belongsTo Batch`; setting key/value stores hashed redemption password; coupon status is represented by `redeemed_at`, batch active flag, and expiry timestamp.

- [ ] **Step 1: Write failing schema test**

Test migration-created tables, unique coupon code, batch-coupon relationship, and nullable redemption fields.

- [ ] **Step 2: Run test**

```bash
php artisan test tests/Feature/SchemaTest.php
```
Expected: FAIL before migrations/models exist.

- [ ] **Step 3: Implement migrations/models**

Use foreign keys, indexes on `code`, `batch_id`, `redeemed_at`, `expires_at`; use UTC timestamps; add `redeemed_ip` and `redeemed_at`.

- [ ] **Step 4: Seed admin and initial setting safely**

Seeder creates admin from `ADMIN_EMAIL` and `ADMIN_PASSWORD` environment values only when present; hash `febub65` as initial redemption password only when setting is absent.

- [ ] **Step 5: Run tests and commit**

```bash
php artisan migrate:fresh --env=testing
php artisan test tests/Feature/SchemaTest.php
 git add . && git commit -m "feat: add coupon data model"
```

### Task 3: Admin authentication and batch generation

**Files:**
- Create: `app/Http/Controllers/Admin/AuthController.php`, `app/Http/Controllers/Admin/BatchController.php`
- Create: `app/Services/CouponBatchGenerator.php`
- Create: `resources/views/admin/login.blade.php`, `resources/views/admin/batches/index.blade.php`, `resources/views/admin/batches/create.blade.php`
- Modify: `routes/web.php`, `resources/views/layouts/app.blade.php`
- Test: `tests/Feature/AdminBatchTest.php`

**Interfaces:** `CouponBatchGenerator::create(string $name, int $quantity): Batch`; controller validates name and bounded quantity, then redirects to batch detail.

- [ ] **Step 1: Write failing feature tests**

Cover unauthenticated denial, valid admin login, batch creation, exact quantity, unique cryptographic codes, prefix, seven-day expiry, and invalid quantity rejection.

- [ ] **Step 2: Run targeted tests**

```bash
php artisan test tests/Feature/AdminBatchTest.php
```
Expected: FAIL.

- [ ] **Step 3: Implement auth, generator, routes, and Blade forms**

Use Laravel auth/session; generate each code from `random_bytes`, encode safely, retry on unique collision; wrap batch creation in a transaction; never accept client-provided code or expiry.

- [ ] **Step 4: Run tests**

```bash
php artisan test tests/Feature/AdminBatchTest.php
```
Expected: PASS.

- [ ] **Step 5: Commit**

```bash
git add . && git commit -m "feat: add admin batch generation"
```

### Task 4: Public coupon status and atomic redemption

**Files:**
- Create: `app/Http/Controllers/CouponController.php`, `app/Services/CouponRedemptionService.php`
- Create: `app/Http/Middleware/RedemptionRateLimit.php`
- Create: `resources/views/coupons/show.blade.php`
- Modify: `routes/web.php`
- Test: `tests/Feature/CouponRedemptionTest.php`

**Interfaces:** `CouponRedemptionService::redeem(string $code, string $password, string $ip): RedemptionResult`; result exposes valid, already-used, expired, inactive, wrong-password, locked, or redeemed state.

- [ ] **Step 1: Write failing tests**

Cover public status, valid password redemption, wrong password, five-failure/15-minute lock, expiry, inactive batch, repeated redemption, CSRF, and two redemption requests where only one succeeds.

- [ ] **Step 2: Run tests**

```bash
php artisan test tests/Feature/CouponRedemptionTest.php
```
Expected: FAIL.

- [ ] **Step 3: Implement status and service**

Use `DB::transaction` plus `lockForUpdate`; verify hashed setting server-side; check active/expiry before update; set `redeemed_at` and `redeemed_ip`; record failed attempts without exposing password state beyond required status.

- [ ] **Step 4: Implement rate limiting**

Count failed attempts per coupon, lock after five for 15 minutes, and add Laravel limiter keyed by IP plus coupon/code. Return generic invalid-password messaging.

- [ ] **Step 5: Run tests and commit**

```bash
php artisan test tests/Feature/CouponRedemptionTest.php
 git add . && git commit -m "feat: add single-use coupon redemption"
```

### Task 5: QR PNG and CSV ZIP export

**Files:**
- Create: `app/Http/Controllers/Admin/ExportController.php`
- Create: `app/Services/CouponExportService.php`
- Modify: `routes/web.php`, `resources/views/admin/batches/index.blade.php`
- Test: `tests/Feature/CouponExportTest.php`

**Interfaces:** `CouponExportService::zip(Batch $batch): StreamedResponse`; ZIP contains one PNG per coupon plus `list_kupon.csv`.

- [ ] **Step 1: Write failing export tests**

Verify admin-only access, ZIP content names, QR payload URL, CSV codes, no export file saved under public storage, and inactive/empty batch handling.

- [ ] **Step 2: Run tests**

```bash
php artisan test tests/Feature/CouponExportTest.php
```
Expected: FAIL.

- [ ] **Step 3: Implement in-memory ZIP**

Use `ZipArchive` temporary file outside public storage, generate PNGs with `endroid/qr-code`, add QR payload `route('coupons.show', $coupon->code)`, add UTF-8 CSV, stream response, delete temp file in response cleanup.

- [ ] **Step 4: Run tests and commit**

```bash
php artisan test tests/Feature/CouponExportTest.php
 git add . && git commit -m "feat: export coupon QR zip"
```

### Task 6: Admin dashboard, settings, and batch controls

**Files:**
- Create: `app/Http/Controllers/Admin/SettingController.php`
- Create: `resources/views/admin/batches/show.blade.php`, `resources/views/admin/settings.blade.php`
- Modify: admin controllers/routes/views
- Test: `tests/Feature/AdminControlsTest.php`

- [ ] **Step 1: Write failing tests**

Cover status counts, password rotation hash verification, batch deactivation, refusal to delete used batches, and admin-only access.

- [ ] **Step 2: Implement minimal dashboard and controls**

Use aggregate queries for counts; update password through `Hash::make`; deactivate rather than delete used batches; validate password confirmation and minimum length.

- [ ] **Step 3: Run tests and commit**

```bash
php artisan test tests/Feature/AdminControlsTest.php
 git add . && git commit -m "feat: add admin controls and password rotation"
```

### Task 7: UI, accessibility, security headers, and documentation

**Files:**
- Create/modify: `resources/css/app.css`, Blade templates
- Create: `app/Http/Middleware/SecurityHeaders.php`
- Modify: `bootstrap/app.php`, `README.md`, `.env.example`
- Test: `tests/Feature/SecurityTest.php`

- [ ] **Step 1: Write failing security tests**

Check CSRF, security headers, no password in rendered HTML/source, no indexing directive, escaped code output, and authenticated admin route protection.

- [ ] **Step 2: Implement focused responsive UI**

Use semantic forms, visible focus styles, large touch targets, explicit status colors plus text, keyboard operation, and mobile-first layout. Keep copy limited to event title, code, status, expiry, and redemption action.

- [ ] **Step 3: Add security headers and deployment docs**

Add `X-Content-Type-Options`, `Referrer-Policy`, and `Content-Security-Policy` compatible with local assets; document HTTPS, MySQL migration, storage permissions, admin provisioning, queue-free export limits, and backup requirements.

- [ ] **Step 4: Run full verification**

```bash
php artisan test
php artisan route:list
php artisan config:clear
```
Expected: all tests pass; routes load without errors.

- [ ] **Step 5: Commit**

```bash
git add . && git commit -m "chore: harden and document coupon app"
```
