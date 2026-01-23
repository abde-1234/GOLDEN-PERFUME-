<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminCommentController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/about', function (Request $request) {
    $request->session()->forget('is_admin');
    return view('about');
})->name('about');

Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
Route::get('/admin', [AdminController::class, 'index'])->name('admin');

Route::get('/admin/products', [AdminProductController::class, 'index'])->name('admin.products.index');
Route::get('/admin/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
Route::post('/admin/products', [AdminProductController::class, 'store'])->name('admin.products.store');
Route::get('/admin/products/{product}/edit', [AdminProductController::class, 'edit'])->name('admin.products.edit');
Route::put('/admin/products/{product}', [AdminProductController::class, 'update'])->name('admin.products.update');
Route::delete('/admin/products/{product}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');

Route::get('/admin/comments', [AdminCommentController::class, 'index'])->name('admin.comments.index');
Route::patch('/admin/comments/{comment}/toggle', [AdminCommentController::class, 'toggle'])->name('admin.comments.toggle');
Route::delete('/admin/comments/{comment}', [AdminCommentController::class, 'destroy'])->name('admin.comments.destroy');

Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
Route::get('/admin/orders/export', [AdminOrderController::class, 'export'])->name('admin.orders.export');
Route::get('/admin/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
Route::patch('/admin/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
Route::delete('/admin/orders/{order}', [AdminOrderController::class, 'destroy'])->name('admin.orders.destroy');
