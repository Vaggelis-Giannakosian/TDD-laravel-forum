<?php

use App\Thread;
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

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



Route::get('/threads','ThreadsController@index')->name('threads.index');
Route::post('/threads','ThreadsController@store')->name('threads.store');

Route::get('/threads/create','ThreadsController@create')->name('threads.create');


Route::get('/threads/{channel:slug}','ThreadsController@index')->name('threads.channel');
Route::get('/threads/{channel:slug}/{thread}','ThreadsController@show')->name('threads.show');
Route::delete('/threads/{channel:slug}/{thread}','ThreadsController@destroy')->name('threads.destroy');

//Route::resource('threads','ThreadsController');

Route::post('/threads/{channel:slug}/{thread}/replies','RepliesController@store')->name('replies.store');

Route::delete('/replies/{reply}','RepliesController@destroy')->name('replies.destroy');
Route::post('/replies/{reply}/favorites','FavoritesController@store')->name('reply.favorite');

Route::get('/profiles/{user:name}','ProfilesController@show')->name('user.profile');
