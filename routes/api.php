<?php

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

Route::get('/', function () {
    echo "Teste API DialHost";
});
/************* User **************/
Route::post('/users', 'UserController@store');

/************** Clientes ********************/
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/users', 'UserController@index')->middleware('scope:administrador');
    // Route::get('/produtos', 'ProdutoController@index')->middleware('scope:administrador,usuario'); //ambas podem acessar
    //Route::post('/produtos', 'ProdutoController@store')->middleware('scope:administrador');//apenas o administrador terá acesso

});
