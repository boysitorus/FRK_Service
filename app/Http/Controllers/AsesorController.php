<?php

namespace App\Http\Controllers;

use App\Models\Rencana;
use Illuminate\Http\Request;

class AsesorController extends Controller
{
    public function getAllDosen()
    {
        try {
//            $res = Rencana::where('flag_save_permananent', 1)
//                ->select('id_dosen')
//                ->distinct()
//                ->get();
            $res = Rencana::select('id_dosen')
                ->distinct()
                ->get();

            return response()->json($res, 200);
        } catch (\Throwable $th) {
            return response()->json($res, 400);
        }
    }

    public function getAllCompleteDosen($role)
    {
        try {
            if ($role == 'asesor1') {
                $condition = 'COUNT(*) = SUM(CASE WHEN asesor1_frk = "setuju" THEN 1 ELSE 0 END)';
            } else {
                $condition = 'COUNT(*) = SUM(CASE WHEN asesor2_frk = "setuju" THEN 1 ELSE 0 END)';
            }
            $res = Rencana::select('id_dosen')
                ->groupBy('id_dosen')
                ->havingRaw($condition)
                ->pluck('id_dosen');

            return response()->json($res, 200);
        } catch (\Throwable $th) {
            return response()->json($res, 400);
        }
    }

    public function reviewRencana(Request $request)
    {
        $id_rencana = $request->get('id_rencana');
        $komentar = $request->get('komentar');
        $role = $request->get('role');
        $rencana = Rencana::where('id_rencana', $id_rencana)->first();

        if ($role == '1') {
            $rencana->asesor1_frk = $komentar;
        } else if ($role == '2') {
            $rencana->asesor2_frk = $komentar;
        }

        $res = [
            "rencana" => $rencana,
            "message" => "Successfully give approval for frk"
        ];

        $rencana->save();

        return response()->json($res, 200);
    }
}
