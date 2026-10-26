<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\KelolaPenggunaController;
use App\Http\Controllers\KepalaPerpusController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\pdfController;
use App\Http\Controllers\PemberitahuanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\SettingController;
use App\Http\Middleware\is_pengguna_and_kepala_perpus;
use App\Http\Middleware\isAnggota;
use App\Http\Middleware\isKepalaPerpus;
use App\Http\Middleware\isPetugas;
use App\Http\Controllers\PengunjungController;
use App\Http\Controllers\EbookController;
use App\Http\Controllers\SkripsiController;
use App\Http\Controllers\CariSkripsiController;
use App\Http\Controllers\PenerbitController;
use App\Http\Controllers\DendaPaymentController;
use Illuminate\Support\Facades\Route;


// Cek Hak Akses
Route::get('/', [RedirectController::class, 'index']);

// Authentication
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login'); // Form Login
    Route::get('/register', [AuthController::class, 'register']); // Form Register
    Route::post('/masuk', [AuthController::class, 'masuk']); // Fungsi Login
    Route::post('/daftar', [AuthController::class, 'daftar']); // Fungsi Register
});
Route::post('/logout', [AuthController::class, 'logout']); // Fungsi Logout
// End Authentication

Route::middleware('auth')->group(function () {
    // Foto Profile Delete
    Route::delete('/foto-profile/{user:id}', [ProfileController::class, 'delete_foto_profile']);
});

// Anggota Routes
Route::middleware(isAnggota::class)->group(function () {
    // Dashboard Anggota
    Route::get('/dashboard-anggota', [AnggotaController::class, 'Dashboard_Anggota']);
    // Riwayat Pinjaman
    Route::get('/riwayat-pinjaman', [AnggotaController::class, 'riwayat_pinjaman']);
    // Denda Saya
    Route::get('/denda-anggota', [AnggotaController::class, 'dendaAnggota']);
    Route::post('/denda/snap-token/{id}', [DendaPaymentController::class, 'getSnapToken']);
    Route::post('/denda/payment-success', [DendaPaymentController::class, 'paymentSuccess']);
    // Daftar Buku
    Route::get('/daftar-buku', [AnggotaController::class, 'daftar_buku']);
    // Ajukan Buku
    Route::post('/ajukan-buku', [PeminjamanController::class, 'ajukanBuku']);
    // Kembalikan Buku
    Route::post('/kembalikan-buku/{id}',[PeminjamanController::class, 'kembalikanBuku']);
    // Detail Buku
    Route::get('/daftar-buku/detail-buku={buku:id}', [AnggotaController::class, 'detail_buku']);

    // KF-04: Bangku Baca & Denah Ketersediaan untuk Anggota
    Route::get('/bangku-baca', [AnggotaController::class, 'bangkuBaca']);
    Route::post('/bangku-baca/pilih/{id}', [AnggotaController::class, 'pilihBangku']);
    Route::post('/bangku-baca/selesai/{id}', [AnggotaController::class, 'selesaiBangku']);

    // Profile Anggota
    Route::get('/profile-anggota', [ProfileController::class, 'profile_anggota']);
    Route::put('/profile-anggota', [ProfileController::class, 'profile_update']);
    // End Profile Anggota

    // Pemberitahuan Anggota
    Route::get('/pemberitahuan',[PemberitahuanController::class, 'index']);
    Route::get('/pemberitahuan/detail/{pemberitahuan:id}',[PemberitahuanController::class, 'detailPemberitahuan']);
    Route::post('/pemberitahuan/read/{id}',[PemberitahuanController::class, 'readPemberitahuan']);
    // End Pemberitahuan Anggota
});

Route::middleware(['auth'])->group(function () {
    Route::get('/koleksi-skripsi', [SkripsiController::class, 'indexByRole']);
    Route::post('/koleksi-skripsi/simpan', [SkripsiController::class, 'store']);
    Route::get('/koleksi-skripsi/tambah', [SkripsiController::class, 'create']);
    Route::put('/koleksi-skripsi/{id}', [SkripsiController::class, 'update']);
    Route::delete('/koleksi-skripsi/{id}', [SkripsiController::class, 'destroy']);
    Route::get('/koleksi-skripsi/{id}/edit', [SkripsiController::class, 'edit']);
});

// Petugas Routes
Route::middleware(isPetugas::class)->group(function () {
    // Dashboard Petugas
    Route::get('/dashboard-petugas', [PetugasController::class, 'Dashboard_petugas']);
    // End Dashboard Petugas
    // Daftar Penerbit (view only)
    Route::get('/petugas/daftar-penerbit', [PenerbitController::class, 'indexPetugas']);
    Route::get('/petugas/daftar-penerbit/{id}/detail', [PenerbitController::class, 'showPetugas']);
    Route::get('/petugas/daftar-tamu', [PengunjungController::class, 'daftarTamuPetugas']);
    // Pengajuan & pengembalian & pembayaran
    Route::get('/pengajuan',[PetugasController::class, 'pengajuan']);
    Route::get('/pengembalian',[PetugasController::class, 'pengembalian']);
    Route::get('/report-belum-kembali', [LaporanController::class, 'reportBelumKembali']);
    Route::get('/pembayaran',[PetugasController::class, 'pembayaran']);
    Route::post('/pembayaran/{id}',[PetugasController::class, 'pembayaranProses']);
    Route::post('/pengembalian/{id}',[PetugasController::class, 'pengembalianKonfirmasi']);
    Route::get('/kelola-meja', [PetugasController::class, 'kelolaMeja']);
    Route::post('/update-meja/{id}', [PetugasController::class, 'updateMeja']);
    Route::post('/pengajuan/konfirmasi/{id}',[PetugasController::class, 'konfirmasi']);
    Route::post('/pengajuan/tolak/{id}',[PetugasController::class, 'tolak']);
    // End Pengajuan & Pengembalian

    // Aktivitas
    Route::get('/aktivitas',[PetugasController::class, 'aktivitas']);
    // EndAktivitas

    // Kelola Laporan
    Route::get('/laporan', [LaporanController::class, 'indexPetugas']);
    Route::post('/laporan', [LaporanController::class, 'storeLaporan']);
    // End Kelola Laporan

    // Cetak PDF
    Route::get('/cetak-pdf/pengajuan',[pdfController::class, 'cetakPengajuan']);
    // End Cetak PDF

    // Profile Petugas
    Route::get('/profile-petugas', [ProfileController::class, 'profile_petugas']);
    Route::put('/profile-petugas', [ProfileController::class, 'profile_update']);
    // End Profile Petugas

});

// Kepala Perpustakaan Routes
Route::middleware(isKepalaPerpus::class)->group(function () {
    // Dashboard Kepala Perpus
    Route::get('/dashboard-kepala-perpustakaan', [KepalaPerpusController::class, 'Dashboard_Kepala_Perpustakaan']);
    // End Dashboard Kepala Perpus

    // Kelola Daftar Transaksi
    Route::get('/daftar-transaksi', [KepalaPerpusController::class, 'daftar_transaksi']);
    // End Kelola Daftar Transaksi
    Route::get('/report-belum-kembali', [LaporanController::class, 'reportBelumKembaliKepala']);

    // Daftar Laporan
    Route::get('/daftar-laporan', [LaporanController::class, 'daftarLaporanKepalaPerpus']);
    // End Daftar Laporan

    // Setting
    Route::get('/setting', [SettingController::class, 'settingIndex']);
    Route::put('/setting/{setting:id}', [SettingController::class, 'settingUpdate']);

    // Cetak PDF
    Route::get('/cetak-pdf/transaksi',[pdfController::class, 'cetakTransaksi']);
    // End Cetak PDF

    // Approve dan rejected Laporan
    Route::post('/approve/laporan/{id}',[LaporanController::class, 'approveLaporan']);
    Route::post('/reject/laporan/{id}',[LaporanController::class, 'rejectLaporan']);


    // Kelola Pengguna
    Route::get('/daftar-pengguna', [KelolaPenggunaController::class, 'daftar_pengguna']);
    Route::delete('/daftar-pengguna/{user:id}', [KelolaPenggunaController::class, 'delete_pengguna']);
    Route::put('/daftar-pengguna/{user:id}', [KelolaPenggunaController::class, 'update_pengguna']);
    Route::get('/daftar-pengguna/detail/pengguna_perpustakaan={user:id}', [KelolaPenggunaController::class, 'detail_pengguna']);
    Route::get('/daftar-pengguna/edit/pengguna_perpustakaan={user:id}', [KelolaPenggunaController::class, 'edit_pengguna']);

    Route::get('/daftar-pengguna/tambah-pengguna', [KelolaPenggunaController::class, 'tambah_pengguna_index']);
    Route::post('/daftar-pengguna/tambah-pengguna', [KelolaPenggunaController::class, 'tambah_pengguna']);
    // End Kelola Pengguna


    // Profile Kepala Perpus
    Route::get('/profile-kepala-perpus', [ProfileController::class, 'profile_kepala_perpus']);
    Route::put('/profile-kepala-perpus', [ProfileController::class, 'profile_update']);
    // End Profile Kepala Perpus

    // Kelola Penerbit (Admin)
    Route::get('/daftar-penerbit', [PenerbitController::class, 'index']);
    Route::get('/daftar-penerbit/tambah', [PenerbitController::class, 'create']);
    Route::post('/daftar-penerbit', [PenerbitController::class, 'store']);
    Route::get('/daftar-penerbit/{id}/detail', [PenerbitController::class, 'show']);
    Route::get('/daftar-penerbit/{id}/edit', [PenerbitController::class, 'editPage']);
    Route::put('/daftar-penerbit/{id}', [PenerbitController::class, 'update']);
    Route::delete('/daftar-penerbit/{id}', [PenerbitController::class, 'destroy']);
    // End Kelola Penerbit
});

// Route Akses Buku Tamu / Pengunjung (Petugas & Kepala Perpustakaan)
Route::middleware(['auth'])->get('/daftar-pengunjung', function (\Illuminate\Http\Request $request) {
    if (Auth::user()->role === 'petugas') {
        return redirect('/petugas/daftar-tamu');
    } elseif (Auth::user()->role === 'kepala_perpus') {
        return app(\App\Http\Controllers\PengunjungController::class)->index($request);
    }
    abort(404);
});

// Kelola Buku Petugas Perpus, Dan Kepala Perpus
Route::middleware(is_pengguna_and_kepala_perpus::class)->group(function () {
    // Kelola Buku
    Route::get('/kelola-buku', [BukuController::class, 'index']);
    Route::get('/kelola-buku/tambah-buku', [BukuController::class, 'tambah_buku']);
    Route::post('/kelola-buku', [BukuController::class, 'store_buku']);
    Route::get('/kelola-buku/{buku:id}', [BukuController::class, 'edit_buku']);
    Route::put('/kelola-buku/{buku:id}', [BukuController::class, 'update_buku']);
    Route::delete('/kelola-buku/{buku:id}', [BukuController::class, 'delete_buku']);
});

Route::view('/buku-tamu', 'pengunjung.buku_tamu')->name('buku.tamu');
Route::get('/form-buku-tamu', [PengunjungController::class, 'showForm']);
Route::post('/simpan-kunjungan', [PengunjungController::class, 'store']);

Route::get('/input-ebook', [EbookController::class, 'indexAdmin']);
Route::get('/tambah-ebook', [EbookController::class, 'create']);
Route::post('/simpan-ebook', [EbookController::class, 'store']);

Route::get('/e-book', [EbookController::class, 'indexAnggota']);
Route::get('/download-ebook/{id}', [EbookController::class, 'download'])->name('ebook.download');
Route::delete('/hapus-ebook/{id}', [EbookController::class, 'destroy']);
Route::get('/edit-ebook/{id}', [EbookController::class, 'edit']);
Route::put('/update-ebook/{id}', [EbookController::class, 'update']);

Route::get('/log-ebook', [EbookController::class, 'indexLog']);


Route::get('/cari-skripsi', [CariSkripsiController::class, 'index']);


// Webhook Midtrans (Endpoint Notifikasi Publik)
Route::post('/midtrans-notification', [DendaPaymentController::class, 'handleWebhook']);
