<?php

use Illuminate\Support\Facades\Route;

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

Route::prefix('v1')
    ->namespace('Api')
    ->name('api.v1.')
    ->middleware('json')
    ->group(static function () {
        // 测试路由
        Route::get('test', 'IndexController@index');
        // 用户模块
        Route::group(['prefix' => 'auth'], function () {
            // 用户注册
            Route::post('register', 'RegisterController@store');
            // 初始化网站
            Route::post('init', 'InitController@index');
            // 用户登录
            Route::post('login', 'AuthorizationRController@login');
            // 初始化网站
            Route::get('init', 'InitController@index');
            // 用户登出
            Route::get('', 'AuthorizationRController@logout');
            // 用户刷新 TOKEN
            Route::put('', 'AuthorizationRController@refresh');
        });

        // 网站会员模块
        Route::group(['prefix' => 'member'], function () {
            // 添加网站会员
            Route::post('', 'MemberController@store');

            // 网站会员列表
            Route::get('', 'MemberController@index');

            // 网站会员详情
            Route::get('{memberId}', 'MemberController@show');

            // 网站会员更新
            Route::patch('', 'MemberController@update');

            // 网站会员删除
            Route::delete('{id}', 'MemberController@destroy');
        });

        // 后台用户模块
        Route::group(['prefix' => 'user'], function () {
            // 添加网站会员
            Route::post('', 'UserController@store');

            // 网站会员列表
            Route::get('', 'UserController@index');

        });
    });
