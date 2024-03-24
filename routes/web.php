<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\AuthController;

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
    //teori
    $router->get('/pendidikan', 'pendidikan_controller@getAll');
    $router->get('/pendidikan/teori', 'pendidikan_controller@getTeori');
    $router->post('/pendidikan/teori', 'pendidikan_controller@postTeori');
    $router->delete('/pendidikan/teori/{id}', 'pendidikan_controller@deleteTeori');
    $router->post('/pendidikan/edit/teori', 'pendidikan_controller@editTeori');

    //bimbingan
    $router->get('/pendidikan/bimbingan', 'pendidikan_controller@getBimbingan');
    $router->post('/pendidikan/bimbingan', 'pendidikan_controller@postBimbingan');
    $router->delete('/pendidikan/bimbingan/{id}', 'pendidikan_controller@deleteBimbingan');

    //seminar
    $router->get('/pendidikan/seminar', 'pendidikan_controller@getSeminar');
    $router->post('/pendidikan/seminar', 'pendidikan_controller@postSeminar');
    $router->delete('/pendidikan/seminar/{id}', 'pendidikan_controller@deleteSeminar');

     //Tugas Akhir
     $router->get('/pendidikan/tugasAkhir', 'pendidikan_controller@getTugasAkhir');
     $router->post('/pendidikan/tugasAkhir', 'pendidikan_controller@postTugasAkhir');
     $router->post('/pendidikan/editTugasAkhir', 'pendidikan_controller@editTugasAkhir');
     $router->delete('/pendidikan/tugasAkhir/{id}', 'pendidikan_controller@deleteTugasAkhir');
});
