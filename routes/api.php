<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function (){
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::prefix("users/")->group(function(){
    Route::post('insert', [UserController::class, 'insert'])->name('users.insert');
    Route::get('index', [UserController::class, 'index'])->name('users.index');
    Route::get('show/{user_id}', [UserController::class, 'show'])->name('users.show');
    Route::get('show/{user}', [UserController::class, 'show'])->name('users.show');
    Route::delete('delete/{user_id}', [UserController::class, 'delete'])->name('users.delete');
});

