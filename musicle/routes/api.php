<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowController;

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

/**
 * ログイン認証が不要なAPI
 */
Route::post('login', LoginController::class)->name('login');
Route::post('logout', LogoutController::class)->name('logout');
// Route::post("/register", [LoginController::class, "register"]);

/**
 * ログイン認証が必要なAPI
 */
Route::group(['middleware' => ['auth:sanctum']], function () {
    // ユーザープロフィール取得API
    Route::get('get_profile/{login_id}', [UserController::class, 'get_profile']);

    Route::get('get_my_profile', [UserController::class, 'get_my_profile']);

    // フォローAPI
    Route::post('follow', [FollowController::class, 'follow']);
    // リムーブAPI
    Route::post('remove', [FollowController::class, 'remove']);

});

/**
 * データ確認用
 */
Route::get('userlist', [UserController::class, 'index']);

