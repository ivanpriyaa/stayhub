<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\VillaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return view('login');
});
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Customer
Route::get('/customer',[CustomerController::class,'customer'])->middleware('auth')->name('customer');
Route::get('/customer/tambah_customer',[CustomerController::class,'tambah_customer'])->middleware('auth')->name('customer');
Route::post('/customer/store',[CustomerController::class,'store']);
Route::get('/customer/edit_customer/{id}', [CustomerController::class,'edit_customer'])->middleware('auth')->name('customer');
Route::post('/customer/update_customer/{id}', [CustomerController::class,'update_customer']);
Route::get('/customer/delete_customer/{id}', [CustomerController::class,'destroy_customer']);

//Villa
Route::get('/villa',[VillaController::class,'villa'])->middleware('auth')->name('villa');
Route::get('/villa/tambah_villa',[VillaController::class,'tambah_villa'])->middleware('auth')->name('villa');
Route::get('/villa/edit_villa/{id}', [villaController::class,'edit_villa'])->middleware('auth')->name('villa');
Route::post('/villa/update_villa/{id}', [villaController::class,'update_villa']);
Route::post('/villa/store', [VillaController::class,'store']);
Route::get('/villa/delete_villa/{id}', [VillaController::class,'destroy_villa']);