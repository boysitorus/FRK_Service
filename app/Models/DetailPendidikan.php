<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPendidikan extends Model
{
    //
    protected $table = 'detail_pendidikan';

    protected $fillable = [
        'id_rencana', 
        'sks_matakuliah', 
        'jumlah_pertemuan', 
        'jumlah_evaluasi', 
        'jumlah_kelas', 
        'jumlah_mahasiswa', 
        'jumlah_kelompok',
        'jumlah_dosen', 
        'jumlah_sap', 
        'jumlah_pengampu'
    ];

    protected $primaryKey = 'id_rencana';
}
