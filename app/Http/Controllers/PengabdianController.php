<?php

namespace App\Http\Controllers;

use App\Models\DetailPenelitian;
use App\Models\Rencana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengabdianController extends Controller
{
    public function getAll()
    {
        // Ambil semua data dari masing-masing tabel rencana

        // BAGIAN A // BAGIAN A // BAGIAN A // BAGIAN A // BAGIAN A // BAGIAN A 
        

        // BAGIAN B // BAGIAN B // BAGIAN B // BAGIAN B // BAGIAN B // BAGIAN B 
        

        // BAGIAN C // BAGIAN C // BAGIAN C // BAGIAN C // BAGIAN C // BAGIAN C 
        

        // BAGIAN D // BAGIAN D // BAGIAN D // BAGIAN D // BAGIAN D // BAGIAN D 
        $karya = Rencana::join('detail_pengabdian', 'rencana.id_rencana', '=', 'detail_pengabdian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pengabdian.jenis_terbit', 'detail_pengabdian.status_tahapan', 'detail_pengabdian.jenis_pengerjaan','detail_pengabdian.peran','detail_pengabdian.jumlah_anggota', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'karya')
            ->get();

        // Kembalikan data dalam bentuk yang sesuai untuk ditampilkan di halaman
        return response()->json([
            //Data Kegiatan

            //Data Penyuluhan

            //Data Konsultan

            //Data Karya
            'karya' => $karya
        ], 200);
    }

    // BEGINING OF METHOD A. KEGIATAN // BEGINING OF METHOD A. KEGIATAN
    public function getKegiatan()
    {

    }

    public function postKegiatan(Request $request)
    {

    }

    public function editKegiatan(Request $request)
    {
        
    }

    public function deleteKegiatan($id)
    {
        
    }

    //END OF METHOD A. KEGIATAN //END OF METHOD A. KEGIATAN //END OF METHOD A. KEGIATAN

    //BEGINNING OF METHOD B. PENYULUHAN //BEGINNING OF METHOD B. PENYULUHAN 
    public function getPenyuluhan()
    {

    }

    public function postPenyuluhan(Request $request)
    {

    }

    public function editPenyuluhan(Request $request)
    {
        
    }

    public function deletePenyuluhan($id)
    {
        
    }
    //END OF METHOD B. PENYULUHAN //END OF METHOD B. PENYULUHAN //END OF METHOD B. PENYULUHAN 

    //BEGINNING OF METHOD C. KONSULTAN //BEGINNING OF METHOD C. KONSULTAN 
    public function getKonsultan()
    {

    }

    public function postKonsultan(Request $request)
    {

    }

    public function editKonsultan(Request $request)
    {
        
    }

    public function deleteKonsultan($id)
    {
        
    }
    //END OF C. KONSULTAN //END OF C. KONSULTAN //END OF C. KONSULTAN //END OF C. KONSULTAN

    //BEGINNING OF METHOD D. KARYA //BEGINNING OF METHOD D. KARYA //BEGINNING OF METHOD D. KARYA
    public function getKarya()
    {
        $karya = Rencana::join('detail_pengabdian', 'rencana.id_rencana', '=', 'detail_pengabdian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pengabdian.jenis_terbit', 'detail_pengabdian.status_tahapan', 'detail_pengabdian.jenis_pengerjaan','detail_pengabdian.peran','detail_pengabdian.jumlah_anggota', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'karya')
            ->get();
        
        return response()->json($karya, 200);
    }

    public function postKarya(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jenis_terbit = $request->get('jenis_terbit');
        $status_tahapan = $request->get('status_tahapan');
        $jenis_pengerjaan = $request->get('jenis_pengerjaan');
        $peran = $request->get('peran');
        $jumlah_anggota = (int)$request->get('jumlah_anggota');

        $bobot_pencapaian = 0;
        switch ($status_tahapan){
            case "Proposal":
                $bobot_pencapaian = 0.25;
                break;
            case "Pengumpulan data /sebar kuesioner":
                $bobot_pencapaian = 0.5;
                break;
            case "Analisa Data":
                $bobot_pencapaian = 0.75;
                break;
            case "Laporan Akhir":
                $bobot_pencapaian = 1;
                break;
            case "Konsep (desain)":
                $bobot_pencapaian = 0.25;
                break;
            case "50% dari Karya":
                $bobot_pencapaian = 0.75;
                break;
            case "Hasil akhir":
                $bobot_pencapaian = 1;
                break;
            default:
                $bobot_pencapaian = 0;
                break;
        }

        $sks = 0;
        if ($peran == "Ketua") {
            $sks = 0.6*2;
        } elseif ($peran == "Anggota") {
            $sks = round(0.8*2/$jumlah_anggota, 2);
        }

        $sks_terhitung = $bobot_pencapaian*$sks;

        $rencana = Rencana::create([
            'jenis_rencana' => 'penelitian',
            'sub_rencana' => 'penelitian_kelompok',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => round($sks_terhitung, 2),
        ]);

        $detailPenelitian = DetailPenelitian::create([
            'id_rencana' => $rencana->id_rencana,
            'jenis_terbit' => $jenis_terbit,
            'status_tahapan' => $status_tahapan,
            'jenis_pengerjaan' => $jenis_pengerjaan,
            'peran' => $peran,
            'jumlah_anggota' => $jumlah_anggota
        ]);

        $res = [$rencana, $detailPenelitian];

        return response()->json($res, 201);
    }

    public function editKarya(Request $request)
    {
        
    }

    public function deleteKarya($id)
    {
        
    }
    //END OF METHOD D. KARYA //END OF METHOD D. KARYA //END OF METHOD D. KARYA //END OF METHOD D. KARYA
}
