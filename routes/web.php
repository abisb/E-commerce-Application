<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
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

//category routes//
Route::get('category_list', [CategoryController::class, 'index']);
Route::get('category/listing', [CategoryController::class, 'getcategory'])->name('category.listing');
Route::get('category_create', [CategoryController::class, 'category_create'])->name('category.create_index');
Route::post('category/create', [CategoryController::class, 'create'])->name('category.create');
Route::get('/delete_cat/{id}/delete',  [CategoryController::class, 'delete'])->name('delete_cat');
Route::get('edit_cat/{id}/edit', [CategoryController::class, 'edit'])->name('edit_cat.edit');
Route::post('category/update', [CategoryController::class, 'update'])->name('category.update');
//category routes end//

//product routes//
Route::get('product_list', [ProductController::class, 'index']);
Route::get('product/listing', [ProductController::class, 'getproduct'])->name('product.listing');
Route::get('product_create', [ProductController::class, 'product_create'])->name('product.create_index');
Route::post('product/create', [ProductController::class, 'create'])->name('product.create');
Route::post('product/create', [ProductController::class, 'create'])->name('product.create');
Route::get('edit_prod/{id}/edit', [ProductController::class, 'edit'])->name('edit_prod.edit');
Route::post('product/update', [ProductController::class, 'update'])->name('product.update');
Route::get('/delete_prod/{id}/delete',  [CategoryController::class, 'delete'])->name('delete_prod');
//product routes end//
