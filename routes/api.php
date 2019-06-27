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

Route::get('/pemasukan', 'IncomeController@incomeChart')->named('pemasukan.chart');
Route::get('/pemasukan/pengguna/{id}', 'IncomeController@userIncomeChart')->named('pemasukan.user_chart');
