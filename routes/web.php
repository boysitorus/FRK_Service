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
    // $router->get('/data-dosen', 'AuthController@index');
    $router->get('/pendidikan', 'pendidikan_controller@getAll');
    $router->get('/pendidikan/teori', 'pendidikan_controller@getTeori');
    $router->post('/pendidikan/teori', 'pendidikan_controller@postTeori');
    $router->delete('/pendidikan/teori/{id}', 'pendidikan_controller@deleteTeori');
    $router->get('/pendidikan/bimbingan', 'pendidikan_controller@getBimbingan');
    $router->post('/pendidikan/bimbingan', 'pendidikan_controller@postBimbingan');
    $router->get('/pendidikan/seminar', 'pendidikan_controller@getSeminar');
    $router->post('/pendidikan/seminar', 'pendidikan_controller@postSeminar');
});