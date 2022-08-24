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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// 开放的用户登录、注册
Route::post('login', 'AuthController@login')->name('login');
Route::post('register', 'AuthController@register');

// 在刷新有效其内，刷新令牌操作
Route::middleware('refresh.token')->group(function () { // 使用 refresh.token 中间件刷新令牌（只能执行一次！！！）
    Route::post('refresh', 'AuthController@refresh');
});

// 登录状态的业务操作
Route::middleware(['auth:api'])->group(function () { // 判断是否登录 auth:api
    Route::post('logout', 'AuthController@logout');
    Route::get('user-profile', 'AuthController@userProfile');

    // 其它业务
    // ...
});
