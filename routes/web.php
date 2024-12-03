<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/unauth', function () {
    return view('auth.unauth');
});

Route::middleware(['guest'])->group(function () {
    Route::get('register', [App\Http\Controllers\UserController::class, "register"])->name('register_page');
    Route::POST('register', [App\Http\Controllers\UserController::class, "register_post"])->name('register');
    Route::get('login', [App\Http\Controllers\UserController::class, 'login'])->name('login');
    Route::POST('login', [App\Http\Controllers\UserController::class, 'login_post'])->name('login_post');
});

Route::middleware(['auth'])->group(function () {
    Route::get('logout', [App\Http\Controllers\UserController::class, 'logout'])->name('logout');
    Route::resource('home', App\Http\Controllers\HomeController::class);

    Route::resource('customer', App\Http\Controllers\CustomerController::class);
    Route::get('/search/customer', [App\Http\Controllers\CustomerController::class, 'search'])->name('search');

    Route::resource('sale', App\Http\Controllers\SaleController::class);

    Route::resource('product', App\Http\Controllers\ProductController::class);
    Route::get('/search/product', [App\Http\Controllers\ProductController::class, 'search']);

    Route::get('/autocomplete/product', [App\Http\Controllers\ProductController::class, 'searchProduct']);
    Route::get('/autocomplete/customer', [App\Http\Controllers\CustomerController::class, 'searchCustomer']);
    Route::get('/render/product', [App\Http\Controllers\ProductController::class, 'renderProduct']);
});
Route::middleware(['type.admin'])->group(function () {
    Route::resource('user', App\Http\Controllers\UserController::class);
});
