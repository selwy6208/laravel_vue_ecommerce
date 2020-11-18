<?php

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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
require "admin.php";
Route::view('/admin/{r}', 'admin_layout')->where('r', '.*');

Route::view('{any}', 'site')->where('any','.*');

Route::view('/offline', 'offline');
Route::get('/product/{id}', function ($id){
	$product = Product::findOrFail($id);
    return view('product',[ 'product' =>  new ProductResource($product) ]);
});

// Route::view('/user-login', 'user_login')->name('login');


// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
