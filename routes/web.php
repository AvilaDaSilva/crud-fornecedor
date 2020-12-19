<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\EmpresasController;

Route::get('/', 'initPageController@init');

Route::get('empresas/{id?}', 'EmpresasController@fetch');
Route::post('empresas', 'EmpresasController@create')->name('cadastrar_empresa');
Route::put('empresas/{id}', 'EmpresasController@update')->name('alterar_empresa');
Route::delete('empresas/{id}', 'EmpresasController@delete');

Route::get('fornecedores/{id?}', 'FornecedoresController@fetch');
Route::post('fornecedores', 'FornecedoresController@create')->name('cadastrar_fornecedor');
Route::put('fornecedores/{id}', 'FornecedoresController@update')->name('alterar_fornecedor');
Route::delete('fornecedores/{id}', 'FornecedoresController@delete');

Route::get('telefones-fornecedor/{id?}', 'FornecedorTelefonesController@fetch');
Route::post('telefones-fornecedor', 'FornecedorTelefonesController@create')->name('cadastrar_telefone');
Route::put('telefones-fornecedor/{id}', 'FornecedorTelefonesController@update')->name('alterar_telefone');
Route::delete('telefones-fornecedor/{id}', 'FornecedorTelefonesController@delete');