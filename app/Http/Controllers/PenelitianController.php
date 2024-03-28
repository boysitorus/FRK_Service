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


        // Tabel  E
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
            'menyadur'=>$menyadur,
            'menyunting'=>$menyunting,
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
            $sks = 0.6 * 2;
        } elseif ($posisi == "Editor") {
            $sks = 0.6 * 2;
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
                $sks = 0.6 * 2;
            } elseif ($posisi == "Editor") {
                $sks = 0.6 * 2;
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
            ->where('rencana.sub_rencana', 'menyunting')
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
            'sub_rencana' => 'menyunting',
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


    // M. Pembicara Seminar
    public function getPembicaraSeminar()
    {
        $pembicara_seminar = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.lingkup_wilayah', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'pembicara_seminar')
            ->get();

        return response()->json($pembicara_seminar, 200);
    }

    public function postPembicaraSeminar(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $tingkatan = $request->get('tingkatan');

        $nilai = 0;
        switch ($tingkatan){
            case "Tingkat regional daerah, institusional(minimum fakultas":
                $nilai = 0.5;
                break;
            case "Tingkat Nasional":
                $nilai = 0.75;
                break;
            case "Tingkat Internasional(dengan bahasa internasional)":
                $nilai = 1;
                break;
            default:
                $nilai = 0;
                break;
        }

        $rencana = Rencana::create([
            'jenis_rencana' => 'penelitian',
            'sub_rencana' => 'pembicara_seminar',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => round($nilai, 2),
        ]);

        $detailPenelitian = DetailPenelitian::create([
            'id_rencana' => $rencana->id_rencana,
            'tingkatan' => $tingkatan,
        ]);

        $res = [$rencana, $detailPenelitian];

        return response()->json($res, 201);
    }

    //Edit Tabel M
    public function editPembicaraSeminar(Request $request)
    {
        $request->all();
        $id_rencana = $request->get('id_rencana');

        $rencana = Rencana::where('id_rencana', $id_rencana)->first();
        $detail_rencana = DetailPenelitian::where('id_rencana', $id_rencana)->first();
        $nama_kegiatan = $request->get('nama_kegiatan');
        $tingkatan = $request->get('tingkatan');


        if ($nama_kegiatan != null && $nama_kegiatan != "") {
            $rencana->nama_kegiatan = $nama_kegiatan;
        }

        if ($tingkatan == null) {
            $tingkatan = $detail_rencana->tingkatan;
        } else {
            $detail_rencana->tingkatan = $tingkatan;
        }


        if ($tingkatan != null) {
            switch ($tingkatan){
                case "Tingkat regional daerah, institusional(minimum fakultas":
                    $nilai = 0.5;
                    break;
                case "Tingkat Nasional":
                    $nilai = 0.75;
                    break;
                case "Tingkat Internasional(dengan bahasa internasional)":
                    $nilai = 1;
                    break;
                default:
                    break;
            }
    
            $sks_terhitung = $nilai;

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

    //Delete tabel M
    public function deletePe($id)
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

    // N. Penyajian Makalah
    public function getPenyajianMakalah()
    {
        $penyajian_makalah = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.lingkup_wilayah', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'penyajian_makalah')
            ->get();

        return response()->json($penyajian_makalah, 200);
    }

    public function postPenyajianMakalah(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $tingkatan = $request->get('tingkatan');

        $nilai = 0;
        switch ($tingkatan){
            case "Tingkat regional daerah, institusional(minimum fakultas":
                $nilai = 0.5;
                break;
            case "Tingkat Nasional":
                $nilai = 0.75;
                break;
            case "Tingkat Internasional(dengan bahasa internasional)":
                $nilai = 1;
                break;
            default:
                $nilai = 0;
                break;
        }

        $rencana = Rencana::create([
            'jenis_rencana' => 'penelitian',
            'sub_rencana' => 'pembicara_seminar',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => round($nilai, 2),
        ]);

        $detailPenelitian = DetailPenelitian::create([
            'id_rencana' => $rencana->id_rencana,
            'tingkatan' => $tingkatan,
        ]);

        $res = [$rencana, $detailPenelitian];

        return response()->json($res, 201);
    }

    //Edit Tabel N
    public function editPenyajianMakalah(Request $request)
    {
        $request->all();
        $id_rencana = $request->get('id_rencana');

        $rencana = Rencana::where('id_rencana', $id_rencana)->first();
        $detail_rencana = DetailPenelitian::where('id_rencana', $id_rencana)->first();
        $nama_kegiatan = $request->get('nama_kegiatan');
        $tingkatan = $request->get('tingkatan');


        if ($nama_kegiatan != null && $nama_kegiatan != "") {
            $rencana->nama_kegiatan = $nama_kegiatan;
        }

        if ($tingkatan == null) {
            $tingkatan = $detail_rencana->tingkatan;
        } else {
            $detail_rencana->tingkatan = $tingkatan;
        }


        if ($tingkatan != null) {
            switch ($tingkatan){
                case "Tingkat regional daerah, institusional(minimum fakultas":
                    $nilai = 0.5;
                    break;
                case "Tingkat Nasional":
                    $nilai = 0.75;
                    break;
                case "Tingkat Internasional(dengan bahasa internasional)":
                    $nilai = 1;
                    break;
                default:
                    break;
            }
    
            $sks_terhitung = $nilai;

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

    //Delete tabel N
    public function deletePenyajianMakalah($id)
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

    //START OF METHOD HAK_PATEN
    public function getHakPaten()
    {
        $hak_paten = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.lingkup_wilayah', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'hak_paten')
            ->get();

        return response()->json($hak_paten, 200);
    }

    public function postHakPaten(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $lingkup_wilayah = $request->get('lingkup_wilayah');
        
        $bobot_pencapaian = 0;
        switch ($lingkup_wilayah){
            case "Paten Sederhana":
                $bobot_pencapaian = 3.00;
                break;
            case "Paten Biasa":
                $bobot_pencapaian = 4.00;
                break;
            case "Paten internasional(minimal tiga negara)":
                $bobot_pencapaian = 5.00;
                break;
            default:
                $bobot_pencapaian = 0;
                break;
        }

        $sks_terhitung = $bobot_pencapaian;

        $rencana = Rencana::create([
            'jenis_rencana' => 'penelitian',
            'sub_rencana' => 'hak_paten',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => round($sks_terhitung, 2),
        ]);

        $detailPenelitian = DetailPenelitian::create([
            'id_rencana' => $rencana->id_rencana,
            'lingkup_wilayah' => $lingkup_wilayah,
        ]);

        $res = [$rencana, $detailPenelitian];

        return response()->json($res, 201);
    }

    public function editHakPaten(Request $request)
    {
        $request->all();
        $id_rencana = $request->get('id_rencana');
    
        $rencana = Rencana::where('id_rencana', $id_rencana)->first();
        $detail_rencana = DetailPenelitian::where('id_rencana', $id_rencana)->first();
        $nama_kegiatan = $request->get('nama_kegiatan');
        $lingkup_wilayah = $request->get('lingkup_wilayah');
      

        if ($nama_kegiatan != null && $nama_kegiatan != "") {
            $rencana->nama_kegiatan = $nama_kegiatan;
        }

        if ($lingkup_wilayah == null) {
            $lingkup_wilayah = $detail_rencana->lingkup_wilayah;
        } else {
            $detail_rencana->lingkup_wilayah = $lingkup_wilayah;
        }

        
        if ($lingkup_wilayah != null ) {
            switch ($lingkup_wilayah){
                case "Paten Sederhana":
                    $bobot_pencapaian = 3.00;
                    break;
                case "Paten Biasa":
                    $bobot_pencapaian = 4.00;
                    break;
                case "Paten internasional(minimal tiga negara)":
                    $bobot_pencapaian = 5.00;
                    break;
                default:
                    $bobot_pencapaian = 0;
                    break;
            }
    
            $sks_terhitung = $bobot_pencapaian;

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

    public function deleteHakPaten($id)
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

    //END OF METHOD

    //START OF METHOD MEDIA_MASSA
    public function getMediaMassa()
    {
        $media_massa = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'media_massa')
            ->get();

        return response()->json($media_massa, 200);
    }

    public function postMediaMassa(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');

        $sks_terhitung = 0.5;

        $rencana = Rencana::create([
            'jenis_rencana' => 'penelitian',
            'sub_rencana' => 'media_massa',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => round($sks_terhitung, 2),
        ]);

        $detailPenelitian = DetailPenelitian::create([
            'id_rencana' => $rencana->id_rencana,
        ]);

        $res = [$rencana, $detailPenelitian];

        return response()->json($res, 201);
    }

    public function editMediaMassa(Request $request)
    {
        $id_rencana = $request->input('id_rencana');
        $nama_kegiatan = $request->input('nama_kegiatan');
    
        // Temukan objek Rencana dan DetailPenelitian berdasarkan id_rencana
        $rencana = Rencana::find($id_rencana);
        $detail_rencana = DetailPenelitian::where('id_rencana', $id_rencana)->first();
    
        // Periksa apakah objek Rencana dan DetailPenelitian ditemukan
        if (!$rencana || !$detail_rencana) {
            return response()->json(["message" => "Rencana not found"], 404);
        }
    
        // Update nama_kegiatan jika tersedia dalam request
        if ($nama_kegiatan !== null && $nama_kegiatan !== "") {
            $rencana->nama_kegiatan = $nama_kegiatan;
        }
    
        // Tetapkan sks_terhitung
        $sks_terhitung = 0.5;
        $rencana->sks_terhitung = $sks_terhitung;
    
        // Simpan perubahan
        $rencana->save();
        $detail_rencana->save();
    
        // Siapkan respons
        $res = [
            "rencana" => $rencana,
            "detail_rencana" => $detail_rencana,
            "message" => "Rencana updated successfully"
        ];
    
        return response()->json($res, 200);
    }
    

    public function deleteMediaMassa($id)
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