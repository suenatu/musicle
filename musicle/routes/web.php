<?php

use Illuminate\Support\Facades\Route;

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

use App\Http\Controllers\MessageController;

Route::get('fetch_messages/{room_no}', [MessageController::class, 'fetch_messages']);
Route::post('send_messages', [MessageController::class, 'send_message']);

Route::get('/{any}', function() {
    return view('app');
})->where('any', '.*');
