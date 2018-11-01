<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('user', 'API\UsersController@getUser')->name('getuser');
Route::get('userdb', 'API\UsersController@getUserDB')->name('getuserdb');
Route::get('blogs', 'API\UsersController@getBlogs')->name('getblogs');
Route::get('blogs/{blog}', 'API\UsersController@getBlog')->name('getblog');
Route::put('blogs/{blog}', 'API\UsersController@updateBlog')->name('updateBlog');
Route::post('blogs/del', 'API\UsersController@deleteBlog')->name('deleteBlog');
Route::post('blogs/crear', 'API\UsersController@createBlog')->name('createBlog');
Route::post('logins', 'API\UsersController@logins')->name('logins');
Route::get('licencia', 'API\UsersController@getLicencia')->name('getLicencia');
