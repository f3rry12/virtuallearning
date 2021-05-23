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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/beranda', 'HomeController@index');
Route::get('/class', 'ClassController@index');
Route::get('/class/{kodeKelas}', 'ClassController@show');

//admin login session
Route::get('/loginadmin', 'AdminController@login');
Route::post('/loginPost', 'AdminController@loginPost');
Route::get('/logout', 'AdminController@logout');

//beranda admin
Route::get('/admin', 'AdminController@index');