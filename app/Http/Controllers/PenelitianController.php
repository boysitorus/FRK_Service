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


        // Tabel  E MENYADUR NASKAH
        $menyadur = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.status_tahapan', "detail_penelitian.posisi",'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'menyadur')
            ->get();
        
        // Tabel F
        $menyunting = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.status_tahapan','detail_penelitian.posisi', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'menyunting')
            ->get();


        // Tabel G


        // Tabel H


        // BAGIAN I


        // BAGIAN J
        

        // BAGIAN K
        

        // Kembalikan data dalam bentuk yang sesuai untuk ditampilkan di halaman
        return response()->json([
            'penelitian_kelompok' => $penelitian_kelompok,
            'penelitian_mandiri' => $penelitian_mandiri,
            'menyadur'=>$menyadur,
            'menyunting'=>$menyunting,
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

    public function editPenelitianKelompok(Request $request)
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

    //END OF METHOD PENELITIAN MANDIRI

    //BEGINNING  OF METHOD PENILITIAN MANDIRI

    public function getPenelitianMandiri()
    {
        $penelitian_mandiri = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.status_tahapan', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'penelitian_mandiri')
            ->get();

        return response()->json($penelitian_mandiri, 200);
    }

    public function postPenelitianMandiri(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $status_tahapan = $request->get('status_tahapan');

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

        $sks = 2;
        $sks_terhitung = $bobot_pencapaian*$sks;

        $rencana = Rencana::create([
            'jenis_rencana' => 'penelitian',
            'sub_rencana' => 'penelitian_mandiri',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => round($sks_terhitung, 2),
        ]);

        $detailPenelitian = DetailPenelitian::create([
            'id_rencana' => $rencana->id_rencana,
            'status_tahapan' => $status_tahapan
        ]);

        $res = [$rencana, $detailPenelitian];

        return response()->json($res, 201);
    }

    public function editPenelitianMandiri(Request $request)
    {
        $request->all();
        $id_rencana = $request->get('id_rencana');

        $rencana = Rencana::where('id_rencana', $id_rencana)->first();
        $detail_rencana = DetailPenelitian::where('id_rencana', $id_rencana)->first();
        $nama_kegiatan = $request->get('nama_kegiatan');
        $status_tahapan = $request->get('status_tahapan');

        if ($nama_kegiatan != null && $nama_kegiatan != "") {
            $rencana->nama_kegiatan = $nama_kegiatan;
        }

        if ($status_tahapan == null) {
            $status_tahapan = $detail_rencana->status_tahapan;
        } else {
            $detail_rencana->status_tahapan = $status_tahapan;
        }

        if ($status_tahapan != null) {
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
            }
            $sks = 2;
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

    public function deletePenelitianMandiri($id)
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

    //END OF METHOD PENELITIAN MANDIRI

    //BEGINNING OF METHOD MENYADUR
    public function getMenyadur(){
        $menyadur = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.status_tahapan',"detail_penelitian.posisi",'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'menyadur')
            ->get();
        return response()->json($menyadur, 200);
    }

    public function postMenyadur(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $status_tahapan = $request->get('status_tahapan');
        $posisi = $request->get('posisi');

        $bobot_pencapaian = 0;
        switch ($status_tahapan){
            case "Pendahuluan":
                $bobot_pencapaian = 0.25;
                break;
            case "50% dari isi buku":
                $bobot_pencapaian = 0.5;
                break;
            case "sks buku jadi":
                $bobot_pencapaian = 0.75;
                break;
            case "persetujan penerbit":
                $bobot_pencapaian = 0.85;
                break;
            case "sks buku selesai dicetak":
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
            $sks = 0.4 * 2;
        }

        $sks_terhitung = $bobot_pencapaian*$sks;

        $rencana = Rencana::create([
            'jenis_rencana' => 'penelitian',
            'sub_rencana' => 'menyadur',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => round($sks_terhitung, 2),
        ]);

        $detailPenelitian = DetailPenelitian::create([
            'id_rencana' => $rencana->id_rencana,
            'status_tahapan' => $status_tahapan,
            'posisi' => $posisi,
        ]);

        $res = [$rencana, $detailPenelitian];

        return response()->json($res, 201);
    }

    public function editMenyadur(Request $request)
    {
        $request->all();
        $id_rencana = $request->get('id_rencana');

        $rencana = Rencana::where('id_rencana', $id_rencana)->first();
        $detail_rencana = DetailPenelitian::where('id_rencana', $id_rencana)->first();
        $nama_kegiatan = $request->get('nama_kegiatan');
        $status_tahapan = $request->get('status_tahapan');
        $posisi = $request->get('posisi');



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

        if ($status_tahapan != null || $posisi != null) {
            switch ($status_tahapan){
                case "Pendahuluan":
                    $bobot_pencapaian = 0.25;
                    break;
                case "50% dari isi buku":
                    $bobot_pencapaian = 0.5;
                    break;
                case "sks buku jadi":
                    $bobot_pencapaian = 0.75;
                    break;
                case "persetujan penerbit":
                    $bobot_pencapaian = 0.85;
                    break;
                case "sks buku selesai dicetak":
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
                $sks = 0.4 * 2;
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

    public function deleteMenyadur($id)
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

    //END OF METHOD MENYADUR

    //BEGINNING OF METHOD MENYUNTING
    public function getMenyunting(){
        $menyunting = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.status_tahapan',"detail_penelitian.posisi",'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'menyadur')
            ->get();
        return response()->json($menyunting, 200);
    }

    public function postMenyunting(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $status_tahapan = $request->get('status_tahapan');
        $posisi = $request->get('posisi');

        $bobot_pencapaian = 0;
        switch ($status_tahapan){
            case "Pendahuluan":
                $bobot_pencapaian = 0.25;
                break;
            case "50% dari isi buku":
                $bobot_pencapaian = 0.5;
                break;
            case "sks buku jadi":
                $bobot_pencapaian = 0.75;
                break;
            case "persetujan penerbit":
                $bobot_pencapaian = 0.85;
                break;
            case "sks buku selesai dicetak":
                $bobot_pencapaian = 1;
                break;
            default:
                $bobot_pencapaian = 0;
                break;
        }

        $sks = 0;
        if ($posisi == "Ketua") {
            $sks = 0.5*2;
        } elseif ($posisi == "Anggota") {
            $sks = 0.5 * 2;
        }

        $sks_terhitung = $bobot_pencapaian*$sks;

        $rencana = Rencana::create([
            'jenis_rencana' => 'penelitian',
            'sub_rencana' => 'menyadur',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => round($sks_terhitung, 2),
        ]);

        $detailPenelitian = DetailPenelitian::create([
            'id_rencana' => $rencana->id_rencana,
            'status_tahapan' => $status_tahapan,
            'posisi' => $posisi,
        ]);

        $res = [$rencana, $detailPenelitian];

        return response()->json($res, 201);
    }

    public function editMenyunting(Request $request)
    {
        $request->all();
        $id_rencana = $request->get('id_rencana');

        $rencana = Rencana::where('id_rencana', $id_rencana)->first();
        $detail_rencana = DetailPenelitian::where('id_rencana', $id_rencana)->first();
        $nama_kegiatan = $request->get('nama_kegiatan');
        $status_tahapan = $request->get('status_tahapan');
        $posisi = $request->get('posisi');



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

        if ($status_tahapan != null || $posisi != null) {
            switch ($status_tahapan){
                case "Pendahuluan":
                    $bobot_pencapaian = 0.25;
                    break;
                case "50% dari isi buku":
                    $bobot_pencapaian = 0.5;
                    break;
                case "sks buku jadi":
                    $bobot_pencapaian = 0.75;
                    break;
                case "persetujan penerbit":
                    $bobot_pencapaian = 0.85;
                    break;
                case "sks buku selesai dicetak":
                    $bobot_pencapaian = 1;
                    break;
                default:
                    $bobot_pencapaian = 0;
                    break;
            }
    
            $sks = 0;
            if ($posisi == "Ketua") {
                $sks = 0.5*2;
            } elseif ($posisi == "Anggota") {
                $sks = 0.5 * 2;
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

    public function deleteMenyunting($id)
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

    //END OF METHOD MENYUNTING
}
