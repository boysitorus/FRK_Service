<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailPenelitian;
use App\Models\Rencana;
use Illuminate\Support\Facades\DB;

class penelitian_controller extends Controller
{
    //
    public function getAll()
    {
        // BAGIAN A
        $penelitianA = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.jumlah_kelas', 'detail_pendidikan.jumlah_evaluasi', 'detail_pendidikan.sks_matakuliah', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'teori')
            ->get();

        // BAGIAN C
        $bimbingan = Rencana::join('detail_pendidikan', 'rencana.id_rencana', '=', 'detail_pendidikan.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pendidikan.jumlah_mahasiswa', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'bimbingan')
            ->get();

        // BAGIAN D
        $rendah = Rencana::join('detail_pendidikan', 'rencana.id_rencana', '=', 'detail_pendidikan.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pendidikan.jumlah_dosen', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'bimbing_rendah')
            ->get();

        // BAGIAN E MENYADUR NASKAH
        $menyadur = Rencana::join('detail_pendidikan', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.status_pencapaian', "detail_penelitian.jenis_pengerjaan","detail_penelitian.posisi" ,'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'tugasAkhir')
            ->get();
        
        // BAGIAN F
        $proposal = Rencana::join('detail_pendidikan', 'rencana.id_rencana', '=', 'detail_pendidikan.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pendidikan.jumlah_mahasiswa', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'proposal')
            ->get();

        // BAGIAN G
        $kembang = Rencana::join('detail_pendidikan', 'rencana.id_rencana', '=', 'detail_pendidikan.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pendidikan.jumlah_sap', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'bimbing_rendah')
            ->get();

        // BAGIAN I
        $cangkok = Rencana::join('detail_pendidikan', 'rencana.id_rencana', '=', 'detail_pendidikan.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pendidikan.jumlah_dosen', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'cangkok')
            ->get();

        // BAGIAN J
        $koordinator = Rencana::join('detail_pendidikan', 'rencana.id_rencana', '=', 'detail_pendidikan.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'koordinator')
            ->get();

        // BAGIAN K
        $asistensi = Rencana::join('detail_pendidikan', 'rencana.id_rencana', '=', 'detail_pendidikan.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pendidikan.jumlah_mahasiswa', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'asistensi')
            ->get();

        // Kembalikan data dalam bentuk yang sesuai untuk ditampilkan di halaman
        // return response()->json([
        //     'teori' => $teori,
        //     'bimbingan' => $bimbingan,
        //     'rendah' => $rendah,
        //     'kembang' => $kembang,
        //     'cangkok' => $cangkok,
        //     'koordinator' => $koordinator,
        //     'asistensi' => $asistensi,
        //     'tugasAkhir' => $tugasAkhir,
        //     'proposal' => $proposal
        // ], 200);
    }
}
