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

        Route::group(['as' => 'share.', 'prefix' => '/{file_id}/share'], function () {
            Route::get('/', 'ShareController@show')->name('show');
            Route::post('/', 'ShareController@store')->name('store');
            Route::delete('/{share_id}', 'ShareController@destroy')->name('destroy');
        });
    });

    Route::group(['as' => 'shared.', 'prefix' => 'shared/{file_id}', 'middleware' => ['share.file']], function () {
        Route::get('/download', 'FileController@download')->name('download');
        Route::get('/', 'ShareController@index')->name('index');
        Route::post('folder/', 'FileController@storeFolder')->name('storeFolder');
        Route::post('/', 'FileController@storeFiles')->name('storeFiles');
        Route::put('/', 'FileController@update')->name('update');
        Route::delete('/', 'FileController@destroy')->name('destroy');
    });

    //TODO : Faire les routes de partages

    Route::get('/settings', 'UserController@editSettings')->name('editSettings');
    Route::put('/settings', 'UserController@updateSettings')->name('updateSettings');
});


