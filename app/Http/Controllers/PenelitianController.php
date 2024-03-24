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
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.tahap_pencapaian', 'detail_pendidikan.posisi', 'detail_pendidikan.jumlah_anggota', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'penelitian_kelompok')
            ->get();

        // Tabel B
        $penelitian_mandiri = Rencana::join('detail_pendidikan', 'rencana.id_rencana', '=', 'detail_pendidikan.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.tahap_pencapaian', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'penelitian_mandiri')
            ->get();

        // Tabel C
        $rendah = Rencana::join('detail_pendidikan', 'rencana.id_rencana', '=', 'detail_pendidikan.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pendidikan.jumlah_dosen', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'bimbing_rendah')
            ->get();

        // Tabel D


        // Tabel E


        // Tabel F


        // Tabel G


        // Tabel H


        // BAGIAN I


        // BAGIAN J
        

        // BAGIAN K
        

        // Kembalikan data dalam bentuk yang sesuai untuk ditampilkan di halaman
        return response()->json([
            'penelitian_kelompok' => $penelitian_kelompok,
            'penelitian_mandiri' => $penelitian_mandiri,
        ], 200);
    }

    // START OF METHOD PENELITIAN_KELOMPOK
    public function getPenelitianKelompok()
    {
        $penelitian_kelompok = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penelitian.tahap_pencapaian', 'detail_pendidikan.posisi', 'detail_pendidikan.jumlah_anggota', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'penelitian_kelompok')
            ->get();

        return response()->json($penelitian_kelompok, 200);
    }

    public function postPenelitianKelompok(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $tahap_pencapaian = $request->get('tahap_pencapaian');
        $posisi = $request->get('posisi');
        $jumlah_anggota = (int)$request->get('jumlah_anggota');

        $bobot_pencapaian = 1
        $sks_terhitung = round(($bobot_pencapaian + $jam_tatap_muka + $jumlah_evaluasi) / 3, 2);

        $rencana = Rencana::create([
            'jenis_rencana' => 'pendidikan',
            'sub_rencana' => 'teori',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => round($sks_terhitung, 2),
        ]);

        $detailPendidikan = DetailPendidikan::create([
            'id_rencana' => $rencana->id_rencana,
            'sks_matakuliah' => $sks_matakuliah,
            'jumlah_evaluasi' => $jumlah_evaluasi,
            'jumlah_kelas' => $jumlah_kelas
        ]);

        $res = [$rencana, $detailPendidikan];

        return response()->json($res, 201);
    }

    public function editTeori(Request $request)
    {
        $request->all();
        $id_rencana = $request->get('id_rencana');

        $rencana = Rencana::where('id_rencana', $id_rencana)->first();
        $detail_rencana = DetailPendidikan::where('id_rencana', $id_rencana)->first();
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jumlah_kelas = (int)$request->get('jumlah_kelas');
        $jumlah_evaluasi = (int)$request->get('jumlah_evaluasi');
        $sks_matakuliah = (int)$request->get('sks_matakuliah');



        if ($nama_kegiatan != null && $nama_kegiatan != "") {
            $rencana->nama_kegiatan = $nama_kegiatan;
        }

        if ($jumlah_kelas == null) {
            $jumlah_kelas = $detail_rencana->jumlah_kelas;
        } else {
            $detail_rencana->jumlah_kelas = $jumlah_kelas;
        }

        if ($jumlah_evaluasi == null) {
            $jumlah_evaluasi = $detail_rencana->jumlah_evaluasi;
        } else {
            $detail_rencana->jumlah_evaluasi = $jumlah_evaluasi;
        }

        if ($sks_matakuliah == null) {
            $sks_matakuliah = $detail_rencana->sks_matakuliah;
        } else {
            $detail_rencana->sks_matakuliah = $sks_matakuliah;
        }

        if ($jumlah_kelas != null || $jumlah_evaluasi != null || $sks_matakuliah != null) {
            $jam_persiapan = $sks_matakuliah;
            $jam_tatap_muka = $sks_matakuliah * $jumlah_kelas;

            $sks_terhitung = round($jam_persiapan + $jam_tatap_muka + $jumlah_evaluasi) / 3;

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

    public function deleteTeori($id)
    {
        $record = Rencana::where('id_rencana', $id);
        $detail_record = DetailPendidikan::where('id_rencana', $id);

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

}
