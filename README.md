# UTS PBO - Sistem Pengelolaan Jadwal Perkuliahan Mahasiswa (BAAK UCIC)

Laravel 13 + SESSION_DRIVER=file + Tailwind CSS v4 via Vite  
Lanjutan dari Tugas Pertemuan 7: https://github.com/hafifradhitya/tugas-pbo-pertemuan7

## Identitas Mahasiswa
- **Nama:** Radhitya Hafif
- **NIM:** 20251020004
- **Program Studi:** Teknik Informatika S-1 (Semester 3)
- **Mata Kuliah:** Pemrograman Berorientasi Objek (TI033015)
- **Dosen Pengampu:** Hilman Lesmana, S.T., M.S.F.
- **Institusi:** Universitas Catur Insan Cendekia (UCIC)

## Cara Menjalankan
1. `composer install`
2. `npm install`
3. `cp .env.example .env`
4. `php artisan key:generate`
5. Pastikan `SESSION_DRIVER=file` di `.env`
6. `npm run dev` (di terminal 1)
7. `php artisan serve` (di terminal 2)
8. Buka browser: `http://127.0.0.1:8000/dashboard` atau `http://127.0.0.1:8000/jadwal`

## Struktur File Utama
- `routes/web.php` — 7 route CRUD + 1 route dashboard + redirect root
- `app/Http/Controllers/JadwalController.php` — 7 method CRUD (`index, create, store, show, edit, update, destroy`) + 1 method `dashboard()`
- `resources/views/layouts/app.blade.php` — Master layout antarmuka BAAK UCIC dengan Tailwind v4 via Vite
- `resources/views/jadwal/dashboard.blade.php` — Dashboard monitoring jadwal
- `resources/views/jadwal/index.blade.php` — Daftar jadwal, filter pencarian/hari/tipe, empty state, tabel 11 kolom
- `resources/views/jadwal/show.blade.php` — Tampilan rincian 11 atribut jadwal
- `resources/views/jadwal/create.blade.php` — Formulir tambah jadwal baru
- `resources/views/jadwal/edit.blade.php` — Formulir pembaruan jadwal (kode readonly)

## Catatan Arsitektur & Keamanan
- **Tanpa database:** Data disimpan sepenuhnya di session file (`SESSION_DRIVER=file`) pada direktori `storage/framework/sessions`.
- **Dashboard real-time:** Angka total, status aktif, tipe, dan jadwal hari ini dihitung langsung dari session, bukan nilai statis.
- **Keamanan:** Dilengkapi proteksi CSRF (`@csrf`), method spoofing (`@method('PUT')`, `@method('DELETE')`), konfirmasi penghapusan dialog JavaScript, server-side validation (`after:jam_mulai`, pengecekan kode unik), serta escaping XSS bawaan Blade (`{{ }}`).
