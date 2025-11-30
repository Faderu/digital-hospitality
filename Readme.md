# 🏥 Sistem Digitalisasi Rumah Sakit (Hospital Digitalization System)

![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.0-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

Sistem informasi manajemen rumah sakit terpadu yang dirancang untuk efisiensi operasional. Sistem ini menghubungkan Admin, Dokter, dan Pasien dalam satu platform digital untuk menangani penjadwalan, rekam medis, dan manajemen inventaris obat.

---

## ✨ Fitur Utama

### 🛡️ Admin (Administrator)
* **Manajemen Pengguna:** Mengelola akun Dokter, Pasien, dan Admin.
* **Manajemen Master Data:** Mengelola Data Poli (Departemen) dan Inventaris Obat.
* **Laporan & Analitik:** Melihat statistik kunjungan pasien, kinerja dokter, dan penggunaan obat.
* **Feedback:** Memantau ulasan dan kepuasan pasien.

### 👨‍⚕️ Dokter
* **Manajemen Jadwal:** Mengatur hari dan jam praktik secara mandiri.
* **Validasi Janji Temu:** Menyetujui atau menolak permintaan janji temu pasien.
* **Rekam Medis Elektronik (EMR):** Mencatat diagnosis, tindakan, dan resep obat digital.
* **Dashboard Dokter:** Ringkasan antrian pasien harian.

### 😷 Pasien
* **Booking Online:** Membuat janji temu dengan memilih Poli, Dokter, dan Jadwal yang tersedia.
* **Riwayat Berobat:** Melihat histori kunjungan dan diagnosa sebelumnya.
* **Tiket Antrian:** Mencetak tiket antrian digital setelah janji disetujui.
* **Ulasan:** Memberikan rating dan masukan terhadap pelayanan.

### 🌐 Guest (Tamu)
* Melihat profil dan jadwal dokter tanpa perlu login.
* Melihat informasi layanan Poliklinik.

---

## ⚙️ Persyaratan Sistem (Prerequisites)

Sebelum menginstall, pastikan komputer Anda memiliki:
* **PHP** >= 8.1
* **Composer**
* **Node.js** & **NPM**
* **MySQL** (XAMPP/Laragon/DBngin)
* **Git**

---

## 🚀 Panduan Instalasi (Step-by-Step)

Ikuti langkah-langkah berikut untuk menjalankan proyek di komputer lokal:

### 1. Clone Repository
Buka terminal (Git Bash/CMD), lalu jalankan:
```bash
git clone https://github.com/USERNAME_GITHUB/NAMA_REPO.git
cd digital-hospitality/digital-hospitality
```

### 2. Konfigurasi Environment

Duplikat file .env.example menjadi .env:
```bash
cp .env.example .env
```

Buka file .env dan sesuaikan konfigurasi database:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rs_digital  <-- Sesuaikan dengan nama database Anda
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Install Dependencies

Install library PHP dan JavaScript yang dibutuhkan:
```bash
composer install
npm install
```

### 4. Generate Key & Link Storage

Generate kunci aplikasi dan buat symbolic link untuk gambar publik:
```bash
php artisan key:generate
php artisan storage:link
```

### 5. Migrasi & Seeding Database

Pastikan Anda sudah membuat database kosong (misal: rs_digital) di phpMyAdmin. Lalu jalankan perintah ini untuk membuat tabel dan Akun Admin Otomatis:
```bash
php artisan migrate:fresh --seed
```

(Perintah ini akan menjalankan AdminSeeder yang sudah kita buat).

### 6. Compile Aset (Tailwind CSS)

Untuk menghasilkan tampilan desain:
```bash
npm run build
```

(Atau npm run dev jika Anda sedang mode pengembangan).

### 7. Jalankan Server

```bash
php artisan serve
```

Buka browser dan akses: http://127.0.0.1:8000

🔑 Akun Default (Login)

Gunakan akun berikut untuk pengujian sistem:

| Role   | Email             | Password |
|--------|-------------------|----------|
| Admin  | admin@rs.com      | password |
| Dokter | dokter@rs.com     | password |
| Pasien | (Silakan Register Baru) | (Sesuai input) |

📖 Cara Menggunakan

### Skenario: Membuat Janji Temu (Booking)

1. Login sebagai Pasien (Register akun baru jika belum punya).
2. Klik tombol "Buat Janji Temu" di Dashboard.
3. Pilih Poli -> Pilih Dokter -> Klik Kartu Jadwal yang tersedia.
4. Pilih Tanggal dan isi keluhan, lalu Simpan.
5. Status awal adalah Pending.

### Skenario: Memproses Pasien (Dokter)

1. Login sebagai Dokter (dokter@rs.com).
2. Buka menu Janji Temu.
3. Lihat status "Pending", lalu klik tombol Approve (Ceklis Hijau).
4. Setelah pasien datang, klik tombol Periksa.
5. Isi form Rekam Medis (Diagnosis & Resep Obat).
6. Simpan. Stok obat akan berkurang otomatis dan status janji menjadi Selesai.

### Skenario: Manajemen Data (Admin)

1. Login sebagai Admin.
2. Gunakan menu samping untuk menambah User Baru, Obat, atau Poli.
3. Lihat Laporan untuk memantau statistik rumah sakit.

📂 Struktur Folder Penting

* app/Http/Controllers - Logika Backend (Admin, Doctor, Patient).
* app/Models - Model Database & Relasi (Eloquent).
* resources/views - Tampilan Antarmuka (Blade Templates).
  * admin/ - View khusus Admin.
  * doctor/ - View khusus Dokter.
  * patient/ - View khusus Pasien.
  * public/ - Halaman depan (Tamu).
* routes/web.php - Definisi Rute & Middleware.

🖼️ Aset Gambar

Pastikan folder public/images/ berisi file berikut agar tampilan maksimal:

* hospital-bg.jpg (Background Login/Home)
* hero-bg.jpg (Background Dashboard)
* logo.png (Logo Aplikasi)

© License

Proyek ini dibuat untuk tugas Individual Project Pemrograman Web.

---