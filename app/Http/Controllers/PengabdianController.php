<?php

namespace App\Http\Controllers;

use App\Models\DetailPengabdian;
use App\Models\Rencana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengabdianController extends Controller
{
    public function getAll($id)
    {
        //SEMUA
        $all = Rencana::where('rencana.id_dosen', $id)
        ->select('rencana.flag_save_permananent', 1)
        ->count();

        // BAGIAN A // BAGIAN A // BAGIAN A // BAGIAN A // BAGIAN A // BAGIAN A
        $kegiatan = Rencana::join('detail_pengabdian', 'rencana.id_rencana', '=', 'detail_pengabdian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pengabdian.jumlah_durasi', 'rencana.sks_terhitung', 'rencana.asesor1_frk', 'rencana.lampiran', 'rencana.asesor2_frk','rencana.flag_save_permananent')
            ->where('rencana.sub_rencana', 'kegiatan')
            ->get();


        // BAGIAN B // BAGIAN B // BAGIAN B // BAGIAN B // BAGIAN B // BAGIAN B
        $penyuluhan = Rencana::join('detail_pengabdian', 'rencana.id_rencana', '=', 'detail_pengabdian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pengabdian.jumlah_durasi', 'rencana.sks_terhitung', 'rencana.asesor1_frk', 'rencana.lampiran', 'rencana.asesor2_frk','rencana.flag_save_permananent')
            ->where('rencana.sub_rencana', 'penyuluhan')
            ->get();

        // BAGIAN C // BAGIAN C // BAGIAN C // BAGIAN C // BAGIAN C // BAGIAN C
        $konsultan = Rencana::join('detail_pengabdian', 'rencana.id_rencana', '=', 'detail_pengabdian.id_rencana')
        ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pengabdian.posisi', 'rencana.sks_terhitung', 'rencana.asesor1_frk', 'rencana.lampiran', 'rencana.asesor2_frk','rencana.flag_save_permananent')
           ->where('rencana.sub_rencana', 'konsultan')
           ->get();

        // BAGIAN D // BAGIAN D // BAGIAN D // BAGIAN D // BAGIAN D // BAGIAN D
        $karya = Rencana::join('detail_pengabdian', 'rencana.id_rencana', '=', 'detail_pengabdian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pengabdian.jenis_terbit', 'detail_pengabdian.status_tahapan', 'detail_pengabdian.jenis_pengerjaan','detail_pengabdian.peran','detail_pengabdian.jumlah_anggota', 'rencana.sks_terhitung', 'rencana.asesor1_frk', 'rencana.lampiran', 'rencana.asesor2_frk','rencana.flag_save_permananent')
            ->where('rencana.sub_rencana', 'karya')
            ->get();

        // Kembalikan data dalam bentuk yang sesuai untuk ditampilkan di halaman
        return response()->json([
            //Data Kegiatan

            //Data Penyuluhan
            'penyuluhan' => $penyuluhan,

            //Data Konsultan
            'konsultan' => $konsultan,
            //Data Karya
            'karya' => $karya
        ], 200);
    }

    // BEGINING OF METHOD A. KEGIATAN // BEGINING OF METHOD A. KEGIATAN
    public function getKegiatan($id)
    {
        $kegiatan = Rencana::join('detail_pengabdian', 'rencana.id_rencana', '=', 'detail_pengabdian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pengabdian.jumlah_durasi', 'rencana.sks_terhitung', 'rencana.asesor1_frk', 'rencana.lampiran', 'rencana.asesor2_frk','rencana.flag_save_permananent')
            ->where('rencana.sub_rencana', 'kegiatan')
            ->where('id_dosen', $id)
            ->get();

        return response()->json($kegiatan, 200);
    }

    public function postKegiatan(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jumlah_durasi = $request->get('jumlah_durasi');

        $jumlah_jam = $jumlah_durasi;

        $sks_terhitung = ($jumlah_jam / 50);
        $sks_terhitung = min($sks_terhitung, 3);

        $rencana = Rencana::create([
            'jenis_rencana' => 'pengabdian',
            'sub_rencana' => 'kegiatan',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => round($sks_terhitung, 2),
        ]);

        $detailPengabdian = DetailPengabdian::create([
            'id_rencana' => $rencana->id_rencana,
            'jumlah_durasi' => $jumlah_durasi
        ]);

        $res = [$rencana, $detailPengabdian];

        return response()->json($res, 201);
    }

    public function editKegiatan(Request $request)
    {
        $request->all();
        $id_rencana = $request->get('id_rencana');

        $rencana = Rencana::where('id_rencana', $id_rencana)->first();
        $detail_rencana = DetailPengabdian::where('id_rencana', $id_rencana)->first();
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jumlah_durasi = $request->get('jumlah_durasi');

        if ($nama_kegiatan != null && $nama_kegiatan != "") {
            $rencana->nama_kegiatan = $nama_kegiatan;
        } else {
            $detail_rencana->nama_kegiatan = $nama_kegiatan;
        }

        if ($jumlah_durasi == null || $jumlah_durasi == "") {
            $jumlah_durasi = $detail_rencana->jumlah_durasi;
        } else {
            $detail_rencana->jumlah_durasi = $jumlah_durasi;
        }

        $jumlah_jam = $jumlah_durasi;

        $sks_terhitung = ($jumlah_jam / 50);
        $sks_terhitung = min($sks_terhitung, 3);
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

    public function deleteKegiatan($id)
    {
        $record = Rencana::where('id_rencana', $id);
        $detail_record = DetailPengabdian::where('id_rencana', $id);

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

    //END OF METHOD A. KEGIATAN //END OF METHOD A. KEGIATAN //END OF METHOD A. KEGIATAN

    //BEGINNING OF METHOD B. PENYULUHAN //BEGINNING OF METHOD B. PENYULUHAN
    public function getPenyuluhan($id)
    {
        $penyuluhan = Rencana::join('detail_pengabdian', 'rencana.id_rencana', '=', 'detail_pengabdian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pengabdian.jumlah_durasi', 'rencana.sks_terhitung', 'rencana.asesor1_frk', 'rencana.lampiran', 'rencana.asesor2_frk','rencana.flag_save_permananent')
            ->where('rencana.sub_rencana', 'penyuluhan')
            ->where('id_dosen', $id)
            ->get();

        return response()->json($penyuluhan, 200);
    }

    public function postPenyuluhan(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jumlah_durasi = $request->get('jumlah_durasi');

        $jumlah_jam = $jumlah_durasi;

        $sks_terhitung = ($jumlah_jam / 50);
        $sks_terhitung = min($sks_terhitung, 3);

        $rencana = Rencana::create([
            'jenis_rencana' => 'pengabdian',
            'sub_rencana' => 'penyuluhan',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => round($sks_terhitung, 2),
        ]);

        $detailPengabdian = DetailPengabdian::create([
            'id_rencana' => $rencana->id_rencana,
            'jumlah_durasi' => $jumlah_durasi
        ]);

        $res = [$rencana, $detailPengabdian];

        return response()->json($res, 201);
    }

    public function editPenyuluhan(Request $request)
    {
        $request->all();
        $id_rencana = $request->get('id_rencana');

        $rencana = Rencana::where('id_rencana', $id_rencana)->first();
        $detail_rencana = DetailPengabdian::where('id_rencana', $id_rencana)->first();
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jumlah_durasi = $request->get('jumlah_durasi');

        if ($nama_kegiatan != null && $nama_kegiatan != "") {
            $rencana->nama_kegiatan = $nama_kegiatan;
        } else {
            $detail_rencana->nama_kegiatan = $nama_kegiatan;
        }

        if ($jumlah_durasi == null || $jumlah_durasi == "") {
            $jumlah_durasi = $detail_rencana->jumlah_durasi;
        } else {
            $detail_rencana->jumlah_durasi = $jumlah_durasi;
        }

        $jumlah_jam = $jumlah_durasi;

        $sks_terhitung = ($jumlah_jam / 50);
        $sks_terhitung = min($sks_terhitung, 3);
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

    public function deletePenyuluhan($id)
    {
        $record = Rencana::where('id_rencana', $id);
        $detail_record = DetailPengabdian::where('id_rencana', $id);

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
    //END OF METHOD B. PENYULUHAN //END OF METHOD B. PENYULUHAN //END OF METHOD B. PENYULUHAN

    //BEGINNING OF METHOD C. KONSULTAN //BEGINNING OF METHOD C. KONSULTAN
    public function getKonsultan($id)
    {
        $konsultan = Rencana::join('detail_pengabdian', 'rencana.id_rencana', '=', 'detail_pengabdian.id_rencana')
        ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pengabdian.posisi', 'rencana.sks_terhitung', 'rencana.asesor1_frk', 'rencana.lampiran', 'rencana.asesor2_frk','rencana.flag_save_permananent')
           ->where('rencana.sub_rencana', 'konsultan')
           ->where('id_dosen', $id)
           ->get();

           return response()->json($konsultan, 200);
    }

    public function postKonsultan(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $posisi = $request->get('posisi');


        $bobot_pencapaian = 0;
        switch ($posisi){
            case "Ketua" :
                $bobot_pencapaian = 0.5;
                break;
            case "Anggota" :
                $bobot_pencapaian = 0.25;
                break;

            default:
            $bobot_pencapaian = 0;
            break;

        }
        $sks_terhitung = $bobot_pencapaian;

        $rencana = Rencana::create([
            'jenis_rencana' => 'pengabdian',
            'sub_rencana' => 'konsultan',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => round($sks_terhitung, 2),
        ]);
        $detailPengabdian = DetailPengabdian::create([
            'id_rencana' => $rencana->id_rencana,
            'posisi' => $posisi,
        ]);

        $res = [$rencana, $detailPengabdian];

        return response()->json($res, 201);

    }

    public function editKonsultan(Request $request)
    {
        $request->all();
        $id_rencana = $request->get('id_rencana');

        $rencana = Rencana::where('id_rencana', $id_rencana)->first();
        $detail_rencana = DetailPengabdian::where('id_rencana', $id_rencana)->first();
        $nama_kegiatan = $request->get('nama_kegiatan');
        $posisi = $request->get('posisi');

        if ($nama_kegiatan != null && $nama_kegiatan != "") {
            $rencana->nama_kegiatan = $nama_kegiatan;
        } else {
            $detail_rencana->nama_kegiatan = $nama_kegiatan;
        }


        if ($posisi == null || $posisi == "") {
            $posisi = $detail_rencana->posisi;
        } else {
            $detail_rencana->posisi = $posisi;
        }


        $bobot_pencapaian = 0;
        switch ($posisi){
            case "Ketua" :
                $bobot_pencapaian = 0.5;
                break;
            case "Anggota" :
                $bobot_pencapaian = 0.25;
                break;
            default:
            $bobot_pencapaian = 0;
            break;

        }
        $sks_terhitung = $bobot_pencapaian;
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

    public function deleteKonsultan($id)
        {
            $record = Rencana::where('id_rencana', $id);
            $detail_record = DetailPengabdian::where('id_rencana', $id);

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
    //END OF C. KONSULTAN //END OF C. KONSULTAN //END OF C. KONSULTAN //END OF C. KONSULTAN

    //BEGINNING OF METHOD D. KARYA //BEGINNING OF METHOD D. KARYA //BEGINNING OF METHOD D. KARYA
    public function getKarya($id)
    {
        $karya = Rencana::join('detail_pengabdian', 'rencana.id_rencana', '=', 'detail_pengabdian.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_pengabdian.jenis_terbit', 'detail_pengabdian.status_tahapan', 'detail_pengabdian.jenis_pengerjaan','detail_pengabdian.peran','detail_pengabdian.jumlah_anggota', 'rencana.sks_terhitung', 'rencana.asesor1_frk', 'rencana.lampiran', 'rencana.asesor2_frk','rencana.flag_save_permananent')
            ->where('rencana.sub_rencana', 'karya')
            ->where('id_dosen', $id)
            ->get();

        return response()->json($karya, 200);
    }

    public function postKarya(Request $request)
    {
        $id_dosen = $request->get('id_dosen');
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jenis_terbit = $request->get('jenis_terbit');
        $status_tahapan = $request->get('status_tahapan');
        $jenis_pengerjaan = $request->get('jenis_pengerjaan');
        $peran = $request->get('peran');
        $jumlah_anggota = (int)$request->get('jumlah_anggota');

        $bobot_pencapaian = 0;
        switch ($status_tahapan){
            case "Pendahuluan":
                $bobot_pencapaian = 0.25;
                break;
            case "50% dari isi buku":
                $bobot_pencapaian = 0.5;
                break;
            case "Buku jadi":
                if($jenis_terbit == "Menulis karya pengabdian yang dipakai sebagai Modul Pelatihan oleh seorang Dosen (Tidak diterbitkan, tetapi digunakan oleh siswa mahasiswa)"){
                    $bobot_pencapaian = 1;
                }else {
                    $bobot_pencapaian = 0.75;
                }
                break;
            case "Persetujuan Penerbit":
                $bobot_pencapaian = 0.85;
                break;
            case "Buku selesai dicetak":
                $bobot_pencapaian = 1;
                break;
            default:
                $bobot_pencapaian = 0;
                break;
        }

        $sks = 1;
        $bobot_peran = 0;
        $sks_terhitung = 0;
        if ($peran == "Penulis Utama") {
            $bobot_peran = 0.6;
        } elseif ($peran == "Penulis Lainnya") {
            $bobot_peran = 0.4*2/$jumlah_anggota;
        } elseif ($peran == "Editor") {
            $bobot_peran = 0.6*2;
        } elseif ($peran == "Kontributor") {
            $bobot_peran = 0.4;
        }

        if ($jenis_pengerjaan == "Mandiri"){
            $sks_terhitung = $bobot_pencapaian*$sks;
        }elseif ($jenis_pengerjaan == "Kelompok"){
            $sks_terhitung = $bobot_pencapaian*$bobot_peran*$sks;
        }

        $rencana = Rencana::create([
            'jenis_rencana' => 'pengabdian',
            'sub_rencana' => 'karya',
            'id_dosen' => $id_dosen,
            'nama_kegiatan' => $nama_kegiatan,
            'sks_terhitung' => round($sks_terhitung, 2),
        ]);

        $detailPengabdian = DetailPengabdian::create([
            'id_rencana' => $rencana->id_rencana,
            'jenis_terbit' => $jenis_terbit,
            'status_tahapan' => $status_tahapan,
            'jenis_pengerjaan' => $jenis_pengerjaan,
            'peran' => $peran,
            'jumlah_anggota' => $jumlah_anggota
        ]);

        $res = [$rencana, $detailPengabdian];

        return response()->json($res, 201);
    }

    public function editKarya(Request $request)
    {
        $request->all();
        $id_rencana = $request->get('id_rencana');

        $rencana = Rencana::where('id_rencana', $id_rencana)->first();
        $detail_rencana = DetailPengabdian::where('id_rencana', $id_rencana)->first();
        $nama_kegiatan = $request->get('nama_kegiatan');
        $jenis_terbit = $request->get('jenis_terbit');
        $status_tahapan = $request->get('status_tahapan');
        $jenis_pengerjaan = $request->get('jenis_pengerjaan');
        $peran = $request->get('peran');
        $jumlah_anggota = (int)$request->get('jumlah_anggota');

        if ($nama_kegiatan != null && $nama_kegiatan != "") {
            $rencana->nama_kegiatan = $nama_kegiatan;
        } else {
            $detail_rencana->nama_kegiatan = $nama_kegiatan;
        }

        if ($jenis_terbit == null || $jenis_terbit == "") {
            $jenis_terbit = $detail_rencana->jenis_terbit;
        } else {
            $detail_rencana->jenis_terbit = $jenis_terbit;
        }

        if ($status_tahapan == null || $status_tahapan == "") {
            $status_tahapan = $detail_rencana->status_tahapan;
        } else {
            $detail_rencana->status_tahapan = $status_tahapan;
        }

        if ($jenis_pengerjaan == null || $jenis_pengerjaan == "") {
            $jenis_pengerjaan = $detail_rencana->jenis_pengerjaan;
        } else {
            $detail_rencana->jenis_pengerjaan = $jenis_pengerjaan;
        }

        if ($peran == null || $peran == "") {
            $peran = $detail_rencana->peran;
        } else {
            $detail_rencana->peran = $peran;
        }

        if ($jumlah_anggota == null || $jumlah_anggota == "") {
            $jumlah_anggota = $detail_rencana->jumlah_anggota;
        } else {
            $detail_rencana->jumlah_anggota = $jumlah_anggota;
        }

        $bobot_pencapaian = 0;
        switch ($status_tahapan){
            case "Pendahuluan":
                $bobot_pencapaian = 0.25;
                break;
            case "50% dari isi buku":
                $bobot_pencapaian = 0.5;
                break;
            case "Buku jadi":
                if($jenis_terbit == "Menulis karya pengabdian yang dipakai sebagai Modul Pelatihan oleh seorang Dosen (Tidak diterbitkan, tetapi digunakan oleh siswa mahasiswa)"){
                    $bobot_pencapaian = 1;
                }else {
                    $bobot_pencapaian = 0.75;
                }
                break;
            case "Persetujuan penerbit":
                $bobot_pencapaian = 0.85;
                break;
            case "Buku selesai dicetak":
                $bobot_pencapaian = 1;
                break;
            default:
                $bobot_pencapaian = 0;
                break;
        }

        $sks = 1;
        $bobot_peran = 0;
        $sks_terhitung = 0;
        if ($peran == "Penulis Utama") {
            $bobot_peran = 0.6;
        } elseif ($peran == "Penulis Lain") {
            $bobot_peran = 0.4*2/$jumlah_anggota;
        } elseif ($peran == "Editor") {
            $bobot_peran = 0.6*2;
        } elseif ($peran == "Kontributor") {
            $bobot_peran = 0.4;
        }

        if ($jenis_pengerjaan == "Mandiri"){
            $sks_terhitung = $bobot_pencapaian*$sks;
        }elseif ($jenis_pengerjaan == "Kelompok"){
            $sks_terhitung = $bobot_pencapaian*$bobot_peran*$sks;
        }

        $sks_terhitung = $bobot_pencapaian*$sks;

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

    public function deleteKarya($id)
    {
        $record = Rencana::where('id_rencana', $id);
        $detail_record = DetailPengabdian::where('id_rencana', $id);

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
    //END OF METHOD D. KARYA //END OF METHOD D. KARYA //END OF METHOD D. KARYA //END OF METHOD D. KARYA
}
