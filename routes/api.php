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
    ->group(static function () {
        Route::get('index', 'Controller@index')->name('index.index');
        Route::group(['prefix' => 'auth'], function () {
            Route::post('login', 'AuthController@login');
            Route::post('logout', 'AuthController@logout');
            Route::post('refresh', 'AuthController@refresh');
            Route::post('me', 'AuthController@me')->name('me')->middleware(['jwt.role:user', 'jwt.auth']);
        });
        Route::group(['prefix' => 'admin'], function () {
            Route::post('login', 'LoginController@login');
            Route::post('logout', 'LoginController@logout');
            Route::post('refresh', 'LoginController@refresh');
            Route::post('me', 'LoginController@me')->middleware(['jwt.role:admin', 'jwt.auth'])->name('me');
        });
    });
