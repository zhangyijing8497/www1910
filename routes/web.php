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

Route::get('/user/reg','User\IndexController@reg'); //注册
Route::post('/user/reg','User\IndexController@regDo'); 
Route::get('/user/login','User\IndexController@login'); //登陆
Route::post('/user/login','User\IndexController@loginDo'); 
Route::get('/user/center','User\IndexController@center'); //个人中心

// API
Route::post('/api/user/reg','Api\UserController@reg'); //注册
Route::post('/api/user/login','Api\UserController@login'); //登陆
Route::get('/api/user/center','Api\UserController@center'); //个人中心

