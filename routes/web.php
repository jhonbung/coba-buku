<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\EbookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MerchandiseController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\NovelController;
use Illuminate\Support\Facades\Route;

// 1. Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// 2. Novels
Route::get('/novels', [NovelController::class, 'index'])->name('novels.index');
Route::get('/novels/{slug}', [NovelController::class, 'show'])->name('novels.show');

// 3. E-Books
Route::get('/ebooks', [EbookController::class, 'index'])->name('ebooks.index');
Route::get('/ebooks/download/{id}', [EbookController::class, 'downloadDemo'])->name('ebooks.download');

// 4. Merchandise
Route::get('/merchandise', [MerchandiseController::class, 'index'])->name('merchandise.index');
Route::get('/merchandise/{slug}', [MerchandiseController::class, 'show'])->name('merchandise.show');

// 5. About the Author
Route::get('/about-author', [AuthorController::class, 'index'])->name('author.index');

// 6. Shopping Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// 7. Checkout & Orders
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/order/success/{order_number}', [CheckoutController::class, 'success'])->name('checkout.success');

// 8. Newsletter
Route::post('/newsletter', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

// 9. Admin Authentication
Route::get('/admin/login', [\App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('admin.logout');

// 10. Admin Protected Backend (Strict Auth Guard)
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::get('/orders/{order_number}/resi', [AdminController::class, 'printResi'])->name('orders.resi');
    Route::post('/orders/{order_number}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.status');
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::get('/products/create', [AdminController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/{id}/edit', [AdminController::class, 'editProduct'])->name('products.edit');
    Route::put('/products/{id}', [AdminController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{id}', [AdminController::class, 'destroyProduct'])->name('products.destroy');
    Route::post('/products/{id}/stock', [AdminController::class, 'updateStock'])->name('products.stock');
});
