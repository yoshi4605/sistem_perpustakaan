<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Setting::firstOrCreate([], [
            'max_pinjam'     => 3,
            'max_pengajuan'  => 2,
            'denda_per_hari' => 1000,
            'durasi_pinjam'  => 7,
        ]);

        $this->call([
            UserSeeder::class,
            PenerbitSeeder::class,
            BukuSeeder::class,
            EbookSeeder::class,
            MejaSeeder::class,
            SkripsiSeeder::class,
        ]);
    }
}
