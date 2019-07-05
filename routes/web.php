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

Route::get('/', 'HomeController@index')->name('home');

Route::prefix('data')->name('data:')->group(function () {
    Route::get('/', 'DataController@index')->name('index');
    Route::get('/datatables', 'DataController@datatables')->name('datatables');
    Route::get('/train', 'DataController@train')->name('train');
});

Route::prefix('tree')->name('tree:')->group(function () {
    Route::get('/', 'TreeController@index')->name('index');
});
