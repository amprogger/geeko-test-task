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

Route::middleware('auth:api')->prefix('client')->group(function () {
    Route::get('search', 'Api\ClientsController@search');
    Route::get('/{id}', 'Api\ClientsController@show');
    Route::post('/', 'Api\ClientsController@createOrUpdate');
    Route::put('/', 'Api\ClientsController@createOrUpdate');
    Route::delete('/{id}', 'Api\ClientsController@delete');
});
