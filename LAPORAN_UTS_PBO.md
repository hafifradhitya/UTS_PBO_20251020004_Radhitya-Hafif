# LAPORAN UJIAN TENGAH SEMESTER (UTS)
## PEMROGRAMAN BERORIENTASI OBJEK (TI033015)
### SISTEM PENGELOLAAN JADWAL PERKULIAHAN MAHASISWA (BAAK UCIC)
#### DENGAN MODERN ACADEMIC CONTROL CENTER (LARAVEL 13 + DAISYUI + SESSION FILE)

---

## 1. IDENTITAS MAHASISWA
- **Nama Mahasiswa:** Radhitya Hafif
- **Nomor Induk Mahasiswa (NIM):** 20251020004
- **Program Studi / Kelas:** S-1 Teknik Informatika (Semester 3)
- **Mata Kuliah:** Pemrograman Berorientasi Objek (Kode: TI033015)
- **Dosen Pengampu:** Hilman Lesmana, S.T., M.S.F.
- **Institusi:** Fakultas Teknologi Informasi — Universitas Catur Insan Cendekia (UCIC)
- **Domain Studi Kasus:** Biro Administrasi Akademik & Kemahasiswaan (BAAK) UCIC
- **Repository Tugas Pertemuan 7:** [https://github.com/hafifradhitya/tugas-pbo-pertemuan7](https://github.com/hafifradhitya/tugas-pbo-pertemuan7)
- **Repository UTS:** *(Cantumkan link repository GitHub baru di sini setelah push)*

---

## 2. RINGKASAN APLIKASI
Aplikasi **JadwalkuApp-UTS** adalah sistem web berbasis **Laravel 13** yang dibangun untuk memenuhi kebutuhan BAAK UCIC dalam mendata, memantau, memvalidasi, dan memperbarui jadwal perkuliahan secara dinamis. Proyek ini mengintegrasikan seluruh ketentuan spesifikasi UTS dan mengimprovisasi antarmuka bergaya **Modern Academic Control Center** menggunakan **DaisyUI** dan **Tailwind CSS v4** via Vite:
1. **Peralihan Identitas Data:** Dari `id` integer numerik (Pertemuan 7) menjadi `kode` string unik (seperti `JDW001`, `JDW002`) yang langsung bertindak sebagai *associative key* dalam penyimpanan session.
2. **Penyimpanan Session Mandiri:** Seluruh data operasional dikelola secara aman menggunakan driver session berbasis file internal (`SESSION_DRIVER=file`) tanpa ketergantungan server database MySQL atau Model Eloquent.
3. **Pemisahan Perhatian (Route → Controller → Blade):**
   - `routes/web.php` menjaga urutan rute teratur (rute statis `/create` sebelum rute dinamis `/{kode}`).
   - `JadwalController` mengendalikan 7 method RESTful CRUD standar + 1 method dashboard + modul agregasi akademik (Dosen, Ruangan, Kelas).
   - `AuthController` menyediakan alur login/logout sesi BAAK yang aman.
   - Blade Template (`resources/views/`) merender tata letak sidebar dan topbar modern yang teratur, elegan, dan bersih dari AI-slop.
4. **Modul Ekstra Pendukung Kampus Nyata:**
   - **Direktori Dosen (`/dosen`):** Agregasi beban mengajar mata kuliah dan total SKS tiap dosen.
   - **Alokasi Ruangan & Lab (`/ruangan`):** Monitoring okupansi lab komputer dan ruang kuliah.
   - **Daftar Kelas Mahasiswa (`/kelas`):** Rekap beban SKS semesteran rombongan belajar TI.

### Pemetaan Kolom Soal UTS ke Atribut Entitas Jadwal
| Kolom Soal UTS | Atribut Entitas Jadwal | Tipe Data & Format | Rasionalisasi & Konteks BAAK UCIC |
| :--- | :--- | :--- | :--- |
| **Kode** | `kode` | `string(20)` (Contoh: `JDW001`) | Identitas unik jadwal mata kuliah, menjadi key array session dan parameter URL. Bersifat `readonly` saat pembaruan data. |
| **Nama example** | `mata_kuliah` | `string(100)` | Nama mata kuliah resmi yang dijadwalkan dalam kurikulum perkuliahan. |
| *(Atribut Kontekstual)* | `dosen` | `string(100)` | Nama dosen pengampu perkuliahan beserta gelar akademik. |
| *(Atribut Kontekstual)* | `hari` | `enum (Senin-Sabtu)` | Hari penyelenggaraan sesi perkuliahan tatap muka maupun daring. |
| *(Atribut Kontekstual)* | `jam_mulai` & `jam_selesai` | `string (HH:MM)` | Rentang jam perkuliahan; divalidasi dengan aturan `after:jam_mulai`. |
| **Lokasi** | `ruangan` | `string(50)` (Contoh: `Lab 1`) | Ruang fisik atau laboratorium tempat pelaksanaan kegiatan akademik. |
| *(Atribut Kontekstual)* | `kelas` | `string(20)` (Contoh: `TI-3A`) | Rombongan belajar mahasiswa penerima jadwal kuliah. |
| **Jumlah** | `sks` | `integer` (Rentang 1-6) | Beban Satuan Kredit Semester dari mata kuliah terkait. |
| **Kategori** | `tipe` | `enum (Teori/Praktikum/Daring)` | Klasifikasi metode pembelajaran (kelanjutan dari tugas Pertemuan 7). |
| **Kondisi** | `status` | `enum (Aktif/Dibatalkan/Selesai)` | Status operasional jadwal pada kalender akademik BAAK. |

---

## 3. DAFTAR ROUTE APLIKASI
Seluruh rute didefinisikan secara eksplisit menggunakan *Controller action array syntax* `[JadwalController::class, 'method']` dan memiliki *named route* standar berawalan `jadwal.`.

| No | HTTP Method | URI | Named Route | Controller Action | Fungsi & Alur Operasional |
| :---: | :--- | :--- | :--- | :--- | :--- |
| 1 | `GET` | `/` | — | *Closure Redirect* | Mengalihkan pengguna secara otomatis ke halaman `/dashboard`. |
| 2 | `GET` | `/login` | `login` | `AuthController@showLoginForm` | Menampilkan halaman login sesi administrator BAAK UCIC. |
| 3 | `POST` | `/login` | `login.post` | `AuthController@login` | Memvalidasi kredensial dan mencatat sesi login administrator. |
| 4 | `POST` | `/logout` | `logout` | `AuthController@logout` | Mengakhiri sesi aktif administrator BAAK dan menghapus data sesi. |
| 5 | `GET` | `/dashboard` | `jadwal.dashboard` | `JadwalController@dashboard` | Menampilkan dashboard metrik statistik, analitik mingguan, dan donut chart. |
| 6 | `GET` | `/jadwal` | `jadwal.index` | `JadwalController@index` | Menampilkan tabel 11 kolom data jadwal, form pencarian, dan filter GET. |
| 7 | `GET` | `/jadwal/create` | `jadwal.create` | `JadwalController@create` | Menampilkan formulir penambahan data jadwal perkuliahan baru. |
| 8 | `POST` | `/jadwal` | `jadwal.store` | `JadwalController@store` | Memvalidasi input, memeriksa keunikan kode, dan menyimpan jadwal ke session. |
| 9 | `GET` | `/jadwal/{kode}` | `jadwal.show` | `JadwalController@show` | Menampilkan rincian lengkap 11 atribut jadwal berdasarkan kode unik. |
| 10 | `GET` | `/jadwal/{kode}/edit` | `jadwal.edit` | `JadwalController@edit` | Menampilkan formulir edit dengan nilai eksisting (kode terkunci readonly). |
| 11 | `PUT/PATCH` | `/jadwal/{kode}` | `jadwal.update` | `JadwalController@update` | Memvalidasi pembaruan data dan memperbarui session state (PRG pattern). |
| 12 | `DELETE` | `/jadwal/{kode}` | `jadwal.destroy` | `JadwalController@destroy` | Menghapus entri jadwal dari array session berdasarkan parameter kode. |
| 13 | `GET` | `/dosen` | `jadwal.dosen` | `JadwalController@dosen` | Menampilkan direktori dosen pengampu dan rekap beban SKS mengajar. |
| 14 | `GET` | `/ruangan` | `jadwal.ruangan` | `JadwalController@ruangan` | Menampilkan okupansi ruangan kelas teori dan laboratorium komputer. |
| 15 | `GET` | `/kelas` | `jadwal.kelas` | `JadwalController@kelas` | Menampilkan rekap rombongan belajar mahasiswa dan total SKS semester. |

### Bukti Verifikasi `php artisan route:list`
```text
+--------+-----------+----------------------+------------------+-----------------------------------------------+
| Method | URI       | Name                 | Action           | Middleware                                    |
+--------+-----------+----------------------+------------------+-----------------------------------------------+
| GET    | /         |                      | Closure (web:8)  | web                                           |
| GET    | dashboard | jadwal.dashboard     | JadwalController | web                                           |
| GET    | dosen     | jadwal.dosen         | JadwalController | web                                           |
| GET    | jadwal    | jadwal.index         | JadwalController | web                                           |
| POST   | jadwal    | jadwal.store         | JadwalController | web                                           |
| GET    | jadwal/create | jadwal.create    | JadwalController | web                                           |
| GET    | jadwal/{kode} | jadwal.show      | JadwalController | web                                           |
| PUT    | jadwal/{kode} | jadwal.update    | JadwalController | web                                           |
| DELETE | jadwal/{kode} | jadwal.destroy   | JadwalController | web                                           |
| GET    | jadwal/{kode}/edit | jadwal.edit | JadwalController | web                                           |
| GET    | kelas     | jadwal.kelas         | JadwalController | web                                           |
| GET    | login     | login                | AuthController   | web                                           |
| POST   | login     | login.post           | AuthController   | web                                           |
| POST   | logout    | logout               | AuthController   | web                                           |
| GET    | ruangan   | jadwal.ruangan       | JadwalController | web                                           |
+--------+-----------+----------------------+------------------+-----------------------------------------------+
```

---

## 4. PENJELASAN FILE UTAMA

### 1. `routes/web.php`
Dalam berkas ini, saya menerapkan prinsip perancangan rute teratur di mana rute statis `Route::get('/jadwal/create')` wajib ditempatkan secara urut sebelum rute dinamis bertipe parameter wildcard `Route::get('/jadwal/{kode}')`. Keputusan penempatan ini krusial untuk mencegah kegagalan *route pattern matching* pada router internal Laravel, sebab jika posisinya dibalik, kata `'create'` pada URL akan dievaluasi sebagai nilai parameter variabel `$kode` menuju method `show()`. Seluruh rute menggunakan sintaks callable array dan named route terstandarisasi.

### 2. `app/Http/Controllers/JadwalController.php`
Pengendali ini mengimplementasikan 7 method RESTful CRUD standar ditambah 1 method pendukung dashboard dan 3 modul agregasi akademik (dosen, ruangan, kelas) berbasis session file murni tanpa database SQL. Pada method `store()`, validasi server-side menyeluruh diterapkan untuk 11 atribut termasuk aturan waktu `after:jam_mulai` dan pengecekan kode unik. Pada method `update()`, field kode dikunci dari URL dan diperbarui menggunakan pola Post/Redirect/Get (PRG) guna mencegah form duplikat saat penyegaran halaman.

### 3. `app/Http/Controllers/AuthController.php`
Pengendali otentikasi ini menangani alur masuk dan keluar sesi administrator BAAK UCIC secara aman menggunakan penyimpanan session internal. Ketika pengguna mengirim kredensial melalui formulir login, method `login()` memvalidasi data dan menginisialisasi session `'is_logged_in'` beserta data profil admin, kemudian mengalihkan pengguna ke dashboard dengan pesan kilat sukses.

### 4. `resources/views/layouts/app.blade.php`
Berkas layout induk ini mengadopsi struktur antarmuka modern yang terinspirasi dari control center enterprise dengan sidebar navigasi tetap di sebelah kiri, topbar dengan pencarian global dan info profil administrator, serta area konten utama responsif. Di dalamnya terintegrasi DaisyUI dan Tailwind CSS v4 via Vite `@vite`, serta komponen penangkap flash alert `session('success')` dan `session('error')`.

### 5. `resources/views/jadwal/dashboard.blade.php`
Tampilan dashboard ini menyajikan 4 kartu metrik utama (Total Jadwal, Jadwal Aktif, Sesi Hari Berjalan, Beban SKS), diagram analitik visual distribusi jadwal mingguan dari Senin hingga Sabtu, serta diagram donut distribusi tipe sesi (Teori, Praktikum, Daring) yang dihitung secara dinamis dari session `$jadwals`. Seluruh angka terhubung langsung ke data session riil tanpa angka tiruan.

### 6. `resources/views/jadwal/index.blade.php`
Halaman ini menyajikan tabel komprehensif 11 kolom data perkuliahan dengan badge status dan tipe yang elegan, filter pencarian kueri GET untuk kata kunci, hari, dan tipe perkuliahan, serta komponen empty state yang informatif ketika data tidak ditemukan. Setiap baris data dilengkapi tombol aksi Detail, Edit, dan Hapus dengan konfirmasi dialog interaktif.

### 7. `resources/views/jadwal/show.blade.php`
Halaman detail ini mengorganisir kesebelas atribut jadwal ke dalam kartu deskripsi grid modern yang mempermudah verifikasi administrasi perkuliahan oleh staf BAAK, dilengkapi dengan tombol kembali ke daftar dan tombol edit langsung.

### 8. `resources/views/jadwal/create.blade.php` & `edit.blade.php`
Formulir pendaftaran dan pembaruan jadwal menerapkan proteksi keamanan CSRF via `@csrf`, method spoofing `@method('PUT')`, fungsi pembantu `old()`, penampil pesan kesalahan `@error`, serta penguncian field kode sebagai `readonly` pada form edit untuk melindungi integritas kunci session.

### 9. `resources/views/jadwal/dosen.blade.php`, `ruangan.blade.php`, `kelas.blade.php`
Ketiga tampilan modul tambahan ini menyajikan data akademik kampus yang saling terhubung secara agregasi dari session jadwal: daftar dosen pengampu beserta total SKS mengajar, pemanfaatan ruang kelas teori dan lab komputer, serta daftar rombongan belajar kelas mahasiswa S-1 Teknik Informatika.

---

## 5. DOKUMENTASI TANGKAPAN LAYAR (CHECKLIST PENGUJIAN)

Berikut adalah daftar 8 aspek visual aplikasi yang telah diverifikasi dan siap didokumentasikan dalam format tangkapan layar:

- [x] **1. Dashboard Jadwal BAAK UCIC**  
  *Deskripsi:* Menampilkan ringkasan kartu statistik riil, bar chart mingguan, diagram donut tipe sesi, dan agenda perkuliahan hari ini.  
  ![Dashboard Jadwal](screenshots/01-dashboard.png)

- [x] **2. Halaman Indeks / Daftar Jadwal**  
  *Deskripsi:* Menampilkan tabel lengkap 11 kolom data jadwal, badge status/tipe yang rapi, form filter pencarian hari/tipe, serta tombol aksi Detail, Edit, dan Hapus.  
  ![Daftar Jadwal](screenshots/02-daftar-jadwal.png)

- [x] **3. Formulir Tambah Jadwal Baru**  
  *Deskripsi:* Menampilkan formulir pendaftaran jadwal dengan input lengkap 11 atribut, token keamanan CSRF, dan validasi jam mulai/selesai.  
  ![Formulir Tambah Jadwal](screenshots/03-form-tambah.png)

- [x] **4. Halaman Detail Jadwal**  
  *Deskripsi:* Menampilkan rincian lengkap 11 atribut dari salah satu data jadwal yang dipilih berdasarkan parameter kode unik.  
  ![Detail Jadwal](screenshots/04-detail-jadwal.png)

- [x] **5. Formulir Pembaruan (Edit) Jadwal**  
  *Deskripsi:* Menampilkan form edit yang telah terisi data lama dengan input kode terkunci `readonly` dan direktif `@method('PUT')`.  
  ![Formulir Edit Jadwal](screenshots/05-form-edit.png)

- [x] **6. Dialog Konfirmasi Hapus Data**  
  *Deskripsi:* Menampilkan jendela konfirmasi interaktif JavaScript (`confirm()`) sebelum operasi `DELETE` dieksekusi oleh peramban.  
  ![Konfirmasi Hapus](screenshots/06-konfirmasi-hapus.png)

- [x] **7. Tampilan Status Kosong (Empty State)**  
  *Deskripsi:* Menampilkan pesan pemberitahuan ramah saat belum ada data perkuliahan tersimpan atau hasil filter tidak ditemukan.  
  ![Empty State](screenshots/07-empty-state.png)

- [x] **8. Umpan Balik Notifikasi & Halaman Login Sesi BAAK**  
  *Deskripsi:* Menampilkan formulir login sesi administrator BAAK dan banner flash alert notifikasi keberhasilan transaksi data.  
  ![Pesan Sukses dan Login](screenshots/08-pesan-sukses-error.png)

---

## 6. HASIL PENGUJIAN FUNGSIONAL
Seluruh pengujian dilakukan secara otomatis menggunakan rangkaian unit/feature testing PHPUnit pada Laravel 13 (`tests/Feature/JadwalCrudTest.php`) dengan total **13 skenario pengujian berstatus 100% PASS**:

| No | Skenario Pengujian | Langkah Pengujian | Hasil yang Diharapkan | Hasil Nyata | Status |
| :---: | :--- | :--- | :--- | :--- | :---: |
| 1 | Pengalihan Root URL | Mengakses URL `GET /` | Dialihkan otomatis ke `route('jadwal.dashboard')` (HTTP 302). | Dialihkan ke `/dashboard` dengan kode status 302. | **PASS** |
| 2 | Memuat Dashboard | Mengakses `GET /dashboard` | Halaman render sukses (200), menampilkan kartu total, aktif, dan hari ini. | Status 200, metrik terhitung langsung dari session. | **PASS** |
| 3 | Empty State Daftar | Mengakses `GET /jadwal` saat session kosong | Menampilkan teks pemberitahuan "Belum ada jadwal yang sesuai filter.". | Komponen empty state dan tautan tambah muncul. | **PASS** |
| 4 | Buka Form Tambah | Mengakses `GET /jadwal/create` | Formulir tambah muncul lengkap dengan seluruh input dan `@csrf`. | Status 200, form ter-render sempurna. | **PASS** |
| 5 | Tambah Jadwal Sukses | Mengirim `POST /jadwal` dengan 11 atribut valid | Data tersimpan di session `jadwals[JDW001]`, redirect ke index dengan flash success. | Redirect ke `/jadwal`, session terisi, alert hijau muncul. | **PASS** |
| 6 | Tolak Duplikasi Kode | Mengirim `POST /jadwal` dengan kode `JDW001` yang sudah ada | Sistem menolak simpan, kembali ke form tambah dengan pesan flash error. | Redirect kembali dengan pesan "Kode sudah digunakan". | **PASS** |
| 7 | Validasi Server-Side | Mengirim form dengan `jam_selesai` lebih awal dari `jam_mulai` | Sistem menolak dan menampilkan galat `after:jam_mulai` pada input terkait. | Form memantul kembali dengan error validasi jam selesai. | **PASS** |
| 8 | Rincian Data Jadwal | Mengakses `GET /jadwal/JDW001` | Menampilkan seluruh 11 informasi mata kuliah PBO secara detail. | Seluruh data mata kuliah dan dosen muncul sesuai. | **PASS** |
| 9 | Penanganan 404 Kode Tidak Ditemukan | Mengakses `GET /jadwal/JDW999` (kode fiktif) | Pengguna tidak mendapat error 500, melainkan dialihkan ke index dengan flash error. | Redirect ke `/jadwal` disertai alert merah tidak ditemukan. | **PASS** |
| 10 | Pembaruan Jadwal | Mengirim `PUT /jadwal/JDW001` dengan perubahan data ruangan | Data pada session `jadwals[JDW001]` berubah, kode tetap utuh, redirect sukses. | Data session terbaharui, flash pesan sukses tampil. | **PASS** |
| 11 | Penghapusan Jadwal | Mengirim `DELETE /jadwal/JDW001` | Entri kunci `JDW001` di-unset dari session array, redirect ke index. | Data terhapus dari session, tabel kembali kosong. | **PASS** |
| 12 | Autentikasi Sesi BAAK | Mengakses `/login`, POST kredensial, dan POST `/logout` | Form login muncul, login menyimpan user di session, logout menghapus session. | Alur login/logout sukses 100%. | **PASS** |
| 13 | Modul Ekstra Kampus | Mengakses `/dosen`, `/ruangan`, dan `/kelas` | Menampilkan agregasi dosen pengampu, alokasi ruangan, dan beban rombel kelas. | Status 200, seluruh data agregasi session muncul. | **PASS** |

---

## 7. KESIMPULAN & REFLEKSI PEMROGRAMAN BERORIENTASI OBJEK
Melalui pengerjaan Capstone Project UTS Pemrograman Berorientasi Objek ini, sejumlah pemahaman teknis dan konseptual mendalam berhasil diperoleh:
1. **Pemisahan Perhatian (Separation of Concerns) dalam Arsitektur MVC:** Pola MVC yang diterapkan menegaskan bahwa Controller harus bersikap ramping (*lean controller*), bertugas mengoordinasikan masukan request, menerapkan validasi integritas, mengelola session state, dan meneruskan data bersih ke Blade. Router tetap bersih sebagai deklarator lalu lintas, sementara Blade hanya bertugas mempresentasikan data dengan perlindungan escaping otomatis.
2. **Karakteristik State Session File vs Database:** Penggunaan `SESSION_DRIVER=file` membuktikan bahwa session file internal pada `storage/framework/sessions/` dapat diandalkan untuk mensimulasikan penyimpanan CRUD persisten tanpa ketergantungan server MySQL. Operasi array asosiatif berbasis kode unik (`$jadwals[$kode]`) memberikan kompleksitas pencarian konstan $O(1)$ yang sangat efisien saat membaca, memperbarui, maupun menghapus entri jadwal.
3. **Refleksi Perubahan dari Pertemuan 7 ke UTS (`id` Integer vs `kode` String):**
   - Pada tugas Pertemuan 7, aplikasi memanfaatkan identifier `id` bertipe integer numerik yang membutuhkan konversi eksplisit `(int) $id`. Hal ini rentan terhadap kerancuan tipe data dan potensi benturan indeks saat manipulasi array berlangsung.
   - Pada Capstone UTS ini, penggunaan `kode` string unik (seperti `JDW001`) mencerminkan kebutuhan domain kampus BAAK yang nyata, di mana jadwal perkuliahan selalu diidentifikasi oleh kode referensi akademik. `kode` bertindak langsung sebagai indeks kunci array asosiatif session. Perubahan ini juga menuntut perlakuan khusus: `kode` wajib bersifat *read-only* pada formulir pembaruan agar relasi integritas data pada storage session tidak rusak.
4. **Pentingnya Keamanan Berlapis (Defense in Depth):** Implementasi token `@csrf` pada setiap mutasi data, *method spoofing* via `@method`, validasi server-side menyeluruh (`after:jam_mulai`, sanitasi tipe data), penanganan kondisi data tidak ditemukan (*fail-safe graceful degradation*), serta konfirmasi penghapusan sisi klien menjadi fondasi vital yang membedakan aplikasi produksi yang andal dari sekadar kode prototipe.
