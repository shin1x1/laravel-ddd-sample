<?php

use Acme\Shop\Application\Controllers\CartController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/**
 * @var \Illuminate\Routing\Router $router
 */
$router->get('/cart', CartController::class . '@get');
$router->post('/cart', CartController::class . '@post');
