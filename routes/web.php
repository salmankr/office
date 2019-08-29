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

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/states/{id}', 'userDataController@states');

Route::middleware('auth')->group(function(){
	Route::get('/api-key-generation', 'userDataController@apiKeys')->name('api');
	Route::get('/localization', 'userDataController@localization');
});

Route::get('/logs', 'logsDataController@index')->middleware('emailVerified');