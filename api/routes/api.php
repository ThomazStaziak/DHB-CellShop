<?php

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

Route::middleware(['cors'])->group(function () {
    Route::get('/produtos', 'API\ProdutosController@index');
    Route::post('/produtos', 'API\ProdutosController@store');
    Route::get('/produtos/{id}', 'API\ProdutosController@show');
    Route::post('/produtos/{id}', 'API\ProdutosController@update');
    Route::delete('/produtos/{id}', 'API\ProdutosController@destroy');
});

