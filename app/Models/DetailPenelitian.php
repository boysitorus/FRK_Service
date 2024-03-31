<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPenelitian extends Model
{
    protected $table = 'detail_penelitian';

    protected $fillable = [
        'id_rencana', 
        'jenis_pengerjaan', 
        'posisi', 
        'jumlah_anggota', 
        'status_tahapan', 
        'lingkup_wilayah', 
        'peran',
        'lingkup_penerbit', 
        'jumlah_dosen',
        'jumlah_bkd'
    ];

    protected $primaryKey = 'id_rencana';
}
