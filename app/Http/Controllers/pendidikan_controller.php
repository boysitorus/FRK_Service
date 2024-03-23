<?php

namespace App\Http\Controllers;

use App\Models\DetailPendidikan;
use App\Models\Rencana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class pendidikan_controller extends Controller
{

    public function getAll()
    {
        // Ambil semua data teori dari tabel Rencana
        $teori = Rencana::join('detail_pendidikan', 'rencana.id_rencana', '=', 'detail_pendidikan.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pendidikan.jumlah_kelas', 'detail_pendidikan.jumlah_evaluasi', 'detail_pendidikan.sks_matakuliah', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'teori')
            ->get();

        // Ambil semua data bimbingan dari tabel Rencana
        $bimbingan = Rencana::join('detail_pendidikan', 'rencana.id_rencana', '=', 'detail_pendidikan.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pendidikan.jumlah_mahasiswa', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'bimbingan')
            ->get();

        $rendah = Rencana::join('detail_pendidikan', 'rencana.id_rencana', '=', 'detail_pendidikan.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pendidikan.jumlah_dosen', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'bimbing_rendah')
            ->get();

        $kembang = Rencana::join('detail_pendidikan', 'rencana.id_rencana', '=', 'detail_pendidikan.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pendidikan.jumlah_sap', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'bimbing_rendah')
            ->get();


        // Kembalikan data dalam bentuk yang sesuai untuk ditampilkan di halaman
        return response()->json([
            'teori' => $teori,
            'bimbingan' => $bimbingan,
            'rendah' => $rendah,
            'kembang' => $kembang
        ], 200);
    }

    // METHOD TEORI
    public function getTeori()
    {

        $teori = Rencana::join('detail_pendidikan', 'rencana.id_rencana', '=', 'detail_pendidikan.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pendidikan.jumlah_kelas', 'detail_pendidikan.jumlah_evaluasi', 'detail_pendidikan.sks_matakuliah', 'rencana.sks_terhitung')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pendidikan.jumlah_kelas', 'detail_pendidikan.jumlah_evaluasi', 'detail_pendidikan.sks_matakuliah', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'teori')
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
            'id_rencana' => $rencana->id_rencana,
            'sks_matakuliah' => $sks_matakuliah,
            'jumlah_evaluasi' => $jumlah_evaluasi,
            'jumlah_kelas' => $jumlah_kelas
        ]);

        $res = [$rencana, $detailPendidikan];

        return response()->json($res, 201);
    }

    public function editTeori(Request $request ){
        $request->all();
        $id_rencana = $request->get('id_rencana');

        $rencana = Rencana::where('id_rencana', $id_rencana)->first();
        $detail_rencana = DetailPendidikan::where('id_rencana', $id_rencana)->first();
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jumlah_kelas = (int)$request->get('jumlah_kelas');
        $jumlah_evaluasi = (int)$request->get('jumlah_evaluasi');
        $sks_matakuliah = (int)$request->get('sks_matakuliah');
        

        if($nama_kegiatan != null && $nama_kegiatan != ""){
            $rencana->nama_kegiatan = $nama_kegiatan;
        }
        
        if($jumlah_kelas == null){
            $jumlah_kelas = $detail_rencana->jumlah_kelas;
        } else {
            $detail_rencana->jumlah_kelas = $jumlah_kelas;
        }

        if($jumlah_evaluasi == null){
            $jumlah_evaluasi = $detail_rencana->jumlah_evaluasi;
        }else {
            $detail_rencana->jumlah_evaluasi = $jumlah_evaluasi;
        }

        if($sks_matakuliah == null){
            $sks_matakuliah = $detail_rencana->sks_matakuliah;
        }else {
            $detail_rencana->sks_matakuliah = $sks_matakuliah;
        }

        if($jumlah_kelas != null || $jumlah_evaluasi != null || $sks_matakuliah != null){
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

    // METHOD BIMBINGAN

    public function getBimbingan()
    {
        $bimbingan = Rencana::join('detail_pendidikan', 'rencana.id_rencana', "=", 'detail_pendidikan.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pendidikan.jumlah_mahasiswa', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'bimbingan')
            ->get();

        return response()->json($bimbingan, 200);
    }

    public function postBimbingan(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jumlah_mahasiswa = (int)$request->get('jumlah_mahasiswa');
        
        $sks_terhitung = $jumlah_mahasiswa / 25;

        $rencana = Rencana::create([
            'jenis_rencana' => 'pendidikan',
            'sub_rencana' => 'bimbingan',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => round($sks_terhitung, 2),
        ]);

        $detailPendidikan = DetailPendidikan::create([
            'id_rencana' => $rencana->id,
            'jumlah_mahasiswa' => $jumlah_mahasiswa
        ]);

        $res =[$rencana, $detailPendidikan];

        return response()->json($res, 201);
    }

    public function deleteBimbingan($id)
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

    // METHOD SEMINAR

    public function getSeminar()
    {
        $seminar = Rencana::join('detail_pendidikan', 'rencana.id_rencana', "=", 'detail_pendidikan.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pendidikan.jumlah_kelompok', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'seminar')
            ->get();

        return response()->json($seminar, 200);
    }

    public function postSeminar(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jumlah_kelompok = (int)$request->get('jumlah_kelompok');

        $sks_terhitung = (4 * $jumlah_kelompok)/42;

        $rencana = Rencana::create([
            'jenis_rencana' => 'pendidikan',
            'sub_rencana' => 'seminar',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => round($sks_terhitung, 2),
        ]);

        $detailPendidikan = DetailPendidikan::create([
            'id_rencana' => $rencana->id,
            'jumlah_kelompok' => $jumlah_kelompok
        ]);

        $res = [$rencana, $detailPendidikan];

        return response()->json($res, 201);
    }

    public function deleteSeminar($id)
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
    
    // G. MEMBIMBING DOSEN YANG LEBIH RENDAH

    public function getRendah()
    {

        $rendah = Rencana::join('detail_pendidikan', 'rencana.id_rencana', '=', 'detail_pendidikan.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pendidikan.jumlah_dosen', 'rencana.sks_terhitung')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pendidikan.jumlah_dosen', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'bimbing_rendah')
            ->get();

        return response()->json($rendah, 200);
    }

    public function postRendah(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jumlah_dosen = (int)$request->get('jumlah_dosen');

        $sks_terhitung = $jumlah_dosen;

        $rencana = Rencana::create([
            'jenis_rencana' => 'pendidikan',
            'sub_rencana' => 'bimbing_rendah',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => $sks_terhitung,
        ]);

        $detailPendidikan = DetailPendidikan::create([
            'id_rencana' => $rencana->id,
            'jumlah_dosen' => $jumlah_dosen,
        ]);

        $res = [$rencana, $detailPendidikan];

        return response()->json($res, 201);
    }

    public function deleteRendah($id)
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

    // H. MENGEMBANGKAN PROGRAM PERKULIAHAN

    public function getKembang()
    {

        $kembang = Rencana::join('detail_pendidikan', 'rencana.id_rencana', '=', 'detail_pendidikan.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pendidikan.jumlah_sap', 'rencana.sks_terhitung')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pendidikan.jumlah_sap', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'pengembangan')
            ->get();

        return response()->json($kembang, 200);
    }

    public function postKembang(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jumlah_sap = (int)$request->get('jumlah_sap');

        $sks_terhitung = $jumlah_sap;

        $rencana = Rencana::create([
            'jenis_rencana' => 'pendidikan',
            'sub_rencana' => 'pengembangan',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => $sks_terhitung,
        ]);

        $detailPendidikan = DetailPendidikan::create([
            'id_rencana' => $rencana->id,
            'jumlah_dosen' => $jumlah_sap,
        ]);

        $res = [$rencana, $detailPendidikan];

        return response()->json($res, 201);
    }

    public function deleteKembang($id)
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
