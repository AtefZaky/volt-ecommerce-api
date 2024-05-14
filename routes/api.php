<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\UserContactController;
use App\Models\Product;
use App\Models\UserContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Category routes

Route::get('/category', [CategoryController::class, 'index']);
Route::post('/category', [CategoryController::class, 'store']);
Route::put('/category/{category}', [CategoryController::class, 'update'])->middleware('admin');
Route::delete('/category/{category}', [CategoryController::class, 'destroy'])->middleware('admin');

// Products routes

Route::get('/product', [ProductController::class, 'index']);
Route::get('/product/{product}', [ProductController::class, 'show']);
Route::post('/product', [ProductController::class, 'store'])->middleware('admin');
Route::post('/product/upload', [ProductController::class, 'storeImage']);
// ->middleware('admin');
Route::put('/product/{product}', [ProductController::class, 'update'])->middleware('admin');
Route::delete('/product/{product}', [ProductController::class, 'destroy'])->middleware('admin');

// Add and Remove from cart routes

Route::post('/cart/add/{product}', [ProductController::class, 'addToCart']);
// ->middleware('auth');
Route::post('/cart/remove/{product}', [ProductController::class, 'removeFromCart']);
// ->middleware('auth');
Route::delete('/cart/delete/{product}', [ProductController::class, 'deleteFromCart']);
// ->middleware('auth');

// Products reviews

Route::get('/review', [ProductController::class, 'indexReviews']);
Route::get('/review/{product}', [ProductController::class, 'showReviews']);
Route::post('/review/{product}', [ProductController::class, 'storeReview'])->middleware('auth');

// User contacts routes

Route::get('/user/contact/{user}', [UserContactController::class, 'show']);
Route::post('/user/contact', [UserContactController::class, 'store'])->middleware('auth');
Route::post('/user/contact/upload', [UserContactController::class, 'storeImage'])->middleware('auth');

// orders

Route::get('/order', [OrderController::class, 'index'])->middleware('admin');
Route::post('/order', [OrderController::class, 'store'])->middleware('auth');
Route::get('/order/{order}', [OrderController::class, 'show'])->middleware('admin');
Route::put('/order/{order}', [OrderController::class, 'update'])->middleware('auth');
// cart

Route::get('/cart', [CartController::class, 'index'])->middleware('auth');

// stats
Route::get('/stats', [StatsController::class, 'index'])->middleware('admin');
