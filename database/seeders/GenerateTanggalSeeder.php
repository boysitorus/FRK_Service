<?php

namespace Database\Seeders;

use App\Models\generate_tanggal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenerateTanggalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        generate_tanggal::create([
            'tipe' => 'FED',
            'tgl_awal_pengisian' => '2024-06-01',
            'tgl_akhir_pengisian' => '2025-06-30',
            'periode_awal_approve_assesor_1' => '2024-06-01',
            'periode_akhir_approve_assesor_1' => '2025-06-30',
            'periode_awal_approve_assesor_2' => '2025-06-30',
            'periode_akhir_approve_assesor_2' => '2025-06-30',
            'tahun_ajaran' => '2023/2024',
            'semester' => 'Ganjil'
        ]);

        generate_tanggal::create([
            'tipe' => 'FRK',
            'tgl_awal_pengisian' => '2024-01-01',
            'tgl_akhir_pengisian' => '2024-12-31',
            'periode_awal_approve_assesor_1' => '2024-01-01',
            'periode_akhir_approve_assesor_1' => '2024-12-31',
            'periode_awal_approve_assesor_2' => '2024-01-01',
            'periode_akhir_approve_assesor_2' => '2024-12-31',
            'tahun_ajaran' => '2023/2024',
            'semester' => 'Ganjil'
        ]);

    }
}
