<?php

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
$router->post('auth/login', 'Auth\AuthController');

$router->get('/example', ['middleware' => 'token.auth', function () {
    return "okay";
}]);

$router->group(['middleware' => ['token.auth']], function () use ($router) {
 
    $router->post('customers/create', 'Teller\CustomerController@create');
    $router->get('customers', 'Teller\CustomerController@index');

});
