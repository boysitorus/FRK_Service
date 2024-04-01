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


        // Kembalikan data dalam bentuk yang sesuai untuk ditampilkan di halaman
        return response()->json([
            'ukm' => $ukm,
            'sosial' => $sosial,
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

        if ($nama_kegiatan != null || $nama_kegiatan != "") {
            $rencana->nama_kegiatan = $nama_kegiatan;
        }

        if ($jumlah_mahasiswa != null) {
            $detail_penunjang->jumlah_mahasiswa = $jumlah_mahasiswa;

            if ($jumlah_mahasiswa >= 2) {
                $detail_penunjang->sks_terhitung = 2;
            } else {
                $detail_penunjang->sks_terhitung = round($jumlah_mahasiswa / 12, 2);
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

            if ($jumlah_mahasiswa >= 2) {
                $detail_penunjang->sks_terhitung = 2;
            } else {
                $detail_penunjang->sks_terhitung = round($jumlah_mahasiswa / 12, 2);
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

        $rencana = Rencana::where('id_rencana', $id_rencana)->first();;
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
    }
    public function postStruktural(Request $request)
    {
    }
    public function editStruktural(Request $request)
    {
    }
    public function deleteStruktural($id)
    {
    }

    //Handler F. Jabatan non struktural
    public function getNonStruktural()
    {
    }
    public function postNonStruktural(Request $request)
    {
    }
    public function editNonStruktural(Request $request)
    {
    }
    public function deleteNonStruktural($id)
    {
    }

    //Handler G. Ketua Redaksi Jurnal
    public function getJurnal()
    {
    }
    public function postJurnal(Request $request)
    {
    }
    public function editJurnal(Request $request)
    {
    }
    public function deleteJurnal($id)
    {
    }

    //Handler H. Ketua Panitia Ad Hoc
    public function getAdHoc()
    {
    }
    public function postAdHoc(Request $request)
    {
    }
    public function editAdHoc(Request $request)
    {
    }
    public function deleteAdHoc($id)
    {
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
        $asosiasi = DetailPenunjang::join('detail_penunjang', 'rencana.id_rencana', '=', 'detail_penunjang.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penunjang.jenis_jabatan_struktural', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'asosiasi')
            ->get();

        return response()->json($asosiasi, 200);
    }
    public function postAsosiasi(Request $request)
    {
    }
    public function editAsosiasi(Request $request)
    {
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
        $seminar = DetailPenunjang::join('detail_penunjang', 'rencana.id_rencana', '=', 'detail_penunjang.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penunjang.jenis_tingkatan', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'seminar')
            ->get();

        return response()->json($seminar, 200);
    }
    public function postSeminar(Request $request)
    {
    }
    public function editSeminar(Request $request)
    {
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
        $reviewer = DetailPenunjang::join('detail_penunjang', 'rencana.id_rencana', '=', 'detail_penunjang.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'reviewer')
            ->get();
        return response()->json($reviewer, 200);
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
