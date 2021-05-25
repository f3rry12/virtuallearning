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
Route::post('/loginadminPost', 'AdminController@loginPost');
Route::get('/logoutadmin', 'AdminController@logout');

//beranda admin
Route::get('/admin', 'AdminController@index');

//crud guru for admin
//Menuju halaman tambah guru
Route::get('/admin/tambahguru', 'AdminController@tambahguru');
//trigger proses logika tambah guru
Route::post('/tambahgurupost', 'AdminController@tambahguruPost');
//Menuju halaman edit guru
Route::get('/admin/profilguru/{kodeguru}', 'AdminController@editguru');
//trigger proses logika edit guru
Route::put('/editguruput/{kodeguru}', 'AdminController@editguruPut');
//hapus akun guru
Route::delete('/admin/hapusguru/{kodeguru}', 'AdminController@hapusguru');


//crud for siswa
//Menuju halaman tambah siswa
Route::get('/admin/tambahsiswa', 'AdminController@tambahsiswa');
//trigger proses logika tambah siswa
Route::post('/tambahsiswapost', 'AdminController@tambahsiswaPost');
//Menuju halaman edit siswa
Route::get('/admin/profilsiswa/{kodesiswa}', 'AdminController@editsiswa');
//trigger proses logika edit siswa
Route::put('/editsiswaput/{kodesiswa}', 'AdminController@editsiswaPut');
//hapus akun siswa
Route::delete('/admin/hapussiswa/{kodesiswa}', 'AdminController@hapussiswa');

