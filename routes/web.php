<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/', 'PessoasController@redirectPessoas');
Route::get('/pessoas', 'PessoasController@index');
Route::get('pessoas/cadastrar', 'PessoasController@getCadastrar');
Route::post('pessoas/cadastrar', 'PessoasController@postCadastrar');
Route::get('pessoas/editar/{idPessoa}', 'PessoasController@getEditar');
Route::post('pessoas/editar', 'PessoasController@postEditar');
Route::get('pessoas/remover/{arrayPessoasId}', 'PessoasController@getRemover');


Route::get('pessoas/ativar/{idPessoa}', 'PessoasController@getAtivarPessoa');
Route::get('pessoas/desativar/{idPessoa}', 'PessoasController@getDesativarPessoa');

Route::get('pessoas/adicionar/dependentes/{idPessoa}', 'PessoasController@getAdicionarDependente');
Route::post('dependentes/cadastrar', 'DependentesController@postCadastrar');
Route::get('dependentes/remover/{idDependente}', 'DependentesController@getRemoverDependente');




