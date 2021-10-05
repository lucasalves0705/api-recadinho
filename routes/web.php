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

$router->group(['prefix' => 'usuarios'], function () use ($router){

    $router->get('/', 'UserController@index');
    $router->post('/novo', 'UserController@store');
    $router->get('/{userId}/mostrar', 'UserController@show');
    $router->post('/{userId}/alterar', 'UserController@store');
    $router->delete('{userId}/remover', 'UserController@destroy');

});

$router->group(['prefix' => 'shows'], function () use ($router){

    $router->get('/', 'ShowController@index');
    $router->post('/novo', 'ShowController@store');
    $router->get('/{showId}/mostrar', 'ShowController@show');
    $router->post('/{showId}/alterar', 'ShowController@store');
    $router->delete('/{showId}/remover', 'ShowController@destroy');

});

$router->group(['prefix' => 'likes'], function () use ($router) {

    $router->get('/{muralId}/post', 'LikeOfMuralController@showByPostMural');
    $router->post('/novo', 'LikeOfMuralController@store');
});

