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

// OAuth Routes
Auth::routes();
Route::get('auth/{provider}', 'Auth\AuthController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback');

// App routes authenticated with auth
Route::group(['middleware' => 'auth'], function () {
    // home page (display all tweets)
    Route::get('/home', 'TweetController@index')->name('home');

    // users routes
    Route::get('/users', 'UserController@index');

    // tweets routes
    Route::get('tweets', 'TweetController@index')->name('tweets.index');
    Route::get('/tweets/create', 'TweetController@create')->name('tweets.create');
    Route::post('/tweets', 'TweetController@store')->name('tweets.store');
    Route::get('/tweets/{id}', 'TweetController@show')->name('tweets.show');
    Route::put('/tweets/{id}', 'TweetController@update')->name('tweets.update');
    Route::delete('/tweets/{id}', 'TweetController@destroy')->name('tweets.destroy');

    // favorite tweet routes
    Route::post('/favorite', 'FavoriteController@favorite');
    Route::delete('/unfavorite', 'FavoriteController@unfavorite');

    // followers routes
    Route::post('/follow/{followeeId}', 'FollowController@follow')->where('followeeId', '[0-9]+');
    Route::delete('/unfollow/{followeeId}', 'FollowController@unfollow')->where('followeeId', '[0-9]+');
});
