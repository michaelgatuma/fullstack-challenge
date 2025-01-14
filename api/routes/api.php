<?php

use App\Http\Controllers\Api\UserController;
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
Route::get('/', fn() => response()->json(['status' => 'online'], 200));
Route::get('/users', [UserController::class, 'index']);
Route::get('/user/{id}', [UserController::class, 'show'])->name('user.show');
