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
    // echo bcrypt('123456');
    return view('welcome');
});

Route::group(['prefix' => '', 'namespace' => 'Demo'],function($router){
    $router->get('index', 'IndexController@index');
});


Route::group(['prefix' => 'admin', 'namespace' => 'Admin'],function($router){
    $router->get('/', 'IndexController@index')->name('admin');

    $router->get('login', 'Auth\LoginController@showLoginForm')->name('admin.login');
    $router->post('login', 'Auth\LoginController@login')->name('admin.doLogin');
    $router->post('logout', 'Auth\LoginController@logout')->name('admin.logout');
});
