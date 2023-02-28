<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductUpdateController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('users',UserController::class);
Route::get('contacts',ContactsController::class);
Route::get('category',CategoryController::class);
Route::get('product',ProductController::class);
Route::get('ProductUpdate',ProductUpdateController::class);
