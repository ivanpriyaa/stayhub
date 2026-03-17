<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\VillaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return view('login');
});
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware('auth')->name('dashboard');

Route::get('/dashboard', [AuthController::class, 'dashboard'])->middleware('auth')->name('dashboard');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//user
Route::get('/user', [UserController::class, 'user'])->middleware('auth')->name('customer');
Route::get('/user/tambah_user', [UserController::class, 'tambah_user'])->middleware('auth')->name('customer');
Route::post('/user/store', [UserController::class, 'store']);
Route::get('/user/edit_user/{id}', [UserController::class, 'edit_user'])->middleware('auth')->name('customer');
Route::post('/user/update_user/{id}', [UserController::class, 'update_user']);
Route::get('/user/delete_user/{id}', [UserController::class, 'destroy_user']);

// Customer
Route::get('/customer', [CustomerController::class, 'customer'])->middleware('auth')->name('customer');
Route::get('/customer/tambah_customer', [CustomerController::class, 'tambah_customer'])->middleware('auth')->name('customer');
Route::post('/customer/store', [CustomerController::class, 'store']);
Route::get('/customer/edit_customer/{id}', [CustomerController::class, 'edit_customer'])->middleware('auth')->name('customer');
Route::post('/customer/update_customer/{id}', [CustomerController::class, 'update_customer']);
Route::get('/customer/delete_customer/{id}', [CustomerController::class, 'destroy_customer']);

//Villa
Route::get('/villa', [VillaController::class, 'villa'])->middleware('auth')->name('villa');
Route::get('/villa/tambah_villa', [VillaController::class, 'tambah_villa'])->middleware('auth')->name('villa');
Route::get('/villa/edit_villa/{id}', [villaController::class, 'edit_villa'])->middleware('auth')->name('villa');
Route::post('/villa/update_villa/{id}', [villaController::class, 'update_villa']);
Route::post('/villa/store', [VillaController::class, 'store']);
Route::get('/villa/delete_villa/{id}', [VillaController::class, 'destroy_villa']);

// Booking
Route::get('/booking', [BookingController::class, 'booking'])->middleware('auth')->name('booking');
Route::get('/booking/tambah_booking', [BookingController::class, 'tambah_booking'])->middleware('auth')->name('booking');
Route::post('/booking/store', [BookingController::class, 'store'])->middleware('auth')->name('tmbhbooking');
Route::get('/customers/search', [BookingController::class, 'search'])->name('customers.search');
Route::get('/booking/edit_booking/{id}', [BookingController::class, 'edit_booking'])->middleware('auth')->name('editbook');
Route::post('/booking/update_booking/{id}', [BookingController::class, 'update_booking']);
Route::get('/booking/delete_booking/{id}', [BookingController::class, 'destroy_booking']);

//cek villa
Route::get('/availability', [VillaController::class, 'available']);
