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
        // BAGIAN A
        $teori = Rencana::join('detail_pendidikan', 'rencana.id_rencana', '=', 'detail_pendidikan.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pendidikan.jumlah_kelas', 'detail_pendidikan.jumlah_evaluasi', 'detail_pendidikan.sks_matakuliah', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'teori')
            ->get();

        // BAGIAN C
        $bimbingan = Rencana::join('detail_pendidikan', 'rencana.id_rencana', '=', 'detail_pendidikan.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pendidikan.jumlah_mahasiswa', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'bimbingan')
            ->get();

        // BAGIAN D
        $rendah = Rencana::join('detail_pendidikan', 'rencana.id_rencana', '=', 'detail_pendidikan.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pendidikan.jumlah_dosen', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'bimbing_rendah')
            ->get();

        // BAGIAN E
        $tugasAkhir = Rencana::join('detail_pendidikan', 'rencana.id_rencana', '=', 'detail_pendidikan.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pendidikan.jumlah_mahasiswa', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'tugasAkhir')
            ->get();
        
        // BAGIAN F
        $proposal = Rencana::join('detail_pendidikan', 'rencana.id_rencana', '=', 'detail_pendidikan.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pendidikan.jumlah_mahasiswa', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'proposal')
            ->get();

        // BAGIAN G
        $kembang = Rencana::join('detail_pendidikan', 'rencana.id_rencana', '=', 'detail_pendidikan.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pendidikan.jumlah_sap', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'bimbing_rendah')
            ->get();

        // BAGIAN I
        $cangkok = Rencana::join('detail_pendidikan', 'rencana.id_rencana', '=', 'detail_pendidikan.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pendidikan.jumlah_dosen', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'cangkok')
            ->get();

        // BAGIAN J
        $koordinator = Rencana::join('detail_pendidikan', 'rencana.id_rencana', '=', 'detail_pendidikan.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'koordinator')
            ->get();

        // BAGIAN K
        $asistensi = Rencana::join('detail_pendidikan', 'rencana.id_rencana', '=', 'detail_pendidikan.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pendidikan.jumlah_mahasiswa', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'asistensi')
            ->get();

        // Kembalikan data dalam bentuk yang sesuai untuk ditampilkan di halaman
        return response()->json([
            'teori' => $teori,
            'bimbingan' => $bimbingan,
            'rendah' => $rendah,
            'kembang' => $kembang,
            'cangkok' => $cangkok,
            'koordinator' => $koordinator,
            'asistensi' => $asistensi,
            'tugasAkhir' => $tugasAkhir,
            'proposal' => $proposal
        ], 200);
    }

    // START OF METHOD A 
    public function getTeori()
    {
        $teori = Rencana::join('detail_pendidikan', 'rencana.id_rencana', '=', 'detail_pendidikan.id_rencana')
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

        $sks_terhitung = round(($jam_persiapan + $jam_tatap_muka + $jumlah_evaluasi) / 3, 2);

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
    //END OF METHOD A

    //START OF METHOD B
    public function getPraktikum()
    {
        $praktikum = Rencana::join('detail_pendidikan', 'rencana.id_rencana', '=', 'detail_pendidikan.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pendidikan.jumlah_kelas', 'detail_pendidikan.sks_matakuliah', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'praktikum')
            ->get();

        return response()->json($praktikum, 200);
    }
    public function postPraktikum(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jumlah_kelas = (int)$request->get('jumlah_kelas');
        $sks_matakuliah = (int)$request->get('sks_matakuliah');

        $sks_terhitung = round((1.5 * $sks_matakuliah * $jumlah_kelas) / 2, 2);

        $rencana = Rencana::create([
            'jenis_rencana' => 'pendidikan',
            'sub_rencana' => 'praktikum',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => $sks_terhitung
        ]);

        $detailPendidikan = DetailPendidikan::create([
            'id_rencana' => $rencana->id_rencana,
            'jumlah_kelas' => $jumlah_kelas,
            'sks_matakuliah' => $sks_matakuliah
        ]);

        $res = [$rencana, $detailPendidikan];

        return response()->json($res, 201);
    }
    public function editPraktikum(Request $request)
    {
        $request->all();
        $id_rencana = $request->get('id_rencana');

        $rencana = Rencana::where('id_rencana', $id_rencana)->first();
        $detail_rencana = DetailPendidikan::where('id_rencana', $id_rencana)->first();

        $nama_kegiatan = $request->get('nama_kegiatan');
        $jumlah_kelas = (int)$request->get('jumlah_kelas');
        $sks_matakuliah = (int)$request->get('sks_matakuliah');


        if ($nama_kegiatan != null && $nama_kegiatan != "") {
            $rencana->nama_kegiatan = $nama_kegiatan;
        }

        if ($jumlah_kelas == null) {
            $jumlah_kelas = $detail_rencana->jumlah_kelas;
        } else {
            $detail_rencana->jumlah_kelas = $jumlah_kelas;
        }

        if ($sks_matakuliah == null) {
            $sks_matakuliah = $detail_rencana->sks_matakuliah;
        } else {
            $detail_rencana->sks_matakuliah = $sks_matakuliah;
        }

        if ($jumlah_kelas != null || $sks_matakuliah != null) {
            $sks_terhitung = round((1.5 * $sks_matakuliah * $jumlah_kelas) / 2, 2);

            $rencana->sks_terhitung = $sks_terhitung;
        }

        $rencana->save();
        $detail_rencana->save();

        $res = [
            "rencana" => $rencana,
            "detail_rencana" => $detail_rencana,
            "message" => "Rencana Praktikum updated successfully"
        ];


        return response()->json($res, 200);
    }
    public function deletePraktikum($id)
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
    //END OF METHOD B

    // START OF METHOD C
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
            'id_rencana' => $rencana->id_rencana,
            'jumlah_mahasiswa' => $jumlah_mahasiswa
        ]);

        $res = [$rencana, $detailPendidikan];

        return response()->json($res, 201);
    }

    public function editBimbingan(Request $request)
    {
        $request->all();
        $id_rencana = $request->get('id_rencana');

        $rencana = Rencana::where('id_rencana', $id_rencana)->first();
        $detail_rencana = DetailPendidikan::where('id_rencana', $id_rencana)->first();
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jumlah_mahasiswa = (int)$request->get('jumlah_mahasiswa');

        if ($nama_kegiatan != null && $nama_kegiatan != "") {
            $rencana->nama_kegiatan = $nama_kegiatan;
        }

        if ($jumlah_mahasiswa == null) {
            $jumlah_mahasiswa = $detail_rencana->jumlah_mahasiswa;
        } else {
            $detail_rencana->jumlah_mahasiswa = $jumlah_mahasiswa;
        }

        if ($jumlah_mahasiswa != null) {
            $sks_terhitung = $jumlah_mahasiswa / 25;

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
    // END OF METHOD C

    // START OF METHOD D
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

        $sks_terhitung = (4 * $jumlah_kelompok) / 42;

        $rencana = Rencana::create([
            'jenis_rencana' => 'pendidikan',
            'sub_rencana' => 'seminar',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => round($sks_terhitung, 2),
        ]);

        $detailPendidikan = DetailPendidikan::create([
            'id_rencana' => $rencana->id_rencana,
            'jumlah_kelompok' => $jumlah_kelompok
        ]);

        $res = [$rencana, $detailPendidikan];

        return response()->json($res, 201);
    }

    public function editSeminar(Request $request)
    {
        $request->all();
        $id_rencana = $request->get('id_rencana');

        $rencana = Rencana::where('id_rencana', $id_rencana)->first();
        $detail_rencana = DetailPendidikan::where('id_rencana', $id_rencana)->first();
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jumlah_kelompok = (int)$request->get('jumlah_kelompok');

        if ($nama_kegiatan != null && $nama_kegiatan != "") {
            $rencana->nama_kegiatan = $nama_kegiatan;
        }

        if ($jumlah_kelompok == null) {
            $jumlah_kelompok = $detail_rencana->jumlah_kelompok;
        } else {
            $detail_rencana->jumlah_kelompok = $jumlah_kelompok;
        }

        if ($jumlah_kelompok != null) {
            $sks_terhitung = (4 * $jumlah_kelompok) / 42;

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
    // END OF METHOD D

    // START OF METHOD E
    public function getTugasAkhir()
    {
        $tugasAkhir = Rencana::join('detail_pendidikan', 'rencana.id_rencana', "=", 'detail_pendidikan.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pendidikan.jumlah_mahasiswa', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'tugasAkhir')
            ->get();

        return response()->json($tugasAkhir, 200);
    }

    public function postTugasAkhir(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jumlah_mahasiswa = (int)$request->get('jumlah_mahasiswa');
        $sks_terhitung = $jumlah_mahasiswa;

        $rencana = Rencana::create([
            'jenis_rencana' => 'pendidikan',
            'sub_rencana' => 'tugasAkhir',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => $sks_terhitung,
        ]);

        if ($rencana) {
            $detailPendidikan = DetailPendidikan::create([
                'id_rencana' => $rencana->id_rencana,
                'jumlah_mahasiswa' => $jumlah_mahasiswa
            ]);
        }


        $res = [
            "rencana" => $rencana,
            "detail_pendidikan" => $detailPendidikan,
            "message" => "Asistensi tugas created successfully"
        ];

        return response()->json($res, 200);
    }


    public function editTugasAkhir(Request $request)
    {
        $request->all();
        $id_rencana = $request->get('id_rencana');

        $rencana = Rencana::where('id_rencana', $id_rencana)->first();
        $detail_rencana = DetailPendidikan::where('id_rencana', $id_rencana)->first();
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jumlah_mahasiswa = (int)$request->get('jumlah_mahasiswa');

        if ($nama_kegiatan != null && $nama_kegiatan != "") {
            $rencana->nama_kegiatan = $nama_kegiatan;
        }

        if ($jumlah_mahasiswa == null) {
            $jumlah_mahasiswa = $detail_rencana->jumlah_mahasiswa;
        } else {
            $detail_rencana->jumlah_kelas = $jumlah_mahasiswa;
        }

        if ($jumlah_mahasiswa != null) {
            $id_dosen = $request->get('id_dosen');
            $nama_kegiatan = $request->get('nama_kegiatan');
            $jumlah_mahasiswa = (int)$request->get('jumlah_mahasiswa');

            $sks_terhitung = (4 * $jumlah_mahasiswa) / 42;

            $rencana->save();
            $detail_rencana->save();

            $res = [
                "rencana" => $rencana,
                "detail_rencana" => $detail_rencana,
                "message" => "Rencana updated successfully"
            ];
        }

        return response()->json($res, 200);
    }

    public function deleteTugasAkhir($id)
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
    // END OF METHOD E

    // START OF METHOD F
    public function getProposal()
    {
        $proposal = Rencana::join('detail_pendidikan', 'rencana.id_rencana', "=", 'detail_pendidikan.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pendidikan.jumlah_mahasiswa', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'proposal')
            ->get();

        return response()->json($proposal, 200);
    }

    public function postProposal(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jumlah_mahasiswa = (int)$request->get('jumlah_mahasiswa');

        $sks_terhitung = (4 * $jumlah_mahasiswa) / 42;

        $rencana = Rencana::create([
            'jenis_rencana' => 'pendidikan',
            'sub_rencana' => 'proposal',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => round($sks_terhitung, 2),
        ]);

        if ($rencana) {
            $detailPendidikan = DetailPendidikan::create([
                'id_rencana' => $rencana->id_rencana,
                'jumlah_mahasiswa' => $jumlah_mahasiswa
            ]);
        }


        $res = [$rencana, $detailPendidikan];

        return response()->json($res, 201);
    }


    public function editProposal(Request $request)
    {
        $request->all();
        $id_rencana = $request->get('id_rencana');

        $rencana = Rencana::where('id_rencana', $id_rencana)->first();
        $detail_rencana = DetailPendidikan::where('id_rencana', $id_rencana)->first();
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jumlah_mahasiswa = (int)$request->get('jumlah_mahasiswa');

        if ($nama_kegiatan != null && $nama_kegiatan != "") {
            $rencana->nama_kegiatan = $nama_kegiatan;
        }

        if ($jumlah_mahasiswa == null) {
            $jumlah_mahasiswa = $detail_rencana->jumlah_mahasiswa;
        } else {
            $detail_rencana->jumlah_kelas = $jumlah_mahasiswa;
        }

        if ($jumlah_mahasiswa != null) {
            $id_dosen = $request->get('id_dosen');
            $nama_kegiatan = $request->get('nama_kegiatan');
            $jumlah_mahasiswa = (int)$request->get('jumlah_mahasiswa');

            $sks_terhitung = (4 * $jumlah_mahasiswa) / 42;

            $rencana->save();
            $detail_rencana->save();

            $res = [
                "rencana" => $rencana,
                "detail_rencana" => $detail_rencana,
                "message" => "Rencana updated successfully"
            ];
        }

        return response()->json($res, 200);
    }

    public function deleteProposal($id)
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
    // END OF METHOD F
    
    // START OF METHOD G
    public function getRendah()
    {
        $rencana = Rencana::join('detail_pendidikan', 'rencana.id_rencana', '=', 'detail_pendidikan.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pendidikan.jumlah_dosen', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'bimbing_rendah')
            ->get();
        return response()->json($rencana, 200);
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
            'id_rencana' => $rencana->id_rencana,
            'jumlah_dosen' => $jumlah_dosen
        ]);

        $res = [$rencana, $detailPendidikan];

        return response()->json($res, 201);
    }

    public function editRendah(Request $request)
    {
        $request->all();
        $id_rencana = $request->get('id_rencana');

        $rencana = Rencana::where('id_rencana', $id_rencana)->first();
        $detail_rencana = DetailPendidikan::where('id_rencana', $id_rencana)->first();
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jumlah_dosen = (int)$request->get('jumlah_dosen');

        if ($nama_kegiatan != null && $nama_kegiatan != "") {
            $rencana->nama_kegiatan = $nama_kegiatan;
        }

        if ($jumlah_dosen == null) {
            $jumlah_dosen = $detail_rencana->jumlah_dosen;
        } else {
            $detail_rencana->jumlah_dosen = $jumlah_dosen;
        }

        if ($jumlah_dosen != null) {

            $sks_terhitung = $jumlah_dosen;

            $rencana->sks_terhitung = $sks_terhitung;
        }

        $rencana->save();
        $detail_rencana->save();

        $res = [
            "rencana" => $rencana,
            "detail_pendidikan" => $detail_rencana,
            "message" => "Cangkok created successfully"
        ];
        
        return response()->json($res, 200);
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
    // END OF METHOD G

    // START OF METHOD H
    public function getKembang()
    {
        $kembang = Rencana::join('detail_pendidikan', 'rencana.id_rencana', "=", 'detail_pendidikan.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pendidikan.jumlah_mahasiswa', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'kembang')
            ->get();

            return response()->json($kembang, 200);
    }

    public function postKembang(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jumlah_sap = (int)$request->get('jumlah_sap');

        $sks_terhitung = 0.5 * $jumlah_sap;

        $rencana = Rencana::create([
            'jenis_rencana' => 'pendidikan',
            'sub_rencana' => 'pengembangan',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => $sks_terhitung,
        ]);

        $detailPendidikan = DetailPendidikan::create([
            'id_rencana' => $rencana->id_rencana,
            'jumlah_sap' => $jumlah_sap
        ]);

        $res = [$rencana, $detailPendidikan];

        return response()->json($res, 201);
    }

    public function editKembang(Request $request)
    {
        $id_rencana = $request->get('id_rencana');

        $rencana = Rencana::find($id_rencana);
        $detailPendidikan = DetailPendidikan::where('id_rencana', $id_rencana)->first();

        $nama_kegiatan = $request->get('nama_kegiatan');
        $jumlah_sap = (int)$request->get('jumlah_sap');
        $sks_terhitung = 0.5 * $jumlah_sap;

        $rencana->nama_kegiatan = $nama_kegiatan;
        $rencana->sks_terhitung = $sks_terhitung;
        $rencana->save();

        $detailPendidikan->jumlah_sap = $jumlah_sap;
        $detailPendidikan->save();

        $res = [
            "rencana" => $rencana,
            "detail_pendidikan" => $detailPendidikan,
            "message" => "Kegiatan detasering updated successfully"
        ];

        return response()->json($res, 200);
    }

    public function deleteKembang($id)
    {
        $rencana = Rencana::find($id);
        $detailPendidikan = DetailPendidikan::where('id_rencana', $id)->first();

        if ($rencana && $detailPendidikan) {
            $detailPendidikan->delete();
            $rencana->delete();
            $response = [
                'message' => 'Delete kegiatan success'
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                'message' => 'Delete kegiatan failed'
            ];
            return response()->json($response, 404);
        }
    }
    // END OF METHOD H

    // START OF METHOD I

    public function getCangkok()
    {
        $cangkok = Rencana::join('detail_pendidikan', 'rencana.id_rencana', '=', 'detail_pendidikan.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pendidikan.jumlah_dosen', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'cangkok')
            ->get();

        return response()->json($cangkok, 200);
    }

    public function postCangkok(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jumlah_dosen = (int)$request->get('jumlah_dosen');

        $sks_terhitung = 2;

        $rencana = Rencana::create([
            'jenis_rencana' => 'pendidikan',
            'sub_rencana' => 'cangkok',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => $sks_terhitung,
        ]);

        $detailPendidikan = DetailPendidikan::create([
            'id_rencana' => $rencana->id_rencana,
            'jumlah_dosen' => $jumlah_dosen
        ]);

        $res = [$rencana, $detailPendidikan];

        return response()->json($res, 201);
    }

    public function deleteCangkok($id)
    {
        $rencana = Rencana::find($id);
        $detailPendidikan = DetailPendidikan::where('id_rencana', $id)->first();

        if ($rencana && $detailPendidikan) {
            $detailPendidikan->delete();
            $rencana->delete();
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

    public function editCangkok(Request $request)
    {
        $request->all();
        $id_rencana = $request->get('id_rencana');

        $rencana = Rencana::where('id_rencana', $id_rencana)->first();
        $detail_rencana = DetailPendidikan::where('id_rencana', $id_rencana)->first();
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jumlah_dosen = (int)$request->get('jumlah_dosen');
        $sks_matakuliah = 2;

        if ($nama_kegiatan != null && $nama_kegiatan != "") {
            $rencana->nama_kegiatan = $nama_kegiatan;
        }

        if ($jumlah_dosen == null) {
            $jumlah_dosen = $detail_rencana->jumlah_dosen;
        } else {
            $detail_rencana->jumlah_dosen = $jumlah_dosen;
        }

        if ($sks_matakuliah == null) {
            $sks_matakuliah = $detail_rencana->sks_matakuliah;
        } else {
            $detail_rencana->sks_matakuliah = $sks_matakuliah;
        }

        if ($jumlah_dosen != null || $sks_matakuliah != null) {
            $jam_persiapan = $sks_matakuliah;
            $jam_tatap_muka = $sks_matakuliah * $jumlah_dosen;

            $sks_terhitung = round($jam_persiapan + $jam_tatap_muka) / 2;

            $rencana->sks_terhitung = $sks_terhitung;
        }

        $rencana->save();
        $detail_rencana->save();

        $res = [
            "rencana" => $rencana,
            "detail_pendidikan" => $detail_rencana,
            "message" => "Kegiatan detasering updated successfully"
        ];

        return response()->json($res, 200);
    }
    // END OF METHOD I


    // START OF METHOD J
    public function getKoordinator()
    {
        $koordinator = Rencana::join('detail_pendidikan', 'rencana.id_rencana', '=', 'detail_pendidikan.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'koordinator')
            ->get();
        return response()->json($koordinator, 200);
    }

    public function postKoordinator(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $sks_terhitung = 1;
        $rencana = Rencana::create([
            'jenis_rencana' => 'pendidikan',
            'sub_rencana' => 'koordinator',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => $sks_terhitung,
        ]);
        $detailPendidikan = DetailPendidikan::create([
            'id_rencana' => $rencana->id_rencana
        ]);
        $res = [
            "rencana" => $rencana,
            "detail_pendidikan" => $detailPendidikan,
            "message" => "Kegiatan detasering updated successfully"
        ];
        return response()->json($res, 201);
    }

    public function editKoordinator(Request $request)
    {
        $id_rencana = $request->get('id_rencana');
        $rencana = Rencana::where('id_rencana', $id_rencana)->first();
        $nama_kegiatan = $request->get('nama_kegiatan');
        $sks_terhitung = 1;
        if ($nama_kegiatan != null && $nama_kegiatan != "") {
            $rencana->nama_kegiatan = $nama_kegiatan;
        }
        if ($sks_terhitung != null) {
            $rencana->sks_terhitung = 1;
        }
        $rencana->save();
        $res = [
            "rencana" => $rencana,
            "message" => "Rencana updated successfully"
        ];
        return response()->json($res, 200);
    }

    public function deleteKoordinator($id)
    {
        $record = Rencana::where('id_rencana', $id);
        $detail_record = DetailPendidikan::where('id_rencana', $id);

        if ($record && $detail_record) {
            $detail_record->delete();
            $record->delete();
            $response = [
                'message' => 'Delete kegiatan success'
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                'message' => 'Delete kegiatan failed'
            ];
            return response()->json($response, 404);
        }
    }
    // END OF METHOD J

    // START OF METHOD K
    public function getAsistensi()
    {
        $asistensi = Rencana::join('detail_pendidikan', 'rencana.id_rencana', '=', 'detail_pendidikan.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan','detail_pendidikan.jumlah_dosen', 'detail_pendidikan.jumlah_mahasiswa', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'asistensi')
            ->get();

        return response()->json($asistensi, 200);
    }

    public function postAsistensi(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jumlah_mahasiswa = (int)$request->get('jumlah_mahasiswa');
        $jumlah_dosen = (int)$request->get('jumlah_dosen'); // Asumsikan ini adalah input tambahan

        // Menentukan SKS Terhitung berdasarkan jumlah mahasiswa
        $sks_terhitung = 1; // Default SKS Terhitung adalah 1

        // Jika jumlah mahasiswa lebih dari 25, maka kita menggunakan prosentase 150%
        if ($jumlah_mahasiswa > 25) {
            $sks_terhitung = 1.5; // 150% dari 1 SKS
        }

        // Menghitung SKS Terhitung dengan mempertimbangkan jumlah dosen
        $sks_terhitung = $sks_terhitung / $jumlah_dosen;

        $rencana = Rencana::create([
            'jenis_rencana' => 'pendidikan',
            'sub_rencana' => 'asistensi',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => $sks_terhitung,
        ]);

        $detailPendidikan = DetailPendidikan::create([
            'id_rencana' => $rencana->id_rencana,
            'jumlah_mahasiswa' => $jumlah_mahasiswa,
            'jumlah_dosen' => $jumlah_dosen
        ]);

        $res = [
            "rencana" => $rencana,
            "detail_pendidikan" => $detailPendidikan,
            "message" => "Asistensi tugas created successfully"
        ];

        return response()->json($res, 200);
    }

    public function editAsistensi(Request $request)
    {
        $id_rencana = $request->get('id_rencana');

        $rencana = Rencana::where('id_rencana', $id_rencana)->first();
        $detail_rencana = DetailPendidikan::where('id_rencana', $id_rencana)->first();
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jumlah_dosen = (int)$request->get('jumlah_dosen');
        $jumlah_mahasiswa = (int)$request->get('jumlah_mahasiswa');

        if ($nama_kegiatan != null && $nama_kegiatan != "") {
            $rencana->nama_kegiatan = $nama_kegiatan;
        }

        if ($jumlah_dosen != null) {
            $detail_rencana->jumlah_dosen = $jumlah_dosen;
        }

        if ($jumlah_mahasiswa != null) {
            $detail_rencana->jumlah_mahasiswa = $jumlah_mahasiswa;

            // Menghitung SKS Terhitung berdasarkan jumlah mahasiswa dan jumlah dosen
            $sks_terhitung = 1; // Default SKS Terhitung adalah 1
            if ($jumlah_mahasiswa > 25) {
                $sks_terhitung = 1.5; // 150% dari 1 SKS
            }
            $sks_terhitung = $sks_terhitung / $jumlah_dosen;

            $rencana->sks_terhitung = round($sks_terhitung, 2);
        }

        $rencana->save();
        $detail_rencana->save();

        $res = [
            "rencana" => $rencana,
            "detail_rencana" => $detail_rencana,
            "message" => "Asistensi updated successfully"
        ];

        return response()->json($res, 200);
    }

    public function deleteAsistensi($id)
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
    // END OF METHOD K
}
