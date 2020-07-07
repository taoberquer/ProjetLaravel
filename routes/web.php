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

Auth::routes();

Route::group(['middleware' => 'auth'], function(){
    Route::get('/{file_id?}', 'FileController@index')->name('home');

    Route::group(['as' => 'file.', 'prefix' => 'file'], function () {
        Route::get('{file_id}/download', 'FileController@download')->name('download');
        Route::post('folder/{file_id?}', 'FileController@storeFolder')->name('storeFolder');
        Route::post('{file_id?}', 'FileController@storeFiles')->name('storeFiles');
        Route::put('{file_id}', 'FileController@update')->name('update');
        Route::delete('{file_id}', 'FileController@destroy')->name('destroy');
    });

    //TODO : Faire les routes de partages

    Route::get('/settings', 'UserController@editSettings')->name('editSettings');
    Route::put('/settings', 'UserController@updateSettings')->name('updateSettings');
});


