# Panduan Pengujian Lengkap — Tugas Week 7 (Bahasa Indonesia)

Panduan ini berisi langkah-langkah praktis untuk menguji setiap nomor pada tugas Week 7. Ikuti urutan di lingkungan lokal Anda (XAMPP pada Windows). Termasuk cek CLI, SQL, dan UI serta contoh hasil yang diharapkan.

---

## Lokasi penting
- Root project: `c:\xampp\htdocs\PrakCRUD`
- Konfigurasi DB: `config/database.php` (database: `minimarket`)
- Skrip seed: `seed.php`
- Halaman uji CSRF: `csrf-test.html`
- Bulk recycle handler: `bulk_action.php`
- Auto-delete action: `?c=maintenance&a=autoDeleteOld`
- Validator: `models/Validator.php`
- Factories: `models/AppointmentFactory.php`, `models/DoctorFactory.php`
- Helpers: `helpers/Sanitizer.php`, `helpers/DateHelper.php`, `helpers/Csrf.php`
- Flash rendering: `views/layout/header.php`

---

## Ringkasan singkat pengujian
1. Validator: numeric(), between(), in(), unique(), confirmed(), dateFormat()
2. Factory: AppointmentFactory & DoctorFactory + `seed.php` (50 patients, 20 doctors, 100 appointments)
3. Recycle Bin: bulk restore/delete + Auto-Delete (>30 hari)
4. Helpers: Sanitizer & DateHelper
5. CSRF: token di form & penolakan pada submit tanpa token (`csrf-test.html`)
6. Flash messages & validation
7. Contoh integrasi: AppointmentsController

---

## 1) Validator — cek fungsi dasar
Jalankan perintah berikut di PowerShell (dari `c:\xampp\htdocs\PrakCRUD`):

```powershell
# numeric
php -r "require 'models/Validator.php'; var_dump(Validator::numeric('12.34'));"

# between (angka)
php -r "require 'models/Validator.php'; var_dump(Validator::between(5,1,10));"

# in (whitelist)
php -r "require 'models/Validator.php'; var_dump(Validator::in('b',['a','b','c']));"

# dateFormat (contoh YYYY-mm-dd)
php -r "require 'models/Validator.php'; var_dump(Validator::dateFormat('2025-11-02','Y-m-d'));"

# confirmed
php -r "require 'models/Validator.php'; var_dump(Validator::confirmed('secret','secret'));"
```

Tes `unique` (perlu DB): masukkan data sample dulu (mis. lewat UI atau SQL), lalu:

```powershell
php -r "require 'models/Validator.php'; var_dump(Validator::unique('kontak','email','someone@example.com'));"
```

Expected:
- Fungsi mengembalikan `true`/`false` sesuai kondisi.
- `unique` mengembalikan `false` jika value sudah ada, `true` jika unik.

Catatan: Untuk pengecekan kombinasi kolom (mis. `doctor_id + start_time`) buat query khusus.

---

## 2) Factory & Seed
Tujuan: Pastikan `seed.php` membuat data realistis.

Jalankan seed:

```powershell
cd c:\xampp\htdocs\PrakCRUD
php .\seed.php
```

Expected output: konfirmasi insert, mis. "Inserted 50 patients", "Inserted 20 doctors", "Inserted 100 appointments".

Verifikasi cepat di MySQL:

```powershell
mysql -u root -e "USE minimarket; SELECT COUNT(*) FROM patients; SELECT COUNT(*) FROM doctors; SELECT COUNT(*) FROM appointments;"
```

Periksa beberapa appointment:

```sql
SELECT id, patient_id, doctor_id, start_time, duration_minutes FROM appointments LIMIT 10;
```

Expected:
- `start_time` pada hari kerja (Mon-Fri), jam antara 08:00–17:00 (sesuai seed logic).
- `duration_minutes` antara 30–60.

Tes manual (buat satu doctor/appointment):

```powershell
php -r "require 'models/DoctorFactory.php'; var_dump(DoctorFactory::create(['name'=>'Dr Test','email'=>'dr@test.com','phone'=>'08123','specialization'=>'General']));"
php -r "require 'models/AppointmentFactory.php'; var_dump(AppointmentFactory::create(['patient_id'=>1,'doctor_id'=>1,'start_time'=>'2025-11-10 09:00:00','duration_minutes'=>30]));"
```

---

## 3) Recycle Bin (Bulk + Auto-Delete)
### Bulk Restore / Delete (UI)
1. Buka: `http://localhost/PrakCRUD/?c=minimarket&a=index`
2. Hapus (soft-delete) beberapa baris.
3. Di bagian Recycle Bin, centang item lalu klik "Restore Selected" atau "Delete Selected".

Expected:
- Restore: `deleted_at` menjadi `NULL`.
- Delete Selected: row dihapus permanen.

Verifikasi SQL:

```sql
SELECT id, nama_minimarket, deleted_at FROM minimarket WHERE deleted_at IS NOT NULL;
```

### Auto-Delete (>30 hari)
1. Set beberapa `deleted_at` menjadi >30 hari:

```sql
UPDATE minimarket SET deleted_at = DATE_SUB(NOW(), INTERVAL 60 DAY) WHERE id IN (1,2,3);
```

2. Di Recycle Bin klik "Auto-Delete >30 days".

Expected: flash sukses berisi jumlah record yang dihapus permanen dan rows hilang dari DB.

Verifikasi:

```sql
SELECT id FROM minimarket WHERE id IN (1,2,3);
```

Catatan teknis: `Repository::autoDeleteOld($days)` menghapus dan mengembalikan jumlah affected rows; controller men-set flash.

---

## 4) Helpers — Sanitizer & DateHelper
Tes singkat:

```powershell
php -r "require 'helpers/Sanitizer.php'; echo Sanitizer::phone('+62 (812)-3456-7890'), PHP_EOL;"
php -r "require 'helpers/Sanitizer.php'; echo Sanitizer::name('john DOE!123'), PHP_EOL;"
php -r "require 'helpers/Sanitizer.php'; echo Sanitizer::alphanumeric('ab#12-34'), PHP_EOL;"

php -r "require 'helpers/DateHelper.php'; echo DateHelper::format('2025-11-02','d/m/Y'), PHP_EOL;"
php -r "require 'helpers/DateHelper.php'; echo DateHelper::age('1990-05-10'), PHP_EOL;"
php -r "require 'helpers/DateHelper.php'; echo DateHelper::diffHuman('2024-01-01'), PHP_EOL;"
php -r "require 'helpers/DateHelper.php'; echo DateHelper::toMysql('02-11-2025'), PHP_EOL;"
php -r "require 'helpers/DateHelper.php'; var_dump(DateHelper::isWeekend('2025-11-02'));"
```

Expected: output terformat dengan benar.

---

## 5) CSRF Protection
### Verifikasi token pada form
- Buka form create/edit (contoh: `?c=minimarket&a=create`) → Inspect Element → harus ada `<input type="hidden" name="csrf_token" ...>`.

### Tes attack page
- Buka: `http://localhost/PrakCRUD/csrf-test.html` (sudah berisi form tanpa token dan form create tanpa token yang melakukan fetch dengan no-referrer).
- Submit form tanpa token.

Expected: server menolak (HTTP 403) atau redirect kembali dengan flash error "Invalid CSRF token. Silakan coba lagi.".

### Tes form valid
- Submit form dari aplikasi (dengan token) → aksi berhasil dan flash sukses muncul.

Catatan: `helpers/Csrf::verifyOrFail` telah diubah untuk set flash dan redirect bila referer tersedia; bila tidak, return HTTP 403.

---

## 6) Flash messages & Validation UX
Tes:
- Buat record valid lewat UI → muncul flash success di header.
- Coba buat data duplikat (mis. email kontak yang sama) → redirect ke form dan muncul flash error (list pesan).
- CSRF error → flash error.

Verifikasi: `views/layout/header.php` menampilkan dan meng-unset `$_SESSION['flash']`.

---

## 7) AppointmentsController — contoh integrasi
Kontrol yang diharapkan:
- CSRF diverifikasi
- Waktu appointment valid (antara 08:00–17:00)
- Durasi numeric 30–60
- Periksa existensi doctor & patient
- Cek overlap appointment
- Jika error → set flash error array dan redirect
- Jika sukses → simpan appointment, set flash success dan redirect

Tes sampel:
- Coba buat appointment pada jam di luar 08:00–17:00 → ditolak.
- Buat appointment yang tumpang tindih untuk dokter sama → ditolak.

---

## 8) Acceptance Checklist (ringkas)
- [ ] Validator functions bekerja sesuai spesifikasi
- [ ] `unique` mencegah duplikat di controller (Kontak, Minimarket)
- [ ] `seed.php` menghasilkan 50 patients, 20 doctors, 100 appointments
- [ ] Bulk restore & delete bekerja dari UI
- [ ] Auto-delete >30 hari menghapus permanen dan menampilkan count
- [ ] Sanitizer & DateHelper bekerja
- [ ] Semua form state-changing punya CSRF token; attack page ditolak
- [ ] Flash success/error muncul di header dan meng-clear setelah reload

---

## 9) Perintah cepat (copy-paste)
Seed data:
```powershell
cd c:\xampp\htdocs\PrakCRUD
php .\seed.php
```
Tes Validator & Helper:
```powershell
php -r "require 'models/Validator.php'; var_dump(Validator::numeric('12.3'));"
php -r "require 'helpers/Sanitizer.php'; echo Sanitizer::phone('+62 812 3456 7890');"
```
Tes auto-delete langsung:
```powershell
php -r "require 'models/Repository.php'; var_dump(Repository::autoDeleteOld(30));"
```

---

## 10) Troubleshooting singkat
- Jika seed gagal: jalankan pada DB kosong atau tambahkan `TRUNCATE` sebelum insert.
- Flash tidak muncul: periksa `session.save_path` dan pastikan `views/layout/header.php` dimuat.
- CSRF tidak menolak: pastikan token ada di form dan `verifyOrFail` dipanggil di controller.
- DB connection error: periksa `config/database.php` dan bahwa MySQL berjalan.

---

## 11) Opsional / Lanjutan
Pilihan yang bisa saya bantu selanjutnya (sebutkan salah satu):
- Buat skrip `run-all.ps1` (PowerShell) untuk menjalankan semua tes CLI secara otomatis.
- Tambah opsi `--purge` pada `seed.php` agar idempotent.
- Buat PHPUnit quick tests untuk beberapa fungsi (Validator, Repository.autoDeleteOld).

---

Jika Anda ingin saya membuatkan skrip `run-all.ps1` atau menambahkan opsi `--purge` pada `seed.php`, tuliskan pilihan Anda dan saya akan lanjutkan.