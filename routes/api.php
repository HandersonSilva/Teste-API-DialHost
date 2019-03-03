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
    //cadastrar cliente
    Route::post('/clientes', 'ClientesController@store')->middleware('scope:administrador');
    //listar todos os clientes
    Route::get('/clientes', 'ClientesController@index')->middleware('scope:administrador,usuario');
    //listar cliente por id
    Route::get('/cliente/{id}', 'ClientesController@show')->middleware('scope:administrador,usuario');
    //editar cliente
    Route::put('/cliente/{id}', 'ClientesController@update')->middleware('scope:administrador');
    //excluir cliente
    Route::delete('/cliente/{id}', 'ClientesController@destroy')->middleware('scope:administrador');

});
