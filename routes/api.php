<?php

use App\Http\Controllers\Api\AuthController;
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
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::prefix("customers/")->group(function(){
    Route::post('insert', [CustomerController::class, 'insert'])->name('customers.insert');
    Route::get('index', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('show/{customer_id}', [CustomerController::class, 'show'])->name('customers.show');
    Route::delete('delete/{customer_id}', [CustomerController::class, 'delete'])->name('customers.delete');
});

