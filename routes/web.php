<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\user\UserController;
use App\Http\Controllers\admin\AdminController;

//Admin

//Create
Route::get('/createItem', [AdminController::class, 'showCreate'])->name('createItem')->middleware('simple.auth:admin');
Route::post('/createItem', [AdminController::class, 'create'])->name('create')->middleware('simple.auth:admin');
Route::post('/createCategory', [AdminController::class, 'createCategory'])->name('createCategory')->middleware('simple.auth:admin');

//Read
Route::get('/seeItems', [AdminController::class, 'show'])->name('seeItems')->middleware('simple.auth:admin');
Route::get('/seeItems/byCategory/{id}', [AdminController::class, 'showByCategory'])->name('seeByCategory')->middleware('simple.auth:admin');

//Update
Route::get('/updateItem/{id}', [AdminController::class, 'showUpdate'])->name('showUpdateItem')->middleware('simple.auth:admin');
Route::post('/updateItem/{id}', [AdminController::class, 'update'])->name('updateItem')->middleware('simple.auth:admin');

//Delete
Route::delete('/deleteItem/{id}', [AdminController::class, 'destroyItem'])->name('deleteItem')->middleware('simple.auth:admin');
Route::delete('/categories/{id}', [AdminController::class, 'destroyCategory'])->name('deleteCategory')->middleware('simple.auth:admin');


//User  

//Read
Route::get('/', [AuthController::class, 'index'])->name('welcomePage');
Route::get('/shop', [UserController::class, 'shop'])->name('shop');

//Cart
Route::get('/cart', [UserController::class, 'index'])->name('showCart');
Route::post('/cart/invoice', [UserController::class, 'storeInvoice'])->name('storeInvoice');

Route::post('/cart/add/{id}', [UserController::class, 'addToCart'])->name('addToCart');
Route::get('/cart/remove/{id}', [UserController::class, 'removeCart'])->name('removeCart');
Route::post('/cart/update', [UserController::class, 'updateCart'])->name('updateCart');
Route::get('/checkout', [UserController::class, 'checkout'])->name('checkout');

//Invoice
Route::get('/invoices', [UserController::class, 'invoices'])->name('invoices');
Route::get('/invoices/{id}', [UserController::class, 'showInvoice'])->name('showInvoice');

//Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('showLogin');
Route::post('/login', [AuthController::class, 'login'])->name('login');


//Register
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/register', [AuthController::class, 'showRegister'])->name('showRegister');

//Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
