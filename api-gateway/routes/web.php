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

/*$router->get('/', function () use ($router) {
    return $router->app->version();
});*/

// Rutas para Authors
$router->group(['prefix' => 'api/authors'], function () use ($router) {
    $router->get('/',            ['uses' => 'GatewayController@authors']);
    $router->get('/{id}',        ['uses' => 'GatewayController@authors']);
    $router->post('/',           ['uses' => 'GatewayController@authors']);
    $router->put('/{id}',        ['uses' => 'GatewayController@authors']);
    $router->delete('/{id}',     ['uses' => 'GatewayController@authors']);
});

// Rutas para Books
$router->group(['prefix' => 'api/books'], function () use ($router) {
    $router->get('/',            ['uses' => 'GatewayController@books']);
    $router->get('/{id}',        ['uses' => 'GatewayController@books']);
    $router->post('/',           ['uses' => 'GatewayController@books']);
    $router->put('/{id}',        ['uses' => 'GatewayController@books']);
    $router->delete('/{id}',     ['uses' => 'GatewayController@books']);
});
