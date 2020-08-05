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


Route::get('/threads/{channel:slug}/{thread}/replies','RepliesController@index');
Route::post('/threads/{channel:slug}/{thread}/replies','RepliesController@store')->name('replies.store');


Route::delete('/replies/{reply}','RepliesController@destroy')->name('replies.destroy');
Route::patch('/replies/{reply}','RepliesController@update')->name('replies.update');

Route::post('/threads/{channel:slug}/{thread}/subscriptions','ThreadSubscrpitionsController@store')->name('subscriptions.store');
Route::delete('/threads/{channel:slug}/{thread}/subscriptions','ThreadSubscrpitionsController@destroy')->name('subscriptions.delete');



Route::post('/replies/{reply}/favorites','FavoritesController@store')->name('reply.favorite');
Route::delete('/replies/{reply}/favorites','FavoritesController@destroy')->name('reply.favorite.destroy');

Route::get('/profiles/{user:name}','ProfilesController@show')->name('user.profile');
Route::get('/profiles/{user:name}/notifications','UserNotificationsController@index')->name('user-notifications.index');
Route::delete('/profiles/{user:name}/notifications/{notification}','UserNotificationsController@destroy')->name('user-notifications.delete');

Route::get('/users','Api\UsersController@index')->name('api.users.index');
Route::post('/users/{user}/avatar','Api\UserAvatarController@store')->name('api.userAvatar.store')->middleware('auth');
