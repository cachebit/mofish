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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/moyus', 'MoyusController@index')->name('moyus.index');
Route::get('/moyus/create', 'MoyusController@create')->name('moyus.create');
Route::post('/moyus', 'MoyusController@store')->name('moyus.store');
Route::get('/moyus/{channel}/{moyu}', 'MoyusController@show')->name('moyus.show');
Route::delete('/moyus/{channel}/{moyu}', 'MoyusController@destroy')->name('moyus.show');
Route::get('/moyus/{channel}', 'MoyusController@index');
Route::post('/moyus', 'MoyusController@store')->name('moyus.store');
Route::delete('/replies/{reply}', 'RepliesController@destroy');
Route::patch('/replies/{reply}', 'RepliesController@update');
Route::post('/moyus/{channel}/{moyu}/replies', 'RepliesController@store')->name('replies.store');
Route::post('/replies/{reply}/favorites', 'FavoritesController@store');;


Route::get('/profiles/{user}', 'ProfilesController@show');
