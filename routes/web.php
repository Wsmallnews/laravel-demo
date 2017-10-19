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

// 图片操作路由
Route::group([], function($router)
{
    $router->post('myUpload', 'FilesController@upload')->name('myUpload');
    $router->any('myEditorUpload', 'FilesController@myEditorUpload')->name('myEditorUpload');
    $router->get('fileOper/{path}', 'FilesController@fileOper')->name('fileOper')->where(['path' => '^[A-Za-z\d\/]*.(png|jpg|jpeg|gif|bmp)$']);
});

// Route::group(['prefix' => '', 'namespace' => 'Demo'], function($router){
//     $router->get('index', 'IndexController@index');
//
//     $router->resource('users', 'UsersController');
// });

Route::group(['prefix' => 'deskapi', 'namespace' => 'DeskApi', 'middleware' => ['thirdauth:thirdwc']], function($router){
    $router->get('/', 'IndexController@index');
});


Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function($router){
    $router->get('/', 'IndexController@index')->name('admin');

    // 后端登录路由器
    $router->get('login', 'Auth\LoginController@showLoginForm')->name('admin.login');
    $router->post('login', 'Auth\LoginController@login')->name('admin.doLogin');
    $router->post('logout', 'Auth\LoginController@logout')->name('admin.logout');

    // 用户路由
    $router->resource('users', 'UsersController', ['names' => 'admin.users']);

    // 文章管理路由
    $router->patch('articles/{article}/updateStatus', 'ArticlesController@updateStatus')->name('admin.articles.updateStatus');
    $router->resource('articles', 'ArticlesController', ['names' => 'admin.articles']);

    // 文章分类管理路由
    $router->resource('articleCats', 'ArticleCatsController', ['names' => 'admin.articleCats']);
});
