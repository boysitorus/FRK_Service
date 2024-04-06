<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPengabdian extends Model
{
    protected $table = 'detail_pengabdian';

    protected $fillable = [
        'id_rencana', 
        'jumlah_durasi',
        'status_tahapan',
        'jenis_pengerjaan',
        'posisi',
        'jenis_terbit',
        'peran',
        'jumlah_anggota',
    ];

    protected $primaryKey = 'id_rencana';
}
