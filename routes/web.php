<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();
Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
Route::get('/dashboard', 'DashboardController@index');
Route::resource('message', 'MessageController');
Route::get('message/view/{id}',['as' => 'message.view', 'uses' => 'MessageController@view']);
Route::post('message/seen',['as' => 'message.hasBeenSeen', 'uses' => 'MessageController@seen']);
Route::post('message/details',['as' => 'message.storeDetails', 'uses' => 'MessageController@storeDetails']);
