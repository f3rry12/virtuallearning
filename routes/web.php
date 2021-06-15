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

//General
Route::get('/', 'HomeController@index');
Route::get('/login', 'HomeController@index');
Route::post('/loginPost', 'HomeController@loginPost');
Route::get('/logout', 'HomeController@logout');
//zoom foto
Route::get('foto/{loc}/{foto}', 'HomeController@zoomfoto');
//download
Route::get('download/{loc}/{path}', 'HomeController@download');

//Guru
Route::get('/guru', 'GuruController@index');
//Menuju halaman profil guru
Route::get('/guru/profilguru', 'GuruController@profilguru');
//trigger proses logika edit guru
Route::put('/guru/editguruput/{username}', 'GuruController@editguruPut');

//guru KELAS
//guru logika tambah kelas
Route::post('/{kodeguru}/tambahkelasPost', 'GuruController@buatkelasPost');
//guru menuju kelas
Route::get('/guru/kelas/{kodekelas}', 'GuruController@indexkelas');
//guru menuju lihat member kelas
Route::get('/guru/member/{kodekelas}', 'GuruController@indexmember');
//Menuju halaman edit kelas
Route::get('/guru/editkelas/{kodekelas}', 'GuruController@editkelas');
//trigger proses logika edit kelas
Route::put('/guru/editkelasPut/{kodekelas}', 'GuruController@editkelasPut');

//guru Pengumuman
//guru logika tambah pengumuman
Route::post('/guru/pengumumanpost/{kodekelas}', 'GuruController@pengumumanPost');
//trigger proses logika edit pengumuman
Route::put('/guru/pengumumanput', 'GuruController@pengumumanPut');

//guru Materi
//Menuju halaman bagi materi
Route::get('/guru/bagimateri/{kodekelas}', 'GuruController@bagimateri');
//trigger proses logika tambah materi
Route::post('/guru/bagimateripost/{kodekelas}', 'GuruController@bagimateriPost');
//Menuju halaman detail materi
Route::get('/guru/editmateri/{idmateri}', 'GuruController@editmateri');
//trigger proses logika edit kelas
Route::put('/guru/editmateriPut/{idmateri}', 'GuruController@editmateriPut');

//guru Tugas
//Menuju halaman bagi tugas
Route::get('/guru/bagitugas/{kodekelas}', 'GuruController@bagitugas');
//trigger proses logika tambah tugas
Route::post('/guru/bagitugaspost/{kodekelas}', 'GuruController@bagitugasPost');
//Menuju halaman detail tugas
Route::get('/guru/edittugas/{idtugas}', 'GuruController@edittugas');
//trigger proses logika edit tugas
Route::put('/guru/edittugasPut/{idtugas}', 'GuruController@edittugasPut');

//guru Penilaian
//Menuju halaman daftar tugas
Route::get('/guru/listtugas', 'GuruController@listtugas');
//Menuju halaman daftar nilai
Route::get('/guru/daftarnilai/{idtugas}', 'GuruController@listnilai');
//Menuju halaman penilaian
Route::get('/guru/penilaian/{idjawaban}', 'GuruController@nilai');
//trigger proses logika edit tugas
Route::put('/guru/nilaiPut/{idjawaban}', 'GuruController@nilaiPut');

//Siswa
Route::get('/siswa', 'SiswaController@index');
//Menuju halaman profil siswa
Route::get('/siswa/profilsiswa', 'SiswaController@profilsiswa');
//trigger proses logika edit siswa
Route::put('/siswa/editsiswaput', 'SiswaController@editsiswaPut');

//Siswa Materi
//Menuju halaman detail materi
Route::get('/siswa/materi/{idmateri}', 'SiswaController@detailmateri');

//Tugas
//Menuju halaman detail tugas
Route::get('/siswa/tugas/{idtugas}', 'SiswaController@detailtugas');
//trigger proses logika submit tugas
Route::post('/siswa/submitjawabanpost/{idtugas}', 'SiswaController@submitjawabanPost');
//trigger proses logika edit tugas
Route::put('/siswa/editjawabanPut/{idjawaban}', 'SiswaController@editjawabanPut');
//Menuju halaman list tugas
Route::get('/siswa/listtugas', 'SiswaController@listtugas');

//siswa kelas
Route::post('/{NIS}/confirmmasukkelas', 'SiswaController@confirmkelas');
Route::post('/siswa/masukkelasPost/{kodekelas}', 'SiswaController@masukkelasPost');
Route::get('/siswa/kelas/{kodekelas}', 'SiswaController@indexkelas');
//siswa menuju lihat member kelas
Route::get('/siswa/member/{kodekelas}', 'SiswaController@indexmember');

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
Route::put('/editguruput/{kodeguru}/{username}', 'AdminController@editguruPut');
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

