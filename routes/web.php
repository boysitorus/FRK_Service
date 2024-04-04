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
    //teori
    $router->get('/pendidikan/teori', 'pendidikan_controller@getTeori');
    $router->post('/pendidikan/teori', 'pendidikan_controller@postTeori');
    $router->delete('/pendidikan/teori/{id}', 'pendidikan_controller@deleteTeori');
    $router->post('/pendidikan/edit/teori', 'pendidikan_controller@editTeori');

    //praktikum
    $router->get('/pendidikan/praktikum', 'pendidikan_controller@getPraktikum');
    $router->post('/pendidikan/praktikum', 'pendidikan_controller@postPraktikum');
    $router->delete('/pendidikan/praktikum/{id}', 'pendidikan_controller@deletePraktikum');
    $router->post('/pendidikan/edit/praktikum', 'pendidikan_controller@editPraktikum');

    //bimbingan
    $router->get('/pendidikan/bimbingan', 'pendidikan_controller@getBimbingan');
    $router->post('/pendidikan/bimbingan', 'pendidikan_controller@postBimbingan');
    $router->delete('/pendidikan/bimbingan/{id}', 'pendidikan_controller@deleteBimbingan');
    $router->post('/pendidikan/edit/bimbingan', 'pendidikan_controller@editBimbingan');

    //seminar
    $router->get('/pendidikan/seminar', 'pendidikan_controller@getSeminar');
    $router->post('/pendidikan/seminar', 'pendidikan_controller@postSeminar');
    $router->delete('/pendidikan/seminar/{id}', 'pendidikan_controller@deleteSeminar');
    $router->post('/pendidikan/edit/seminar', 'pendidikan_controller@editSeminar');

     //Tugas Akhir
    $router->get('/pendidikan/tugasAkhir', 'pendidikan_controller@getTugasAkhir');
    $router->post('/pendidikan/tugasAkhir', 'pendidikan_controller@postTugasAkhir');
    $router->post('/pendidikan/editTugasAkhir', 'pendidikan_controller@editTugasAkhir');
    $router->delete('/pendidikan/tugasAkhir/{id}', 'pendidikan_controller@deleteTugasAkhir');
    $router->get('/pendidikan/tugasAkhir', 'pendidikan_controller@getTugasAkhir');
    $router->post('/pendidikan/tugasAkhir', 'pendidikan_controller@postTugasAkhir');
    $router->delete('/pendidikan/tugasAkhir/{id}', 'pendidikan_controller@deleteTugasAkhir');
    $router->post('/pendidikan/edit/tugasAkhir', 'pendidikan_controller@editTugasAkhir');

     //Proposal
    $router->get('/pendidikan/proposal', 'pendidikan_controller@getProposal');
    $router->post('/pendidikan/proposal', 'pendidikan_controller@postProposal');
    $router->delete('/pendidikan/proposal/{id}', 'pendidikan_controller@deleteProposal');
    $router->post('/pendidikan/edit/proposal', 'pendidikan_controller@editProposal');

    // rendah
    $router->get('/pendidikan/rendah', 'pendidikan_controller@getRendah');
    $router->post('/pendidikan/rendah', 'pendidikan_controller@postRendah');
    $router->delete('/pendidikan/rendah/{id}', 'pendidikan_controller@deleteRendah');
    $router->post('/pendidikan/edit/rendah', 'pendidikan_controller@editRendah');

    // Kembang
    $router->get('/pendidikan/kembang', 'pendidikan_controller@getKembang');
    $router->post('/pendidikan/kembang', 'pendidikan_controller@postKembang');
    $router->delete('/pendidikan/kembang/{id}', 'pendidikan_controller@deleteKembang');
    $router->post('/pendidikan/edit/kembang', 'pendidikan_controller@editKembang');

    // CANGKOK
    $router->get('/pendidikan/cangkok', 'pendidikan_controller@getCangkok');
    $router->post('/pendidikan/cangkok', 'pendidikan_controller@postCangkok');
    $router->delete('/pendidikan/cangkok/{id}', 'pendidikan_controller@deleteCangkok');
    $router->post('/pendidikan/edit/cangkok/{id}', 'pendidikan_controller@editCangkok');

    //KOORDINATOR
    $router->get('/pendidikan/koordinator', 'pendidikan_controller@getKoordinator');
    $router->post('/pendidikan/koordinator', 'pendidikan_controller@postKoordinator');
    $router->delete('/pendidikan/koordinator/{id}', 'pendidikan_controller@deleteKoordinator');
    $router->post('/pendidikan/edit/koordinator', 'pendidikan_controller@editKoordinator');

    //PENDIDIKAN END

    //PENELITIAN START
    //A. Penelitian kelompok
    $router->get('/penelitian/penelitian_kelompok', 'PenelitianController@getPenelitianKelompok');
    $router->post('/penelitian/penelitian_kelompok', 'PenelitianController@postPenelitianKelompok');
    $router->delete('/penelitian/penelitian_kelompok/{id}', 'PenelitianController@deletePenelitianKelompok');
    $router->post('/penelitian/edit/penelitian_kelompok', 'PenelitianController@editPenelitianKelompok');

    //B. Penelitian mandiri
    $router->get('/penelitian/penelitian_mandiri', 'PenelitianController@getPenelitianMandiri');
    $router->post('/penelitian/penelitian_mandiri', 'PenelitianController@postPenelitianMandiri');
    $router->delete('/penelitian/penelitian_mandiri/{id}', 'PenelitianController@deletePenelitianMandiri');
    $router->post('/penelitian/edit/penelitian_mandiri', 'PenelitianController@editPenelitianMandiri');

    //C. Buku Terbit
    $router->get('/penelitian/buku_terbit', 'PenelitianController@getBukuTerbit');
    $router->post('/penelitian/buku_terbit', 'PenelitianController@postBukuTerbit');
    $router->delete('/penelitian/buku_terbit/{id}', 'PenelitianController@deleteBukuTerbit');
    $router->post('/penelitian/edit/buku_terbit', 'PenelitianController@editBukuTerbit');

    //D. Buku Internasional
    $router->get('/penelitian/buku_internasional', 'PenelitianController@getBukuInternasional');
    $router->post('/penelitian/buku_internasional', 'PenelitianController@postBukuInternasional');
    $router->delete('/penelitian/buku_internasional/{id}', 'PenelitianController@deleteBukuInternasional');
    $router->post('/penelitian/edit/buku_internasional', 'PenelitianController@editBukuInternasional');

    //E. Menyadur naskah buku
    $router->get('/penelitian/menyadur', 'PenelitianController@getMenyadur');
    $router->post('/penelitian/menyadur', 'PenelitianController@postMenyadur');
    $router->delete('/penelitian/menyadur/{id}', 'PenelitianController@deleteMenyadur');
    $router->post('/penelitian/edit/menyadur', 'PenelitianController@editMenyadur');

    //F. Menyunting naskah buku
    $router->get('/penelitian/menyunting', 'PenelitianController@getMenyunting');
    $router->post('/penelitian/menyunting', 'PenelitianController@postMenyunting');
    $router->delete('/penelitian/menyunting/{id}', 'PenelitianController@deleteMenyunting');
    $router->post('/penelitian/edit/menyunting', 'PenelitianController@editMenyunting');

    //G. penelitian modul
    $router->get('/penelitian/penelitian_modul', 'PenelitianController@getPenelitianModul');
    $router->post('/penelitian/penelitian_modul', 'PenelitianController@postPenelitianModul');
    $router->delete('/penelitian/penelitian_modul/{id}', 'PenelitianController@deletePenelitianModul');
    $router->post('/penelitian/edit/penelitian_modul', 'PenelitianController@editPenelitianModul');

    //H. penelitian pekerti
    $router->get('/penelitian/penelitian_pekerti', 'PenelitianController@getPenelitianPekerti');
    $router->post('/penelitian/penelitian_pekerti', 'PenelitianController@postPenelitianPekerti');
    $router->delete('/penelitian/penelitian_pekerti/{id}', 'PenelitianController@deletePenelitianPekerti');
    $router->post('/penelitian/edit/penelitian_pekerti', 'PenelitianController@editPenelitianPekerti');

    // I. Pelaksanaa Tridharma
    $router->get('/penelitian/penelitian_tridharma', 'PenelitianController@getPenelitianTridharma');
    $router->post('/penelitian/penelitian_tridharma', 'PenelitianController@postPenelitianTridharma');
    $router->delete('/penelitian/penelitian_tridharma/{id}', 'PenelitianController@deletePenelitianTridharma');
    $router->post('/penelitian/edit/penelitian_tridharma', 'PenelitianController@editPenelitianTridharma');

    // J. Menulis Jurnal ilmiah
    $router->get('/penelitian/jurnal_ilmiah', 'PenelitianController@getJurnalIlmiah');
    $router->post('/penelitian/jurnal_ilmiah', 'PenelitianController@postJurnalIlmiah');
    $router->delete('/penelitian/jurnal_ilmiah/{id}', 'PenelitianController@deleteJurnalIlmiah');
    $router->post('/penelitian/edit/jurnal_ilmiah', 'PenelitianController@editJurnalIlmiah');

    //M. Pembicara Seminar
    $router->get('/penelitian/pembicara_seminar', 'PenelitianController@getPembicaraSeminar');
    $router->post('/penelitian/pembicara_seminar', 'PenelitianController@postPembicaraSeminar');
    $router->delete('/penelitian/pembicara_seminar/{id}', 'PenelitianController@deletePembicarSeminar');
    $router->post('/penelitian/edit/pembicara_seminar', 'PenelitianControllerr@editPembicaraSeminar');

    //N. Penyajian Makalah
    $router->get('/penelitian', 'PenelitianController@getAll');
    $router->get('/penelitian/penyajian_makalah', 'PenelitianController@getPenyajianMakalah');
    $router->post('/penelitian/penyajian_makalah', 'PenelitianController@postPenyajianMakalah');
    $router->delete('/penelitian/penyajian_makalah/{id}', 'PenelitianController@deletePenyajianMakalah');
    $router->post('/penelitian/edit/penyajian_makalah', 'PenelitianControllerr@editPenyajianMakalah');

    //K. Hak Paten
    $router->get('/penelitian/hak_paten', 'PenelitianController@getHakPaten');
    $router->post('/penelitian/hak_paten', 'PenelitianController@postHakPaten');
    $router->delete('/penelitian/hak_paten/{id}', 'PenelitianController@deleteHakPaten');
    $router->post('/penelitian/edit/hak_paten', 'PenelitianController@editHakPaten');

    //L. Media Massa
    $router->get('/penelitian/media_massa', 'PenelitianController@getMediaMassa');
    $router->post('/penelitian/media_massa', 'PenelitianController@postMediaMassa');
    $router->delete('/penelitian/media_massa/{id}', 'PenelitianController@deleteMediaMassa');
    $router->post('/penelitian/edit/media_massa', 'PenelitianController@editMediaMassa');

    //M. Pembaca Seminar
    $router->get('/penelitian/pembicara_seminar', 'PenelitianController@getPembicaraSeminar');
    $router->post('/penelitian/pembicara_seminar', 'PenelitianController@postPembicaraSeminar');
    $router->delete('/penelitian/pembicara_seminar/{id}', 'PenelitianController@deletePembicaraSeminar');
    $router->post('/penelitian/edit/pembicara_seminar', 'PenelitianController@editPembicaraSeminar');

    //N. Penyajian Makalah
    $router->get('/penelitian/penyajian_makalah', 'PenelitianController@getPenyajianMakalah');
    $router->post('/penelitian/penyajian_makalah', 'PenelitianController@postPenyajianMakalah');
    $router->delete('/penelitian/penyajian_makalah/{id}', 'PenelitianController@deletePenyajianMakalah');
    $router->post('/penelitian/edit/penyajian_makalah', 'PenelitianController@editPenyajianMakalah');
    //PENELITIAN END

    //START ROUTE FOR PENGABDIAN //START ROUTE FOR PENGABDIAN //START ROUTE FOR PENGABDIAN
    $router->group(['prefix' => 'pengabdian'], function () use ($router) {
        // Bagian A
        $router->get('/kegiatan', 'PengabdianController@getKegiatan');
        $router->post('/kegiatan', 'PengabdianController@postKegiatan');
        $router->post('/edit/kegiatan', 'PengabdianController@editKegiatan');
        $router->delete('/kegiatan/{id}', 'PengabdianController@deleteKegiatan');
        // END OF BAGIAN A

        //BAGIAN B
        $router->get('/penyuluhan', 'PengabdianController@getPenyuluhan');
        $router->post('/penyuluhan', 'PengabdianController@postPenyuluhan');
        $router->post('/edit/penyuluhan', 'PengabdianController@editPenyuluhan');
        $router->delete('/penyuluhan/{id}', 'PengabdianController@deletePenyuluhan');
        //END OF BAGIAN B

        //BAGIAN C
        $router->get('/konsultan', 'PengabdianController@getKonsultan');
        $router->post('/konsultan', 'PengabdianController@postKonsultan');
        $router->post('/edit/konsultan', 'PengabdianController@editKonsultan');
        $router->delete('/konsultan/{id}', 'PengabdianController@deleteKonsultan');
        //END OF BAGIAN C

        //BAGIAN D
        $router->get('/karya', 'PengabdianController@getKarya');
        $router->post('/karya', 'PengabdianController@postKarya');
        $router->post('/edit/karya', 'PengabdianController@editKarya');
        $router->delete('/karya/{id}', 'PengabdianController@deleteKarya');
        //END OF BAGIAN D

    });
    //END OF ROUTE FOR PENGABDIAN //END OF ROUTE FOR PENGABDIAN //END OF ROUTE FOR PENGABDIAN

    //START ROUTE FOR PENUNJANG
    $router->group(['prefix' => 'penunjang'], function () use ($router) {
        // Bagian A
        $router->get('/akademik', 'penunjang_controller@getAkademik');
        $router->post('/akademik', 'penunjang_controller@postAkademik');
        $router->post('/edit/akademik', 'penunjang_controller@editAkademik');
        $router->delete('/akademik/{id}', 'penunjang_controller@deleteAkademik');
        // END OF BAGIAN A

        //BAGIAN B
        $router->get('/bimbingan', 'penunjang_controller@getBimbingan');
        $router->post('/bimbingan', 'penunjang_controller@postBimbingan');
        $router->post('/edit/bimbingan', 'penunjang_controller@editBimbingan');
        $router->delete('/bimbingan/{id}', 'penunjang_controller@deleteBimbingan');
        //END OF BAGIAN B

        //BAGIAN C
        $router->get('/ukm', 'penunjang_controller@getUkm');
        $router->post('/ukm', 'penunjang_controller@postUkm');
        $router->post('/edit/ukm/', 'penunjang_controller@editUkm');
        $router->delete('/ukm/{id}', 'penunjang_controller@deleteUkm');
        //END OF BAGIAN C

        //BAGIAN D
        $router->get('/sosial', 'penunjang_controller@getSosial');
        $router->post('/sosial', 'penunjang_controller@postSosial');
        $router->post('/edit/sosial/', 'penunjang_controller@editSosial');
        $router->delete('/sosial/{id}', 'penunjang_controller@deleteSosial');
        //END OF BAGIAN D

        // BAGIAN E
        $router->get('/struktural', 'penunjang_controller@getStruktural');
        $router->post('/struktural', 'penunjang_controller@postStruktural');
        $router->post('/edit/struktural/', 'penunjang_controller@editStruktural');
        $router->delete('/struktural/{id}', 'penunjang_controller@deleteStruktural');
        // END OF BAGIAN E

        // BAGIAN F
        $router->get('/nonstruktural', 'penunjang_controller@getNonstruktural');
        $router->post('/nonstruktural', 'penunjang_controller@postNonstruktural');
        $router->post('/edit/nonstruktural/', 'penunjang_controller@editNonstruktural');
        $router->delete('/nonstruktural/{id}', 'penunjang_controller@deleteNonstruktural');
        // END OF BAGIAN F

        // BAGIAN G
        $router->get('/redaksi', 'penunjang_controller@getRedaksi');
        $router->post('/redaksi', 'penunjang_controller@postRedaksi');
        $router->post('/edit/redaksi/', 'penunjang_controller@editRedaksi');
        $router->delete('/redaksi/{id}', 'penunjang_controller@deleteRedaksi');
        // END OF BAGIAN G

        // BAGIAN H
        $router->get('/adhoc', 'penunjang_controller@getAdhoc');
        $router->post('/adhoc', 'penunjang_controller@postAdhoc');
        $router->post('/edit/adhoc/', 'penunjang_controller@editAdhoc');
        $router->delete('/adhoc/{id}', 'penunjang_controller@deleteAdhoc');
        // END OF BAGIAN H

        //BAGIAN L
        $router->get('/asosiasi', 'penunjang_controller@getAsosiasi');
        $router->post('/asosiasi', 'penunjang_controller@postAsosiasi');
        $router->post('/edit/asosiasi', 'penunjang_controller@editAsosiasi');
        $router->delete('/asosiasi/{id}', 'penunjang_controller@deleteAsosiasi');
        //END OF BAGIAN L


        //BAGIAN M
        $router->get('/seminar', 'penunjang_controller@getSeminar');
        $router->post('/seminar', 'penunjang_controller@postSeminar');
        $router->post('/edit/seminar', 'penunjang_controller@editSeminar');
        $router->delete('/seminar/{id}', 'penunjang_controller@deleteSeminar');
        //END OF BAGIAN M


        //BAGIAN N
        $router->get('/reviewer', 'penunjang_controller@getReviewer');
        $router->post('/reviewer', 'penunjang_controller@postReviewer');
        $router->post('/edit/reviewer', 'penunjang_controller@editReviewer');
        $router->delete('/reviewer/{id}', 'penunjang_controller@deleteReviewer');
        //END OF BAGIAN N
    });
    //END OF ROUTE FOR PENUNJANG
});
