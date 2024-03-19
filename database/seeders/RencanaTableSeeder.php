<?php

namespace Database\Seeders;

use App\Models\Rencana;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RencanaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Rencana::create([
            'jenis_rencana'=>'pendidikan',
            'sub_rencana'=>'teori',
            'id_dosen'=>1,
            'nama_kegiatan'=>'Mengajar Matakuliah PBO',
            'sks_terhitung'=>3
        ]);
    }
}
