<?php

namespace App\Http\Controllers;

use App\Models\DetailPendidikan;
use App\Models\Rencana;
use Illuminate\Http\Request;

class pendidikan_controller extends Controller
{
    public function getTeori()
    {

        $teori = Rencana::join('detail_pendidikan', 'rencana.id_rencana', '=', 'detail_pendidikan.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pendidikan.jumlah_kelas', 'detail_pendidikan.jumlah_evaluasi', 'detail_pendidikan.sks_matakuliah', 'rencana.sks_terhitung')
            ->get();

        return response()->json($teori, 200);
    }

    public function postTeori(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jumlah_kelas = (int)$request->get('jumlah_kelas');
        $jumlah_evaluasi = (int)$request->get('jumlah_evaluasi');
        $sks_matakuliah = (int)$request->get('sks_matakuliah');

        $jam_persiapan = $sks_matakuliah;
        $jam_tatap_muka = $sks_matakuliah * $jumlah_kelas;

        $sks_terhitung = round($jam_persiapan + $jam_tatap_muka + $jumlah_evaluasi) / 3;

        $rencana = Rencana::create([
            'jenis_rencana' => 'pendidikan',
            'sub_rencana' => 'teori',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => round($sks_terhitung, 2),
        ]);

        $detailPendidikan = DetailPendidikan::create([
            'id_rencana' => $rencana->id,
            'sks_matakuliah' => $sks_matakuliah,
            'jumlah_evaluasi' => $jumlah_evaluasi,
            'jumlah_kelas' => $jumlah_kelas
        ]);

        $res = [$rencana, $detailPendidikan];

        return response()->json($res, 201);
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
}
