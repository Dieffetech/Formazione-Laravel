<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::prefix("customer")->group(function (){
    Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('/store/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/show/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    Route::get('/edit/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/update/{customer}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/delete/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');
});


require __DIR__.'/auth.php';
