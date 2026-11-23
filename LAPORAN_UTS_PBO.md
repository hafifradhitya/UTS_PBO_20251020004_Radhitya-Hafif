# LAPORAN UJIAN TENGAH SEMESTER (UTS)
## PEMROGRAMAN BERORIENTASI OBJEK (TI033015)
### SISTEM PENGELOLAAN JADWAL PERKULIAHAN MAHASISWA (BAAK UCIC)

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
Aplikasi **JadwalkuApp-UTS** adalah sistem web berbasis **Laravel 13** yang dibangun untuk memenuhi kebutuhan BAAK UCIC dalam mendata, memantau, memvalidasi, dan memperbarui jadwal perkuliahan secara dinamis. Proyek ini merupakan kelanjutan langsung (*continuity*) dari proyek tugas Pertemuan 7, namun mengalami lompatan arsitektural yang signifikan:
1. **Peralihan Identitas Data:** Pada Pertemuan 7, sistem menggunakan `id` integer numerik (1, 2, 3) yang mengandalkan casting `(int) $id`. Pada UTS ini, sistem beralih penuh menggunakan `kode` string unik (seperti `JDW001`, `JDW002`) yang langsung bertindak sebagai *associative key* dalam penyimpanan session.
2. **Arsitektur Penyimpanan Mandiri Tanpa Database:** Sesuai spesifikasi ujian, sistem tidak memanfaatkan basis data SQL/MySQL maupun Eloquent Model, melainkan memanfaatkan driver session berbasis file internal (`SESSION_DRIVER=file`). Data disimpan secara terstruktur di dalam session key `'jadwals'`.
3. **Pola Pemrograman Bersih (Route → Controller → Blade):** Seluruh aliran kerja mengikuti pemisahan tanggung jawab yang tegas:
   - `routes/web.php` hanya bertindak sebagai pemetaan rute tanpa *business logic closure*.
   - `JadwalController` menjadi pengendali alur logika, validasi input, serta manipulasi session state.
   - Blade Template (`resources/views/`) menangani representasi visual antarmuka secara bersih, aman, dan responsif.
4. **Desain Antarmuka BAAK yang Fungsional & Anti AI-Slop:** Antarmuka dibangun menggunakan **Tailwind CSS v4** resmi bawaan Laravel 13 via Vite (`@vite(['resources/css/app.css', 'resources/js/app.js'])`), tanpa ketergantungan CDN eksternal, tanpa gradasi warna ungu-biru sintetis, serta menampilkan data statistik riil yang dihitung langsung dari session.

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
Seluruh rute didefinisikan secara eksplisit menggunakan *Controller action array syntax* `[JadwalController::class, 'method']` dan memiliki *named route* standar dengan prefix `jadwal.`.

| No | HTTP Method | URI | Named Route | Controller Action | Fungsi & Alur Operasional |
| :---: | :--- | :--- | :--- | :--- | :--- |
| 1 | `GET` | `/` | — | *Closure Redirect* | Mengalihkan pengguna secara otomatis ke halaman `/dashboard`. |
| 2 | `GET` | `/dashboard` | `jadwal.dashboard` | `JadwalController@dashboard` | Menampilkan metrik statistik jadwal dan agenda perkuliahan hari ini. |
| 3 | `GET` | `/jadwal` | `jadwal.index` | `JadwalController@index` | Menampilkan tabel 11 kolom data jadwal, form pencarian, dan filter. |
| 4 | `GET` | `/jadwal/create` | `jadwal.create` | `JadwalController@create` | Menampilkan formulir penambahan data jadwal perkuliahan baru. |
| 5 | `POST` | `/jadwal` | `jadwal.store` | `JadwalController@store` | Memvalidasi input, memeriksa keunikan kode, dan menyimpan jadwal ke session. |
| 6 | `GET` | `/jadwal/{kode}` | `jadwal.show` | `JadwalController@show` | Menampilkan rincian lengkap 11 atribut jadwal berdasarkan kode unik. |
| 7 | `GET` | `/jadwal/{kode}/edit` | `jadwal.edit` | `JadwalController@edit` | Menampilkan formulir edit dengan nilai eksisting (kode terkunci readonly). |
| 8 | `PUT/PATCH` | `/jadwal/{kode}` | `jadwal.update` | `JadwalController@update` | Memvalidasi pembaruan data dan memperbarui session state (PRG pattern). |
| 9 | `DELETE` | `/jadwal/{kode}` | `jadwal.destroy` | `JadwalController@destroy` | Menghapus entri jadwal dari array session berdasarkan parameter kode. |

### Bukti Verifikasi `php artisan route:list`
```text
+--------+-----------+----------------------+------------------+-----------------------------------------------+
| Method | URI       | Name                 | Action           | Middleware                                    |
+--------+-----------+----------------------+------------------+-----------------------------------------------+
| GET    | /         |                      | Closure (web:6)  | web                                           |
| GET    | dashboard | jadwal.dashboard     | JadwalController | web                                           |
| GET    | jadwal    | jadwal.index         | JadwalController | web                                           |
| POST   | jadwal    | jadwal.store         | JadwalController | web                                           |
| GET    | jadwal/create | jadwal.create    | JadwalController | web                                           |
| GET    | jadwal/{kode} | jadwal.show      | JadwalController | web                                           |
| PUT    | jadwal/{kode} | jadwal.update    | JadwalController | web                                           |
| DELETE | jadwal/{kode} | jadwal.destroy   | JadwalController | web                                           |
| GET    | jadwal/{kode}/edit | jadwal.edit | JadwalController | web                                           |
+--------+-----------+----------------------+------------------+-----------------------------------------------+
```

---

## 4. PENJELASAN FILE UTAMA

### 1. `routes/web.php`
Dalam berkas ini, saya menerapkan prinsip perancangan rute teratur di mana rute statis `Route::get('/jadwal/create')` wajib ditempatkan secara urut sebelum rute dinamis bertipe parameter wildcard `Route::get('/jadwal/{kode}')`. Keputusan penempatan ini krusial untuk mencegah kegagalan *route pattern matching* pada router internal Laravel, sebab jika posisinya dibalik, kata `'create'` pada URL akan dievaluasi sebagai nilai parameter variabel `$kode` menuju method `show()`. Selain itu, saya sepenuhnya meniadakan *business logic* di dalam closure route dan mengaitkan seluruh aksi ke method terisolasi di `JadwalController` dengan konvensi *named route* terpadu.

### 2. `app/Http/Controllers/JadwalController.php`
Pengendali ini mengimplementasikan 7 method RESTful CRUD standar ditambah 1 method pendukung dashboard dengan arsitektur manipulasi data berbasis session file murni tanpa ketergantungan SQL. Pada method `store()`, saya menyusun validasi server-side menyeluruh untuk 11 atribut jadwal termasuk aturan validasi waktu `after:jam_mulai` serta memverifikasi apakah kode jadwal yang diinput telah eksis di array `$jadwals` guna mencegah penimpaan data tanpa sengaja. Pada method `update()`, saya sengaja mengunci parameter `$kode` langsung dari URL dan mengecualikannya dari input form, lalu menerapkan pola *Post/Redirect/Get* (PRG) di `store`, `update`, dan `destroy` agar pengguna tidak mengalami duplikasi aksi saat menyegarkan (*refresh*) halaman peramban.

### 3. `resources/views/layouts/app.blade.php`
Berkas layout induk ini mengadopsi prinsip *View Inheritance* dalam PBO untuk memastikan seluruh tampilan memiliki struktur DOM, header instansi BAAK UCIC, palet warna zinc-emerald yang konsisten, dan integrasi aset Tailwind CSS v4 via direktif `@vite`. Di dalam layout ini, saya menyematkan komponen penangkap pesan kilat (*flash alert*) `session('success')` dan `session('error')` di atas `@yield('content')`, sehingga setiap hasil mutasi session state dari Controller dapat langsung dikomunikasikan secara transparan kepada pengguna tanpa memerlukan duplikasi penulisan blok notifikasi pada setiap sub-tampilan.

### 4. `resources/views/jadwal/dashboard.blade.php`
Tampilan dashboard ini dirancang khusus untuk memenuhi standar antarmuka operasional staf BAAK UCIC dengan menyajikan tiga kartu metrik ringkasan (Total Jadwal, Jadwal Aktif, dan Beban Jadwal Hari Berjalan) serta tabel perkuliahan harian yang dihitung secara dinamis dari session `$jadwals`. Saya menghindari penggunaan angka rekayasa (*hardcoded dummy metric*); seluruh angka total, pemilahan status aktif, dan komposisi kategori (Teori, Praktikum, Daring) dihitung secara riil menggunakan agregasi `count()` dan `array_filter()` di Controller, sehingga dashboard secara otomatis merefleksikan perubahan seketika setelah penambahan atau penghapusan jadwal.

### 5. `resources/views/jadwal/index.blade.php`
Halaman ini menyajikan tabel komprehensif 11 kolom data perkuliahan yang dilengkapi mekanisme penyaringan dinamis berbasis HTTP GET untuk kata kunci pencarian teks, pemilihan hari, dan klasifikasi tipe perkuliahan. Ketika koleksi data session kosong atau kueri pencarian tidak menghasilkan data, halaman ini tidak menampilkan tabel kosong yang membingungkan, melainkan merender komponen *empty state* informatif yang menyediakan tombol ajakan bertindak (*call-to-action*) langsung menuju form penambahan jadwal baru.

### 6. `resources/views/jadwal/show.blade.php`
Halaman detail ini mengorganisir kesebelas atribut jadwal ke dalam tata letak deskripsi list dua kolom yang bersih dan terstruktur untuk mempermudah verifikasi administrasi perkuliahan. Di samping menyajikan badge klasifikasi visual untuk membedakan kategori Teori, Praktikum, atau Daring, halaman ini menyediakan tautan navigasi kontekstual yang memungkinkan staf BAAK untuk segera kembali ke daftar utama atau melompat ke form pembaruan data jadwal yang bersangkutan melalui `route('jadwal.edit', $jadwal['kode'])`.

### 7. `resources/views/jadwal/create.blade.php`
Formulir pendaftaran jadwal ini menerapkan mekanisme pertahanan keamanan formulir web standar berupa proteksi serangan Cross-Site Request Forgery melalui direktif `@csrf`. Agar pengalaman pengguna tetap nyaman saat terjadi kegagalan validasi server-side, seluruh elemen input teks dan seleksi dropdown dipasangkan dengan fungsi pembantu `old()`, disertai komponen penampil pesan galat bersyarat `@error` tepat di bawah masing-masing field untuk memandu koreksi data mahasiswa/BAAK secara presisi.

### 8. `resources/views/jadwal/edit.blade.php`
Pada tampilan modifikasi data ini, saya menerapkan teknik *HTTP Method Spoofing* via `@method('PUT')` karena keterbatasan spesifikasi form HTML yang hanya mendukung metode GET dan POST secara bawaan. Input kode jadwal secara sengaja dikunci dengan atribut `readonly` dan diberi gaya visual non-aktif (latar belakang `bg-zinc-50`) untuk menegaskan bahwa kode jadwal berperan sebagai *primary identity key* dalam session yang tidak boleh diubah sembarangan oleh pengguna, sementara nilai atribut lainnya dimuat secara otomatis menggunakan fungsi `old('field', $jadwal['field'])`.

---

## 5. DOKUMENTASI TANGKAPAN LAYAR (CHECKLIST PENGUJIAN)

Berikut adalah daftar 8 aspek visual aplikasi yang telah diverifikasi dan siap didokumentasikan dalam format tangkapan layar untuk lampiran laporan resmi:

- [x] **1. Dashboard Jadwal BAAK UCIC**  
  *Deskripsi:* Menampilkan ringkasan kartu statistik riil (Total Jadwal, Status Aktif, Tipe Perkuliahan) dan tabel sesi perkuliahan pada hari aktif berjalan.  
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

- [x] **8. Umpan Balik Notifikasi (Flash Alert & Error Validasi)**  
  *Deskripsi:* Menampilkan banner notifikasi hijau `session('success')` saat data berhasil disimpan, serta pesan peringatan merah saat validasi dilanggar.  
  ![Pesan Sukses dan Error](screenshots/08-pesan-sukses-error.png)

---

## 6. HASIL PENGUJIAN FUNGSIONAL
Seluruh pengujian dilakukan secara otomatis menggunakan rangkaian unit/feature testing PHPUnit pada Laravel 13 (`tests/Feature/JadwalCrudTest.php`) dengan total 11 skenario pengujian berstatus **100% PASS**:

| No | Skenario Pengujian | Langkah Pengujian | Hasil yang Diharapkan | Hasil Nyata | Status |
| :---: | :--- | :--- | :--- | :--- | :---: |
| 1 | Pengalihan Root URL | Mengakses URL `GET /` | Dialihkan otomatis ke `route('jadwal.dashboard')` (HTTP 302). | Dialihkan ke `/dashboard` dengan kode status 302. | **PASS** |
| 2 | Memuat Dashboard | Mengakses `GET /dashboard` | Halaman render sukses (200), menampilkan kartu total, aktif, dan hari ini. | Status 200, metrik terhitung langsung dari session. | **PASS** |
| 3 | Empty State Daftar | Mengakses `GET /jadwal` saat session kosong | Menampilkan teks pemberitahuan "Belum ada jadwal yang sesuai filter". | Komponen empty state dan tautan tambah muncul. | **PASS** |
| 4 | Buka Form Tambah | Mengakses `GET /jadwal/create` | Formulir tambah muncul lengkap dengan seluruh input dan `@csrf`. | Status 200, form ter-render sempurna. | **PASS** |
| 5 | Tambah Jadwal Sukses | Mengirim `POST /jadwal` dengan 11 atribut valid | Data tersimpan di session `jadwals[JDW001]`, redirect ke index dengan flash success. | Redirect ke `/jadwal`, session terisi, alert hijau muncul. | **PASS** |
| 6 | Tolak Duplikasi Kode | Mengirim `POST /jadwal` dengan kode `JDW001` yang sudah ada | Sistem menolak simpan, kembali ke form tambah dengan pesan flash error. | Redirect kembali dengan pesan "Kode sudah digunakan". | **PASS** |
| 7 | Validasi Server-Side | Mengirim form dengan `jam_selesai` lebih awal dari `jam_mulai` | Sistem menolak dan menampilkan galat `after:jam_mulai` pada input terkait. | Form memantul kembali dengan error validasi jam selesai. | **PASS** |
| 8 | Rincian Data Jadwal | Mengakses `GET /jadwal/JDW001` | Menampilkan seluruh 11 informasi mata kuliah PBO secara detail. | Seluruh data mata kuliah dan dosen muncul sesuai. | **PASS** |
| 9 | Penanganan 404 Kode Tidak Ditemukan | Mengakses `GET /jadwal/JDW999` (kode fiktif) | Pengguna tidak mendapat error 500, melainkan dialihkan ke index dengan flash error. | Redirect ke `/jadwal` disertai alert merah tidak ditemukan. | **PASS** |
| 10 | Pembaruan Jadwal | Mengirim `PUT /jadwal/JDW001` dengan perubahan data ruangan | Data pada session `jadwals[JDW001]` berubah, kode tetap utuh, redirect sukses. | Data session terbaharui, flash pesan sukses tampil. | **PASS** |
| 11 | Penghapusan Jadwal | Mengirim `DELETE /jadwal/JDW001` | Entri kunci `JDW001` di-unset dari session array, redirect ke index. | Data terhapus dari session, tabel kembali kosong. | **PASS** |

---

## 7. KESIMPULAN & REFLEKSI PEMROGRAMAN BERORIENTASI OBJEK
Melalui pengerjaan Capstone Project UTS Pemrograman Berorientasi Objek ini, sejumlah pemahaman teknis dan konseptual mendalam berhasil diperoleh:
1. **Pemisahan Perhatian (Separation of Concerns) dalam Arsitektur MVC:** Pola MVC yang diterapkan menegaskan bahwa Controller harus bersikap ramping (*lean controller*), bertugas mengoordinasikan masukan request, menerapkan validasi integritas, mengelola session state, dan meneruskan data bersih ke Blade. Router tetap bersih sebagai deklarator lalu lintas, sementara Blade hanya bertugas mempresentasikan data dengan perlindungan escaping otomatis.
2. **Karakteristik State Session File vs Database:** Penggunaan `SESSION_DRIVER=file` membuktikan bahwa session file internal pada `storage/framework/sessions/` dapat diandalkan untuk mensimulasikan penyimpanan CRUD persisten tanpa ketergantungan server MySQL. Operasi array asosiatif berbasis kode unik (`$jadwals[$kode]`) memberikan kompleksitas pencarian konstan $O(1)$ yang sangat efisien saat membaca, memperbarui, maupun menghapus entri jadwal.
3. **Refleksi Perubahan dari Pertemuan 7 ke UTS (`id` Integer vs `kode` String):**
   - Pada tugas Pertemuan 7, aplikasi memanfaatkan identifier `id` bertipe integer numerik yang membutuhkan konversi eksplisit `(int) $id`. Hal ini rentan terhadap kerancuan tipe data dan potensi benturan indeks saat manipulasi array berlangsung.
   - Pada Capstone UTS ini, penggunaan `kode` string unik (seperti `JDW001`) mencerminkan kebutuhan domain kampus BAAK yang nyata, di mana jadwal perkuliahan selalu diidentifikasi oleh kode referensi akademik. `kode` bertindak langsung sebagai indeks kunci array asosiatif session. Perubahan ini juga menuntut perlakuan khusus: `kode` wajib bersifat *read-only* pada formulir pembaruan agar relasi integritas data pada storage session tidak rusak.
4. **Pentingnya Keamanan Berlapis (Defense in Depth):** Implementasi token `@csrf` pada setiap mutasi data, *method spoofing* via `@method`, validasi server-side menyeluruh (`after:jam_mulai`, sanitasi tipe data), penanganan kondisi data tidak ditemukan (*fail-safe graceful degradation*), serta konfirmasi penghapusan sisi klien menjadi fondasi vital yang membedakan aplikasi produksi yang andal dari sekadar kode prototipe.
