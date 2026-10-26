<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\RiwayatPengajuan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KepalaPerpusController extends Controller
{

    // Jumlah keseluruhan anggota
    private function jumlahAnggota()
    {
        // Ambil Jumlah User dengan Role Anggota
        return User::where('role', 'anggota')->count();
    }

    // Jumlah keseluruhan petugas
    private function jumlahPetugas()
    {
        // Ambil Jumlah User dengan Role Petugas
        return User::where('role', 'petugas')->count();
    }

    // Jumlah keseluruhan Buku
    private function jumlahBuku()
    {
        // Ambil Jumlah Buku
        return Buku::count();
    }

    // Jumlah keseluruhan peminjaman
    private function jumlahPeminjaman()
    {
        // Ambil Jumlah Peminjaman dengan Status Dipinjam
         $peminjaman = Peminjaman::where('status', 'dipinjam')->count();
         return $peminjaman;
    }

    // Jumlah keseluruhan pengembalian
    private function jumlahPengembalian()
    {
        // Ambil Jumlah Pengembalian dengan Status Dikembalikan
        $pengembalian = Pengembalian::where('status', 'dikembalikan')
            ->count();
         return $pengembalian;
    }

    /**
     * Data tren peminjaman & pengembalian per bulan (6 bulan terakhir)
     * Digunakan untuk Spline Area Chart
     */
    private function trenBulanan()
    {
        $labels = [];
        $dataPeminjaman = [];
        $dataPengembalian = [];

        // Loop 6 bulan terakhir (dari bulan paling lama ke bulan saat ini)
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $labels[] = $date->translatedFormat('M Y');

            // Hitung peminjaman berdasarkan tanggal_pinjam di bulan tersebut
            $dataPeminjaman[] = Peminjaman::whereMonth('tanggal_pinjam', $date->month)
                ->whereYear('tanggal_pinjam', $date->year)
                ->count();

            // Hitung pengembalian berdasarkan created_at di bulan tersebut
            $dataPengembalian[] = Pengembalian::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
        }

        return [
            'labels' => $labels,
            'peminjaman' => $dataPeminjaman,
            'pengembalian' => $dataPengembalian,
        ];
    }

    /**
     * Data status ketersediaan buku
     * Digunakan untuk Doughnut Chart
     */
    private function statusBuku()
    {
        $totalBuku = Buku::count();
        $sedangDipinjam = Peminjaman::where('status', 'dipinjam')->count();
        $terlambat = Peminjaman::where('status', 'dipinjam')
            ->whereNotNull('tanggal_jatuh_tempo')
            ->where('tanggal_jatuh_tempo', '<', Carbon::now())
            ->count();
        // Kurangi yang terlambat dari yang dipinjam agar tidak duplikat
        $dipinjamNormal = $sedangDipinjam - $terlambat;
        $tersedia = $totalBuku - $sedangDipinjam;
        // Pastikan tidak ada nilai negatif
        if ($tersedia < 0) $tersedia = 0;
        if ($dipinjamNormal < 0) $dipinjamNormal = 0;

        return [
            'tersedia' => $tersedia,
            'dipinjam' => $dipinjamNormal,
            'terlambat' => $terlambat,
        ];
    }

    /**
     * Data kategori buku terpopuler berdasarkan jumlah peminjaman
     * Digunakan untuk Horizontal Bar Chart
     */
    private function kategoriPopuler()
    {
        $kategoris = Peminjaman::join('buku', 'peminjam_buku.buku_id', '=', 'buku.id')
            ->select('buku.kategori', DB::raw('COUNT(*) as total'))
            ->whereNotNull('buku.kategori')
            ->where('buku.kategori', '!=', '')
            ->groupBy('buku.kategori')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return [
            'labels' => $kategoris->pluck('kategori')->toArray(),
            'data' => $kategoris->pluck('total')->toArray(),
        ];
    }

    /**
     * Data aktivitas peminjaman terbaru
     * Digunakan untuk Activity Table
     */
    private function aktivitasTerbaru()
    {
        return Peminjaman::with(['anggota', 'buku'])
            ->latest()
            ->limit(5)
            ->get();
    }


    // Dashboard Kepala Perpustakaan
    public function Dashboard_Kepala_Perpustakaan()
    {
        return view('Kepala_perpus.dashboard', [
            "Jumlah_Anggota"       => $this->jumlahAnggota(),
            "Jumlah_Petugas"       => $this->jumlahPetugas(),
            "jumlah_buku"          => $this->jumlahBuku(),
            "jumlah_peminjaman"    => $this->jumlahPeminjaman(),
            "jumlah_pengembalian"  => $this->jumlahPengembalian(),
            // Data untuk chart
            "tren_bulanan"         => $this->trenBulanan(),
            "status_buku"          => $this->statusBuku(),
            "kategori_populer"     => $this->kategoriPopuler(),
            "aktivitas_terbaru"    => $this->aktivitasTerbaru(),
        ]);
    }

    // Daftar Transaksi
    public function daftar_transaksi(Request $request)
    {
        // Ambil Jenis Transaksi dari Request
        $jenis_transaksi = $request->input('jenis_transaksi', 'pengajuan');

        // Ambil Data Transaksi Berdasarkan Jenis Transaksi
        if ($jenis_transaksi === 'pengembalian') {
            // Jika Jenis Transaksi Pengembalian, Ambil Data Pengembalian Beserta Relasi Peminjaman dan Anggota
            $query = Pengembalian::with(['peminjaman.buku', 'peminjaman.anggota'])
                ->where('status', 'dikembalikan');
        } else {
            // Jika Jenis Transaksi Pengajuan, Ambil Data Pengajuan Beserta Relasi Peminjaman
            $query = RiwayatPengajuan::with(['peminjaman.buku', 'peminjaman.anggota']);
        }

        // Filter Waktu
        if ($request->filter_waktu) {
            $dateColumn = ($jenis_transaksi === 'pengembalian') ? 'updated_at' : 'created_at';

            // Filter Minggu ini
            if ($request->filter_waktu === 'minggu_ini') {
                $query->whereBetween($dateColumn, [
                    now()->startOfWeek(),
                    now()->endOfWeek()
                ]);
            }

            // Filter Bulan Ini
            if ($request->filter_waktu == 'bulan_ini') {
                $query->whereMonth($dateColumn, now()->month)
                    ->whereYear($dateColumn, now()->year);
            }

            // Bulan Lalu
            if ($request->filter_waktu == 'bulan_lalu') {
                $lastMonth = now()->subMonthNoOverflow();

                $query->whereMonth($dateColumn, $lastMonth->month)
                    ->whereYear($dateColumn, $lastMonth->year);
            }
        }

        // Ambil Data Transaksi Berdasarkan Filter Waktu
        $transaksis = $query->latest()->paginate(5)->withQueryString();

        return view('Kepala_perpus.daftar-transaksi', [
            "transaksis"   => $transaksis,
            "jenis_transaksi"  => $jenis_transaksi
        ]);
    }
}
