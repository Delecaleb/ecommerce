<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminCartController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminProductController;



Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/product', [AdminProductController::class, 'index'])->name('product.index');
    Route::post('/product', [AdminProductController::class, 'store'])->name('product.store');
    Route::get('/product-edit/{product}', [AdminProductController::class, 'edit'])->name('product.edit');
    Route::patch('/product/{product}', [AdminProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{product}', [AdminProductController::class, 'destroy'])->name('product.delete');
    Route::get('/cart-item-list', [AdminCartController::class, 'index'])->name('cart.list');
    Route::get('/order-list', [AdminOrderController::class, 'index'])->name('order.list');
    Route::patch('/order/{order}', [AdminOrderController::class, 'update'])->name('order.update');
});
