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

Route::get('/login','ClaveUnicaController@login');
Route::get('/','ClaveUnicaController@autenticar')->name('login.claveunica');
Route::get('/callback','ClaveUnicaController@callback')->name('login.callback');
//
// Route::get('/', function () {
//     return view('welcome');
// });
//
//
// Route::any('/claveunica/autenticar', 'Auth\LoginController@redirectToProvider')->name('login.claveunica');
// Route::any('/claveunica/validar', 'Auth\LoginController@handleProviderCallback')->name('login.claveunica.callback');
