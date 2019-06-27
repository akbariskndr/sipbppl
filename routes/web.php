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

Route::get('/login', 'AuthController@showLogin')->name('login');
Route::post('/login', 'AuthController@login');
Route::get('/logout', 'AuthController@logout');

Route::group(['middleware' => ['auth', 'project_count']], function() {

    Route::get('/dashboard', 'GeneralController@dashboard')->name('dashboard');
    Route::get('/cari', 'GeneralController@search')->name('cari');
    
    Route::get('/pengguna', 'UserController@index')->name('pengguna.index');
    Route::post('/pengguna', 'UserController@store')->name('pengguna.store');
    Route::get('/pengguna/{id}', 'UserController@show')->name('pengguna.show');
    Route::get('/pengguna/{id}/ubah', 'UserController@edit')->name('pengguna.edit');
    Route::put('/pengguna/{id}', 'UserController@update')->name('pengguna.update');
    Route::delete('/pengguna/{id}', 'UserController@destroy')->name('pengguna.destroy');
    Route::put('/pengguna/{id}/ulang-password', 'UserController@resetPassword')->name('pengguna.reset');

    Route::get('/bobot', 'WeightController@index')->name('bobot.index');
    Route::post('/bobot', 'WeightController@store')->name('bobot.store');

    Route::get('/proyek/buat', 'ProjectController@create')->name('proyek.create');
    Route::get('/proyek/lihat/ditangani', 'ProjectController@handled')->name('proyek.handled');
    Route::get('/proyek/lihat/belum-dihitung', 'ProjectController@notCalculated')->name('proyek.not_calculated');
    Route::get('/proyek/lihat/belum-dikonfirmasi', 'ProjectController@notConfirmed')->name('proyek.not_confirmed');
    Route::get('/proyek/lihat/dikerjakan', 'ProjectController@inProgress')->name('proyek.in_progress');
    Route::get('/proyek/lihat/selesai', 'ProjectController@completed')->name('proyek.completed');
    Route::get('/proyek/lihat/gagal', 'ProjectController@failed')->name('proyek.failed');
    Route::get('/proyek/lihat/riwayat', 'ProjectController@history')->name('proyek.history');
    Route::get('/proyek/{id}', 'ProjectController@show')->name('proyek.show');
    Route::get('/proyek/{id}/ubah', 'ProjectController@edit')->name('proyek.edit');

    Route::put('/proyek/{id}/hitung', 'ProjectController@calculate')->name('proyek.calculate');
    Route::put('/proyek/{id}/konfirmasi', 'ProjectController@confirm')->name('proyek.confirm');
    Route::put('/proyek/{id}/selesai', 'ProjectController@done')->name('proyek.done');
    Route::put('/proyek/{id}/gagal', 'ProjectController@fail')->name('proyek.fail');

    Route::get('/proyek/{id}/cetak', 'ProjectController@print')->name('proyek.print');
    Route::post('/proyek', 'ProjectController@store')->name('proyek.store');
    Route::put('/proyek/{id}', 'ProjectController@update')->name('proyek.update');
    Route::delete('/proyek/{id}', 'ProjectController@destroy')->name('proyek.destroy');

    Route::get('/pemasukan', 'IncomeController@index')->name('pemasukan.index');
    Route::get('/pemasukan/pengguna', 'IncomeController@userIncome')->name('pemasukan.user_income');

    // Route::group(['middleware' => ['access:1']], function() {

    // });

    // Route::group(['middleware' => ['access:2']], function() {

    // });

    // Route::group(['middleware' => ['access:3']], function() {

    // });

});

Route::get('/reset-auth', function() {
    $user = App\User::find(1);
    $user->password = Hash::make('rahasia');

    $user->save();
});