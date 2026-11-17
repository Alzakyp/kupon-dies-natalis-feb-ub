# Kategori Pendaftaran Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Add validated Mahasiswa Aktif and Alumni registration categories while preserving existing OTP, coupon, ticket, and check-in flows.

**Architecture:** Additive `student_registries` reference data keyed by textual NIM and category. A session-bound lookup stores only the verified registry ID; OTP and ticket records persist category and registry ID. Excel import uses a repeatable Artisan command; source file stays outside Git.

**Tech Stack:** Laravel 12, PHP 8.5, MySQL, Blade, PHPUnit, OpenSpout already available if present; no new dependency unless existing composer inspection proves required.

**Spec:** `docs/superpowers/specs/2026-11-17-registration-categories-design.md`

## Global Constraints

- Do not delete or rewrite existing coupon, batch, ticket, or redemption data.
- NIM is stored as text; leading zeroes must survive import and lookup.
- Both categories require exact NIM validation; alumni stays unavailable until alumni registry rows exist.
- Do not commit the Excel file or personally identifying source data.
- Keep `REGISTRATION_OPEN=false` or `REGISTRATION_MAIL_VERIFIED=false` on deployment until real SMTP verification.
- Preserve `/kupon` subpath URL generation, OTP throttling, and existing ticket uniqueness.

---

### Task 1: Registry schema and models

**Files:**
- Create: `database/migrations/2026_11_17_000001_create_student_registries_table.php`
- Create: `app/Models/StudentRegistry.php`
- Modify: `app/Models/PendingRegistration.php`, `app/Models/Ticket.php`
- Test: `tests/Feature/StudentRegistryTest.php`

**Interfaces:**
- `StudentRegistry::normalizeNim(string $nim): string`
- `StudentRegistry::pendingRegistrations(): HasMany`
- `StudentRegistry::tickets(): HasMany`
- Pending/ticket fields: `student_registry_id`, `registration_type`.

- [ ] Write failing tests: textual NIM, unique `(nim, registration_type)`, category values, pending/ticket relations.
- [ ] Run `php artisan test --filter=StudentRegistryTest`; expect missing table/fields.
- [ ] Add additive migration with `nim`, `name`, `education_level`, nullable `study_program`, `registration_type`, timestamps; add indexes and foreign keys from pending/tickets.
- [ ] Add casts, fillable fields, relations, and NIM normalization preserving leading zeroes while trimming whitespace.
- [ ] Run target/full tests; commit `feat: add categorized student registry`.

### Task 2: Excel import command and seeder

**Files:**
- Create: `app/Console/Commands/ImportStudentRegistry.php`
- Create: `database/seeders/StudentRegistrySeeder.php`
- Modify: `routes/console.php` only if cleanup registration is already defined there
- Test: `tests/Feature/StudentRegistryImportTest.php`

**Interfaces:**
- Command: `php artisan students:import {path} {--type=active_student}`.
- Seeder accepts an explicit path argument/configured source and performs idempotent upsert.

- [ ] Write failing test using a small temporary CSV/XLSX fixture generated in test; assert NIM remains text, fields map from `NIM`, `Nama`, `JENJANG`, `Program Studi`, `Status Aktif`.
- [ ] Run target test; expect command/registry missing.
- [ ] Implement import with existing installed spreadsheet reader; if none supports XLSX, use a minimal ZIP/XML reader rather than adding a dependency. Skip blank NIM rows; for active imports skip rows whose `Status Aktif` is explicitly inactive; normalize category.
- [ ] Upsert by `(nim, registration_type)` and print imported/skipped counts. Never log names, email, phone, or full rows.
- [ ] Run import test and full suite; commit `feat: import student registry data`.
- [ ] On server, upload the Excel out-of-band, run command with explicit path, verify count, then remove/restrict the source file.

### Task 3: Category choice and NIM lookup

**Files:**
- Modify: `app/Http/Controllers/RegistrationController.php`
- Modify: `routes/web.php`
- Modify: `resources/views/registration/form.blade.php`
- Test: `tests/Feature/RegistrationCategoryTest.php`

**Interfaces:**
- `GET /daftar?type=active_student|alumni`
- `POST /daftar/lookup` with `type`, `nim`
- Session keys: `registration_type`, `student_registry_id`.

- [ ] Write failing tests: two category buttons, exact valid active lookup, invalid/mismatched NIM generic failure, alumni unavailable without alumni row, throttling, closed registration still 404.
- [ ] Run target test; expect missing route/session behavior.
- [ ] Implement category choice with allowlisted values and exact lookup; apply rate limiter keyed by IP plus hashed NIM; return only verified name/education level/program.
- [ ] Render readonly verified identity and contact form only after lookup; never trust browser-posted name/program.
- [ ] Run target/full tests; commit `feat: validate registration categories by nim`.

### Task 4: Carry verified identity into OTP and ticket

**Files:**
- Modify: `app/Http/Controllers/RegistrationController.php`
- Modify: `app/Services/RegistrationService.php`
- Modify: `resources/views/registration/success.blade.php`
- Test: `tests/Feature/RegistrationCategoryJourneyTest.php`

**Interfaces:**
- `RegistrationService::requestOtp(string $email, string $phone, ?int $registryId = null, ?string $registrationType = null): PendingRegistration`
- `RegistrationService::complete(...)` copies verified registry/category into ticket.

- [ ] Write failing tests: active lookup → OTP → ticket preserves registry/category; tampered request fields cannot alter identity; legacy direct OTP flow is rejected or explicitly tested according to final route policy; existing ticket tests remain green.
- [ ] Run target test; expect signature/schema/controller gaps.
- [ ] Require matching session registry/category before OTP; persist them on pending; verify registry/category again inside finalization transaction.
- [ ] Display verified identity on success; do not expose unnecessary registry records publicly.
- [ ] Run target/full tests; commit `feat: persist registration category on tickets`.

### Task 5: Admin visibility and pagination

**Files:**
- Modify: `resources/views/admin/batches/show.blade.php`
- Modify: `public/css/app.css`
- Modify: `app/Http/Controllers/Admin/BatchController.php` only if participant filtering is added
- Test: `tests/Feature/PaginationTest.php`, `tests/Feature/AdminRegistrationCategoryTest.php`

- [ ] Finish the existing pagination test first; render Laravel default pagination with query-string preservation, visible focus, accessible labels, and mobile overflow-safe layout.
- [ ] Add category column to admin participant/ticket detail only if the current page already exposes participant data; do not add a new dashboard.
- [ ] Run targeted/full tests; commit `fix: style admin pagination and show registration category`.

### Task 6: Operational import, documentation, and deployment

**Files:**
- Modify: `README.md`
- Modify: `.env.example` only if category gate/config is needed
- Do not commit Excel data.

- [ ] Document local secure import, server command, expected row-count verification, backup, and source-file removal.
- [ ] Run `php artisan test --compact`, `git diff --check`, `php artisan route:list`.
- [ ] Deploy code to devel; run migration and import only after explicit server path confirmation.
- [ ] Verify `/kupon/daftar` closed/open behavior, active lookup, alumni unavailable, and SMTP gate. Do not enable public registration without real inbox OTP and ticket verification.
- [ ] Commit documentation if needed and push/deploy only after all checks pass.

## Self-review

Coverage: registry schema, safe import, both category choices, exact NIM validation, session-bound identity, OTP/ticket persistence, alumni gating, pagination, tests, deployment. Deliberately excluded: alumni data import until supplied, new participant fields beyond registry/category, public search, camera/SMS, and Excel in Git.
