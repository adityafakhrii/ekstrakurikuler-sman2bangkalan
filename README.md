# 🏫 Aplikasi Manajemen Ekstrakurikuler SMAN 2 Bangkalan

Aplikasi web untuk mengelola pendaftaran, penilaian, dan administrasi kegiatan Ekstrakurikuler di SMAN 2 Bangkalan. Dibangun menggunakan **Laravel** (Backend), **Inertia.js** (Bridge), **React** dengan **TypeScript** (Frontend), dan **Tailwind CSS** (Styling).

---

## 📋 Prasyarat Sistem (Prerequisites)

Sebelum memulai instalasi, pastikan laptop Anda telah terpasang software berikut:

1. **PHP (Minimal versi 8.3)**
   - Periksa versi PHP dengan perintah: `php -v`
2. **Composer (Dependency Manager untuk PHP)**
   - Periksa instalasi dengan perintah: `composer -v`
3. **Node.js (Minimal versi 18) & npm**
   - Periksa versi Node.js dengan perintah: `node -v`
4. **XAMPP** (Untuk menjalankan MySQL database server dan mengakses phpMyAdmin)
5. **Git CLI**
   - Periksa instalasi dengan perintah: `git -v`

---

## 🛠️ Langkah-Langkah Instalasi (Local Setup)

Ikuti langkah-langkah berikut secara berurutan untuk memasang project di laptop Anda:

### 1. Clone Repositori dari GitHub
Buka terminal (CMD / PowerShell / Terminal git bash) lalu jalankan perintah berikut:
```bash
git clone https://github.com/adityafakhrii/ekstrakurikuler-sman2bangkalan.git
cd ekstrakurikuler-sman2bangkalan
```

### 2. Duplikasi File Konfigurasi Environment (`.env`)
Salin file `.env.example` untuk membuat konfigurasi environment lokal Anda sendiri:
- **Windows (CMD):**
  ```cmd
  copy .env.example .env
  ```
- **Windows (PowerShell) / macOS / Linux:**
  ```bash
  cp .env.example .env
  ```

### 3. Setup Database MySQL via XAMPP
1. Buka aplikasi **XAMPP Control Panel** di laptop Anda.
2. Klik tombol **Start** pada modul **Apache** dan **MySQL** (pastikan keduanya berwarna hijau / aktif).
3. Buka browser Anda (Chrome/Edge/Firefox) dan akses alamat: **`http://localhost/phpmyadmin`**
4. Buat database baru:
   - Pilih tab **"New"** (Baru) di kolom sebelah kiri.
   - Masukkan nama database: **`ekstrakurikuler_sman2bangkalan`**
   - Klik tombol **"Create"** (Buat).
5. Buka file `.env` yang berada di folder project menggunakan Text Editor (VS Code, Notepad, dll), lalu pastikan bagian konfigurasi database sudah sesuai dengan pengaturan XAMPP Anda (secara default seperti di bawah ini):
   ```ini
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=ekstrakurikuler_sman2bangkalan
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   *(Kosongkan `DB_PASSWORD` karena secara default instalasi XAMPP tidak memiliki password untuk user `root`)*

### 4. Install Dependensi PHP
Instal library PHP yang dibutuhkan melalui Composer:
```bash
composer install
```
> **Catatan:** Jika Anda menemui masalah kecocokan versi PHP, Anda bisa menambahkan flag bypass: `composer install --ignore-platform-reqs`

### 5. Generate Application Key
Jalankan perintah ini untuk membuat key enkripsi aplikasi yang unik:
```bash
php artisan key:generate
```

### 6. Jalankan Migrasi Database & Seeding Data Awal
Migrasikan semua tabel dan masukkan data awal (admin, ketua ekskul, daftar ekskul default, akun siswa dummy) ke database MySQL yang telah Anda buat:
```bash
php artisan migrate:fresh --seed
```

### 7. Install Dependensi Node.js & Compile Asset
Instal library frontend dan buat build aplikasi React Anda:
```bash
npm install
npm run build
```

---

## 🚀 Cara Menjalankan Project

Jalankan perintah berikut di terminal Anda untuk menjalankan aplikasi secara otomatis (server Laravel, antrean queue, dan aset frontend React akan berjalan sekaligus):

```bash
composer run dev
```

Aplikasi Anda sekarang aktif!
- Buka browser Anda dan akses: **`http://localhost:8000`**

---

## 🔑 Kredensial Akun Uji Coba (Dummy Accounts)

Setelah menjalankan database seeder (`--seed`), Anda dapat masuk ke aplikasi menggunakan akun-akun simulasi berikut (semua akun menggunakan password: **`password`**):

| Nama Akun / Pemilik | Username / NISN | Role | Password | Deskripsi Akses |
| :--- | :--- | :--- | :--- | :--- |
| **Administrator** | `admin` | Admin | `password` | Mengelola seluruh data sistem, user, ekskul, dan periode. |
| **Ketua OSIS** | `ketua.osis` | Ketua | `password` | Mengakses pengajuan dan manajemen internal OSIS. |
| **Ketua Pramuka** | `ketua.pramuka` | Ketua | `password` | Mengelola ekskul Pramuka, input nilai, dan pendaftaran anggota. |
| **Ketua Basket** | `ketua.basket` | Ketua | `password` | Mengelola ekskul Basket, input nilai, dan pendaftaran anggota. |
| **Ketua PMR** | `ketua.pmr` | Ketua | `password` | Mengelola ekskul PMR, input nilai, dan pendaftaran anggota. |
| **Ketua Paduan Suara** | `ketua.paduan` | Ketua | `password` | Mengelola ekskul Paduan Suara, input nilai, dan pendaftaran anggota. |
| **Ahmad Jihaduddin** | `2120202` | Siswa | `password` | Mengakses dashboard siswa, mendaftar ekskul, melihat pengumuman & rekomendasi. |
| **Saiful Bahri** | `2120203` | Siswa | `password` | Mengakses dashboard siswa, mendaftar ekskul, melihat pengumuman & rekomendasi. |
| **Dewi Sartika** | `2120204` | Siswa | `password` | Mengakses dashboard siswa, mendaftar ekskul, melihat pengumuman & rekomendasi. |

---

## ⚠️ Troubleshooting (Kendala Umum)

* **Error: `Access denied for user 'root'@'localhost'`**
  Periksa kembali file `.env` Anda. Sesuaikan `DB_USERNAME` dan `DB_PASSWORD` dengan kredensial database di laptop Anda (misalnya jika Anda mengganti username/password default MySQL di XAMPP).
* **Error: `Connection refused` atau database tidak bisa diakses**
  Pastikan modul **MySQL** dan **Apache** di **XAMPP Control Panel** dalam keadaan aktif (tombol Start sudah berubah menjadi Stop dan berwarna hijau).
* **Halaman Putih Kosong atau CSS/JS Tidak Terkoneksi**
  Pastikan Anda telah menjalankan `npm run build` sebelum membuka website, atau sedang menjalankan `composer run dev` di terminal agar file aset frontend ter-compile dengan dinamis.
