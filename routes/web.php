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

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', 'HomeController@index')->name('home');


    Route::get('/folders/create', 'FolderController@create')->name('folders.create');
    Route::post('/folders/create', 'FolderController@store');
    Route::group(['middleware' => 'can:view,folder'], function() {
        Route::get('/folders/{folder}/tasks', 'TaskController@index')->name('tasks.index');

        Route::get('/folders/{folder}/tasks/create', 'TaskController@create')->name('tasks.create');
        Route::post('/folders/{folder}/tasks/create', 'TaskController@store');
        
        Route::get('/folders/{folder}/tasks/{task}/edit', 'TaskController@edit')->name('tasks.edit');
        Route::post('/folders/{folder}/tasks/{task}/edit', 'TaskController@update')->name('tasks.update');
    });
});

Auth::routes();