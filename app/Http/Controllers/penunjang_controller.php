<?php

namespace App\Http\Controllers;

use App\Models\DetailPenunjang;
use App\Models\Rencana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class penunjang_controller extends Controller
{

    public function getAll()
    {
        // BAGIAN C
        $ukm = Rencana::join('detail_penunjang', 'rencana.id_rencana', "=", "detail_penunjang.id_rencana")
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penunjang.jumlah_kegiatan', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'ukm')
            ->get();

        // BAGIAN D
        $sosial = Rencana::join('detail_penunjang', 'rencana.id_rencana', "=", "detail_penunjang.id_rencana")
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'sosial')
            ->get();

        // BAGIAN E
        $struktural = Rencana::join('detail_penunjang', 'rencana.id_rencana', "=", "detail_penunjang.id_rencana")
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'rencana.sks_terhitung', 'detail_penunjang.jenis_jabatan_struktural')
            ->where('rencana.sub_rencana', 'struktural')
            ->get();

        // BAGIAN F
        $nonstruktural = Rencana::join('detail_penunjang', 'rencana.id_rencana', "=", "detail_penunjang.id_rencana")
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'rencana.sks_terhitung', 'detail_penunjang.jenis_jabatan_nonstruktural')
            ->where('rencana.sub_rencana', 'nonstruktural')
            ->get();

        // BAGIAN G
        $redaksi = Rencana::join('detail_penunjang', 'rencana.id_rencana', "=", "detail_penunjang.id_rencana")
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'rencana.sks_terhitung', 'detail_penunjang.jabatan')
            ->where('rencana.sub_rencana', 'redaksi')
            ->get();

        // BAGIAN H
        $adhoc = Rencana::join('detail_penunjang', 'rencana.id_rencana', "=", "detail_penunjang.id_rencana")
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'rencana.sks_terhitung', 'detail_penunjang.jabatan')
            ->where('rencana.sub_rencana', 'adhoc')
            ->get();


        // Kembalikan data dalam bentuk yang sesuai untuk ditampilkan di halaman
        return response()->json([
            'ukm' => $ukm,
            'sosial' => $sosial,
            'struktural' => $struktural,
            'nonstruktural' => $nonstruktural,
            'redaksi' => $redaksi,
            'adhoc' => $adhoc,
        ], 200);
    }


    //Handler A. Bimbingan Akademik
    public function getAkademik()
    {
        $akademik = Rencana::join('detail_penunjang', 'rencana.id_rencana', '=', 'detail_penunjang.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'rencana.sks_terhitung', 'detail_penunjang.jumlah_mahasiswa')
            ->where('rencana.sub_rencana', 'akademik')
            ->get();

        return response()->json($akademik, 200);
    }
    public function postAkademik(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jumlah_mahasiswa = (int)$request->get('jumlah_mahasiswa');
        $sks_terhitung = 0;

        if ($jumlah_mahasiswa >= 25) {
            $sks_terhitung = 2;
        } else {
            $sks_terhitung = round($jumlah_mahasiswa / 12, 2);
        }

        $rencana = Rencana::create([
            'jenis_rencana' => 'penunjang',
            'sub_rencana' => 'akademik',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => $sks_terhitung,
        ]);

        $detailPenunjang = DetailPenunjang::create([
            'id_rencana' => $rencana->id_rencana,
            'jumlah_mahasiswa' => $jumlah_mahasiswa
        ]);

        $res = [$rencana, $detailPenunjang];

        return response()->json($res, 201);
    }
    public function editAkademik(Request $request)
    {
        $id_rencana = $request->get('id_rencana');

        $rencana = Rencana::where('id_rencana', $id_rencana)->first();
        $detail_penunjang = DetailPenunjang::where('id_rencana', $id_rencana)->first();

        $nama_kegiatan = $request->get('nama_kegiatan');
        $jumlah_mahasiswa = (int)$request->get('jumlah_mahasiswa');

        if ($nama_kegiatan != null && $nama_kegiatan != "") {
            $rencana->nama_kegiatan = $nama_kegiatan;
        }

        if ($jumlah_mahasiswa != null) {
            $detail_penunjang->jumlah_mahasiswa = $jumlah_mahasiswa;

            if ($jumlah_mahasiswa >= 25) {
                $rencana->sks_terhitung = 2;
            } else {
                $rencana->sks_terhitung = round($jumlah_mahasiswa / 12, 2);
            }
        }

        $rencana->save();
        $detail_penunjang->save();

        $res = [
            "rencana" => $rencana,
            "detail_penunjang" => $detail_penunjang,
            "message" => "Rencana updated successfully"
        ];

        return response()->json($res, 200);
    }
    public function deleteAkademik($id)
    {
        $record = Rencana::where('id_rencana', $id);
        $detail_record = DetailPenunjang::where('id_rencana', $id);

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


    //Handler B. Bimbingan dan Konseling
    public function getBimbingan()
    {
        $bimbingan = Rencana::join('detail_penunjang', 'rencana.id_rencana', '=', 'detail_penunjang.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'rencana.sks_terhitung', 'detail_penunjang.jumlah_mahasiswa')
            ->where('rencana.sub_rencana', 'bimbingan')
            ->get();

        return response()->json($bimbingan, 200);
    }
    public function postBimbingan(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jumlah_mahasiswa = (int)$request->get('jumlah_mahasiswa');
        $sks_terhitung = 0;

        if ($jumlah_mahasiswa >= 25) {
            $sks_terhitung = 2;
        } else {
            $sks_terhitung = round($jumlah_mahasiswa / 12, 2);
        }

        $rencana = Rencana::create([
            'jenis_rencana' => 'penunjang',
            'sub_rencana' => 'bimbingan',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => $sks_terhitung,
        ]);

        $detailPenunjang = DetailPenunjang::create([
            'id_rencana' => $rencana->id_rencana,
            'jumlah_mahasiswa' => $jumlah_mahasiswa
        ]);

        $res = [$rencana, $detailPenunjang];

        return response()->json($res, 201);
    }
    public function editBimbingan(Request $request)
    {
        $id_rencana = $request->get('id_rencana');

        $rencana = Rencana::where('id_rencana', $id_rencana)->first();
        $detail_penunjang = DetailPenunjang::where('id_rencana', $id_rencana)->first();

        $nama_kegiatan = $request->get('nama_kegiatan');
        $jumlah_mahasiswa = (int)$request->get('jumlah_mahasiswa');

        if ($nama_kegiatan != null || $nama_kegiatan != "") {
            $rencana->nama_kegiatan = $nama_kegiatan;
        }

        if ($jumlah_mahasiswa != null) {
            $detail_penunjang->jumlah_mahasiswa = $jumlah_mahasiswa;

            if ($jumlah_mahasiswa >= 25) {
                $rencana->sks_terhitung = 2;
            } else {
                $rencana->sks_terhitung = round($jumlah_mahasiswa / 12, 2);
            }
        }

        $rencana->save();
        $detail_penunjang->save();

        $res = [
            "rencana" => $rencana,
            "detail_penunjang" => $detail_penunjang,
            "message" => "Rencana updated successfully"
        ];

        return response()->json($res, 200);
    }
    public function deleteBimbingan($id)
    {
        $record = Rencana::where('id_rencana', $id);
        $detail_record = DetailPenunjang::where('id_rencana', $id);

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

    //Handler C. Pimpinan Pembinaan UKM
    public function getUkm()
    {
        $ukm = Rencana::join('detail_penunjang', 'rencana.id_rencana', "=", "detail_penunjang.id_rencana")
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penunjang.jumlah_kegiatan', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'ukm')
            ->get();

        return response()->json($ukm, 200);
    }

    public function postUkm(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jumlah_kegiatan = (int) $request->get('jumlah_kegiatan');

        $sks_terhitung = $jumlah_kegiatan;

        $rencana = Rencana::create([
            'jenis_rencana' => 'penunjang',
            'sub_rencana' => 'ukm',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => round($sks_terhitung, 2),
        ]);

        $detailPenunjang = DetailPenunjang::create([
            'id_rencana' => $rencana->id_rencana,
            'jumlah_kegiatan' => $jumlah_kegiatan,
        ]);

        $res = [$rencana, $detailPenunjang];

        return response()->json($res, 201);
    }

    public function editUkm(Request $request)
    {
        $request->all();
        $id_rencana = $request->get('id_rencana');

        $rencana = Rencana::where('id_rencana', $id_rencana)->first();
        $detail_rencana = DetailPenunjang::where('id_rencana', $id_rencana)->first();
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jumlah_kegiatan = (int)$request->get('jumlah_kegiatan');

        if ($nama_kegiatan != null && $nama_kegiatan != "") {
            $rencana->nama_kegiatan = $nama_kegiatan;
        }

        if ($jumlah_kegiatan == null) {
            $jumlah_kegiatan = $detail_rencana->jumlah_kegiatan;
        } else {
            $detail_rencana->jumlah_kegiatan = $jumlah_kegiatan;
        }

        if ($jumlah_kegiatan != null) {
            $sks_terhitung = $jumlah_kegiatan;

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
    public function deleteUkm($id)
    {
        $record = Rencana::where('id_rencana', $id);
        $detail_record = DetailPenunjang::where('id_rencana', $id);

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

    //Handler D. Pimpinan organisasi sosial intern
    public function getSosial()
    {
        $sosial = Rencana::join('detail_penunjang', 'rencana.id_rencana', "=", "detail_penunjang.id_rencana")
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'sosial')
            ->get();

        return response()->json($sosial, 200);
    }

    public function postSosial(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $sks_terhitung = 1;

        $rencana = Rencana::create([
            'jenis_rencana' => 'penunjang',
            'sub_rencana' => 'sosial',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => round($sks_terhitung, 2),
        ]);

        $detailPenunjang = DetailPenunjang::create([
            'id_rencana' => $rencana->id_rencana,
        ]);

        $res = [$rencana, $detailPenunjang];

        return response()->json($res, 201);
    }

    public function editSosial(Request $request)
    {
        $request->all();
        $id_rencana = $request->get('id_rencana');

        $rencana = Rencana::where('id_rencana', $id_rencana)->first();
        $detail_rencana = DetailPenunjang::where('id_rencana', $id_rencana)->first();
        $nama_kegiatan = $request->get('nama_kegiatan');

        if ($nama_kegiatan != null && $nama_kegiatan != "") {
            $rencana->nama_kegiatan = $nama_kegiatan;
        }

        $rencana->save();
        $detail_rencana->save();

        $res = [
            "rencana" => $rencana,
            'detail_rencana' => $detail_rencana,
            "message" => "Rencana updated successfully",
        ];

        return response()->json($res, 200);
    }

    public function deleteSosial($id)
    {
        $record = Rencana::where('id_rencana', $id);
        $detail_record = DetailPenunjang::where('id_rencana', $id);

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

    //Handler E. Jabatan Struktural
    public function getStruktural()
    {
        $struktural = Rencana::join('detail_penunjang', 'rencana.id_rencana', "=", "detail_penunjang.id_rencana")
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'rencana.sks_terhitung', 'detail_penunjang.jenis_jabatan_struktural')
            ->where('rencana.sub_rencana', 'struktural')
            ->get();

        return response()->json($struktural, 200);
    }

    public function postStruktural(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jabatan = $request->get('jenis_jabatan_struktural');

        $bobot = 0;

        switch ($jabatan) {
            case 'Rektor':
                $bobot = 12;
                break;
            case 'Wakil Rektor':
                $bobot = 8;
                break;
            case 'Dekan':
                $bobot = 6;
                break;
            case 'Wakil Dekan':
                $bobot = 2;
                break;
            case 'SPM':
                $bobot = 4;
                break;
            case 'SPI':
                $bobot = 4;
                break;
            case 'Kaprodi':
                $bobot = 4;
                break;
            case 'Sekretaris Kaprodi':
                $bobot = 2;
                break;
            case 'Direktur':
                $bobot = 5;
                break;
            case 'Ka Biro atau Ka Lembaga':
                $bobot = 4;
                break;
            case 'Waka Biro/ Waka Lembaga':
                $bobot = 3;
                break;
            case 'Ka. UPT Teknologi Informasi':
                $bobot = 4;
                break;
            case 'Ka. UPT Perpustakaan':
                $bobot = 2;
                break;
            case 'Ka. UPT Bahasa':
                $bobot = 1;
                break;
            case 'Ka UPT SAM':
                $bobot = 1;
                break;
            case 'Ka Pusat Karir':
                $bobot = 2;
                break;
            case 'Koordinator Divisi di bawah WR3':
                $bobot = 2;
                break;
            case 'Wakil Kepala Unit/Koordinator':
                $bobot = 2;
                break;
            default:
                $bobot = 0;
                break;
        }

        $sks_terhitung = $bobot * 1;

        $rencana = Rencana::create([
            'jenis_rencana' => 'penunjang',
            'sub_rencana' => 'struktural',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => round($sks_terhitung, 2),
        ]);

        // Membuat entri baru menggunakan metode create pada model DetailPenunjang
        $detailPenunjang = DetailPenunjang::create([
            'id_rencana' => $rencana->id_rencana,
            'jenis_jabatan_struktural' => $jabatan,
        ]);

        $res = [$rencana, $detailPenunjang];

        return response()->json($res, 201);
    }

    public function editStruktural(Request $request)
    {
        $request->all();
        $id_rencana = $request->get('id_rencana');

        $rencana = Rencana::where('id_rencana', $id_rencana)->first();
        $detail_rencana = DetailPenunjang::where('id_rencana', $id_rencana)->first();
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jabatan = $request->get('jenis_jabatan_struktural');

        if ($nama_kegiatan != null && $nama_kegiatan != "") {
            $rencana->nama_kegiatan = $nama_kegiatan;
        }

        if ($jabatan == null) {
            $jabatan = $detail_rencana->jenis_jabatan_struktural;
        } else {
            $detail_rencana->jenis_jabatan_struktural = $jabatan;
        }

        if ($jabatan != null) {
            switch ($jabatan) {
                case 'Rektor':
                    $bobot = 12;
                    break;
                case 'Wakil Rektor':
                    $bobot = 8;
                    break;
                case 'Dekan':
                    $bobot = 6;
                    break;
                case 'Wakil Dekan':
                    $bobot = 2;
                    break;
                case 'SPM':
                    $bobot = 4;
                    break;
                case 'SPI':
                    $bobot = 4;
                    break;
                case 'Kaprodi':
                    $bobot = 4;
                    break;
                case 'Sekretaris Kaprodi':
                    $bobot = 2;
                    break;
                case 'Direktur':
                    $bobot = 5;
                    break;
                case 'Ka Biro atau Ka Lembaga':
                    $bobot = 4;
                    break;
                case 'Waka Biro/ Waka Lembaga':
                    $bobot = 3;
                    break;
                case 'Ka. UPT Teknologi Informasi':
                    $bobot = 4;
                    break;
                case 'Ka. UPT Perpustakaan':
                    $bobot = 2;
                    break;
                case 'Ka. UPT Bahasa':
                    $bobot = 1;
                    break;
                case 'Ka UPT SAM':
                    $bobot = 1;
                    break;
                case 'Ka Pusat Karir':
                    $bobot = 2;
                    break;
                case 'Koordinator Divisi di bawah WR3':
                    $bobot = 2;
                    break;
                case 'Wakil Kepala Unit/Koordinator':
                    $bobot = 2;
                    break;
                default:
                    $bobot = 0;
                    break;
            }
            $rencana->sks_terhitung = $bobot;
        }

        $rencana->save();
        $detail_rencana->save();

        $res = [
            "rencana" => $rencana,
            "detail_rencana" => $detail_rencana,
        ];

        return response()->json($res, 200);
    }

    public function deleteStruktural($id)
    {
        $record = Rencana::where('id_rencana', $id);
        $detail_record = DetailPenunjang::where('id_rencana', $id);

        if ($record && $detail_record) {
            $detail_record->delete();
            $record->delete();
            $response = [
                'message' => 'delete kegiatan sukses'
            ];

            return response()->json($response, 201);
        } else {
            $response = [
                'message' => 'Delete kegiatan gagal'
            ];
            return response()->json($response, 300);
        }
    }


    //Handler F. Jabatan non struktural
    public function getNonstruktural()
    {
        $nonstruktural = Rencana::join('detail_penunjang', 'rencana.id_rencana', "=", "detail_penunjang.id_rencana")
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'rencana.sks_terhitung', 'detail_penunjang.jenis_jabatan_nonstruktural')
            ->where('rencana.sub_rencana', 'nonstruktural')
            ->get();

        return response()->json($nonstruktural, 200);
    }

    public function postNonstruktural(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jabatan = $request->get('jenis_jabatan_nonstruktural');

        $bobot = 0;

        switch ($jabatan) {
            case 'Ketua Senat Akademik Institut':
                $bobot = 2;
                break;
            case 'Sekretaris Senat Akademik Institut':
                $bobot = 1;
                break;
            case 'Anggota Senat Akademik Institut':
                $bobot = 0.5;
                break;
            case 'Ketua Senat Fakultas':
                $bobot = 1;
                break;
            case 'Sekretaris Senat Fakultas':
                $bobot = 0.5;
                break;
            case 'Anggota Senat Fakultas':
                $bobot = 0.25;
                break;
            case 'Ka GBK':
                $bobot = 1;
                break;
            case 'Ka GJM /GKM':
                $bobot = 1;
                break;
            case 'Anggota GJM /GKM':
                $bobot = 0.5;
                break;
        }

        $sks_terhitung = $bobot * 1;

        $rencana = Rencana::create([
            'jenis_rencana' => 'penunjang',
            'sub_rencana' => 'nonstruktural',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => round($sks_terhitung, 2),
        ]);

        $detailPenunjang = DetailPenunjang::create([
            'id_rencana' => $rencana->id_rencana,
            'jenis_jabatan_nonstruktural' => $jabatan,
        ]);

        $res = [$rencana, $detailPenunjang];

        return response()->json($res, 201);
    }

    public function editNonstruktural(Request $request)
    {
        $request->all();
        $id_rencana = $request->get('id_rencana');

        $rencana = Rencana::where('id_rencana', $id_rencana)->first();
        $detail_rencana = DetailPenunjang::where('id_rencana', $id_rencana)->first();
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jabatan = $request->get('jenis_jabatan_nonstruktural');

        if ($nama_kegiatan != null && $nama_kegiatan != "") {
            $rencana->nama_kegiatan = $nama_kegiatan;
        }

        if ($jabatan == null) {
            $jabatan = $detail_rencana->jenis_jabatan_nonstruktural;
        } else {
            $detail_rencana->jenis_jabatan_nonstruktural = $jabatan;
        }

        if ($jabatan != null) {
            switch ($jabatan) {
                case 'Ketua Senat Akademik Institut':
                    $bobot = 2;
                    break;
                case 'Sekretaris Senat Akademik Institut':
                    $bobot = 1;
                    break;
                case 'Anggota Senat Akademik Institut':
                    $bobot = 0.5;
                    break;
                case 'Ketua Senat Fakultas':
                    $bobot = 1;
                    break;
                case 'Sekretaris Senat Fakultas':
                    $bobot = 0.5;
                    break;
                case 'Anggota Senat Fakultas':
                    $bobot = 0.25;
                    break;
                case 'Ka GBK':
                    $bobot = 1;
                    break;
                case 'Ka GJM /GKM':
                    $bobot = 1;
                    break;
                case 'Anggota GJM /GKM':
                    $bobot = 0.5;
                    break;
            }
            $rencana->sks_terhitung = $bobot;
        }

        $rencana->save();
        $detail_rencana->save();

        $res = [
            "rencana" => $rencana,
            "detail_rencana" => $detail_rencana,
        ];

        return response()->json($res, 200);
    }

    public function deleteNonstruktural($id)
    {
        $record = Rencana::where('id_rencana', $id);
        $detail_record = DetailPenunjang::where('id_rencana', $id);

        if ($record && $detail_record) {
            $detail_record->delete();
            $record->delete();
            $response = [
                'message' => 'delete kegiatan sukses'
            ];

            return response()->json($response, 201);
        } else {
            $response = [
                'message' => 'Delete kegiatan gagal'
            ];
            return response()->json($response, 300);
        }
    }

    //Handler G. Ketua Redaksi Jurnal
    public function getRedaksi()
    {
        $redaksi = Rencana::join('detail_penunjang', 'rencana.id_rencana', "=", "detail_penunjang.id_rencana")
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'rencana.sks_terhitung', 'detail_penunjang.jabatan')
            ->where('rencana.sub_rencana', 'redaksi')
            ->get();

        return response()->json($redaksi, 200);
    }

    public function postRedaksi(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jabatan = $request->get('jabatan');

        $bobot = 0;

        switch ($jabatan) {
            case 'Ketua Redaksi Jurnal ber-ISSN':
                $bobot = 1;
                break;
            case 'Anggota Redaksi Jurnal ber-ISSN':
                $bobot = 0.5;
                break;
        }

        $sks_terhitung = $bobot * 1;

        $rencana = Rencana::create([
            'jenis_rencana' => 'penunjang',
            'sub_rencana' => 'redaksi',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => round($sks_terhitung, 2),
        ]);

        $detailPenunjang = DetailPenunjang::create([
            'id_rencana' => $rencana->id_rencana,
            'jabatan' => $jabatan
        ]);

        $res = [$rencana, $detailPenunjang];

        return response()->json($res, 201);
    }

    public function editRedaksi(Request $request)
    {
        $request->all();
        $id_rencana = $request->get('id_rencana');

        $rencana = Rencana::where('id_rencana', $id_rencana)->first();
        $detail_rencana = DetailPenunjang::where('id_rencana', $id_rencana)->first();
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jabatan = $request->get('jabatan');

        if ($nama_kegiatan != null && $nama_kegiatan != "") {
            $rencana->nama_kegiatan = $nama_kegiatan;
        }

        if ($jabatan == null) {
            $jabatan = $detail_rencana->jabatan;
        } else {
            $detail_rencana->jabatan = $jabatan;
        }

        if ($jabatan != null) {
            switch ($jabatan) {
                case 'Ketua Redaksi Jurnal ber-ISSN':
                    $bobot = 1;
                    break;
                case 'Anggota Redaksi Jurnal ber-ISSN':
                    $bobot = 0.5;
                    break;
            }
            $rencana->sks_terhitung = $bobot;
        }

        $rencana->save();
        $detail_rencana->save();

        $res = [
            "rencana" => $rencana,
            "detail_rencana" => $detail_rencana,
        ];

        return response()->json($res, 200);
    }

    public function deleteRedaksi($id)
    {
        $record = Rencana::where('id_rencana', $id);
        $detail_record = DetailPenunjang::where('id_rencana', $id);

        if ($record && $detail_record) {
            $detail_record->delete();
            $record->delete();
            $response = [
                'message' => 'delete kegiatan sukses'
            ];

            return response()->json($response, 201);
        } else {
            $response = [
                'message' => 'Delete kegiatan gagal'
            ];
            return response()->json($response, 300);
        }
    }
    //Handler H. Ketua Ad Hoc
    public function getAdhoc()
    {
        $adhoc = Rencana::join('detail_penunjang', 'rencana.id_rencana', "=", "detail_penunjang.id_rencana")
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'rencana.sks_terhitung', 'detail_penunjang.jabatan')
            ->where('rencana.sub_rencana', 'adhoc')
            ->get();

        return response()->json($adhoc, 200);
    }

    public function postAdhoc(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jabatan = $request->get('jabatan');

        $bobot = 0;

        switch ($jabatan) {
            case 'Ketua Panitia Ad Hoc':
                $bobot = 1.0;
                break;
            case 'Anggota Panitia Ad Hoc':
                $bobot = 0.5;
                break;
        }

        $sks_terhitung = $bobot * 1;

        $rencana = Rencana::create([
            'jenis_rencana' => 'penunjang',
            'sub_rencana' => 'adhoc',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => round($sks_terhitung, 2),
        ]);

        $detailPenunjang = DetailPenunjang::create([
            'id_rencana' => $rencana->id_rencana,
            'jabatan' => $jabatan
        ]);

        $res = [$rencana, $detailPenunjang];

        return response()->json($res, 201);
    }

    public function editAdhoc(Request $request)
    {
        $request->all();
        $id_rencana = $request->get('id_rencana');

        $rencana = Rencana::where('id_rencana', $id_rencana)->first();
        $detail_rencana = DetailPenunjang::where('id_rencana', $id_rencana)->first();
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jabatan = $request->get('jabatan');

        if ($nama_kegiatan != null && $nama_kegiatan != "") {
            $rencana->nama_kegiatan = $nama_kegiatan;
        }

        if ($jabatan == null) {
            $jabatan = $detail_rencana->jabatan;
        } else {
            $detail_rencana->jabatan = $jabatan;
        }

        if ($jabatan != null) {
            switch ($jabatan) {
                case 'Ketua Panitia Ad Hoc':
                    $bobot = 1.0;
                    break;
                case 'Anggota Panitia Ad Hoc':
                    $bobot = 0.5;
                    break;
            }
            $rencana->sks_terhitung = $bobot;
        }

        $rencana->save();
        $detail_rencana->save();

        $res = [
            "rencana" => $rencana,
            "detail_rencana" => $detail_rencana,
        ];

        return response()->json($res, 200);
    }

    public function deleteAdhoc($id)
    {
        $record = Rencana::where('id_rencana', $id);
        $detail_record = DetailPenunjang::where('id_rencana', $id);

        if ($record && $detail_record) {
            $detail_record->delete();
            $record->delete();
            $response = [
                'message' => 'delete kegiatan sukses'
            ];

            return response()->json($response, 201);
        } else {
            $response = [
                'message' => 'Delete kegiatan gagal'
            ];
            return response()->json($response, 300);
        }
    }


    //Handler I. Ketua Panitia Tetap
    public function getKetuaPanitia()
    {
    }
    public function postKetuaPanitia(Request $request)
    {
    }
    public function editKetuaPanitia(Request $request)
    {
    }
    public function deleteKetuaPanitia($id)
    {
    }

    //Handler J. Anggota Panitia Tetap
    public function getAnggotaPanitia()
    {
    }
    public function postAnggotaPanitia(Request $request)
    {
    }
    public function editAnggotaPanitia(Request $request)
    {
    }
    public function deleteAnggotaPanitia($id)
    {
    }

    //Handler K. Menjadi Pengurus Yayasan
    public function getPengurusYayasan()
    {
    }
    public function postPengurusYayasan(Request $request)
    {
    }
    public function editPengurusYayasan(Request $request)
    {
    }
    public function deletePengurusYayasan($id)
    {
    }

    //Handler L. Menjadi Pengurus/Anggota Asosiasi Profesi
    public function getAsosiasi()
    {
        $akademik = Rencana::join('detail_penunjang', 'rencana.id_rencana', '=', 'detail_penunjang.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'rencana.sks_terhitung', 'detail_penunjang.jenis_tingkatan', 'detail_penunjang.jabatan')
            ->where('rencana.sub_rencana', 'asosiasi')
            ->get();

        return response()->json($akademik, 200);
    }
    public function postAsosiasi(Request $request)
    {
        // Mengambil data dari request
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jabatan = $request->get('jabatan');
        $jenis_tingkatan = $request->get('jenis_tingkatan');

        // Menghitung SKS berdasarkan tingkat kegiatan dan jabatan
        $sks_terhitung = 0;
        if ($jenis_tingkatan === 'Nasional') {
            if ($jabatan === 'Ketua') {
                $sks_terhitung = 1;
            } else if ($jabatan === 'Anggota') {
                $sks_terhitung = 0.5;
            }
        } else if ($jenis_tingkatan === 'Internasional') {
            if ($jabatan === 'Ketua') {
                $sks_terhitung = 2;
            } else if ($jabatan === 'Anggota') {
                $sks_terhitung = 1;
            }
        }

        // Jika belum mencapai batas, lanjutkan dengan proses submit
        $rencana = Rencana::create([
            'jenis_rencana' => 'penunjang',
            'sub_rencana' => 'asosiasi',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => round($sks_terhitung, 2),
        ]);

        $detailPenunjang = DetailPenunjang::create([
            'id_rencana' => $rencana->id_rencana,

            'jenis_tingkatan' => $jenis_tingkatan,
            'jabatan' => $jabatan,
        ]);

        $res = [$rencana, $detailPenunjang];

        return response()->json($res, 201);
    }

    public function editAsosiasi(Request $request)
    {
        $request->all();
        $id_rencana = $request->get('id_rencana');

        $rencana = Rencana::where('id_rencana', $id_rencana)->first();
        $detail_rencana = DetailPenunjang::where('id_rencana', $id_rencana)->first();
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jabatan = $request->get('jabatan');
        $tingkatan = $request->get('tingkatan');

        if ($nama_kegiatan != null && $nama_kegiatan != "") {
            $rencana->nama_kegiatan = $nama_kegiatan;
        }

        if ($jabatan != null && $jabatan != "") {
            $detail_rencana->jabatan = $jabatan;
        }

        if ($tingkatan != null && $tingkatan != "") {
            $detail_rencana->tingkatan = $tingkatan;
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
    public function deleteAsosiasi($id)
    {
        $record = Rencana::where('id_rencana', $id);
        $detail_record = DetailPenunjang::where('id_rencana', $id);

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

    //Handler M. Peserta seminar/workshop/kursus berdasar penugasan pimpinan
    public function getSeminar()
    {
        $akademik = Rencana::join('detail_penunjang', 'rencana.id_rencana', '=', 'detail_penunjang.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'rencana.sks_terhitung', 'detail_penunjang.jenis_tingkatan')
            ->where('rencana.sub_rencana', 'seminar')
            ->get();

        return response()->json($akademik, 200);
    }
    public function postSeminar(Request $request)
    {
        // Mengambil data dari request
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jenis_tingkatan = $request->get('jenis_tingkatan');

        // Menghitung SKS berdasarkan tingkat kegiatan
        $sks_terhitung = 0;
        if ($jenis_tingkatan === 'Regional/Nasional') {
            $sks_terhitung = 0.5;
        } else if ($jenis_tingkatan === 'Internasional') {
            $sks_terhitung = 1.0;
        }

        // Jika belum mencapai batas, lanjutkan dengan proses submit
        $rencana = Rencana::create([
            'jenis_rencana' => 'penunjang',
            'sub_rencana' => 'seminar',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => round($sks_terhitung, 2),
        ]);

        $detailPenunjang = DetailPenunjang::create([
            'id_rencana' => $rencana->id_rencana,
            'jenis_tingkatan' => $jenis_tingkatan, // Menyimpan jenis tingkatan ke dalam detail penunjang
        ]);

        $res = [$rencana, $detailPenunjang];

        return response()->json($res, 201);
    }

    public function editSeminar(Request $request)
    {
        $id_rencana = $request->get('id_rencana');

        $rencana = Rencana::where('id_rencana', $id_rencana)->first();
        $detail_rencana = DetailPenunjang::where('id_rencana', $id_rencana)->first();
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jenis_tingkatan = $request->get('jenis_tingkatan');

        // Menghitung SKS berdasarkan tingkat kegiatan
        $sks_terhitung = 0;
        if ($jenis_tingkatan === 'Regional/Nasional') {
            $sks_terhitung = 0.5;
        } else if ($jenis_tingkatan === 'Internasional') {
            $sks_terhitung = 1.0;
        }

        if ($nama_kegiatan != null && $nama_kegiatan != "") {
            $rencana->nama_kegiatan = $nama_kegiatan;
        }

        if ($jenis_tingkatan != null && $jenis_tingkatan != "") {
            $detail_rencana->jenis_tingkatan = $jenis_tingkatan;
            // Mengupdate SKS terhitung berdasarkan tingkat kegiatan
            $rencana->sks_terhitung = round($sks_terhitung, 2);
        }

        $rencana->save();
        $detail_rencana->save();

        $res = [
            "rencana" => $rencana,
            'detail_rencana' => $detail_rencana,
            "message" => "Rencana updated successfully",
        ];

        return response()->json($res, 200);
    }

    public function deleteSeminar($id)
    {
        $record = Rencana::where('id_rencana', $id);
        $detail_record = DetailPenunjang::where('id_rencana', $id);

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

    //Handler N. Reviewer jurnal ilmiah , proposal Hibah dll
    public function getReviewer()
    {
        $akademik = Rencana::join('detail_penunjang', 'rencana.id_rencana', '=', 'detail_penunjang.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'reviewer')
            ->get();

        return response()->json($akademik, 200);
    }
    public function postReviewer(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $sks_terhitung = 1;

        $rencana = Rencana::create([
            'jenis_rencana' => 'penunjang',
            'sub_rencana' => 'reviewer',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => $sks_terhitung,
        ]);

        $detail_penunjang = DetailPenunjang::create([
            'id_rencana' => $rencana->id_rencana,
        ]);
        $res = [$rencana, $detail_penunjang];
        return response()->json($res, 201);
    }
    public function editReviewer(Request $request)
    {
        $request->all();
        $id_rencana = $request->get('id_rencana');

        $rencana = Rencana::where('id_rencana', $id_rencana)->first();
        $detail_rencana = DetailPenunjang::where('id_rencana', $id_rencana)->first();
        $nama_kegiatan = $request->get('nama_kegiatan');

        if ($nama_kegiatan != null && $nama_kegiatan != "") {
            $rencana->nama_kegiatan = $nama_kegiatan;
        }

        $rencana->save();
        $detail_rencana->save();

        $res = [
            "rencana" => $rencana,
            'detail_rencana' => $detail_rencana,
            "message" => "Rencana updated successfully",
        ];

        return response()->json($res, 200);
    }

    public function deleteReviewer($id)
    {
        $record = Rencana::where('id_rencana', $id);
        $detail_record = DetailPenunjang::where('id_rencana', $id);

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
