# 🎓 Student Management System with Multi-Role Authentication & File Management

A web-based academic information and student record management system built using **PHP Native** and **MySQL**, styled with **Bootstrap 5**, **Font Awesome**, and **DataTables**. The system supports role-based access control (Admin, Dosen, Mahasiswa), student record CRUD, dynamic grading, and file upload/download functionality.

---

## 🌟 Fitur Utama (Key Features)

### 1. 🔐 Role-Based Access Control (RBAC) & Autentikasi
* **Multi-Role Login**: Membedakan hak akses berdasarkan 3 level peran:
  * **Admin**: Pengelolaan penuh data mahasiswa (CRUD) dan upload berkas lampiran.
  * **Dosen**: Hak akses untuk meninjau data mahasiswa, menginput nilai, serta menambahkan catatan evaluasi.
  * **Mahasiswa**: Portal mandiri bagi mahasiswa untuk melihat biodata pribadi serta status nilai mereka sendiri sesuai sesi login (NRP).
* **Keamanan Akun**:
  * Enkripsi password menggunakan hash MD5.
  * Proteksi halaman via Session (`session_start()`, pengecekan peran pengguna).
  * Fitur Registrasi akun dengan pencegahan duplikasi *username*.

### 2. 📝 Manajemen Data Mahasiswa (CRUD)
* **Create**: Penambahan data mahasiswa (NRP, Nama, Jenis Kelamin, Jurusan, Email, Alamat, No. HP, Asal SMA, Matkul Favorit).
* **Read**: Tampilan tabel responsif bertenaga **DataTables** (fitur pencarian real-time, sorting kolom, dan pagination).
* **Update**: Formulir pengeditan data terintegrasi.
* **Delete**: Penghapusan data dengan otomatis membersihkan berkas fisik terkait di server.

### 3. 📂 Manajemen Berkas (File Upload & Download)
* **Upload Berkas**: Formulir *multipart* untuk melampirkan dokumen/berkas mahasiswa langsung tersimpan di folder `uploads/`.
* **Download Berkas**: Tombol download otomatis muncul jika berkas tersedia (`download.php`).
* **Pembersihan Berkas**: Menggunakan fungsi `unlink()` untuk mencegah sisa file sampah (*orphan files*) saat data dihapus.

---

## 🛠️ Tech Stack

* **Backend**: PHP Native (v7.4 - v8.x)
* **Database**: MySQL / MariaDB (MySQLi Extension)
* **Frontend**: HTML5, CSS3, JavaScript
* **Libraries & Frameworks**:
  * [Bootstrap 5](https://getbootstrap.com/)
  * [DataTables](https://datatables.net/)
  * [Font Awesome](https://fontawesome.com/)
* **Web Server**: Apache (via XAMPP / MAMP)

---

## 🚀 Panduan Instalasi Lokal (Setup Guide)

Ikuti langkah-langkah berikut untuk menjalankan project ini di komputer lokal:

### 1. Prasyarat
* Pasang **XAMPP** atau **MAMP** (sudah mencakup Apache dan MySQL).
* Web browser modern (Google Chrome, Firefox, Safari).

### 2. Penempatan Folder Project
Pindahkan folder project ini ke direktori web server lokal:
* **macOS (XAMPP)**: `/Applications/XAMPP/xamppfiles/htdocs/crud`
* **Windows (XAMPP)**: `C:\xampp\htdocs\crud`

### 3. Impor Basis Data (MySQL)
1. Buka aplikasi XAMPP dan nyalakan **Apache** serta **MySQL**.
2. Buka browser dan akses **phpMyAdmin** di `http://localhost/phpmyadmin`.
3. Buat database baru bernama `crud`.
4. Klik tab **Import** pada database `crud`, pilih file [`database.sql`](database.sql) yang tersedia di repositori ini, lalu klik **Go**.

### 4. Konfigurasi Koneksi Database
Jika pengaturan MySQL lokal kamu berbeda dari default, sesuaikan file `koneksi.php`:
```php
$servername = "localhost";
$user       = "root";
$password   = "";
$db         = "crud";
```

### 5. Jalankan Aplikasi
Buka web browser dan akses URL:
```text
http://localhost/crud/login.php
```

---

## 🔑 Akun Demo untuk Pengujian (Default Credentials)

| Role | Username | Password | Keterangan |
| :--- | :--- | :--- | :--- |
| **Admin** | `admin` | `admin123` | Akses penuh dashboard CRUD & upload berkas |
| **Dosen** | `dosen1` | `dosen123` | Akses penilaian & catatan evaluasi |
| **Mahasiswa** | `farah` | `mhs123` | Portal nilai & profil mahasiswa |

---

## 📁 Struktur Direktori

```text
├── css/                  # Berkas styling Bootstrap
├── datatables/           # Library DataTables (CSS & JS)
├── fontawesome/          # Library icon Font Awesome
├── js/                   # Berkas JavaScript Bootstrap
├── uploads/              # Direktori penyimpanan berkas unggahan
├── database.sql          # Skema basis data & data dummy awal
├── koneksi.php           # Konfigurasi koneksi MySQL
├── login.php             # Halaman login multi-role
├── register.php          # Halaman registrasi akun baru
├── logout.php            # Logika logout & destroy session
├── index.php             # Dashboard utama Admin
├── kelola.php            # Form Tambah / Edit data mahasiswa
├── proses.php            # Handler proses CRUD
├── fungsi.php            # Kumpulan fungsi query & file handling
├── dosen.php             # Dashboard peran Dosen
├── beri_nilai.php        # Handler input nilai oleh Dosen
├── mahasiswa.php         # Dashboard portal Mahasiswa
├── upload.php            # Handler upload berkas
├── download.php          # Handler download berkas
├── edit_file.php         # Handler edit berkas lampiran
└── README.md             # Dokumentasi project
```

---

## 👤 Author
* **Nama**: Farah Hasna Salsabila
* **Program Studi**: D4 Teknik Informatika, Politeknik Elektronika Negeri Surabaya (PENS)
