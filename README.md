# Website Klinik Poli Gigi Pratama
### Deskripsi Proyek
Proyek ini adalah Website Management System yang dikembangkan sebagai bagian dari tugas UTS mata kuliah Pengelolaan Proyek Perangkat Lunak. Proyek ini dikerjakan secara berkelompok dengan seorang dokter dari klinik Pratama sebagai klien. Website ini bertujuan untuk mempermudah pengelolaan data klinik poli gigi serta memberikan layanan reservasi online kepada pasien.

### Fitur Utama
Website ini memiliki 2 halaman utama yang melayani dua jenis pengguna, yaitu Admin dan User (Pasien).
[Klik di sini untuk melihat desain Figma](https://www.figma.com/design/odw8QiQAz1oHMXTOF62S3G/UI-Poli-Gigi-Klinik-Pratama---TIM-1?node-id=205-130&t=mPS6Nmrq8nZxCneY-0)

1. Halaman Admin (Pihak Klinik)
   - Manajemen Data Dokter => Menambahkan, memperbarui, dan menghapus data dokter (CRUD).
   - Manajemen Akun Admin => Fitur login dan pembuatan akun admin untuk keamanan akses.
   - Manajemen Data Pasien => Mengelola data pasien, seperti data diri dan tanggal reservasi.
2. Halaman User (Pasien)
   - Informasi Klinik => Menyediakan informasi lengkap mengenai layanan klinik poli gigi Pratama.
   - Reservasi Online via WhatsApp => Membantu pasien melakukan reservasi online langsung melalui integrasi dengan WhatsApp.

### Teknologi yang Digunakan
Website ini dibangun dengan menggunakan:

- Backend: PHP
- Frontend: HTML, CSS, JavaScript dan Framework Bootstrap
- Database: MySQL
- Operasi CRUD: Mengelola data dokter, pasien, dan akun admin

## Cara Penggunaan Website
### 1. Clone Repository
Buka terminal atau Git Bash dan jalankan perintah berikut:

```
git clone https://github.com/Divarizky/website-poli-gigi-klinik-pratama-pppl.git 
```
*Lakukan clone di dalam folder direktori `C:\xampp\htdocs`

### 2. Konfigurasi Database
1. Buka XAMPP dan pastikan Apache dan MySQL sudah berjalan.
2. Buka PhpMyAdmin melalui http://localhost/phpmyadmin.
3. Buat database baru dengan nama db_poligigi_pratama.
4. Import file database di PhpMyAdmin:
   - Navigasikan ke tab Import.
   - Pilih file db_poligigi_pratama.sql yang ada di folder `Admin/db/db_poligigi_pratama` yang terdapat di dalam folder Proyek.
   - Klik Go untuk memulai proses import.

### 3. Konfigurasi Koneksi Database
Pastikan konfigurasi koneksi database sudah sesuai. File konfigurasi terdapat di:
```
Admin/config/config_query.php
```

sesuaikan bagian berikut:
``` php
$servername = "localhost";
$username = "root";                // Default MySQL username
$password = "";                    // Password MySQL (kosong jika default)
$dbname = "db_poligigi_pratama";   // Pastikan nama database sesuai
```

### 4. Jalankan Website
1. Letakkan atau pastikan folder proyek terletak di direktori htdocs XAMPP.
2. Akses website melalui browser:
   - Halaman User: http://localhost/website-poli-gigi-klinik-pratama-pppl/index.php
   - Halaman Admin: http://localhost/website-poli-gigi-klinik-pratama-pppl/Admin/pages/login.html

### 5. Login Admin
Gunakan akun admin default yang sudah tersedia di dalam database:
   - Username: `admin`
   - Password: `admin123`

## Kontribusi
Proyek ini dikembangkan oleh TIM 1 mahasiswa 4IA03 Universitas Gunadarma sebagai bentuk implementasi manajemen proyek dan pengelolaan perangkat lunak dengan klien.

Nama Anggota Tim:
1. Diva Rizky Ananda
2. Rahfil Farhan
3. M. Farras Nabhan
4. Naufal Tabrizan
5. M. Akbar Noersal
6. Naufal Athasany

Client: Dokter Klinik Poli Gigi Pratama

Tools: Visual Studio Code, Figma, XAMPP, PhpMyAdmin, GitHub
