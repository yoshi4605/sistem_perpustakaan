<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\KepalaPerpus;
use App\Models\Petugas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class KelolaPenggunaController extends Controller
{
    
    public function daftar_pengguna(Request $request)
    {
        $cari = $request->input('cari');
        $query = User::query();

        // Logika Pencarian
        if ($cari) {
            $query->where(function ($q) use ($cari) {
                $q->where('username', 'like', "%{$cari}%")
                  ->orWhere('email', 'like', "%{$cari}%")
                  ->orWhereHas('anggota', fn($s) => $s->where('nama_lengkap', 'like', "%{$cari}%")->orWhere('nomer_induk', 'like', "%{$cari}%"))
                  ->orWhereHas('petugas', fn($s) => $s->where('nama_lengkap', 'like', "%{$cari}%")->orWhere('nomer_induk', 'like', "%{$cari}%"))
                  ->orWhereHas('KepalaPerpus', fn($s) => $s->where('nama_lengkap', 'like', "%{$cari}%")->orWhere('nomer_induk', 'like', "%{$cari}%"));
            });
        }

        return view('Kepala_perpus.daftar-pengguna', [
            "admins"   => (clone $query)->where('role', 'kepala_perpus')->get(),
            "petugas"  => (clone $query)->where('role', 'petugas')->get(),
            "anggotas" => (clone $query)->where('role', 'anggota')->get()
        ]);
    }

    // Detail Pengguna
    public function detail_pengguna(User $user)
    {
        return view('Kepala_perpus.detail-pengguna', [
            "User"   =>   $user
        ]);
    }

    // Tambah Pengguna Form
    public function tambah_pengguna_index()
    {
        return view('Kepala_perpus.tambah-pengguna');
    }

    // Tambah Pengguna
    public function tambah_pengguna(Request $request)
    {
        // Validasi Input
        $request->validate([
            "username" => "required|max:14|unique:users,username",
            "no_telepon" => "required|numeric|digits_between:10,15",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:6",
            "role"     => "required",
            "profile_photo" => "nullable|image|mimes:jpeg,png,jpg|max:2048",
            "nama_lengkap" => "required|string|min:4|max:32",
            "nomer_induk" => "required|string|min:6|unique:anggota,nomer_induk|unique:petugas,nomer_induk|unique:kepala_perpus,nomer_induk",
            "jenis_kelamin" => "required",
            "tanggal_lahir" => "required|date",
            "alamat" => "required|min:10",
        ], [
            "username.required" => "Username wajib diisi",
            "username.max" => "Username maksimal 14 karakter",
            "username.unique" => "Username sudah digunakan",
            "no_telepon.required" => "No Telepon wajib diisi",
            "no_telepon.numeric" => "No Telepon harus berupa angka",
            "no_telepon.digits_between" => "No Telepon harus antara 10 sampai 15 digit",
            "email.required" => "Email wajib diisi",
            "email.email" => "Email tidak valid",
            "email.unique" => "Email sudah digunakan",
            "password.required" => "Password wajib diisi.",
            "password.min" => "Password minimal 6 karakter.",
            "role"   =>   "Role Harus Di Isi",
            "tanggal_lahir.date" => "Tanggal Lahir harus berupa tanggal",
            "tanggal_lahir.required" => "Tanggal Lahir harus di isi",
            "nama_lengkap.string" => "Nama Lengkap harus berupa string",
            "nama_lengkap.required" => "Nama Lengkap Harus di isi",
            "nama_lengkap.min" => "Nama Lengkap minimal 4 karakter",
            "nama_lengkap.max" => "Nama Lengkap maksimal 32 karakter",
            "nomer_induk.string" => "Nomer Induk harus berupa string",
            "nomer_induk.unique" => "Nomer Induk sudah digunakan",
            "nomer_induk.min" => "Nomer Induk minimal 6 karakter",
            "nomer_induk.required" => "Nomer Induk harus di isi",
            "alamat.min" => "Alamat Lengkap  minimal 10 karakter",
            "alamat.required" => "Alamat Lengkap harus di isi",
            "profile_photo.image" => "Profile Photo harus berupa gambar",
            "profile_photo.mimes" => "Profile Photo harus berupa file dengan ekstensi jpeg, png, jpg",
            "profile_photo.max" => "Profile Photo maksimal berukuran 2MB",
        ]);

        // Inisialisasi Variabel Profile Photo
        $profilePhoto = null;

        // Jika Ada File Profile Photo, Simpan File dan Ambil Path-nya
        if ($request->hasFile('profile_photo')) {
            $profilePhoto = $request->file('profile_photo')->store('profile_photos', 'public');
        }

        // Auto-generate email @mylibrary.com untuk staff (petugas/kepala_perpus)
        $email = $request->email;
        if (in_array($request->role, ['petugas', 'kepala_perpus'])) {
            // Jika email belum memiliki domain @mylibrary.com, generate dari username
            if (!str_ends_with(strtolower($email), '@mylibrary.com')) {
                $email = $this->generateStaffEmail($request->username);
            }
        }

        // Buat Data User Baru
        $user = User::create([
            "username"        =>    $request->username,
            "no_telepon"      =>    $request->no_telepon,
            "email"           =>    $email,
            "password"        => Hash::make($request->password),
            "role"            =>    $request->role,
            "profile_photo"   =>    $profilePhoto
        ]);

        // Cek APabila Role Anggota
        if ($request->role === "anggota") {
            Anggota::create([
                "user_id"         =>   $user->id,
                "nama_lengkap"    =>    $request->nama_lengkap,
                "nomer_induk"     =>    $request->nomer_induk,
                "jenis_kelamin"   =>    $request->jenis_kelamin,
                "tanggal_lahir"   =>    $request->tanggal_lahir,
                "alamat"          =>    $request->alamat,
            ]);
            // Petugas
        } elseif ($request->role === "petugas") {
            Petugas::create([
                "user_id"         =>    $user->id,
                "nama_lengkap"    =>    $request->nama_lengkap,
                "nomer_induk"     =>    $request->nomer_induk,
                "jenis_kelamin"   =>    $request->jenis_kelamin,
                "tanggal_lahir"   =>    $request->tanggal_lahir,
                "alamat"          =>    $request->alamat,
            ]);
            // Kepala Perpustkaan
        } elseif ($request->role === "kepala_perpus") {
            KepalaPerpus::create([
                "user_id"         =>    $user->id,
                "nama_lengkap"    =>    $request->nama_lengkap,
                "nomer_induk"     =>    $request->nomer_induk,
                "jenis_kelamin"   =>    $request->jenis_kelamin,
                "tanggal_lahir"   =>    $request->tanggal_lahir,
                "alamat"          =>    $request->alamat,
            ]);
        }

        return redirect('/daftar-pengguna')->with('success', 'Success!, Pengguna berhasil ditambahkan');
    }

    // Edit Pengguna Form
    public function edit_pengguna(User $user)
    {
        return view('Kepala_perpus.edit-pengguna', [
            "Data"    =>    $user
        ]);
    }

    // Update Pengguna
    public function update_pengguna(Request $request, User $user)
    {
        // Validasi Input
        $request->validate([
            "username" => "required|max:14|unique:users,username," . $user->id,
            "no_telepon" => "required|numeric|digits_between:10,15",
            "email" => "required|email|unique:users,email," . $user->id,
            "password"   =>   "nullable|min:6",
            "role"      =>     "required",
            "profile_photo" => "nullable|image|mimes:jpeg,png,jpg|max:2048",
            "tanggal_lahir" => "required|date",
            "nama_lengkap" => "required|string|min:4|max:32",
            "nomer_induk" => "required|string|min:6|unique:anggota,nomer_induk," . optional($user->anggota)->id . "|unique:petugas,nomer_induk," . optional($user->petugas)->id . "|unique:kepala_perpus,nomer_induk," . optional($user->kepala_perpus)->id,
            "jenis_kelamin" => "required",
            "alamat" => "required|min:10",
        ], [
            "username.required" => "Username wajib diisi",
            "username.max" => "Username maksimal 14 karakter",
            "username.unique" => "Username sudah digunakan",
            "no_telepon.required" => "No Telepon wajib diisi",
            "no_telepon.numeric" => "No Telepon harus berupa angka",
            "no_telepon.digits_between" => "No Telepon harus antara 10 sampai 15 digit",
            "email.required" => "Email wajib diisi",
            "email.email" => "Email tidak valid",
            "email.unique" => "Email sudah digunakan",
            "role.required"  =>    "Role Harus Di Isi",
            "password"       =>     "Password Minimal 6 Kata",
            "tanggal_lahir.date" => "Tanggal Lahir harus berupa tanggal",
            "tanggal_lahir.required" => "Tanggal Lahir harus di isi",
            "nama_lengkap.string" => "Nama Lengkap harus berupa string",
            "nama_lengkap.required" => "Nama Lengkap Harus di isi",
            "nama_lengkap.min" => "Nama Lengkap minimal 4 karakter",
            "nama_lengkap.max" => "Nama Lengkap maksimal 32 karakter",
            "nomer_induk.string" => "Nomer Induk harus berupa string",
            "nomer_induk.unique" => "Nomer Induk sudah digunakan",
            "nomer_induk.min" => "Nomer Induk minimal 6 karakter",
            "nomer_induk.required" => "Nomer Induk harus di isi",
            "alamat.min" => "Alamat Lengkap  minimal 10 karakter",
            "alamat.required" => "Alamat Lengkap harus di isi",
            "profile_photo.image" => "Profile Photo harus berupa gambar",
            "profile_photo.mimes" => "Profile Photo harus berupa file dengan ekstensi jpeg, png, jpg",
            "profile_photo.max" => "Profile Photo maksimal berukuran 2MB",
        ]);

        // CEK FOTO
        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            // Simpan Foto Baru dan Update Path Foto di Database
            $fhoto = $request->file('profile_photo')->store('profile_photos', 'public');
            $user->profile_photo = $fhoto;
        }

        // CEK PASSWORD
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        // CEK ROLE
        $role_saatIni = $user->role;
        // Role Baru dari Request
        $newRole = $request->role;

        // CEK ROLE KEPALA PERPUS
        if ($role_saatIni === 'kepala_perpus') {
            // Cek Jumlah Kepala Perpus
            $jumlahKepala = User::where('role', 'kepala_perpus')->count();

            // jika cuma 1 kepala perpus, role tidak boleh diubah
            if ($jumlahKepala <= 1) {
                return back()->with('error', "Gagal Mengubah Role!. Akun Kepala <br> Perpustakaan Hanya Tersedia 1 Saat ini.");
            }
        }

        // Update Data User
        $user->username = $request->username;
        $user->email = $request->email;
        $user->no_telepon = $request->no_telepon;
        $user->role = $newRole;
        $user->save();

        // Ambil data relasi lama jika ada
        $dataRelasi = null;
        if ($role_saatIni === 'anggota' && $user->anggota) $dataRelasi = $user->anggota;
        if ($role_saatIni === 'petugas' && $user->petugas) $dataRelasi = $user->petugas;
        if ($role_saatIni === 'kepala_perpus' && $user->kepalaPerpus) $dataRelasi = $user->kepalaPerpus;

        // Hapus relasi lama jika role berubah
        if ($role_saatIni !== $newRole && $dataRelasi) {
            $dataRelasi->delete();
        }

        // Buat relasi baru sesuai role baru
        switch ($newRole) {
            case 'anggota':
                $relasi = $user->anggota;
                if (!$relasi) {
                    $relasi = new Anggota();
                }
                break;

            case 'petugas':
                $relasi = $user->petugas;
                if (!$relasi) {
                    $relasi = new Petugas();
                }
                break;

            case 'kepala_perpus':
                $relasi = $user->kepalaPerpus;
                if (!$relasi) {
                    $relasi = new KepalaPerpus();
                }
                break;
        }

        // isi data relasi dengan data lama jika ada, atau dari request
        $relasi->user_id = $user->id;
        $relasi->nama_lengkap = $request->nama_lengkap;
        $relasi->nomer_induk = $request->nomer_induk;
        $relasi->jenis_kelamin = $request->jenis_kelamin;
        $relasi->tanggal_lahir = $request->tanggal_lahir;
        $relasi->alamat = $request->alamat;
        $relasi->save();

        return back()->with('success', 'Success!, Pengguna berhasil diperbarui.');
    }


    // Delete Penggguna
    public function delete_pengguna(User $user)
    {
        // Cek Jumlah Kepala Perpus
        $jumlahKepala = User::where('role', 'kepala_perpus')->count();

        // Jika role kepala_perpus dan hanya 1, jangan hapus
        if ($user->role === 'kepala_perpus' && $jumlahKepala <= 1) {
            return back()->with('error', "Gagal!, Tidak dapat Menghapus <br> Akun Default.");
        }

        // Hapus Foto Profil Jika Ada
        if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        $user->delete($user->id);
        return redirect('/daftar-pengguna')->with('success', 'Success!, Berhasil Menghapus Akun.');
    }

    /**
     * Generate email @mylibrary.com dari username untuk staff.
     * Spasi diubah jadi titik, huruf kecil, karakter spesial dihapus.
     * Contoh: "Yosep Sudirman" → "yosep.sudirman@mylibrary.com"
     */
    private function generateStaffEmail(string $username): string
    {
        $sanitized = strtolower(trim($username));
        $sanitized = preg_replace('/[^a-z0-9\s._-]/', '', $sanitized);
        $sanitized = preg_replace('/\s+/', '.', $sanitized);
        $sanitized = preg_replace('/\.{2,}/', '.', $sanitized);
        $sanitized = trim($sanitized, '.');

        return $sanitized . '@mylibrary.com';
    }
}
