<?php

use Illuminate\Http\Request;
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
        // 用户
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

        // 成员
        Route::group(['prefix' => 'member'], function () {
            Route::post('', 'MemberController@store');
        });
    });
