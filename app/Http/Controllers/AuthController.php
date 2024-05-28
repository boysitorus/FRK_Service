<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    //

    public function index()
    {
        $data_dosen = [
            "username" => "wilona.divaa",
		    "password" => "testing123",
		    "nama" => "Wilona Diva Artha Simbolon",
		    "nik" => 1234567890,
		    "fakultas" => "Informatika dan Teknik Elektro",
		    "prodi" => "S1 Informatika",
		    "jabatan" => "Dosen"
        ];

        return response()->json($data_dosen, 200);
    }
}
