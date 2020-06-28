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
Route::prefix('/user/')->group(function(){
    Route::get('reg','User\IndexController@reg'); //注册
    Route::post('reg','User\IndexController@regDo'); 
    Route::get('login','User\IndexController@login'); //登陆
    Route::post('login','User\IndexController@loginDo'); 
    Route::get('center','User\IndexController@center'); //个人中心
});
// API
Route::prefix('/api/user/')->group(function(){
    Route::post('reg','Api\UserController@reg'); //注册
    Route::post('login','Api\UserController@login'); //登陆
    Route::get('center','Api\UserController@center')->middleware('test','check.pri'); //个人中心
});
Route::prefix('/api/my/')->middleware('check.pri')->group(function(){
    Route::get('orders','Api\UserController@orders'); //订单
    Route::get('cart','Api\UserController@cart'); //购物车
});
Route::get('/api/a','Api\TestController@a')->middleware('check.pri','access.filter'); 
Route::get('/api/b','Api\TestController@b')->middleware('check.pri','access.filter'); 
Route::get('/api/c','Api\TestController@c')->middleware('check.pri','access.filter'); 

Route::prefix('/api/')->middleware('check.pri','access.filter')->group(function(){
    Route::get('x','Api\TestController@x'); 
    Route::get('y','Api\TestController@y'); 
    Route::get('z','Api\TestController@z'); 
});
