<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPenunjang extends Model
{
    protected $table = 'detail_penunjang';

    protected $fillable = [
        'id_rencana',
        'jumlah_mahasiswa',
        'posisi',
        'jenis_jabatan_struktural',
        'jenis_jabatan_nonstruktural',
        'jenis_tingkatan',
        'jumlah_prodi',
        'jumlah_kegiatan',
        'jabatan'
    ];

    protected $primaryKey = 'id_rencana';
}
