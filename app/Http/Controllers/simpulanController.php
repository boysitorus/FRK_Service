<?php

namespace App\Http\Controllers;

use App\Models\Rencana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class SimpulanController extends Controller
{
    public function getAll($id)
    {
        try {
            $totalSksPendidikan = Rencana::where('id_dosen', $id)->where("jenis_rencana", "pendidikan")->sum("sks_terhitung");
            $totalSksPenelitian = Rencana::where('id_dosen', $id)->where("jenis_rencana", "penelitian")->sum("sks_terhitung");
            $totalSksPengabdian = Rencana::where('id_dosen', $id)->where("jenis_rencana", "pengabdian")->sum("sks_terhitung");
            $totalSksPenunjang = Rencana::where('id_dosen', $id)->where("jenis_rencana", "penunjang")->sum("sks_terhitung");
            $sksTotal = $totalSksPendidikan + $totalSksPenelitian + $totalSksPengabdian + $totalSksPenunjang;

            $res = [
                "sks_pendidikan" => $totalSksPendidikan,
                "sks_penelitian" => $totalSksPenelitian,
                "sks_pengabdian" => $totalSksPengabdian,
                "sks_penunjang" => $totalSksPenunjang,
                "sks_total" => $sksTotal
            ];

            return response()->json($res, 200);

        } catch(\Throwable $th) {
            return response()->json(['error' => 'Failed to retrieve data from database'], 500);
        }
    }

    public function getSksPendidikan()
    {
        $totalSksPendidikan = Rencana::join('detail_pendidikan', 'rencana.id_rencana', '=', 'detail_pendidikan.id_rencana')
            ->where('rencana.jenis_rencana', 'pendidikan')
            ->sum('rencana.sks_terhitung');

        return response()->json($totalSksPendidikan, 200);
    }

    public function getSksPenelitian()
    {
        $totalSksPenelitian = Rencana::join('detail_penelitian', 'rencana.id_rencana', '=', 'detail_penelitian.id_rencana')
        ->where('rencana.jenis_rencana', 'penelitian')
        ->sum('rencana.sks_terhitung');

        return response()->json($totalSksPenelitian, 200);
    }

    public function getSksPengabdian()
    {
        $totalSksPengabdian = Rencana::join('detail_pengabdian', 'rencana.id_rencana', '=', 'detail_pengabdian.id_rencana')
        ->where('rencana.jenis_rencana', 'pengabdian')
        ->sum('rencana.sks_terhitung');

        return response()->json($totalSksPengabdian, 200);
    }

    public function getSksPenunjang()
    {
        $totalSksPenunjang = Rencana::join('detail_penunjang', 'rencana.id_rencana', '=', 'detail_penunjang.id_rencana')
        ->where('rencana.jenis_rencana', 'penunjang')
        ->sum('rencana.sks_terhitung');

        return response()->json($totalSksPenunjang, 200);
    }

    public function getTotalSks()
    {
        $totalSks = Rencana::sum('sks_terhitung');

        return response()->json($totalSks, 200);
    }

    public function simpanRencana($id) //tambahkan 1 params lagi ketika function generate FRK telah dibuat, $id_frk
    {
        try {
            $pendidikan = Rencana::where("id_dosen", $id)->where("jenis_rencana", "pendidikan")->sum("sks_terhitung");
            $penelitian = Rencana::where("id_dosen", $id)->where("jenis_rencana", "penelitian")->sum("sks_terhitung");
            $pengabdian = Rencana::where("id_dosen", $id)->where("jenis_rencana", "pengabdian")->sum("sks_terhitung");
            $penunjang = Rencana::where("id_dosen", $id)->where("jenis_rencana", "penunjang")->sum("sks_terhitung");
            if ($pendidikan == 0 || $penelitian == 0 || $pengabdian == 0 || $penunjang == 0) {
                return response()->json(["message" => "Jumlah rencana tidak memenuhi"], 500);
            } else {
                Rencana::where('id_dosen', $id)->update(['flag_save_permananent' => true]);
                return response()->json(['message' => 'Berhasil menyimpan Rencana Kerja'], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Gagal menyimpan rencana kerja'], 500);
        }
    }
}
