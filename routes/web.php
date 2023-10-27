<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{ProductController, CategoryController}; 


Route::get('/', [ProductController::class, 'indexGuest'])->name('products.indexGuest');
Route::post('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::post('/', [ProductController::class, 'filter'])->name('products.filter');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/painel', [ProductController::class, 'index'])->name('painel');
    Route::post('painel/search', [ProductController::class, 'searchAsAdmin'])->name('painel.search');

    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::post('/products/create', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::get('/products/show/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.delete');
    Route::get('/products/{id}', [ProductController::class, 'edit'])->name('products.edit');

    Route::post('/products/category', [CategoryController::class, 'store'])->name('category.store');
    Route::delete('category/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
