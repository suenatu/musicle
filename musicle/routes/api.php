<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\UserController;

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
    Route::get('userlist', [UserController::class, 'index']);
    Route::get('get_profile/{id}', [UserController::class, 'get_profile']);
});
