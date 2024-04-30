<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class generate_tanggal extends Model
{
    //
    protected $table = 'generate_tanggal';

    protected $fillable = [
        'id_tanggal',
        'tipe',
        'tgl_awal_pengisian',
        'tgl_akhir_pengisian',
        'periode_awal_approve_assesor_1',
        'periode_akhir_approve_assesor_1',
        'periode_awal_approve_assesor_2',
        'periode_akhir_approve_assesor_2',
        'tahun_ajaran',
    ];
}
