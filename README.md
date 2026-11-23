# UTS PBO - Sistem Pengelolaan Jadwal Perkuliahan Mahasiswa (BAAK UCIC)

Laravel 13 + SESSION_DRIVER=file + Tailwind CSS v4 & DaisyUI via Vite  
Lanjutan dari Tugas Pertemuan 7: https://github.com/hafifradhitya/tugas-pbo-pertemuan7

## Identitas Mahasiswa
- **Nama:** Radhitya Hafif
- **NIM:** 20251020004
- **Program Studi:** Teknik Informatika S-1 (Semester 3)
- **Mata Kuliah:** Pemrograman Berorientasi Objek (TI033015)
- **Dosen Pengampu:** Hilman Lesmana, S.T., M.S.F.
- **Institusi:** Universitas Catur Insan Cendekia (UCIC)

## Fitur & Modul Sistem BAAK UCIC
1. **Autentikasi Sesi BAAK:**
   - Halaman Login & Logout berbasis session file murni tanpa DB (`/login`, `/logout`).
   - Akun default: `admin@ucic.ac.id` / `admin123`.
2. **Dashboard Kontrol Akademik (Inspirasi Modern Control Center):**
   - 4 Kartu Metrik: Total Jadwal, Jadwal Aktif, Sesi Hari Berjalan, dan Beban SKS Terjadwal.
   - Analitik Visual Distribusi Sesi Mingguan (Senin - Sabtu).
   - Diagram Donut Distribusi Kategori Sesi (Teori, Praktikum, Daring).
   - Agenda Perkuliahan Hari Ini.
3. **Modul Inti CRUD Jadwal Kuliah (Sesuai Kontrak UTS):**
   - 7 Method RESTful (`index, create, store, show, edit, update, destroy`) berurutan aman.
   - Tabel 11 kolom lengkap + Filter pencarian, hari, dan tipe (GET).
   - Kode unik string `JDW001` sebagai primary session key (`readonly` saat edit).
4. **Modul Ekstra Pendukung Akademik Kampus:**
   - **Direktori Dosen Pengampu (`/dosen`):** Agregasi beban mengajar dan mata kuliah per dosen.
   - **Alokasi Ruangan & Lab (`/ruangan`):** Monitoring penggunaan lab komputer dan ruang teori.
   - **Daftar Kelas Mahasiswa (`/kelas`):** Rombongan belajar TI dan beban SKS semesteran.

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
