<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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


$router->post('/user/register','UserController@store');
$router->post('/user/auth','UserController@auth');

$router->get('/movie','MovieController@index');
$router->get('/movie/{idmovie}','MovieController@show');
$router->get('/movie_genre/{idgenre}','MovieController@movie_by_genre');
$router->post('/movie/{iduser}','MovieController@store');

$router->get('/genre','GenreController@index');
$router->get('/genre/{idmovie}','GenreController@show');

$router->get('/tanggapan/{idmovie}','TanggapanController@index');
$router->post('/tanggapan/{idmovie}/{iduser}','TanggapanController@store');