<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\AuthController;
use App\Http\Controllers\pendidikan_controller;
use App\Http\Controllers\penunjang_controller;
use App\Http\Controllers\PenelitianController;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {
    //PENDIDIKAN START
    $router->get('/pendidikan', 'pendidikan_controller@getAll');

    //START ROUTE FOR PENDIDIKAN
    $router->group(['prefix' => 'pendidikan'], function () use ($router) {
        //teori
        $router->get('/teori/{id}', 'pendidikan_controller@getTeori');
        $router->post('/teori', 'pendidikan_controller@postTeori');
        $router->delete('/teori/{id}', 'pendidikan_controller@deleteTeori');
        $router->post('/edit/teori', 'pendidikan_controller@editTeori');

        //praktikum
        $router->get('/praktikum/{id}', 'pendidikan_controller@getPraktikum');
        $router->post('/praktikum', 'pendidikan_controller@postPraktikum');
        $router->delete('/praktikum/{id}', 'pendidikan_controller@deletePraktikum');
        $router->post('/edit/praktikum', 'pendidikan_controller@editPraktikum');

        //bimbingan
        $router->get('/bimbingan/{id}', 'pendidikan_controller@getBimbingan');
        $router->post('/bimbingan', 'pendidikan_controller@postBimbingan');
        $router->delete('/bimbingan/{id}', 'pendidikan_controller@deleteBimbingan');
        $router->post('/edit/bimbingan', 'pendidikan_controller@editBimbingan');

        //seminar
        $router->get('/seminar/{id}', 'pendidikan_controller@getSeminar');
        $router->post('/seminar', 'pendidikan_controller@postSeminar');
        $router->delete('/seminar/{id}', 'pendidikan_controller@deleteSeminar');
        $router->post('/edit/seminar', 'pendidikan_controller@editSeminar');

        //Tugas Akhir
        $router->get('/tugasAkhir/{id}', 'pendidikan_controller@getTugasAkhir');
        $router->post('/tugasAkhir', 'pendidikan_controller@postTugasAkhir');
        $router->post('/edit/tugasAkhir', 'pendidikan_controller@editTugasAkhir');
        $router->delete('/tugasAkhir/{id}', 'pendidikan_controller@deleteTugasAkhir');

        //Proposal
        $router->get('/proposal/{id}', 'pendidikan_controller@getProposal');
        $router->post('/proposal', 'pendidikan_controller@postProposal');
        $router->delete('/proposal/{id}', 'pendidikan_controller@deleteProposal');
        $router->post('/edit/proposal', 'pendidikan_controller@editProposal');

        // rendah
        $router->get('/rendah/{id}', 'pendidikan_controller@getRendah');
        $router->post('/rendah', 'pendidikan_controller@postRendah');
        $router->delete('/rendah/{id}', 'pendidikan_controller@deleteRendah');
        $router->post('/edit/rendah', 'pendidikan_controller@editRendah');

        // Kembang
        $router->get('/kembang/{id}', 'pendidikan_controller@getKembang');
        $router->post('/kembang', 'pendidikan_controller@postKembang');
        $router->delete('/kembang/{id}', 'pendidikan_controller@deleteKembang');
        $router->post('/edit/kembang', 'pendidikan_controller@editKembang');

        // CANGKOK
        $router->get('/cangkok/{id}', 'pendidikan_controller@getCangkok');
        $router->post('/cangkok', 'pendidikan_controller@postCangkok');
        $router->delete('/cangkok/{id}', 'pendidikan_controller@deleteCangkok');
        $router->post('/edit/cangkok/{id}', 'pendidikan_controller@editCangkok');

        //KOORDINATOR
        $router->get('/koordinator/{id}', 'pendidikan_controller@getKoordinator');
        $router->post('/koordinator', 'pendidikan_controller@postKoordinator');
        $router->delete('/koordinator/{id}', 'pendidikan_controller@deleteKoordinator');
        $router->post('/edit/koordinator', 'pendidikan_controller@editKoordinator');
    });
    //END ROUTE FOR PENDIDIKAN

    //START ROUTE FOR PENELITIAN
    $router->group(['prefix' => 'penelitian'], function () use ($router) {
        //A. Penelitian kelompok
        $router->get('/penelitian_kelompok/{id}', 'PenelitianController@getPenelitianKelompok');
        $router->post('/penelitian_kelompok', 'PenelitianController@postPenelitianKelompok');
        $router->delete('/penelitian_kelompok/{id}', 'PenelitianController@deletePenelitianKelompok');
        $router->post('/edit/penelitian_kelompok', 'PenelitianController@editPenelitianKelompok');

        //B. Penelitian mandiri
        $router->get('/penelitian_mandiri/{id}', 'PenelitianController@getPenelitianMandiri');
        $router->post('/penelitian_mandiri', 'PenelitianController@postPenelitianMandiri');
        $router->delete('/penelitian_mandiri/{id}', 'PenelitianController@deletePenelitianMandiri');
        $router->post('/edit/penelitian_mandiri', 'PenelitianController@editPenelitianMandiri');

        //C. Buku Terbit
        $router->get('/buku_terbit/{id}', 'PenelitianController@getBukuTerbit');
        $router->post('/buku_terbit', 'PenelitianController@postBukuTerbit');
        $router->delete('/buku_terbit/{id}', 'PenelitianController@deleteBukuTerbit');
        $router->post('/edit/buku_terbit', 'PenelitianController@editBukuTerbit');

        //D. Buku Internasional
        $router->get('/buku_internasional/{id}', 'PenelitianController@getBukuInternasional');
        $router->post('/buku_internasional', 'PenelitianController@postBukuInternasional');
        $router->delete('/buku_internasional/{id}', 'PenelitianController@deleteBukuInternasional');
        $router->post('/edit/buku_internasional', 'PenelitianController@editBukuInternasional');

        //E. Menyadur naskah buku
        $router->get('/menyadur/{id}', 'PenelitianController@getMenyadur');
        $router->post('/menyadur', 'PenelitianController@postMenyadur');
        $router->delete('/menyadur/{id}', 'PenelitianController@deleteMenyadur');
        $router->post('/edit/menyadur', 'PenelitianController@editMenyadur');

        //F. Menyunting naskah buku
        $router->get('/menyunting/{id}', 'PenelitianController@getMenyunting');
        $router->post('/menyunting', 'PenelitianController@postMenyunting');
        $router->delete('/menyunting/{id}', 'PenelitianController@deleteMenyunting');
        $router->post('/edit/menyunting', 'PenelitianController@editMenyunting');

        //G. penelitian modul
        $router->get('/penelitian_modul/{id}', 'PenelitianController@getPenelitianModul');
        $router->post('/penelitian_modul', 'PenelitianController@postPenelitianModul');
        $router->delete('/penelitian_modul/{id}', 'PenelitianController@deletePenelitianModul');
        $router->post('/edit/penelitian_modul', 'PenelitianController@editPenelitianModul');

        //H. penelitian pekerti
        $router->get('/penelitian_pekerti/{id}', 'PenelitianController@getPenelitianPekerti');
        $router->post('/penelitian_pekerti', 'PenelitianController@postPenelitianPekerti');
        $router->delete('/penelitian_pekerti/{id}', 'PenelitianController@deletePenelitianPekerti');
        $router->post('/edit/penelitian_pekerti', 'PenelitianController@editPenelitianPekerti');

        // I. Pelaksanaa Tridharma
        $router->get('/penelitian_tridharma/{id}', 'PenelitianController@getPenelitianTridharma');
        $router->post('/penelitian_tridharma', 'PenelitianController@postPenelitianTridharma');
        $router->delete('/penelitian_tridharma/{id}', 'PenelitianController@deletePenelitianTridharma');
        $router->post('/edit/penelitian_tridharma', 'PenelitianController@editPenelitianTridharma');

        // J. Menulis Jurnal ilmiah
        $router->get('/jurnal_ilmiah/{id}', 'PenelitianController@getJurnalIlmiah');
        $router->post('/jurnal_ilmiah', 'PenelitianController@postJurnalIlmiah');
        $router->delete('/jurnal_ilmiah/{id}', 'PenelitianController@deleteJurnalIlmiah');
        $router->post('/edit/jurnal_ilmiah', 'PenelitianController@editJurnalIlmiah');

        //M. Pembicara Seminar
        $router->get('/pembicara_seminar/{id}', 'PenelitianController@getPembicaraSeminar');
        $router->post('/pembicara_seminar', 'PenelitianController@postPembicaraSeminar');
        $router->delete('/pembicara_seminar/{id}', 'PenelitianController@deletePembicarSeminar');
        $router->post('/edit/pembicara_seminar', 'PenelitianControllerr@editPembicaraSeminar');

        //N. Penyajian Makalah
        $router->get('/penyajian_makalah/{id}', 'PenelitianController@getPenyajianMakalah');
        $router->post('/penyajian_makalah', 'PenelitianController@postPenyajianMakalah');
        $router->delete('/penyajian_makalah/{id}', 'PenelitianController@deletePenyajianMakalah');
        $router->post('/edit/penyajian_makalah', 'PenelitianControllerr@editPenyajianMakalah');

        //K. Hak Paten
        $router->get('/hak_paten/{id}', 'PenelitianController@getHakPaten');
        $router->post('/hak_paten', 'PenelitianController@postHakPaten');
        $router->delete('/hak_paten/{id}', 'PenelitianController@deleteHakPaten');
        $router->post('/edit/hak_paten', 'PenelitianController@editHakPaten');

        //L. Media Massa
        $router->get('/media_massa/{id}', 'PenelitianController@getMediaMassa');
        $router->post('/media_massa', 'PenelitianController@postMediaMassa');
        $router->delete('/media_massa/{id}', 'PenelitianController@deleteMediaMassa');
        $router->post('/edit/media_massa', 'PenelitianController@editMediaMassa');

        //M. Pembaca Seminar
        $router->get('/pembicara_seminar/{id}', 'PenelitianController@getPembicaraSeminar');
        $router->post('/pembicara_seminar', 'PenelitianController@postPembicaraSeminar');
        $router->delete('/pembicara_seminar/{id}', 'PenelitianController@deletePembicaraSeminar');
        $router->post('/edit/pembicara_seminar', 'PenelitianController@editPembicaraSeminar');

        //N. Penyajian Makalah
        $router->get('/penyajian_makalah/{id}', 'PenelitianController@getPenyajianMakalah');
        $router->post('/penyajian_makalah', 'PenelitianController@postPenyajianMakalah');
        $router->delete('/penyajian_makalah/{id}', 'PenelitianController@deletePenyajianMakalah');
        $router->post('/edit/penyajian_makalah', 'PenelitianController@editPenyajianMakalah');
    });
    //END ROUTE FOR PENELITIAN

    //START ROUTE FOR PENGABDIAN
    $router->group(['prefix' => 'pengabdian'], function () use ($router) {
        // Bagian A
        $router->get('/kegiatan/{id}', 'PengabdianController@getKegiatan');
        $router->post('/kegiatan', 'PengabdianController@postKegiatan');
        $router->post('/edit/kegiatan', 'PengabdianController@editKegiatan');
        $router->delete('/kegiatan/{id}', 'PengabdianController@deleteKegiatan');
        // END OF BAGIAN A

        //BAGIAN B
        $router->get('/penyuluhan/{id}', 'PengabdianController@getPenyuluhan');
        $router->post('/penyuluhan', 'PengabdianController@postPenyuluhan');
        $router->post('/edit/penyuluhan', 'PengabdianController@editPenyuluhan');
        $router->delete('/penyuluhan/{id}', 'PengabdianController@deletePenyuluhan');
        //END OF BAGIAN B

        //BAGIAN C
        $router->get('/konsultan/{id}', 'PengabdianController@getKonsultan');
        $router->post('/konsultan', 'PengabdianController@postKonsultan');
        $router->post('/edit/konsultan', 'PengabdianController@editKonsultan');
        $router->delete('/konsultan/{id}', 'PengabdianController@deleteKonsultan');
        //END OF BAGIAN C

        //BAGIAN D
        $router->get('/karya/{id}', 'PengabdianController@getKarya');
        $router->post('/karya', 'PengabdianController@postKarya');
        $router->post('/edit/karya', 'PengabdianController@editKarya');
        $router->delete('/karya/{id}', 'PengabdianController@deleteKarya');
        //END OF BAGIAN D

    });
    //END OF ROUTE FOR PENGABDIAN

    //START ROUTE FOR PENUNJANG
    $router->group(['prefix' => 'penunjang'], function () use ($router) {
        // Bagian A
        $router->get('/akademik/{id}', 'penunjang_controller@getAkademik');
        $router->post('/akademik', 'penunjang_controller@postAkademik');
        $router->post('/edit/akademik', 'penunjang_controller@editAkademik');
        $router->delete('/akademik/{id}', 'penunjang_controller@deleteAkademik');
        // END OF BAGIAN A

        //BAGIAN B
        $router->get('/bimbingan/{id}', 'penunjang_controller@getBimbingan');
        $router->post('/bimbingan', 'penunjang_controller@postBimbingan');
        $router->post('/edit/bimbingan', 'penunjang_controller@editBimbingan');
        $router->delete('/bimbingan/{id}', 'penunjang_controller@deleteBimbingan');
        //END OF BAGIAN B

        //BAGIAN C
        $router->get('/ukm/{id}', 'penunjang_controller@getUkm');
        $router->post('/ukm', 'penunjang_controller@postUkm');
        $router->post('/edit/ukm/', 'penunjang_controller@editUkm');
        $router->delete('/ukm/{id}', 'penunjang_controller@deleteUkm');
        //END OF BAGIAN C

        //BAGIAN D
        $router->get('/sosial/{id}', 'penunjang_controller@getSosial');
        $router->post('/sosial', 'penunjang_controller@postSosial');
        $router->post('/edit/sosial/', 'penunjang_controller@editSosial');
        $router->delete('/sosial/{id}', 'penunjang_controller@deleteSosial');
        //END OF BAGIAN D

        // BAGIAN E
        $router->get('/struktural/{id}', 'penunjang_controller@getStruktural');
        $router->post('/struktural', 'penunjang_controller@postStruktural');
        $router->post('/edit/struktural/', 'penunjang_controller@editStruktural');
        $router->delete('/struktural/{id}', 'penunjang_controller@deleteStruktural');
        // END OF BAGIAN E

        // BAGIAN F
        $router->get('/nonstruktural/{id}', 'penunjang_controller@getNonstruktural');
        $router->post('/nonstruktural', 'penunjang_controller@postNonstruktural');
        $router->post('/edit/nonstruktural/', 'penunjang_controller@editNonstruktural');
        $router->delete('/nonstruktural/{id}', 'penunjang_controller@deleteNonstruktural');
        // END OF BAGIAN F

        // BAGIAN G
        $router->get('/redaksi/{id}', 'penunjang_controller@getRedaksi');
        $router->post('/redaksi', 'penunjang_controller@postRedaksi');
        $router->post('/edit/redaksi/', 'penunjang_controller@editRedaksi');
        $router->delete('/redaksi/{id}', 'penunjang_controller@deleteRedaksi');
        // END OF BAGIAN G

        // BAGIAN H
        $router->get('/adhoc/{id}', 'penunjang_controller@getAdhoc');
        $router->post('/adhoc', 'penunjang_controller@postAdhoc');
        $router->post('/edit/adhoc/', 'penunjang_controller@editAdhoc');
        $router->delete('/adhoc/{id}', 'penunjang_controller@deleteAdhoc');
        // END OF BAGIAN H

        // BAGIAN I
        $router->get('/ketuapanitia/{id}', 'penunjang_controller@getKetuaPanitia');
        $router->post('/ketuapanitia', 'penunjang_controller@postKetuaPanitia');
        $router->post('/edit/ketuapanitia', 'penunjang_controller@editKetuaPanitia');
        $router->delete('/ketuapanitia/{id}', 'penunjang_controller@deleteKetuaPanitia');

        // BAGIAN J
        $router->get('/anggotapanitia/{id}', 'penunjang_controller@getAnggotaPanitia');
        $router->post('/anggotapanitia', 'penunjang_controller@postAnggotaPanitia');
        $router->post('/edit/anggotapanitia', 'penunjang_controller@editAnggotaPanitia');
        $router->delete('/anggotapanitia/{id}', 'penunjang_controller@deleteAnggotaPanitia');

        // BAGIAN K
        $router->get('/pengurusyayasan/{id}', 'penunjang_controller@getPengurusYayasan');
        $router->post('/pengurusyayasan', 'penunjang_controller@postPengurusYayasan');
        $router->post('/edit/pengurusyayasan', 'penunjang_controller@editPengurusYayasan');
        $router->delete('/pengurusyayasan/{id}', 'penunjang_controller@deletePengurusYayasan');

        //BAGIAN L
        $router->get('/asosiasi/{id}', 'penunjang_controller@getAsosiasi');
        $router->post('/asosiasi', 'penunjang_controller@postAsosiasi');
        $router->post('/edit/asosiasi', 'penunjang_controller@editAsosiasi');
        $router->delete('/asosiasi/{id}', 'penunjang_controller@deleteAsosiasi');
        //END OF BAGIAN L


        //BAGIAN M
        $router->get('/seminar/{id}', 'penunjang_controller@getSeminar');
        $router->post('/seminar', 'penunjang_controller@postSeminar');
        $router->post('/edit/seminar', 'penunjang_controller@editSeminar');
        $router->delete('/seminar/{id}', 'penunjang_controller@deleteSeminar');
        //END OF BAGIAN M


        //BAGIAN N
        $router->get('/reviewer/{id}', 'penunjang_controller@getReviewer');
        $router->post('/reviewer', 'penunjang_controller@postReviewer');
        $router->post('/edit/reviewer', 'penunjang_controller@editReviewer');
        $router->delete('/reviewer/{id}', 'penunjang_controller@deleteReviewer');
        //END OF BAGIAN N
    });
    //END OF ROUTE FOR PENUNJANG

    // START OF ROUTE SIMPULAN FRK
    $router->get('/simpulan/{id}', 'simpulanController@getAll');
    $router->get('/simpulan-pendidikan', 'simpulanController@getSksPendidikan');
    $router->get('/simpulan-penelitian', 'simpulanController@getSksPenelitian');
    $router->get('/simpulan-pengabdian', 'simpulanController@getSksPengabdian');
    $router->get('/simpulan-penunjang', 'simpulanController@getSksPenunjang');
    $router->get('/simpulan-total', 'simpulanController@getTotalSks');
    $router->post('/simpulan-simpan-rencana/{id}', 'simpulanController@simpanRencana');

    // START OF ROUTE ASESOR FRK
    $router->group(['prefix' => 'asesor-frk'], function () use ($router) {
        $router->get('/getAllDosen', 'AsesorController@getAllDosen');
        $router->post('/reviewRencana', 'AsesorController@reviewRencana');
    });
});
