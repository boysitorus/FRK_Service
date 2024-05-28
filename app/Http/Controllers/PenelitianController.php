<?php

namespace App\Http\Controllers;

use App\Models\DetailPenelitian;
use App\Models\Rencana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenelitianController extends Controller
{

    public function getAll($id)
    {
        //SEMUA
        $all = Rencana::where('rencana.id_dosen', $id)
            ->select('rencana.flag_save_permananent', 1)
            ->count();

        // BAGIAN A // BAGIAN A // BAGIAN A // BAGIAN A // BAGIAN A // BAGIAN A
        $penelitian_kelompok = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.status_tahapan', 'detail_penelitian.posisi', 'detail_penelitian.jumlah_anggota', 'rencana.sks_terhitung', 'rencana.asesor1_frk', 'rencana.asesor2_frk', 'rencana.lampiran', 'rencana.flag_save_permananent')
            ->where('rencana.sub_rencana', 'penelitian_kelompok')
            ->get();

        // BAGIAN B // BAGIAN B // BAGIAN B // BAGIAN B // BAGIAN B // BAGIAN B
        $penelitian_mandiri = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.status_tahapan', 'rencana.sks_terhitung', 'rencana.asesor1_frk','rencana.asesor2_frk', 'rencana.lampiran', 'rencana.flag_save_permananent')
            ->where('rencana.sub_rencana', 'penelitian_mandiri')
            ->get();

        // BAGIAN C // BAGIAN C // BAGIAN C // BAGIAN C // BAGIAN C // BAGIAN C
        $buku_terbit = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.status_tahapan', 'detail_penelitian.jenis_pengerjaan','detail_penelitian.peran','rencana.sks_terhitung', 'rencana.asesor1_frk', 'rencana.asesor2_frk', 'rencana.lampiran', 'rencana.flag_save_permananent')
            ->where('rencana.sub_rencana', 'buku_terbit')
            ->get();

        // BAGIAN D // BAGIAN D // BAGIAN D // BAGIAN D // BAGIAN D // BAGIAN D
        $buku_internasional = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.status_tahapan', 'detail_penelitian.jenis_pengerjaan','detail_penelitian.peran','rencana.sks_terhitung', 'rencana.asesor1_frk', 'rencana.asesor2_frk', 'rencana.lampiran', 'rencana.flag_save_permananent')
            ->where('rencana.sub_rencana', 'buku_internasional')
            ->get();

        // BAGIAN E // BAGIAN E // BAGIAN E // BAGIAN E // BAGIAN E // BAGIAN E
        $menyadur = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.status_tahapan', "detail_penelitian.posisi",'rencana.sks_terhitung', 'rencana.asesor1_frk', 'rencana.asesor2_frk', 'rencana.lampiran', 'rencana.flag_save_permananent')
            ->where('rencana.sub_rencana', 'menyadur')
            ->get();

        // BAGIAN F // BAGIAN F // BAGIAN F // BAGIAN F // BAGIAN F // BAGIAN F
        $menyunting = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.status_tahapan','detail_penelitian.posisi', 'rencana.sks_terhitung', 'rencana.asesor1_frk', 'rencana.asesor2_frk', 'rencana.lampiran', 'rencana.flag_save_permananent')
            ->where('rencana.sub_rencana', 'menyunting')
            ->get();

        // BAGIAN G // BAGIAN G // BAGIAN G // BAGIAN G // BAGIAN G // BAGIAN G
        $penelitian_modul = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.status_tahapan', 'detail_penelitian.jenis_pengerjaan', 'detail_penelitian.peran', 'rencana.sks_terhitung', 'rencana.asesor1_frk', 'rencana.asesor2_frk', 'rencana.lampiran', 'rencana.flag_save_permananent')
            ->where('rencana.sub_rencana', 'penelitian_modul')
            ->get();

        // BAGIAN H // BAGIAN H // BAGIAN H // BAGIAN H // BAGIAN H // BAGIAN H
        $penelitian_pekerti = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'rencana.sks_terhitung', 'rencana.asesor1_frk', 'rencana.asesor2_frk', 'rencana.lampiran', 'rencana.flag_save_permananent')
            ->where('rencana.sub_rencana', 'penelitian_pekerti')
            ->get();

        // BAGIAN I // BAGIAN I // BAGIAN I // BAGIAN I // BAGIAN I // BAGIAN I
        $penelitian_tridharma = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.jumlah_bkd', 'rencana.sks_terhitung', 'rencana.asesor1_frk', 'rencana.asesor2_frk', 'rencana.lampiran', 'rencana.flag_save_permananent')
            ->where('rencana.sub_rencana', 'penelitian_tridharma')
            ->get();

        // BAGIAN J // BAGIAN J // BAGIAN J // BAGIAN J // BAGIAN J // BAGIAN J
        $jurnal_ilmiah = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.jenis_pengerjaan', 'detail_penelitian.lingkup_penerbit',
            'detail_penelitian.peran','rencana.sks_terhitung', 'rencana.asesor1_frk', 'rencana.asesor2_frk', 'rencana.lampiran', 'rencana.flag_save_permananent')
            ->where('rencana.sub_rencana', 'jurnal_ilmiah')
            ->get();

        // BAGIAN K // BAGIAN K // BAGIAN K // BAGIAN K // BAGIAN K // BAGIAN K
        $hak_paten = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.lingkup_wilayah', 'rencana.sks_terhitung', 'rencana.asesor1_frk', 'rencana.asesor2_frk', 'rencana.lampiran', 'rencana.flag_save_permananent')
            ->where('rencana.sub_rencana', 'hak_paten')
            ->get();

        // BAGIAN L // BAGIAN L // BAGIAN L // BAGIAN L // BAGIAN L // BAGIAN L
        $media_massa = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'rencana.sks_terhitung', 'rencana.asesor1_frk', 'rencana.asesor2_frk', 'rencana.lampiran', 'rencana.flag_save_permananent')
            ->where('rencana.sub_rencana', 'media_massa')
            ->get();

        // BAGIAN M // BAGIAN M // BAGIAN M // BAGIAN M // BAGIAN M // BAGIAN M
        $pembicara_seminar = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.lingkup_wilayah', 'rencana.sks_terhitung', 'rencana.asesor1_frk', 'rencana.asesor2_frk', 'rencana.lampiran', 'rencana.flag_save_permananent')
            ->where('rencana.sub_rencana', 'pembicara_seminar')
            ->get();

        // BAGIAN N // BAGIAN N // BAGIAN N // BAGIAN N // BAGIAN N // BAGIAN N
        $penyajian_makalah = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
        ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.jenis_pengerjaan', 'detail_penelitian.lingkup_wilayah', 'detail_penelitian.posisi', 'detail_penelitian.jumlah_anggota', 'rencana.sks_terhitung', 'rencana.asesor1_frk', 'rencana.asesor2_frk', 'rencana.lampiran', 'rencana.flag_save_permananent')
        ->where('rencana.sub_rencana', 'penyajian_makalah')
        ->get();


        // Kembalikan data dalam bentuk yang sesuai untuk ditampilkan di halaman
        return response()->json([
            'penelitian_kelompok' => $penelitian_kelompok,
            'penelitian_mandiri' => $penelitian_mandiri,
            'buku_terbit' => $buku_terbit,
            'buku_internasional' => $buku_internasional,
            'menyadur'=>$menyadur,
            'menyunting'=>$menyunting,
            'penelitian_modul' => $penelitian_modul,
            'penelitian_pekerti' => $penelitian_pekerti,
            'penelitian_tridharma' => $penelitian_tridharma,
            'jurnal_ilmiah' => $jurnal_ilmiah,
            'hak_paten' => $hak_paten,
            'media_massa' => $media_massa,
            'pembicara_seminar' => $pembicara_seminar,
            'penyajian_makalah'=> $penyajian_makalah
        ], 200);
    }

    public function all($id)
    {
        $all = Rencana::where('rencana.id_dosen', $id)
            ->where('rencana.flag_save_permananent', 1)
            ->count();

            return response()->json($all, 200);
    }

    // BEGINING OF METHOD A. PENELITIAN_KELOMPOK // BEGINING OF METHOD A. PENELITIAN_KELOMPOK
    public function getPenelitianKelompok($id)
    {
        $penelitian_kelompok = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.status_tahapan', 'detail_penelitian.posisi', 'detail_penelitian.jumlah_anggota', 'rencana.sks_terhitung', 'rencana.asesor1_frk', 'rencana.asesor2_frk', 'rencana.lampiran', 'rencana.flag_save_permananent')
            ->where('rencana.sub_rencana', 'penelitian_kelompok')
            ->where('id_dosen', $id)
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
            $sks = 0.8*2;
        } elseif ($posisi == "Anggota") {
            $sks = round(0.6*2/$jumlah_anggota, 2);
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
                $sks = 0.8*2;
            } elseif ($posisi == "Anggota") {
                $sks = round(0.6*2/$jumlah_anggota, 2);
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

    //END OF METHOD A. PENELITIAN KELOMPOK //END OF METHOD A. PENELITIAN KELOMPOK

    //BEGINNING  OF METHOD B. PENILITIAN MANDIRI //BEGINNING  OF METHOD B. PENILITIAN MANDIRI

    public function getPenelitianMandiri($id)
    {
        $penelitian_mandiri = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.status_tahapan', 'rencana.sks_terhitung', 'rencana.asesor1_frk', 'rencana.asesor2_frk', 'rencana.lampiran', 'rencana.flag_save_permananent')
            ->where('rencana.sub_rencana', 'penelitian_mandiri')
            ->where('id_dosen', $id)
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

    //END OF METHOD B. PENELITIAN MANDIRI //END OF METHOD B. PENELITIAN MANDIRI

    //BEGINNING OF METHOD C. BUKU TERBIT //BEGINNING OF METHOD C. BUKU TERBIT

    public function getBukuTerbit($id)
    {
        $buku_terbit = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.status_tahapan', 'detail_penelitian.jenis_pengerjaan','detail_penelitian.peran','rencana.sks_terhitung', 'rencana.asesor1_frk', 'rencana.asesor2_frk', 'rencana.lampiran', 'rencana.flag_save_permananent')
            ->where('rencana.sub_rencana', 'buku_terbit')
            ->where('id_dosen', $id)
            ->get();

        return response()->json($buku_terbit, 200);
    }

    public function postBukuTerbit(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $status_tahapan = $request->get('status_tahapan');
        $jenis_pengerjaan = $request->get('jenis_pengerjaan');
        $peran = $request->get('peran');

        $bobot_pencapaian = 0;
        switch ($status_tahapan){
            case "Pendahuluan":
                $bobot_pencapaian = 0.25;
                break;
            case "50% dari isi buku":
                $bobot_pencapaian = 0.5;
                break;
            case "Buku Jadi":
                $bobot_pencapaian = 0.75;
                break;
            case "Persetujuan Penerbit":
                $bobot_pencapaian = 0.85;
                break;
            case "Buku Selesai Dicetak":
                $bobot_pencapaian = 1;
                break;
            default:
                $bobot_pencapaian = 0;
                break;
        }

        $bobot_peran = 0;

        if($peran == "Editor"){
            $bobot_peran = 0.6;
        }else if($peran == "Kontributor"){
            $bobot_peran = 0.4;
        }

        $sks = 3;
        $sks_terhitung = 0;

        if($jenis_pengerjaan == "Mandiri"){
            $sks_terhitung = $bobot_pencapaian*$sks;
        }else if($jenis_pengerjaan == "Kelompok"){
            $sks_terhitung = $bobot_pencapaian*$bobot_peran*$sks;
        }

        $rencana = Rencana::create([
            'jenis_rencana' => 'penelitian',
            'sub_rencana' => 'buku_terbit',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => round($sks_terhitung, 3)
        ]);

        $detailPenelitian = DetailPenelitian::create([
            'id_rencana' => $rencana->id_rencana,
            'jenis_pengerjaan' => $jenis_pengerjaan,
            'status_tahapan' => $status_tahapan,
            'peran'=> $peran
        ]);

        $res = [$rencana, $detailPenelitian];

        return response()->json($res, 201);
    }

    public function editBukuTerbit(Request $request)
    {
        $request->all();
        $id_rencana = $request->get('id_rencana');

        $rencana = Rencana::where('id_rencana', $id_rencana)->first();
        $detail_rencana = DetailPenelitian::where('id_rencana', $id_rencana)->first();
        $nama_kegiatan = $request->get('nama_kegiatan');
        $status_tahapan = $request->get('status_tahapan');
        $jenis_pengerjaan = $request->get('jenis_pengerjaan');
        $peran = $request->get('peran');

        if ($nama_kegiatan != null) {
            $rencana->nama_kegiatan = $nama_kegiatan;
        }

        if ($status_tahapan == null) {
            $status_tahapan = $detail_rencana->status_tahapan;
        } else {
            $detail_rencana->status_tahapan = $status_tahapan;
        }

        if ($jenis_pengerjaan == null) {
            $jenis_pengerjaan = $detail_rencana->jenis_pengerjaan;
        } else {
            $detail_rencana->jenis_pengerjaan = $jenis_pengerjaan;
        }

        if ($peran == null) {
            $peran = $detail_rencana->peran;
        } else {
            $detail_rencana->peran = $peran;
        }

        $bobot_pencapaian = 0;

        if ($status_tahapan != null) {
            switch ($status_tahapan){
                case "Pendahuluan":
                $bobot_pencapaian = 0.25;
                break;
            case "50% dari isi buku":
                $bobot_pencapaian = 0.5;
                break;
            case "Buku Jadi":
                $bobot_pencapaian = 0.75;
                break;
            case "Persetujuan Penerbit":
                $bobot_pencapaian = 0.85;
                break;
            case "Buku Selesai Dicetak":
                $bobot_pencapaian = 1;
                break;

            default:
                $bobot_pencapaian = 0;
                break;
            }
            $bobot_peran = 0;

            if($peran == "Editor"){
                $bobot_peran = 0.6;
            }else if($peran == "Kontributor"){
                $bobot_peran = 0.4;
            }

            $sks = 5;
            $sks_terhitung = 0;

            if($jenis_pengerjaan == "Mandiri"){
                $sks_terhitung = $bobot_pencapaian*$sks;
            }else if($jenis_pengerjaan == "Kelompok"){
                $sks_terhitung = $bobot_pencapaian*$bobot_peran*$sks;
            }

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

    public function deleteBukuTerbit($id)
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

    //END OF METHOD C. BUKU TERBIT //END OF METHOD C. BUKU TERBIT

    //BEGINNING  OF METHOD D. BUKU INTERNASIONAL //BEGINNING  OF METHOD D. BUKU INTERNASIONAL

    public function getBukuInternasional($id)
    {
        $buku_internasional = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.status_tahapan', 'detail_penelitian.jenis_pengerjaan','detail_penelitian.peran','rencana.sks_terhitung', 'rencana.asesor1_frk', 'rencana.asesor2_frk', 'rencana.lampiran', 'rencana.flag_save_permananent')
            ->where('rencana.sub_rencana', 'buku_internasional')
            ->where('id_dosen', $id)
            ->get();

        return response()->json($buku_internasional, 200);
    }

    public function postBukuInternasional(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $status_tahapan = $request->get('status_tahapan');
        $jenis_pengerjaan = $request->get('jenis_pengerjaan');
        $peran = $request->get('peran');

        $bobot_pencapaian = 0;
        switch ($status_tahapan){
            case "Pendahuluan":
                $bobot_pencapaian = 0.25;
                break;
            case "50% dari isi buku":
                $bobot_pencapaian = 0.5;
                break;
            case "Buku Jadi":
                $bobot_pencapaian = 0.75;
                break;
            case "Persetujuan Penerbit":
                $bobot_pencapaian = 0.85;
                break;
            case "Buku Selesai Dicetak":
                $bobot_pencapaian = 1;
                break;
            default:
                $bobot_pencapaian = 0;
                break;
        }

        $bobot_peran = 0;

        if($peran == "Editor"){
            $bobot_peran = 0.6;
        }else if($peran == "Kontributor"){
            $bobot_peran = 0.4;
        }

        $sks = 5;
        $sks_terhitung = 0;

        if($jenis_pengerjaan == "Mandiri"){
            $sks_terhitung = $bobot_pencapaian*$sks;
        }else if($jenis_pengerjaan == "Kelompok"){
            $sks_terhitung = $bobot_pencapaian*$bobot_peran*$sks;
        }

        $rencana = Rencana::create([
            'jenis_rencana' => 'penelitian',
            'sub_rencana' => 'buku_internasional',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => round($sks_terhitung, 2)
        ]);

        $detailPenelitian = DetailPenelitian::create([
            'id_rencana' => $rencana->id_rencana,
            'jenis_pengerjaan' => $jenis_pengerjaan,
            'status_tahapan' => $status_tahapan,
            'peran'=> $peran
        ]);

        $res = [$rencana, $detailPenelitian];

        return response()->json($res, 201);
    }

    public function editBukuInternasional(Request $request)
    {
        $request->all();
        $id_rencana = $request->get('id_rencana');

        $rencana = Rencana::where('id_rencana', $id_rencana)->first();
        $detail_rencana = DetailPenelitian::where('id_rencana', $id_rencana)->first();
        $nama_kegiatan = $request->get('nama_kegiatan');
        $status_tahapan = $request->get('status_tahapan');
        $jenis_pengerjaan = $request->get('jenis_pengerjaan');
        $peran = $request->get('peran');

        if ($nama_kegiatan != null && $nama_kegiatan != "") {
            $rencana->nama_kegiatan = $nama_kegiatan;
        } else {
            $detail_rencana->nama_kegiatan = $nama_kegiatan;
        }

        if ($status_tahapan == null) {
            $status_tahapan = $detail_rencana->status_tahapan;
        } else {
            $detail_rencana->status_tahapan = $status_tahapan;
        }

        if ($jenis_pengerjaan == null) {
            $jenis_pengerjaan = $detail_rencana->jenis_pengerjaan;
        } else {
            $detail_rencana->jenis_pengerjaan = $jenis_pengerjaan;
        }

        if ($peran == null) {
            $peran = $detail_rencana->peran;
        } else {
            $detail_rencana->peran = $peran;
        }

        $bobot_pencapaian = 0;
        $bobot_peran = 0;
        $sks = 5;
        $sks_terhitung = 0;
        if ($status_tahapan != null) {
            switch ($status_tahapan){
                case "Pendahuluan":
                    $bobot_pencapaian = 0.25;
                    break;
                case "50% dari isi buku":
                    $bobot_pencapaian = 0.5;
                    break;
                case "Buku Jadi":
                    $bobot_pencapaian = 0.75;
                    break;
                case "Persetujuan Penerbit":
                    $bobot_pencapaian = 0.85;
                    break;
                case "Buku Selesai Dicetak":
                    $bobot_pencapaian = 1;
                    break;
                default:
                    $bobot_pencapaian = 0;
                    break;
            }

            if($peran == "Editor"){
                $bobot_peran = 0.6;
            }else if($peran == "Kontributor"){
                $bobot_peran = 0.4;
            }

            if($jenis_pengerjaan == "Mandiri"){
                $sks_terhitung = $bobot_pencapaian*$sks;
            }else if($jenis_pengerjaan == "Kelompok"){
                $sks_terhitung = $bobot_pencapaian*$bobot_peran*$sks;
            }

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

    public function deleteBukuInternasional($id)
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

    //END OF METHOD D. BUKU INTERNASIONAL //END OF METHOD D. BUKU INTERNASIONAL

    //BEGINNING OF METHOD E. MENYADUR //BEGINNING OF METHOD E. MENYADUR
    public function getMenyadur($id){
        $menyadur = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.status_tahapan',"detail_penelitian.posisi",'rencana.sks_terhitung', 'rencana.asesor1_frk', 'rencana.asesor2_frk', 'rencana.lampiran', 'rencana.flag_save_permananent')
            ->where('rencana.sub_rencana', 'menyadur')
            ->where('id_dosen', $id)
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
            case "persetujuan penerbit":
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

    //END OF METHOD E. MENYADUR //END OF METHOD E. MENYADUR

    //BEGINNING OF METHOD F. MENYUNTING //BEGINNING OF METHOD F. MENYUNTING
    public function getMenyunting($id){
        $menyunting = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.status_tahapan',"detail_penelitian.posisi",'rencana.sks_terhitung', 'rencana.asesor1_frk', 'rencana.asesor2_frk', 'rencana.lampiran', 'rencana.flag_save_permananent')
            ->where('rencana.sub_rencana', 'menyunting')
            ->where('id_dosen', $id)
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

    //END OF METHOD F. MENYUNTING //END OF METHOD F. MENYUNTING

    //BEGINNING OF METHOD G. PENELITIAN_MODUL //BEGINNING OF METHOD G. PENELITIAN_MODUL
    public function getPenelitianModul($id)
    {
        $penelitian_modul = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.status_tahapan', 'detail_penelitian.jenis_pengerjaan', 'detail_penelitian.peran', 'rencana.sks_terhitung', 'rencana.asesor1_frk', 'rencana.asesor2_frk', 'rencana.lampiran', 'rencana.flag_save_permananent')
            ->where('rencana.sub_rencana', 'penelitian_modul')
            ->where('id_dosen', $id)
            ->get();

        return response()->json($penelitian_modul, 200);
    }

    public function postPenelitianModul(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $status_tahapan = $request->get('status_tahapan');
        $jenis_pengerjaan = $request->get('jenis_pengerjaan');
        $peran = $request->get('peran');

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
        if ($jenis_pengerjaan == "Kelompok") {
            if ($peran == "Penulis Utama") {
                $sks = 0.6*1;
            } elseif ($peran == "Anggota") {
                $sks = 0.4*1;
            }
        } elseif ($jenis_pengerjaan == "Mandiri") {
            $sks = (1);
        }

        $sks_terhitung = $bobot_pencapaian*$sks;

        $rencana = Rencana::create([
            'jenis_rencana' => 'penelitian',
            'sub_rencana' => 'penelitian_modul',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => round($sks_terhitung, 2),
        ]);

        $detailPenelitian = DetailPenelitian::create([
            'id_rencana' => $rencana->id_rencana,
            'status_tahapan' => $status_tahapan,
            'jenis_pengerjaan' => $jenis_pengerjaan,
            'peran' => $peran
        ]);

        $res = [$rencana, $detailPenelitian];

        return response()->json($res, 201);
    }

    public function editPenelitianModul(Request $request)
    {
        $request->all();
        $id_rencana = $request->get('id_rencana');

        $rencana = Rencana::where('id_rencana', $id_rencana)->first();
        $detail_rencana = DetailPenelitian::where('id_rencana', $id_rencana)->first();
        $nama_kegiatan = $request->get('nama_kegiatan');
        $status_tahapan = $request->get('status_tahapan');
        $jenis_pengerjaan = $request->get('jenis_pengerjaan');
        $peran= $request->get('peran');

        if ($nama_kegiatan != null && $nama_kegiatan != "") {
            $rencana->nama_kegiatan = $nama_kegiatan;
        }

        if ($status_tahapan == null) {
            $status_tahapan = $detail_rencana->status_tahapan;
        } else {
            $detail_rencana->status_tahapan = $status_tahapan;
        }

        if ($jenis_pengerjaan == null) {
            $jenis_pengerjaan = $detail_rencana->jenis_pengerjaan;
        } else {
            $detail_rencana->jenis_pengerjaan = $jenis_pengerjaan;
        }

        if ($peran == null) {
            $peran = $detail_rencana->peran;
        } else {
            $detail_rencana->peran = $peran;
        }

        if ($status_tahapan != null || $jenis_pengerjaan != null || $peran != null) {
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

            $sks = 0;
            if ($jenis_pengerjaan == "Kelompok") {
                if ($peran == "Penulis Utama") {
                    $sks = 0.6*1;
                } elseif ($peran == "Anggota") {
                    $sks = 0.4*1;
                }
            } elseif ($jenis_pengerjaan == "Mandiri") {
                $sks = 1;
            }

            $sks_terhitung = $bobot_pencapaian * $sks;

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

    public function deletePenelitianModul($id)
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
    //END OF METHOD G. PENELITIAN MODUL //END OF METHOD G. PENELITIAN MODUL

    //BEGINNING OF METHOD H. PENELITIAN_PEKERTI //BEGINNING OF METHOD H. PENELITIAN_PEKERTI
    public function getPenelitianPekerti($id)
    {
        $penelitian_pekerti = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'rencana.sks_terhitung', 'rencana.asesor1_frk', 'rencana.asesor2_frk', 'rencana.lampiran', 'rencana.flag_save_permananent')
            ->where('rencana.sub_rencana', 'penelitian_pekerti')
            ->where('id_dosen', $id)
            ->get();

        return response()->json($penelitian_pekerti, 200);
    }

    public function postPenelitianPekerti(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');

        $sks = 2;

        $sks_terhitung = $sks;

        $rencana = Rencana::create([
            'jenis_rencana' => 'penelitian',
            'sub_rencana' => 'penelitian_pekerti',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => $sks_terhitung,
        ]);

        $detailPenelitian = DetailPenelitian::create([
            'id_rencana' => $rencana->id_rencana,
        ]);

        $res = [$rencana, $detailPenelitian];

        return response()->json($res, 201);
    }

    public function editPenelitianPekerti(Request $request)
    {
        $request->all();

        $id_rencana = $request->get('id_rencana');
        $rencana = Rencana::where('id_rencana', $id_rencana)->first();
        $nama_kegiatan = $request->get('nama_kegiatan');

        if ($nama_kegiatan != null && $nama_kegiatan != "") {
            $rencana->nama_kegiatan = $nama_kegiatan;

            $rencana->save();
        }

        $res = [
            "rencana" => $rencana,
            "message" => "Rencana updated successfully"
        ];

        return response()->json($res, 200);
    }

    public function deletePenelitianPekerti($id)
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
    //END OF METHOD H. PENELITIAN PEKERTI //END OF METHOD H. PENELITIAN PEKERTI

    //START OF METHOD I. PENELITIAN TRIDHARMA // START OF METHOD I. PENELITIAN TRIDHARMA
    public function getPenelitianTridharma($id)
    {
        $penelitian_tridharma = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'jumlah_bkd', 'rencana.sks_terhitung', 'rencana.asesor1_frk', 'rencana.asesor2_frk', 'rencana.lampiran', 'rencana.flag_save_permananent')
            ->where('rencana.sub_rencana', 'penelitian_tridharma')
            ->where('id_dosen', $id)
            ->get();

        return response()->json($penelitian_tridharma, 200);
    }

    public function postPenelitianTridharma(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jumlah_bkd = (int)$request->get('jumlah_bkd');

        $sks = 1;

        $sks_terhitung = ($jumlah_bkd/8)*$sks;

        $rencana = Rencana::create([
            'jenis_rencana' => 'penelitian',
            'sub_rencana' => 'penelitian_tridharma',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => round($sks_terhitung, 2),
        ]);

        $detailPenelitian = DetailPenelitian::create([
            'id_rencana' => $rencana->id_rencana,
            'jumlah_bkd' => $jumlah_bkd
        ]);

        $res = [$rencana, $detailPenelitian];

        return response()->json($res, 201);
    }

    public function editPenelitianTridharma(Request $request)
    {
        $request->all();
        $id_rencana = $request->get('id_rencana');

        $rencana = Rencana::where('id_rencana', $id_rencana)->first();
        $detail_rencana = DetailPenelitian::where('id_rencana', $id_rencana)->first();
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jumlah_bkd= (int)$request->get('jumlah_bkd');



        if ($nama_kegiatan != null && $nama_kegiatan != "") {
            $rencana->nama_kegiatan = $nama_kegiatan;
        }

        if ($jumlah_bkd == null) {
            $jumlah_bkd = $detail_rencana->jumlah_bkd;
        } else {
            $detail_rencana->jumlah_bkd = $jumlah_bkd;
        }

        $sks = 1;
        $sks_terhitung = ($jumlah_bkd/8)*$sks;

        $rencana->sks_terhitung = $sks_terhitung;

        $rencana->save();
        $detail_rencana->save();

        $res = [
            "rencana" => $rencana,
            "detail_rencana" => $detail_rencana,
            "message" => "Rencana updated successfully"
        ];


        return response()->json($res, 200);
    }

    public function deletePenelitianTridharma($id)
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

    //END OF METHOD I. PENELITIAN MANDIRI //END OF METHOD I. PENELITIAN MANDIRI

    //BEGINNING OF METHOD J. JURNAL ILMIAH //BEGINNING OF METHOD J. JURNAL ILMIAH
    public function getJurnalIlmiah($id){
        $jurnal_ilmiah = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
        ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.jenis_pengerjaan', 'detail_penelitian.lingkup_penerbit',
        'detail_penelitian.peran','rencana.sks_terhitung', 'rencana.asesor1_frk', 'rencana.asesor2_frk', 'rencana.lampiran', 'rencana.flag_save_permananent')
        ->where('rencana.sub_rencana', 'jurnal_ilmiah')
        ->where('id_dosen', $id)
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
        $sks_terhitung = 0;

        switch($lingkup_penerbit)
        {
            case 'Diterbitkan oleh Jurnal ilmiah/majalah ilmiah ber-ISSN tidak terakreditasi atau proceedings seminar nasional maupun internasional' :
                $sks_lingkup = 1;
                break;

            case 'Diterbitkan oleh Jurnal terakreditasi' :
                $sks_lingkup = 2;
                break;

            case 'Diterbitkan oleh Jurnal terakreditasi internasional (dalam bahasa intenasional)' :
                $sks_lingkup = 3;
                break;
            default;
        }

        switch($peran){
            case 'Penulis Utama':
                $bobot_peran = 0.6;
                break;
            case 'Penulis Lainnya':
                $bobot_peran = 0.4;
                break;
            default:
                $bobot_peran = 0;
                break;
        }

        if($jenis_pengerjaan == 'Mandiri'){
            $sks_terhitung = $sks_lingkup;
        }else if($jenis_pengerjaan == 'Kelompok'){
            $sks_terhitung = $sks_lingkup * $bobot_peran;
        }

        $rencana = Rencana::create([
            'jenis_rencana' => 'penelitian',
            'sub_rencana' => 'jurnal_ilmiah',
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
        $sks_terhitung = 0;

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
            $detail_rencana->peran = $peran;
        }

        switch($lingkup_penerbit)
        {
            case 'Diterbitkan oleh Jurnal ilmiah/majalah ilmiah ber-ISSN tidak terakreditasi atau proceedings seminar nasional maupun internasional' :
                $sks_lingkup = 1;
                break;

            case 'Diterbitkan oleh Jurnal terakreditasi' :
                $sks_lingkup = 2;
                break;

            case 'Diterbitkan oleh Jurnal terakreditasi internasional (dalam bahasa intenasional)' :
                $sks_lingkup = 3;
                break;
            default;
        }

        switch($peran){
            case 'Penulis Utama':
                $bobot_peran = 0.6;
                break;
            case 'Penulis Lainnya':
                $bobot_peran = 0.4;
                break;
            default:
                $bobot_peran = 0;
                break;
        }

        if($jenis_pengerjaan == 'Mandiri'){
            $sks_terhitung = $sks_lingkup;
        }else if($jenis_pengerjaan == 'Kelompok'){
            $sks_terhitung = $sks_lingkup * $bobot_peran;
        }

        $rencana->sks_terhitung = $sks_terhitung;
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
    //END OF METHOD J. JURNAL ILMIAH //END OF METHOD J. JURNAL ILMIAH

    //START OF METHOD K. HAK PATEN //START OF METHOD K. HAK PATEN
    public function getHakPaten($id)
    {
        $hak_paten = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.lingkup_wilayah', 'rencana.sks_terhitung', 'rencana.asesor1_frk', 'rencana.asesor2_frk', 'rencana.lampiran', 'rencana.flag_save_permananent')
            ->where('rencana.sub_rencana', 'hak_paten')
            ->where('id_dosen', $id)
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

    //END OF METHOD K. HAK PATEN //END OF METHOD K. HAK PATEN

    //BEGINNING OF METHOD L. MEDIA MASSA //BEGINNING OF METHOD L. MEDIA MASSA
    public function getMediaMassa($id)
    {
        $media_massa = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'rencana.sks_terhitung', 'rencana.asesor1_frk', 'rencana.asesor2_frk', 'rencana.lampiran', 'rencana.flag_save_permananent')
            ->where('rencana.sub_rencana', 'media_massa')
            ->where('id_dosen', $id)
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
    // END OF METHOD L. MEDIA MASSA // END OF METHOD L. MEDIA MASSA

    // BEGINNING OF METHOD M. PEMBICARA SEMINAR // BEGINNING OF METHOD M. PEMBICARA SEMINAR
    public function getPembicaraSeminar($id)
    {
        $pembicara_seminar = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
        ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.lingkup_wilayah', 'rencana.sks_terhitung', 'rencana.asesor1_frk', 'rencana.asesor2_frk', 'rencana.lampiran', 'rencana.flag_save_permananent')
        ->where('rencana.sub_rencana', 'pembicara_seminar')
        ->where('id_dosen', $id)
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
            case "Tingkat Regional/minimal fakultas":
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

    $rencana = Rencana::create([
    'jenis_rencana' => 'penelitian',
    'sub_rencana' => 'pembicara_seminar',
    'id_dosen' => $id_dosen,
    'nama_kegiatan' => $nama_kegiatan,
    'sks_terhitung' => round($sks_terhitung, 2),
    ]);

    $detailPenelitian = DetailPenelitian::create([
    'id_rencana' => $rencana->id_rencana,
    'lingkup_wilayah' => $tingkatan,
    ]);

    $res = [$rencana, $detailPenelitian];

    return response()->json($res, 201);
    }

    public function editPembicaraSeminar(Request $request)
    {
        $request->all();
        $id_rencana = $request->get('id_rencana');

        $rencana = Rencana::where('id_rencana', $id_rencana)->first();
        $detail_rencana = DetailPenelitian::where('id_rencana', $id_rencana)->first();

        // Mengambil data dari request
        $nama_kegiatan = $request->get('nama_kegiatan');
        $tingkatan = $request->get('tingkatan');

        // Memperbarui nama kegiatan jika diberikan
        if (!is_null($nama_kegiatan)) {
            $rencana->nama_kegiatan = $nama_kegiatan;
        }

        // Memperbarui tingkatan jika diberikan
        if (!is_null($tingkatan)) {
            $nilai = 0;
                switch ($tingkatan) {
                case "Tingkat Regional/minimal fakultas":
                    $nilai = 0.5;
                    break;
                case "Tingkat Nasional":
                    $nilai = 0.75;
                    break;
                case "Tingkat Internasional (dengan bahasa internasional)":
                    $nilai = 1;
                    break;
                default:
                    break;
            }
            $rencana->sks_terhitung = round($nilai, 2);
            $detail_rencana->lingkup_penerbit = $tingkatan;
        }

        // Menyimpan perubahan ke database
        $rencana->update();
        $detail_rencana->update();

        // Membuat respons
        $res = [
        "rencana" => $rencana,
        "detail_rencana" => $detail_rencana,
        "message" => "Rencana updated successfully"
        ];

        return response()->json($res, 200);
    }

    public function deletePembicaraSeminar($id)
    {
        // Langsung menghapus detail record terkait
        $detailDeleted = DetailPenelitian::where('id_rencana', $id)->delete();

        // Menghapus record utama
        $recordDeleted = Rencana::where('id_rencana', $id)->delete();

        if ($recordDeleted || $detailDeleted) {
        // Jika salah satu atau kedua penghapusan berhasil
        $response = ['message' => 'Delete kegiatan sukses'];
        return response()->json($response, 200); // Menggunakan kode status 200 OK
        } else {
            // Jika tidak ada record yang dihapus
            $response = ['message' => 'Delete kegiatan gagal, data tidak ditemukan'];
            return response()->json($response, 404); // Menggunakan kode status 404 Not Found
        }
    }
    //END OF METHOD M. PEMBICARA SEMINAR //END OF METHOD M. PEMBICARA SEMINAR

    //BEGINNING OF METHOD N. PENYAJIAN MAKALAH //BEGINNING OF METHOD N. PENYAJIAN MAKALAH
    public function getPenyajianMakalah($id)
    {
        $pembicara_seminar = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
        ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.jenis_pengerjaan', 'detail_penelitian.lingkup_wilayah', 'detail_penelitian.posisi', 'detail_penelitian.jumlah_anggota', 'rencana.sks_terhitung', 'rencana.asesor1_frk', 'rencana.asesor2_frk', 'rencana.lampiran', 'rencana.flag_save_permananent')
        ->where('rencana.sub_rencana', 'penyajian_makalah')
        ->where('id_dosen', $id)
        ->get();

        return response()->json($pembicara_seminar, 200);
    }

    public function postPenyajianMakalah(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $tingkatan = $request->get('tingkatan');
        $jumlah_anggota = $request->input('jumlah_anggota', 1);
        $posisi = $request->get('posisi');
        $jenis_pengerjaan = $request->get('jenis_pengerjaan');


        $nilai = 0;
        switch ($tingkatan){
            case "Tingkat regional daerah, institusional(minimum fakultas)":
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

        $sks = 0;
        if ($posisi == "Ketua") {
            $sks = $nilai * 0.6;
        } elseif ($posisi == "Anggota") {
            $sks = $nilai * 0.4 ;
        } else {
            return 0;
        }

        $sks_terhitung = $nilai*$sks;

        $rencana = Rencana::create([
        'jenis_rencana' => 'penelitian',
        'sub_rencana' => 'penyajian_makalah',
        'id_dosen' => $id_dosen,
        'nama_kegiatan' => $nama_kegiatan,
        'sks_terhitung' => round($sks_terhitung, 2),
        ]);

        $detailPenelitian = DetailPenelitian::create([
        'id_rencana' => $rencana->id_rencana,
        'lingkup_wilayah' => $tingkatan,
        'posisi' => $posisi,
        'jumlah_anggota' => $jumlah_anggota,
        'jenis_pengerjaan' => $jenis_pengerjaan,
        ]);

        $res = [$rencana, $detailPenelitian];

        return response()->json($res, 201);
    }

    public function editPenyajianMakalah(Request $request)
    {
        $request->all();
        $id_rencana = $request->get('id_rencana');

        $rencana = Rencana::where('id_rencana', $id_rencana)->first();
        $detail_rencana = DetailPenelitian::where('id_rencana', $id_rencana)->first();

        $nama_kegiatan = $request->get('nama_kegiatan');
        $tingkatan = $request->get('tingkatan');
        $jumlah_anggota = $request->input('jumlah_anggota', 1);
        $posisi = $request->get('posisi');
        $jenis_pengerjaan = $request->get('jenis_pengerjaan');

        if ($nama_kegiatan) {
            $rencana->nama_kegiatan = $nama_kegiatan;
        }

        $nilai = 0;
        switch ($tingkatan) {
            case "Tingkat regional daerah, institusional(minimum fakultas)":
                $nilai = 0.5;
            break;
            case "Tingkat Nasional":
                $nilai = 0.75;
            break;
            case "Tingkat Internasional(dengan bahasa internasional)":
                $nilai = 1;
            break;
        }

        $sks = 0;
        if ($posisi == "Ketua") {
            $sks = $nilai * 0.6;
        } elseif ($posisi == "Anggota") {
            $sks = $nilai * 0.4 ;
        } else {
            return 0;
        }

        $sks_terhitung = $nilai*$sks;


        $rencana->sks_terhitung = round($sks_terhitung, 2);
        $rencana->update();
        $detail_rencana->posisi = $posisi;
        $detail_rencana->jumlah_anggota = $jumlah_anggota;
        $detail_rencana->status_tahapan = $tingkatan;
        $detail_rencana->jenis_pengerjaan = $jenis_pengerjaan;
        $detail_rencana->update();

        // Membuat respons
        $res = [
        "rencana" => $rencana,
        "detail_rencana" => $detail_rencana,
        "message" => "Rencana updated successfully"
        ];

        return response()->json($res, 200);
    }

    public function deletePenyajianMakalah($id)
    {
        // Coba menghapus detail record terkait terlebih dahulu
        $detailDeleted = DetailPenelitian::where('id_rencana', $id)->delete();

        // Kemudian, coba menghapus record utama
        $recordDeleted = Rencana::where('id_rencana', $id)->delete();

        // Mengecek apakah penghapusan berhasil
        // Logika ini mengasumsikan bahwa penghapusan berhasil jika salah satu operasi delete mengembalikan nilai > 0
        if ($detailDeleted > 0 || $recordDeleted > 0) {

        // Jika penghapusan berhasil (salah satu atau kedua operasi delete menghapus record)
        $response = ['message' => 'Kegiatan berhasil dihapus'];
        return response()->json($response, 200); // Menggunakan kode status 200 OK
        } else {
            // Jika tidak ada record yang dihapus (kedua operasi delete mengembalikan 0)
            $response = ['message' => 'Kegiatan gagal dihapus, data tidak ditemukan'];
            return response()->json($response, 404); // Menggunakan kode status 404 Not Found
        }
    }

    // END OF METHOD N. PENYAJIAN MAKALAH

}
