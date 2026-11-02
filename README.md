# 📚 MyLibrary - Sistem Informasi Perpustakaan Digital

Selamat datang di repositori resmi **MyLibrary**. MyLibrary adalah aplikasi sistem informasi manajemen perpustakaan modern berbasis web yang dibangun menggunakan **Laravel 11**, **Tailwind CSS**, **MySQL**, serta terintegrasi dengan **Midtrans Payment Gateway** dan **Webcam Attendance**.

Aplikasi ini dirancang untuk memudahkan operasional sirkulasi buku, tata kelola fasilitas membaca, dan pelayanan pengguna dengan memisahkan hak akses ke dalam **3 peran (Role)**: **Admin (Kepala Perpustakaan)**, **Pustakawan (Petugas)**, dan **Anggota (Member/Siswa/Mahasiswa)**, serta menyediakan portal publik **Buku Tamu**.

---

## 📑 Daftar Isi
1. [Fitur Utama Sistem](#-fitur-utama-sistem)
2. [Kebutuhan Perangkat Lunak (Prerequisites)](#-kebutuhan-perangkat-lunak-prerequisites)
3. [Panduan Instalasi & Menjalankan Sistem](#-panduan-instalasi--menjalankan-sistem)
4. [Akun Pengguna Default (Hasil Seeder)](#-akun-pengguna-default-hasil-seeder)
5. [Panduan Lengkap Penggunaan Berdasarkan Peran](#-panduan-lengkap-penggunaan-berdasarkan-peran)
   - [A. Kepala Perpustakaan (Admin Eksekutif)](#a-panduan-admin-kepala-perpustakaan)
   - [B. Pustakawan (Petugas Operasional)](#b-panduan-pustakawan-petugas)
   - [C. Anggota (Member / Pembaca)](#c-panduan-anggota-member--pembaca)
   - [D. Pengunjung Tamu (Presensi Webcam)](#d-panduan-pengunjung-tamu-buku-tamu)
6. [Penanganan Masalah Umum (Troubleshooting)](#-penanganan-masalah-umum-troubleshooting)

---

## 🌟 Fitur Utama Sistem

- **Multi-Role Authentication & Authorization:** Pemisahan dashboard dan hak akses spesifik untuk Admin, Petugas, dan Anggota.
- **Katalog & Sirkulasi Buku Otomatis (KF-01 s/d KF-03):** Pencarian koleksi buku fisik, lokasi nomor rak, pengajuan pinjam, persetujuan petugas, serta penyesuaian stok buku otomatis (`+1` / `-1`).
- **Hitung Denda Otomatis & Midtrans QRIS (KF-07, KF-08):** Perhitungan denda keterlambatan otomatis berdasarkan tarif per hari dengan opsi pembayaran tunai di kasir atau pembayaran online QRIS/E-Wallet otomatis lunas via Midtrans Webhook.
- **Pemilihan Bangku Baca Interaktif (KF-04):** Denah grid meja baca dengan status visual realtime (Hijau = Tersedia, Abu-abu = Sedang Dipakai) serta tombol reservasi dan pelepasan meja.
- **Buku Tamu Presensi Webcam (Selfie):** Pengambilan foto wajah langsung melalui webcam komputer/laptop untuk buku tamu kunjungan harian lengkap dengan zoom foto selfie dan filter tanggal.
- **Perpustakaan Digital (E-Book & Repositori Skripsi) (KF-05):** Akses baca dan unduh dokumen PDF e-book serta log unduhan anggota.
- **Manajemen Eksekutif & Laporan PDF (KF-10 s/d KF-12):** Pengelolaan master data penerbit, pengelolaan akun pengguna, persetujuan (*approval*) laporan sirkulasi oleh Kepala Perpustakaan, dan cetak PDF resmi ber-kop surat.

---

## 💻 Kebutuhan Perangkat Lunak (Prerequisites)

Sebelum menjalankan aplikasi, pastikan komputer/laptop telah terinstal:
- **PHP** $\ge$ 8.2 (dengan ekstensi: `pdo_mysql`, `mbstring`, `fileinfo`, `openssl`, `curl`)
- **Composer** $\ge$ 2.x
- **Node.js** $\ge$ 18.x & **NPM**
- **Web Server & Database:** Laragon / XAMPP (Apache & MySQL)
- **Web Browser Modern:** Google Chrome / Microsoft Edge / Mozilla Firefox (disarankan mengizinkan izin akses kamera untuk fitur buku tamu)

---

## 🚀 Panduan Instalasi & Menjalankan Sistem

Ikuti langkah-langkah berikut untuk menginstal project di komputer lokal:

### 1. Clone atau Ekstrak Project
Tempatkan project di direktori web server Anda (contoh untuk Laragon: `C:\laragon\www\Mylibrary`).

### 2. Buka Terminal di Folder Project
```bash
cd C:\laragon\www\Mylibrary
```

### 3. Salin File Konfigurasi Environment (`.env`)
Jika belum memiliki file `.env`, salin dari `.env.example`:
```bash
cp .env.example .env
```
Pastikan pengaturan koneksi database di file `.env` sudah sesuai dengan database lokal Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE="nama database"
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Install Dependensi Backend (PHP / Composer)
```bash
composer install
```

### 5. Generate Application Key
```bash
php artisan key:generate
```

### 6. Jalankan Migrasi Database & Seeder
Buat database baru bernama `perpusku` di MySQL (via HeidiSQL / phpMyAdmin), lalu jalankan:
```bash
php artisan migrate --seed
```
*(Perintah ini akan membuat seluruh tabel sistem dan mengisi akun default).*

### 7. Buat Symbolic Link Storage (Untuk Upload Cover, PDF & Foto)
```bash
php artisan storage:link
```

### 8. Install & Build Asset Frontend (Tailwind CSS / Vite)
```bash
npm install
npm run build
# Atau untuk mode development:
npm run dev
```

### 9. Jalankan Server Aplikasi
Jika menggunakan Laragon, aplikasi dapat langsung diakses di browser melalui:
```text
http://mylibrary.test  atau  http://127.0.0.1:8000
```
*(Bila menggunakan artisan serve, jalankan `php artisan serve`).*

---

## 🔑 Akun Pengguna Default (Hasil Seeder)

Gunakan akun siap pakai berikut untuk login ke masing-masing peran:

| Peran (Role) | Email / Username | Password | Halaman Dashboard Tujuan |
| :--- | :--- | :--- | :--- |
| **Kepala Perpustakaan (Admin)** | `admin@mylibrary.com` | `123456` | `/dashboard-kepala-perpustakaan` |
| **Pustakawan (Petugas)** | `petugas@mylibrary.com` | `123456` | `/dashboard-petugas` |
| **Anggota (Member)** | `anggota@gmail.com` | `123456` | `/dashboard-anggota` |
| **Pengunjung Tamu** | *Tanpa Login (Publik)* | `-` | `/buku-tamu` |

---

## 📖 Panduan Lengkap Penggunaan Berdasarkan Peran

### A. Panduan Admin (Kepala Perpustakaan)
Role **Kepala Perpustakaan** memiliki otoritas tertinggi untuk fungsi manajerial, pengawasan statistik, manajemen akun, serta pengesahan dokumen.

1. **Akses Dashboard Eksekutif:**
   - Login dengan akun `admin@mylibrary.com`.
   - Di dashboard, amati grafik ringkasan peminjaman, jumlah buku aktif, pengembalian, dan statistik keuangan denda.
2. **Kelola Pengguna (`/daftar-pengguna`):**
   - **Melihat Data:** Telusuri tabel pengguna yang terbagi dalam tab Petugas dan Anggota.
   - **Detail Pengguna:** Klik tombol nama/detail untuk melihat profil lengkap, nomor induk, kontak, dan alamat.
   - **Tambah Pengguna Baru:** Klik tombol *Tambah Pengguna*, isi formulir (Username, Email, No Telp, Nomor Induk, Password, dan pilih Role).
   - **Edit & Hapus Pengguna:** Admin dapat memperbarui data pengguna atau menghapus akun yang sudah tidak aktif (akun yang masih memiliki peminjaman aktif akan diproteksi otomatis oleh sistem).
3. **Kelola Master Penerbit (`/daftar-penerbit`):**
   - Tambah, tinjau, dan edit mitra penerbit buku (Nama, Alamat, dan No. Telepon Penerbit).
4. **Validasi & Persetujuan Laporan (`/daftar-laporan`):**
   - Tinjau rekap sirkulasi buku dan denda yang diajukan oleh petugas perpustakaan.
   - Klik **Approve** untuk menyetujui laporan atau **Reject** (disertai alasan revisi) jika ada data yang belum sesuai.
5. **Cetak Dokumen PDF Resmi (`/daftar-transaksi`):**
   - Masuk ke menu cetak laporan, tentukan rentang tanggal periode transaksi yang diinginkan.
   - Klik tombol **Cetak PDF** untuk mengunduh laporan sirkulasi resmi ber-kop perpustakaan dan lembar pengesahan tanda tangan.
6. **Pengaturan Sistem (`/setting`):**
   - Atur konfigurasi operasional perpustakaan, seperti **Tarif Denda Keterlambatan per Hari** dan **Maksimal Durasi Peminjaman Buku**.

---

### B. Panduan Pustakawan (Petugas)
Role **Petugas** berfokus pada operasional pelayanan sirkulasi buku fisik sehari-hari di perpustakaan.

1. **Dashboard Operasional Petugas (`/dashboard-petugas`):**
   - Melihat antrean pengajuan pinjam baru, daftar buku yang sedang dipinjam, buku yang telah jatuh tempo, dan tagihan denda.
2. **Kelola Katalog Buku (`/kelola-buku`):**
   - **Tambah Buku:** Klik tombol *Tambah Buku*, masukkan Judul, Pengarang, Penerbit, Kategori, Nomor Rak, Stok Awal, dan unggah Cover Buku.
   - **Update Stok & Edit:** Perbarui data buku fisik bila ada penambahan eksemplar atau perubahan lokasi rak.
3. **Memproses Pengajuan Peminjaman (`/petugas/pengajuan`):**
   - Buka menu antrean pengajuan dari anggota.
   - Periksa ketersediaan buku fisik di rak.
   - Klik **Setujui** untuk meminjamkan (stok buku otomatis terpotong `-1` dan tenggat jatuh tempo diset 7 hari kedepan), atau klik **Tolak** dengan mengisi alasan penolakan jika buku rusak/hilang.
4. **Memproses Pengembalian Buku (`/petugas/pengembalian`):**
   - Buka menu pengembalian saat anggota mengembalikan buku fisik ke meja sirkulasi.
   - Sistem secara otomatis menghitung apakah buku dikembalikan tepat waktu atau terlambat.
   - Jika terlambat, sistem otomatis mengalikan jumlah hari telat dengan tarif denda yang berlaku.
   - Klik **Konfirmasi Kembali**: stok buku otomatis bertambah kembali (`+1`).
5. **Kasir Pembayaran Denda Tunai (`/petugas/pembayaran`):**
   - Untuk anggota yang memilih membayar denda secara tunai di perpustakaan, petugas membuka rincian denda anggota.
   - Klik **Konfirmasi Pembayaran Kasir** setelah menerima uang tunai. Status tagihan denda seketika berubah menjadi `Lunas`.
6. **Patroli Bangku Meja Baca (`/petugas/kelola-meja`):**
   - Petugas dapat memantau denah meja membaca. Bila terdapat meja yang ditinggal pembaca tanpa checkout, petugas dapat menekan tombol **Reset Meja** untuk mengembalikan status meja menjadi hijau (*Tersedia*).
7. **Monitoring Buku Tamu (`/petugas/daftar-tamu`):**
   - Melihat rekapan presensi pengunjung fisik, memfilter berdasarkan tanggal kunjungan, dan mengklik thumbnail foto untuk membuka **Modal Zoom Foto Selfie Wajah** pengunjung.

---

### C. Panduan Anggota (Member / Pembaca)
Portal anggota didesain interaktif untuk memudahkan siswa/mahasiswa dalam mengakses fasilitas perpustakaan.

1. **Pendaftaran & Login:**
   - Pengguna baru dapat mendaftar mandiri via menu Register di `/register`.
   - Login dengan akun anggota untuk masuk ke portal pembaca (`/dashboard-anggota`).
2. **Pencarian Buku & Pinjam Buku (`/daftar-buku`):**
   - Cari buku favorit melalui kolom pencarian.
   - Klik kartu buku untuk melihat informasi sinopsis, nomor rak tempat buku berada, dan sisa stok.
   - Klik tombol **Ajukan Pinjaman** (hanya bisa diklik jika stok $\ge 1$).
3. **Memantau Riwayat Pinjaman (`/riwayat-pinjaman`):**
   - Anggota dapat melihat status pinjaman (`Menunggu Konfirmasi`, `Dipinjam`, `Ditolak`, atau `Selesai`).
   - Perhatikan batas **Tanggal Jatuh Tempo** agar tidak terkena denda keterlambatan.
   - Saat hendak mengembalikan buku, klik tombol **Kembalikan Buku** dan bawa buku fisik ke meja petugas.
4. **Pemilihan Bangku Meja Baca (`/bangku-baca`):**
   - Buka denah visual perpustakaan.
   - Pilih meja yang bertanda **Hijau (Tersedia)**.
   - Klik meja tersebut untuk melakukan reservasi tempat duduk belajar.
   - Setelah selesai membaca atau saat hendak meninggalkan perpustakaan, klik tombol **Selesai Menggunakan Bangku** agar bangku dapat dipakai oleh anggota lain.
5. **Pembayaran Denda Online via Midtrans (`/denda-anggota`):**
   - Jika memiliki denda keterlambatan, buka menu *Denda Saya*.
   - Pilih tagihan denda, lalu klik tombol **Bayar Online**.
   - Pop-up Midtrans Snap akan terbuka. Pilih metode bayar yang diinginkan (**QRIS, GoPay, ShopeePay, Virtual Account BCA/BNI/Mandiri**).
   - Setelah scan QRIS dan bayar, status denda di sistem seketika terupdate otomatis menjadi `Lunas` tanpa perlu konfirmasi manual.
6. **Perpustakaan Digital (E-Book & Skripsi) (`/e-book` & `/cari-skripsi`):**
   - Akses koleksi buku elektronik dan karya ilmiah digital.
   - Unduh berkas dokumen PDF langsung ke perangkat untuk dibaca secara offline.

---

### D. Panduan Pengunjung Tamu (Buku Tamu)
Fitur ini biasanya diakses pada komputer/tablet kiosk yang diletakkan di pintu masuk perpustakaan:

1. Buka alamat:
   ```text
   http://127.0.0.1:8000/buku-tamu
   ```
2. Saat peramban web meminta konfirmasi, klik **Izinkan / Allow** untuk memberikan akses ke webcam/kamera.
3. Masukkan data identitas: **Nama Lengkap**, **Nomor Induk / Institusi / Kelas**, dan **Tujuan Kunjungan**.
4. Posisikan wajah di depan kamera, lalu klik tombol **Ambil Foto Wajah**.
5. Klik **Kirim Data Kunjungan**. Sistem akan mencatat presensi dan menampilkan notifikasi selamat datang.

---

## 🛠️ Penanganan Masalah Umum (Troubleshooting)

- **Gambar Cover Buku / Foto Profil / Selfie Tidak Muncul:**
  Pastikan symbolic link storage sudah dibuat dengan benar:
  ```bash
  php artisan storage:link
  ```
- **Error Database Connection / Table Not Found:**
  Pastikan service MySQL di Laragon/XAMPP dalam keadaan *Running*, nama database di file `.env` bernama `perpusku`, lalu jalankan kembali:
  ```bash
  php artisan migrate --seed
  ```
- **Akses Kamera Webcam Ditolak pada Buku Tamu:**
  Pastikan peramban (Chrome/Edge) mengizinkan izin kamera (*Camera Permission: Allow*). Fitur webcam membutuhkan akses via `http://localhost`, `http://127.0.0.1`, atau domain bersertifikat SSL (`https://`).
- **Tampilan Style Rusak / Tidak Rapi:**
  Jalankan perintah build frontend:
  ```bash
  npm run build
  ```
  Lalu bersihkan cache view blade:
  ```bash
  php artisan optimize:clear
  ```

---

## 👨‍💻 Kontributor & Lisensi

- **Pengembang:**Yosep, Tanti, Desty, Fadli
- **Framework:** Laravel 11 (PHP 8.2+)
- **Lisensi:** Open-source software berlisensi [MIT License](https://opensource.org/licenses/MIT).
