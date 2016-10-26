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

Route::group(['prefix' => 'messages'], function () {
    Route::get('/', ['as' => 'messages', 'uses' => 'MessagesController@index']);
    Route::get('create', ['as' => 'messages.create', 'uses' => 'MessagesController@create']);
    Route::post('/', ['as' => 'messages.store', 'uses' => 'MessagesController@store']);
    Route::get('{id}', ['as' => 'messages.show', 'uses' => 'MessagesController@show']);
    Route::put('{id}', ['as' => 'messages.update', 'uses' => 'MessagesController@update']);
});