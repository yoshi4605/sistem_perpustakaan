<?php

namespace Database\Seeders;

use App\Models\Anggota;
use App\Models\KepalaPerpus;
use App\Models\Petugas;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Kepala Perpustakaan
        $userKepala = User::create([
            "username"   => "Yosep Sudirman",
            "no_telepon" => "08219012441",
            "email"      => "admin@mylibrary.com",
            "password"   => Hash::make("123456"),
            "role"       => "kepala_perpus",
        ]);

        KepalaPerpus::create([
            "user_id"       => $userKepala->id,
            "nama_lengkap"  => "Mochammad Yosep Sudirman",
            "nomer_induk"   => "121099121",
            "jenis_kelamin" => "Laki-Laki",
            "tanggal_lahir" => "2007-11-27",
            "alamat"        => "Jalan Janti Nomer 21",
        ]);

        // Petugas
        $userPetugas = User::create([
            "username"   => "Tanti",
            "no_telepon" => "081234567890",
            "email"      => "petugas@mylibrary.com",
            "password"   => Hash::make("123456"),
            "role"       => "petugas",
        ]);

        Petugas::create([
            "user_id"       => $userPetugas->id,
            "nama_lengkap"  => "Tanti Dwi",
            "nomer_induk"   => "987654321",
            "jenis_kelamin" => "Perempuan",
            "tanggal_lahir" => "2002-05-15",
            "alamat"        => "Jalan Perpus No. 10",
        ]);

        // Anggota
        $userAnggota = User::create([
            "username"   => "Fadli Ansah",
            "no_telepon" => "081122334455",
            "email"      => "anggota@gmail.com",
            "password"   => Hash::make("123456"),
            "role"       => "anggota",
        ]);

        Anggota::create([
            "user_id"       => $userAnggota->id,
            "nama_lengkap"  => "Fadli Ansah",
            "nomer_induk"   => "12345678",
            "jenis_kelamin" => "Laki-Laki",
            "tanggal_lahir" => "2008-01-20",
            "alamat"        => "Jalan Merdeka No 5",
        ]);
    }
}
}