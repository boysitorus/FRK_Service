<?php

namespace App\Http\Controllers;

use App\Models\Rencana;
use Illuminate\Http\Request;

class AsesorController extends Controller
{
    public function getAllDosen()
    {
        try {
            $res = Rencana::where('flag_save_permananent', 1)
                ->select('id_dosen')
                ->distinct()
                ->get();
            return response()->json($res, 200);
        } catch (\Throwable $th) {
            return response()->json($res, 400);
        }
    }

    public function reviewRencana(Request $request){
        $id_rencana = $request->get('id_rencana');
        $komentar = $request->get('komentar');

        $rencana = Rencana::where('id_rencana', $id_rencana)->first();

        $rencana->asesor1_frk = $komentar;

        $res = [
            "rencana" => $rencana,
            "message" => "Successfully give approval for frk"
        ];

        $rencana->save();

        return response()->json($res, 200);
    }

}
