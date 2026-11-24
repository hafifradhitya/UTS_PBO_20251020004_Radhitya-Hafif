# Sistem Pengelolaan Jadwal Perkuliahan Mahasiswa (UTS PBO)

Aplikasi web CRUD berbasis **Laravel 13** yang mengadaptasi entitas **Jadwal Perkuliahan Mahasiswa (BAAK UCIC)** dari proyek Capstone dan penugasan Pemrograman Berorientasi Objek. Seluruh data jadwal disimpan pada **Session (`SESSION_DRIVER=file`)** tanpa menggunakan koneksi database maupun Eloquent.

---

## Identitas Mahasiswa

- **Nama Lengkap**: Radhitya Hafif
- **NIM**: 20251020004
- **Program Studi / Kelas**: S-1 Teknik Informatika (Semester 3)
- **Mata Kuliah**: Pemrograman Berorientasi Objek (Kode: TI033015)
- **Dosen Pengampu**: Hilman Lesmana, S.T., M.S.F.
- **Institusi**: Fakultas Teknologi Informasi — Universitas Catur Insan Cendekia (UCIC)
- **Repository Tugas Pertemuan 7**: [https://github.com/hafifradhitya/tugas-pbo-pertemuan7](https://github.com/hafifradhitya/tugas-pbo-pertemuan7)
- **Repository UTS**: [https://github.com/hafifradhitya/UTS_PBO_20251020004_Radhitya-Hafif](https://github.com/hafifradhitya/UTS_PBO_20251020004_Radhitya-Hafif)
- **Berkas Laporan PDF**: `UTS_PBO_20251020004_Radhitya_Hafif.pdf`

---

## Ringkasan Arsitektur

- **Pola Desain**: `Route -> Controller -> Blade` (MVC murni tanpa Model database)
- **Routing (`routes/web.php`)**:
  - `GET /` &rarr; *Closure Redirect* ke halaman `/dashboard`
  - `GET /login` (`login`) &rarr; `AuthController@showLoginForm`
  - `POST /login` (`login.post`) &rarr; `AuthController@login`
  - `POST /logout` (`logout`) &rarr; `AuthController@logout`
  - `GET /dashboard` (`jadwal.dashboard`) &rarr; `JadwalController@dashboard`
  - `GET /jadwal` (`jadwal.index`) &rarr; `JadwalController@index`
  - `GET /jadwal/create` (`jadwal.create`) &rarr; `JadwalController@create`
  - `POST /jadwal` (`jadwal.store`) &rarr; `JadwalController@store`
  - `GET /jadwal/{kode}` (`jadwal.show`) &rarr; `JadwalController@show`
  - `GET /jadwal/{kode}/edit` (`jadwal.edit`) &rarr; `JadwalController@edit`
  - `PUT|PATCH /jadwal/{kode}` (`jadwal.update`) &rarr; `JadwalController@update`
  - `DELETE /jadwal/{kode}` (`jadwal.destroy`) &rarr; `JadwalController@destroy`
  - `POST /jadwal-reset` (`jadwal.reset`) &rarr; `JadwalController@resetDefault`
  - `GET /dosen` (`jadwal.dosen`) &rarr; `JadwalController@dosen`
  - `GET /ruangan` (`jadwal.ruangan`) &rarr; `JadwalController@ruangan`
  - `GET /kelas` (`jadwal.kelas`) &rarr; `JadwalController@kelas`
- **Controller (`app/Http/Controllers/JadwalController.php`)**:
  Memisahkan seluruh logika CRUD ke 7 method utama (`index`, `create`, `store`, `show`, `edit`, `update`, `destroy`) ditambah modul `dashboard()` dan manajemen sesi berbasis file murni.
- **Blade Views (`resources/views/`)**:
  - `layouts/app.blade.php`: Layout master antarmuka (sidebar menu, topbar pencarian dan profil user BAAK, flash alert notifikasi, `@yield('content')`, footer).
  - `jadwal/dashboard.blade.php`: Dasbor analitik, metrik kartu jadwal, statistik mingguan, diagram lingkaran (donut chart) tipe sesi.
  - `jadwal/index.blade.php`: Tabel daftar 11 kolom, form filter pencarian (GET), pesan notifikasi status, kondisi data kosong (empty state), modal konfirmasi hapus.
  - `jadwal/create.blade.php`: Formulir pendaftaran jadwal baru lengkap dengan validasi server-side.
  - `jadwal/edit.blade.php`: Formulir pembaruan dengan nilai awal lama (`old()`), kode read-only, dan simulasi method `@method('PUT')`.
  - `jadwal/show.blade.php`: Rincian lengkap 11 atribut dari satu data jadwal perkuliahan.

---

## Pemetaan Kolom Soal UTS ke Atribut Entitas Jadwal

| Kolom Soal UTS | Atribut Entitas Jadwal | Tipe Data & Format | Konteks & Rasionalisasi BAAK UCIC |
| :--- | :--- | :--- | :--- |
| **Kode** | `kode` | `string(20)` (Contoh: `TI033015`) | Kunci primer asosiatif array session & parameter URL dinamis. Read-only saat update. |
| **Nama example** | `mata_kuliah` | `string(100)` | Nama mata kuliah resmi kurikulum Teknik Informatika UCIC. |
| *(Atribut Tambahan)* | `dosen` | `string(100)` | Dosen pengampu mata kuliah beserta gelar akademik. |
| *(Atribut Tambahan)* | `hari` | `enum (Senin-Sabtu)` | Hari pelaksanaan sesi tatap muka / praktikum. |
| *(Atribut Tambahan)* | `jam_mulai` & `jam_selesai` | `string (HH:MM)` | Rentang jam perkuliahan, tervalidasi dengan aturan `after:jam_mulai`. |
| **Lokasi** | `ruangan` | `string(50)` (Contoh: `Lab 1`) | Ruang teori atau laboratorium komputer pelaksanaan kuliah. |
| *(Atribut Tambahan)* | `kelas` | `string(20)` (Contoh: `TI-3A`) | Rombongan belajar mahasiswa peserta kuliah. |
| **Jumlah** | `sks` | `integer (1 - 6)` | Beban Satuan Kredit Semester dari mata kuliah. |
| **Kategori** | `tipe` | `enum (Teori/Praktikum/Daring)` | Klasifikasi metode pembelajaran akademik BAAK. |
| **Kondisi** | `status` | `enum (Aktif/Dibatalkan/Selesai)` | Status kelangsungan jadwal pada kalender akademik. |

---

## Langkah Menjalankan Proyek Secara Lokal

1. Pastikan **PHP 8.3+** dan **Composer** sudah terpasang pada komputer Anda.
2. Masuk ke direktori proyek dan instal dependensi composer & npm:
   ```bash
   composer install
   npm install
   ```
3. Salin file konfigurasi `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   ```
   Pastikan pada `.env` sudah tertulis:
   ```env
   SESSION_DRIVER=file
   ```
4. Buat kunci aplikasi Laravel (*application key*):
   ```bash
   php artisan key:generate
   ```
5. Pastikan folder `storage/framework/sessions` tersedia dan dapat ditulisi (*writable*).
6. Bangun aset antarmuka Tailwind CSS v4 via Vite:
   ```bash
   npm run build
   ```
   *(Atau jalankan `npm run dev` pada terminal terpisah untuk live reload)*
7. Verifikasi daftar route aplikasi:
   ```bash
   php artisan route:list
   ```
8. Jalankan server pengembangan lokal:
   ```bash
   php artisan serve
   ```
9. Buka browser dan akses:
   - Katalog Utama: [http://127.0.0.1:8000/jadwal](http://127.0.0.1:8000/jadwal)
   - Dashboard Akademik: [http://127.0.0.1:8000/dashboard](http://127.0.0.1:8000/dashboard)
   - Akun Default Sesi Admin BAAK: `admin@ucic.ac.id` / `admin123`

---

## Dokumentasi Screenshot Proses CRUD

### 1. Daftar Route (`php artisan route:list`)
Verifikasi bahwa seluruh 18 route (termasuk 7 rute standar CRUD) telah dipetakan secara rapi dan benar.
![Terminal php artisan route:list](screenshots/01-daftar-route.png)

### 2. Daftar Jadwal Saat Kosong
Kondisi sistem saat belum ada data yang sesuai filter pencarian (*Empty State Card*) disertai tombol pintasan tambah jadwal.
![Daftar Jadwal Kosong](screenshots/02-daftar-jadwal-kosong.png)

### 3. Form Tambah Jadwal
Formulir pendaftaran jadwal perkuliahan baru lengkap dengan 11 input atribut, proteksi `@csrf`, dan retensi input `old()`.
![Form Tambah Jadwal](screenshots/03-form-tambah-jadwal.png)

### 4. Daftar Jadwal Terisi & Notifikasi Sukses
Katalog tabel 11 kolom data jadwal perkuliahan terisi lengkap dari penyimpanan session file.
![Daftar Jadwal Terisi dan Notifikasi Sukses](screenshots/04-daftar-jadwal-terisi-sukses.png)

### 5. Halaman Detail Jadwal
Halaman rincian lengkap 11 atribut perkuliahan berdasarkan parameter kode unik pada URL (`/jadwal/{kode}`).
![Halaman Detail Jadwal](screenshots/05-halaman-detail-jadwal.png)

### 6. Halaman Edit Jadwal
Formulir pengubahan data jadwal dengan kode terkunci *readonly* sebagai identitas session dan simulasi `@method('PUT')`.
![Edit Jadwal](screenshots/06-halaman-edit-jadwal.png)

### 7. Hasil Setelah Update Data Jadwal
Tampilan umpan balik alert notifikasi sukses hijau `session('success')` setelah pembaruan data berhasil dieksekusi.
![Hasil Setelah Update](screenshots/07-hasil-setelah-update.png)

### 8. Penanganan Data Jadwal Tidak Ditemukan
Mekanisme pertahanan (*fail-safe redirect*) saat pengguna mencoba mengakses kode jadwal yang tidak terdaftar di session, memunculkan notifikasi merah `alert-error`.
![Data Jadwal Tidak Ditemukan](screenshots/08-penanganan-jadwal-tidak-ditemukan.png)

### 9. Dialog Konfirmasi Hapus
Modal konfirmasi penghapusan data interaktif (*DaisyUI modal dialog*) sebelum aksi penghapusan permanen dijalankan.
![Dialog Konfirmasi Hapus](screenshots/09-dialog-konfirmasi-hapus.png)

### 10. Hasil Setelah Dihapus
Tampilan katalog tabel setelah item jadwal dihapus dari session file, disertai banner konfirmasi sukses penghapusan.
![Hasil Setelah Dihapus](screenshots/10-hasil-setelah-dihapus.png)

---

## Fitur Tambahan: Dashboard Monitoring & Autentikasi Sesi

### Dashboard Monitoring Jadwal BAAK UCIC
Panel ringkasan metrik statistik perkuliahan hari ini, analitik mingguan, dan diagram beban SKS.
![Dashboard Monitoring](screenshots/dashboard-monitoring.png)

### Halaman Login Sesi BAAK UCIC
Autentikasi sesi mandiri berbasis session file murni tanpa ketergantungan tabel database.
![Login Sesi BAAK](screenshots/login-sesi-baak.png)

---

## Dokumentasi Screenshot Source Code

Hasil kurasi tangkapan layar kode sumber Controller dan Blade View (telah diseleksi bersih tanpa file duplikat):

### Controller (`app/Http/Controllers/JadwalController.php`)
1. **Method `dashboard()` & `index()`**:
   ![Controller 1](screenshots/sourcecode/controller1-dashboard-index.png)
2. **Penyaringan Filter & Logika Session `index()`**:
   ![Controller 2](screenshots/sourcecode/controller2-index-filter.png)
3. **Method `create()` & `store()` (Validasi Lengkap)**:
   ![Controller 3](screenshots/sourcecode/controller3-create-store.png)
4. **Method `show($kode)` (Fail-Safe Lookup)**:
   ![Controller 4](screenshots/sourcecode/controller4-show.png)
5. **Method `edit($kode)`**:
   ![Controller 5](screenshots/sourcecode/controller5-edit.png)
6. **Method `update(Request $request, $kode)`**:
   ![Controller 6](screenshots/sourcecode/controller6-update.png)
7. **Method `destroy($kode)`**:
   ![Controller 7](screenshots/sourcecode/controller7-destroy.png)
8. **Modul Ekstra Akademik (`dosen`, `ruangan`, `kelas`) & Dataset Default**:
   ![Controller 8](screenshots/sourcecode/controller8-academic-modules.png)

### Blade Views (`resources/views/`)
1. **Master Layout Head & Asset Bundling Vite (`layouts/app.blade.php`)**:
   ![View 1](screenshots/sourcecode/view1-layout-app-head.png)
2. **Topbar Profil & Form Logout Session (`layouts/app.blade.php`)**:
   ![View 2](screenshots/sourcecode/view2-layout-app-auth.png)
3. **Flash Alerts Notification & Direktif `@yield('content')` (`layouts/app.blade.php`)**:
   ![View 3](screenshots/sourcecode/view3-layout-app-alerts.png)
4. **Header Halaman Indeks & Tombol Pintasan (`jadwal/index.blade.php`)**:
   ![View 4](screenshots/sourcecode/view4-jadwal-index-header.png)
5. **Formulir Tambah Data Jadwal (`jadwal/create.blade.php`)**:
   ![View 5](screenshots/sourcecode/view5-jadwal-create-form.png)
6. **Formulir Edit Jadwal dengan Nilai Lama & Kode Read-Only (`jadwal/edit.blade.php`)**:
   ![View 6](screenshots/sourcecode/view6-jadwal-edit-form.png)

---

## Hasil Pengujian Otomatis (Testing)

Seluruh skenario pengujian unit & integrasi dijalankan otomatis melalui PHPUnit (`tests/Feature/JadwalCrudTest.php`):

```bash
php artisan test
```

Hasil: **13 passed, 43 assertions (100% PASS)**

| No | Nama Test Method | Skenario Pengujian | Hasil |
| :---: | :--- | :--- | :---: |
| 1 | `test_root_url_redirects_to_dashboard` | Akses `/` dialihkan ke `/dashboard` | **PASS** |
| 2 | `test_dashboard_page_loads_successfully` | Menampilkan 4 kartu metrik & kalender | **PASS** |
| 3 | `test_index_page_displays_schedules_from_session` | Menampilkan tabel 11 kolom data sesi | **PASS** |
| 4 | `test_index_page_can_filter_by_search_query` | Filter pencarian `?cari=matkul` | **PASS** |
| 5 | `test_create_page_loads_successfully` | Menampilkan formulir pendaftaran baru | **PASS** |
| 6 | `test_store_creates_new_schedule_in_session` | Simpan jadwal baru ke session file | **PASS** |
| 7 | `test_store_validates_required_fields` | Validasi error jika field wajib kosong | **PASS** |
| 8 | `test_store_prevents_duplicate_kode` | Menolak kode duplikat | **PASS** |
| 9 | `test_show_displays_schedule_details` | Menampilkan rincian 11 atribut jadwal | **PASS** |
| 10 | `test_show_redirects_if_not_found` | Redirect aman jika kode tidak ada | **PASS** |
| 11 | `test_edit_page_loads_with_schedule_data` | Form edit terisi nilai awal lama | **PASS** |
| 12 | `test_update_modifies_schedule_in_session` | Pembaruan data session sukses | **PASS** |
| 13 | `test_destroy_removes_schedule_from_session` | Penghapusan jadwal dari session | **PASS** |
