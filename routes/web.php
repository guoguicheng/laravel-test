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

Route::get('/', 'HomeController@index');
Route::get('/register', 'View\ViewsController@register');
Route::get('/login', 'View\ViewsController@login');
Route::get('/stulist', 'View\ViewsController@stulist');
Route::get('/teacherlist', 'View\ViewsController@teacherlist');
Route::get('/teacheralllist', 'View\ViewsController@teacheralllist');
Route::get('/followlist', 'View\ViewsController@followlist');

Route::get('/websocket', 'View\ViewsController@websocket');
Route::get('/chat','View\ViewsController@chat');

Route::prefix('callback')->group(function () {
    Route::get('/line/callback', 'CallbackController@lineOauthCallback');
    Route::get('/line/callback/token', 'CallbackController@lineOauthTokenCallback');
});

Route::get('/error','View\ViewsController@error');
