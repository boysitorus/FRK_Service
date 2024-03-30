<?php

namespace App\Http\Controllers;

use App\Models\DetailPenunjang;
use Illuminate\Http\Request;

class penunjang_controller extends Controller
{

    public function getAll()
    {
        // BAGIAN L
        $asosiasi = DetailPenunjang::join('detail_penunjang', 'rencana.id_rencana', '=', 'detail_penunjang.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'profesi')
            ->get();

        //BAGIAN M
        $seminar = DetailPenunjang::join('detail_penunjang', 'rencana.id_rencana', '=', 'detail_penunjang.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'peserta')
            ->get();

        //BAGIAN N
        $reviewer = DetailPenunjang::join('detail_penunjang', 'rencana.id_rencana', '=', 'detail_penunjang.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'reviewer')
            ->get();

        // Kembalikan data dalam bentuk yang sesuai untuk ditampilkan di halaman
        return response()->json([
            'asosiasi' => $asosiasi,
            'seminar' => $seminar,
            'reviewer' => $reviewer
        ], 200);
    }
    

    //Handler A. Bimbingan Akademik
    public function getAkademik(){}
    public function postAkademik(Request $request){}
    public function editAkademik(Request $request){}
    public function deleteAkademik($id){}


    //Handler B. Bimbingan dan Konseling
    public function getBimbingan(){}
    public function postBimbingan(Request $request){}
    public function editBimbingan(Request $request){}
    public function deleteBimbingan($id){}

    //Handler C. Pimpinan Pembinaan UKM
    public function getUkm(){}
    public function postUkm(Request $request){}
    public function editUkm(Request $request){}
    public function deleteUkm($id){}

    //Handler D. Pimpinan organisasi sosial intern
    public function getSosial(){}
    public function postSosial(Request $request){}
    public function editSosial(Request $request){}
    public function deleteSosial($id){}

    //Handler E. Jabatan Struktural
    public function getStruktural(){}
    public function postStruktural(Request $request){}
    public function editStruktural(Request $request){}
    public function deleteStruktural($id){}

    //Handler F. Jabatan non struktural
    public function getNonStruktural(){}
    public function postNonStruktural(Request $request){}
    public function editNonStruktural(Request $request){}
    public function deleteNonStruktural($id){}

    //Handler G. Ketua Redaksi Jurnal
    public function getJurnal(){}
    public function postJurnal(Request $request){}
    public function editJurnal(Request $request){}
    public function deleteJurnal($id){}

    //Handler H. Ketua Panitia Ad Hoc
    public function getAdHoc(){}
    public function postAdHoc(Request $request){}
    public function editAdHoc(Request $request){}
    public function deleteAdHoc($id){}

    //Handler I. Ketua Panitia Tetap
    public function getKetuaPanitia(){}
    public function postKetuaPanitia(Request $request){}
    public function editKetuaPanitia(Request $request){}
    public function deleteKetuaPanitia($id){}

    //Handler J. Anggota Panitia Tetap
    public function getAnggotaPanitia(){}
    public function postAnggotaPanitia(Request $request){}
    public function editAnggotaPanitia(Request $request){}
    public function deleteAnggotaPanitia($id){}

    //Handler K. Menjadi Pengurus Yayasan
    public function getPengurusYayasan(){}
    public function postPengurusYayasan(Request $request){}
    public function editPengurusYayasan(Request $request){}
    public function deletePengurusYayasan($id){}

    //Handler L. Menjadi Pengurus/Anggota Asosiasi Profesi
    public function getAsosiasi(){
        $asosiasi = DetailPenunjang::join('detail_penunjang', 'rencana.id_rencana', '=', 'detail_penunjang.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penunjang.jenis_jabatan_struktural', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'asosiasi')
            ->get();

        return response()->json($asosiasi, 200);
    }
    public function postAsosiasi(Request $request){}
    public function editAsosiasi(Request $request){}
    public function deleteAsosiasi($id){}

    //Handler M. Peserta seminar/workshop/kursus berdasar penugasan pimpinan
    public function getSeminar(){
        $seminar = DetailPenunjang::join('detail_penunjang', 'rencana.id_rencana', '=', 'detail_penunjang.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'detail_penunjang.jenis_tingkatan', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'seminar')
            ->get();

        return response()->json($seminar, 200);
    }
    public function postSeminar(Request $request){}
    public function editSeminar(Request $request){}
    public function deleteSeminar($id){}

    //Handler N. Reviewer jurnal ilmiah , proposal Hibah dll
    public function getReviewer(){
        $reviewer = DetailPenunjang ::join('detail_penunjang', 'rencana.id_rencana', '=', 'detail_penunjang.id_rencana')
            ->select('rencana.id_rencana', 'rencana.nama_kegiatan', 'rencana.sks_terhitung')
            ->where('rencana.sub_rencana', 'reviewer')
            ->get();
        return response()->json($reviewer, 200);
    }
    public function postReviewer(Request $request)
    {
        
    }
    public function editReviewer(Request $request){}
    public function deleteReviewer($id){}
}
