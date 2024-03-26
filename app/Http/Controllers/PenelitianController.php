<?php

namespace App\Http\Controllers;

use App\Models\DetailPenelitian;
use App\Models\Rencana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenelitianController extends Controller
{
    
    public function getAll()
    {
        // Ambil semua data dari masing-masing tabel rencana

        // Tabel A
        $penelitian_kelompok = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.status_tahapan', 'detail_penelitian.posisi', 'detail_penelitian.jumlah_anggota', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'penelitian_kelompok')
            ->get();

        // Tabel B
        $penelitian_mandiri = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.status_tahapan', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'penelitian_mandiri')
            ->get();

        // Tabel C


        // Tabel D


        // Tabel E


        // Tabel F


        // Tabel G


        // Tabel H


        // BAGIAN I
        $penelitian_tridharma = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.bkd_evaluasi', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'penelitian_mandiri')
            ->get();

        // BAGIAN J
        $jurnal_ilmiah = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.lingkup_penerbit','' ,'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'penelitian_mandiri')
            ->get();

        // BAGIAN K
        

        // Kembalikan data dalam bentuk yang sesuai untuk ditampilkan di halaman
        return response()->json([
            'penelitian_kelompok' => $penelitian_kelompok,
            'penelitian_mandiri' => $penelitian_mandiri,
            'penelitian_tridharma' => $penelitian_tridharma,
        ], 200);
    }

    // START OF METHOD PENELITIAN_KELOMPOK
    public function getPenelitianKelompok()
    {
        $penelitian_kelompok = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.status_tahapan', 'detail_penelitian.posisi', 'detail_penelitian.jumlah_anggota', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'penelitian_kelompok')
            ->get();

        return response()->json($penelitian_kelompok, 200);
    }

    public function postPenelitianKelompok(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $status_tahapan = $request->get('status_tahapan');
        $posisi = $request->get('posisi');
        $jumlah_anggota = (int)$request->get('jumlah_anggota');

        $bobot_pencapaian = 0;
        switch ($status_tahapan){
            case "Proposal":
                $bobot_pencapaian = 0.25;
                break;
            case "Pengumpulan Data /sebar kuesioner":
                $bobot_pencapaian = 0.5;
                break;
            case "Analisa Data":
                $bobot_pencapaian = 0.75;
                break;
            case "Laporan Akhir":
                $bobot_pencapaian = 1;
                break;
            default:
                $bobot_pencapaian = 0;
                break;
        }

        $sks = 0;
        if ($posisi == "Ketua") {
            $sks = 0.6*2;
        } elseif ($posisi == "Anggota") {
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
            'status_tahapan' => $status_tahapan,
            'posisi' => $posisi,
            'jumlah_anggota' => $jumlah_anggota
        ]);

        $res = [$rencana, $detailPenelitian];

        return response()->json($res, 201);
    }

    public function editPenelitanKelompok(Request $request)
    {
        $request->all();
        $id_rencana = $request->get('id_rencana');

        $rencana = Rencana::where('id_rencana', $id_rencana)->first();
        $detail_rencana = DetailPenelitian::where('id_rencana', $id_rencana)->first();
        $nama_kegiatan = $request->get('nama_kegiatan');
        $status_tahapan = $request->get('status_tahapan');
        $posisi = $request->get('posisi');
        $jumlah_anggota= (int)$request->get('jumlah_anggota');



        if ($nama_kegiatan != null && $nama_kegiatan != "") {
            $rencana->nama_kegiatan = $nama_kegiatan;
        }

        if ($status_tahapan == null) {
            $status_tahapan = $detail_rencana->status_tahapan;
        } else {
            $detail_rencana->status_tahapan = $status_tahapan;
        }

        if ($posisi == null) {
            $posisi = $detail_rencana->posisi;
        } else {
            $detail_rencana->posisi = $posisi;
        }

        if ($jumlah_anggota == null) {
            $jumlah_anggota = $detail_rencana->jumlah_anggota;
        } else {
            $detail_rencana->jumlah_anggota = $jumlah_anggota;
        }

        if ($status_tahapan != null || $posisi != null || $jumlah_anggota != null) {
            switch ($status_tahapan){
                case "Proposal":
                    $bobot_pencapaian = 0.25;
                case "Pengumpulan Data /sebar kuesioner":
                    $bobot_pencapaian = 0.5;
                case "Analisa Data":
                    $bobot_pencapaian = 0.75;
                case "Laporan Akhir":
                    $bobot_pencapaian = 1;
                default:
                    $bobot_pencapaian = 0;
            }
    
            if ($posisi == "Ketua") {
                $sks = 0.6*2;
            } elseif ($posisi == "Anggota") {
                $sks = round(0.8*2/$jumlah_anggota, 2);
            }
    
            $sks_terhitung = $bobot_pencapaian*$sks;

            $rencana->sks_terhitung = $sks_terhitung;
        }

        $rencana->save();
        $detail_rencana->save();

        $res = [
            "rencana" => $rencana,
            "detail_rencana" => $detail_rencana,
            "message" => "Rencana updated successfully"
        ];


        return response()->json($res, 200);
    }

    public function deletePenelitianKelompok($id)
    {
        $record = Rencana::where('id_rencana', $id);
        $detail_record = DetailPenelitian::where('id_rencana', $id);

        if ($record && $detail_record) {
            $detail_record->delete();
            $record->delete();
            $response = [
                'message' => 'Delete kegiatan sukses'
            ];
            return response()->json($response, 201);
        } else {
            $response = [
                'message' => 'Delete kegiatan gagal'
            ];
            return response()->json($response, 300);
        }
    }

    //END OF METHOD TEORI

    // Bagian I
    public function getPenelitianTridharma(){
        $penelitian_tridharma = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
        ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.bkd_evaluasi', 'rencana.sks_terhitung')
        ->where('rencana.sub_rencana', 'penelitian_mandiri')
        ->get();
            
        return response()->json($penelitian_tridharma, 200);
    }

    public function postPenelitianTridharma(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $bkd_evaluasi = $request->get('bkd_evaluasi');
    }
    
    public function editPenelitianTridharma(){

    }

    public function deletePenelitianTridharma($id){
        $record = Rencana::where('id_rencana', $id);
        $detail_record = DetailPenelitian::where('id_rencana', $id);

        if ($record && $detail_record) {
            $detail_record->delete();
            $record->delete();
            $response = [
                'message' => 'Delete kegiatan sukses'
            ];
            return response()->json($response, 201);
        } else {
            $response = [
                'message' => 'Delete kegiatan gagal'
            ];
            return response()->json($response, 300);
        }
    }

    // akhir bagian I


    // Awal bagian J
    public function getJurnalIlmiah(){
        $jurnal_ilmiah = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
        ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.jenis_pengerjaan', 'detail_penelitian.lingkup_penerbit',
        'detail_penelitian.peran','rencana.sks_terhitung')
        ->where('rencana.sub_rencana', 'penelitian_mandiri')
        ->get();
            
        return response()->json($jurnal_ilmiah, 200);
    }

    public function postJurnalIlmiah(Request $request){
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jenis_pengerjaan = $request->get('jenis_pengerjaan');
        $lingkup_penerbit = $request->get('lingkup_penerbit');
        $peran = $request->get('peran');
       
        $sks_lingkup = 0;
        $bobot_peran = 0;
        switch($lingkup_penerbit)
        {
            case '1' : 
                $sks_lingkup = 1;
                break;

            case '2' : 
                $sks_lingkup = 2;
                break;

            case '3' : 
                $sks_lingkup = 3;
                break;
            default;
        }

        switch($peran){
            case '1':
                $bobot_peran = 0.6;
                break;
            
            case '2':
                $bobot_peran = 0.4;
                break;
            default;
        }

        $sks_terhitung = 0;
        if($jenis_pengerjaan == 1){
            $sks_terhitung = $sks_lingkup;
        }else if($jenis_pengerjaan == 2){
            $sks_terhitung = $sks_lingkup * $bobot_peran;
        }

        $rencana = Rencana::create([
            'jenis_rencana' => 'penelitian',
            'sub_rencana' => 'penelitian_kelompok',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => round($sks_terhitung, 2),
        ]);

        $detailPenelitian = DetailPenelitian::create([
            'id_rencana' => $rencana->id_rencana,
            'jenis_pengerjaan' => $jenis_pengerjaan,
            'lingkup_penerbit' => $lingkup_penerbit,
            'peran' => $peran
        ]);

        $res = [$rencana, $detailPenelitian];

        return response()->json($res, 201);


    }

    public function editJurnalIlmiah(Request $request){

        $request->all();
        $id_rencana = $request->get('id_rencana');

        $rencana = Rencana::where('id_rencana', $id_rencana)->first();
        $detail_rencana = DetailPenelitian::where('id_rencana', $id_rencana)->first();
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jenis_pengerjaan = $request->get('jenis_pengerjaan');
        $lingkup_penerbit = $request->get('lingkup_penerbit');
        $peran = $request->get('peran');
       
        $sks_lingkup = 0;
        $bobot_peran = 0;

        

        if ($nama_kegiatan != null && $nama_kegiatan != "") {
            $rencana->nama_kegiatan = $nama_kegiatan;
        }

        if ($jenis_pengerjaan == null) {
            $jenis_pengerjaan = $detail_rencana->jenis_pengerjaan;
        } else {
            $detail_rencana->jenis_pengerjaan = $jenis_pengerjaan;
        }

        if ($lingkup_penerbit == null) {
            $lingkup_penerbit = $detail_rencana->lingkup_penerbit;
        } else {
            $detail_rencana->lingkup_penerbit = $lingkup_penerbit;
        }

        if ($peran == null) {
            $peran = $detail_rencana->peran;
        } else {
            $peran->peran = $peran;
        }

        switch($lingkup_penerbit)
        {
            case '1' : 
                $sks_lingkup = 1;
                break;

            case '2' : 
                $sks_lingkup = 2;
                break;

            case '3' : 
                $sks_lingkup = 3;
                break;
            default;
        }

        switch($peran){
            case '1':
                $bobot_peran = 0.6;
                break;
            
            case '2':
                $bobot_peran = 0.4;
                break;
            default;
        }

        $sks_terhitung = 0;
        if($jenis_pengerjaan == 1){
            $sks_terhitung = $sks_lingkup;
        }else if($jenis_pengerjaan == 2){
            $sks_terhitung = $sks_lingkup * $bobot_peran;
        }


        $rencana->save();
        $detail_rencana->save();

        $res = [
            "rencana" => $rencana,
            "detail_rencana" => $detail_rencana,
            "message" => "Rencana updated successfully"
        ];


        return response()->json($res, 200);

    }

    public function deleteJurnalIlmiah($id)
    {
        $record = Rencana::where('id_rencana', $id);
        $detail_record = DetailPenelitian::where('id_rencana', $id);

        if ($record && $detail_record) {
            $detail_record->delete();
            $record->delete();
            $response = [
                'message' => 'Delete kegiatan sukses'
            ];
            return response()->json($response, 201);
        } else {
            $response = [
                'message' => 'Delete kegiatan gagal'
            ];
            return response()->json($response, 300);
        }
    }

}
