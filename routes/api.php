<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CustomerController;
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
    Route::post('customer/login', [AuthController::class, 'loginCustomer'])->name('customers.login');
    Route::post('user/login', [AuthController::class, 'loginUser'])->name('users.login');
});

Route::prefix("users")->group(function(){
    Route::post('/', [UserController::class, 'insert'])->name('users.insert');
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::get('/{user}', [UserController::class, 'show'])->name('users.show');
    Route::delete('/{user}', [UserController::class, 'delete'])->name('users.delete');
});

Route::prefix("customers")->group(function(){
    Route::post('/', [CustomerController::class, 'insert'])->name('customers.insert');
    Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    Route::delete('/{customer}', [CustomerController::class, 'delete'])->name('customers.delete');
});

