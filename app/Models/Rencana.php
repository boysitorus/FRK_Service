<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rencana extends Model
{
    //
    protected $table = 'rencana';

    protected $fillable = [
        'id_dosen', 'jenis_rencana', 'sub_rencana', 'id_dosen', 'nama_kegiatan',
        'sks_terhitung', 'asesor1_frk', 'asesor2_frk', 'asesor1_fed', 'asesor2_fed', 'lampiran'
    ];

    protected $primaryKey = 'id_rencana';
}
