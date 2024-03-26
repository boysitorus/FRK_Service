<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\AuthController;
use App\Http\Controllers\pendidikan_controller;

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
    //teori
    $router->get('/pendidikan', 'pendidikan_controller@getAll');
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

     //Tugas Akhir
    $router->get('/pendidikan/tugasAkhir', 'pendidikan_controller@getTugasAkhir');
    $router->post('/pendidikan/tugasAkhir', 'pendidikan_controller@postTugasAkhir');
    $router->post('/pendidikan/editTugasAkhir', 'pendidikan_controller@editTugasAkhir');
    $router->delete('/pendidikan/tugasAkhir/{id}', 'pendidikan_controller@deleteTugasAkhir');
    $router->post('/pendidikan/edit/seminar', 'pendidikan_controller@editSeminar');
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

    // ASISTENSI
    $router->get('/pendidikan/asistensi', 'pendidikan_controller@getAsistensi');
    $router->post('/pendidikan/asistensi', 'pendidikan_controller@postAsistensi');
    $router->delete('/pendidikan/asistensi/{id}', 'pendidikan_controller@deleteAsistensi');
    $router->post('/pendidikan/edit/asistensi', 'pendidikan_controller@editAsistensi');
    //PENDIDIKAN END

    //PENELITIAN START
    //A. penelitian kelompok
    $router->get('/penelitian', 'PenelitianController@getAll');
    $router->get('/penelitian/penelitian_kelompok', 'PenelitianController@getPenelitianKelompok');
    $router->post('/penelitian/penelitian_kelompok', 'PenelitianController@postPenelitianKelompok');
    $router->delete('/penelitian/penelitian_kelompok/{id}', 'PenelitianController@deletePenelitianKelompok');
    $router->post('/penelitian/edit/penelitian_kelompok', 'PenelitianController@editPenelitianKelompok');

    //B. penelitian mandiri
    $router->get('/penelitian/penelitian_mandiri', 'PenelitianController@getPenelitianMandiri');
    $router->post('/penelitian/penelitian_mandiri', 'PenelitianController@postPenelitianMandiri');
    $router->delete('/penelitian/penelitian_mandiri/{id}', 'PenelitianController@deletePenelitianMandiri');
    $router->post('/penelitian/edit/penelitian_mandiri', 'PenelitianController@editPenelitianMandiri');

    // I.
    $router->get('/penelitian/penelitian_tridharma', 'PenelitianController@getPenelitianTridharma');
    $router->post('/penelitian/penelitian_tridharma', 'PenelitianController@postPenelitianTridharma');
    $router->delete('/penelitian/penelitian_tridharma/{id}', 'PenelitianController@deletePenelitianTridharma');
    $router->post('/penelitian/edit/penelitian_tridharma', 'PenelitianControllerr@editPenelitianTridharma');
    
    // J. Menulis Jurnal ilmiah
    $router->get('/penelitian/jurnal_ilmiah', 'PenelitianController@getJurnalIlmiah');
    $router->post('/penelitian/jurnal_ilmiah', 'PenelitianController@postJurnalIlmiah');
    $router->delete('/penelitian/jurnal_ilmiah/{id}', 'PenelitianController@deleteJurnalIlmiah');
    $router->post('/penelitian/edit/jurnal_ilmiah', 'PenelitianControllerr@editJurnalIlmiah');
    

    //M. Pembicara Seminar 
    $router->get('/penelitian/pembicara_seminar', 'PenelitianController@getPembicaraSeminar');
    $router->post('/penelitian/pembicara_seminar', 'PenelitianController@postPembicaraSeminar');
    $router->delete('/penelitian/pembicara_seminar/{id}', 'PenelitianController@deletePembicarSeminar');
    $router->post('/penelitian/edit/pembicara_seminar', 'PenelitianControllerr@editPembicaraSeminar');
    
    //N. Penyajian Makalah
    $router->get('/penelitian/penyajian_makalah', 'PenelitianController@getPenyajianMakalah');
    $router->post('/penelitian/penyajian_makalah', 'PenelitianController@postPenyajianMakalah');
    $router->delete('/penelitian/penyajian_makalah/{id}', 'PenelitianController@deletePenyajianMakalah');
    $router->post('/penelitian/edit/penyajian_makalah', 'PenelitianControllerr@editPenyajianMakalah');

    //E. Menyadur naskah buku
    $router->get('/penelitian/menyadur', 'PenelitianController@getMenyadur');
    $router->post('/penelitian/menyadur', 'PenelitianController@postMenyadur');
    $router->delete('/penelitian/menyadur/{id}', 'PenelitianController@deleteMenyadur');
    $router->post('/penelitian/edit/menyadur', 'PenelitianControllerr@editMenyadur');

    //F. Menyunting naskah buku
    $router->get('/penelitian/menyunting', 'PenelitianController@getMenyunting');
    $router->post('/penelitian/menyunting', 'PenelitianController@postMenyunting');
    $router->delete('/penelitian/menyunting/{id}', 'PenelitianController@deleteMenyunting');
    $router->post('/penelitian/edit/menyunting', 'PenelitianControllerr@editMenyunting');

    //PENELITIAN END
});