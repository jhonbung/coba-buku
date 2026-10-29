<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminCustomerController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerAuthController;
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

// 3. E-Books & Web Reader
Route::get('/ebooks', [EbookController::class, 'index'])->name('ebooks.index');
Route::get('/ebooks/{slug}', [EbookController::class, 'show'])->name('ebooks.show');
Route::get('/ebooks/download/{id}', [EbookController::class, 'downloadDemo'])->name('ebooks.download');
Route::get('/reader/{slug}', [EbookController::class, 'reader'])->name('reader.show');

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
Route::get('/checkout/payment/{order_number}', [CheckoutController::class, 'payment'])->name('checkout.payment');
Route::post('/checkout/finish/{order_number}', [CheckoutController::class, 'finishPayment'])->name('checkout.finish');
Route::get('/order/success/{order_number}', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/order/{order_number}/resi', [CheckoutController::class, 'resi'])->name('order.resi');
Route::post('/midtrans/callback', [CheckoutController::class, 'handleNotification'])->name('midtrans.callback');
Route::get('/shipping/destinations', [CheckoutController::class, 'searchDestinations'])->name('shipping.destinations');
Route::post('/shipping/calculate', [CheckoutController::class, 'calculateShipping'])->name('shipping.calculate');

// 8. Newsletter
Route::post('/newsletter', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

// 9. Customer Authentication
Route::get('/login', [CustomerAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [CustomerAuthController::class, 'login'])->name('login.submit');
Route::get('/register', [CustomerAuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [CustomerAuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('logout');

// Customer Account Protected
Route::middleware('auth')->group(function () {
    Route::get('/account/profile', [CustomerAuthController::class, 'profile'])->name('account.profile');
    Route::post('/account/profile', [CustomerAuthController::class, 'updateProfile'])->name('account.profile.update');
    Route::get('/account/orders', [CustomerAuthController::class, 'orders'])->name('account.orders');
});

// 10. Live Chat (Customer Side)
Route::get('/chat/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
Route::get('/chat/unread-count', [ChatController::class, 'getUnreadCount'])->name('chat.unread_count');

// 11. Admin Authentication
Route::get('/admin/login', [\App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('admin.logout');

// 12. Admin Protected Backend (Strict Auth Guard)
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

    // Video Teaser Management
    Route::get('/videos', [AdminController::class, 'videos'])->name('videos');
    Route::get('/videos/create', [AdminController::class, 'createVideo'])->name('videos.create');
    Route::post('/videos', [AdminController::class, 'storeVideo'])->name('videos.store');
    Route::get('/videos/{id}/edit', [AdminController::class, 'editVideo'])->name('videos.edit');
    Route::put('/videos/{id}', [AdminController::class, 'updateVideo'])->name('videos.update');
    Route::delete('/videos/{id}', [AdminController::class, 'destroyVideo'])->name('videos.destroy');
    Route::post('/videos/{id}/activate', [AdminController::class, 'activateVideo'])->name('videos.activate');

    // E-Book Parts Management
    Route::get('/ebook-parts', [AdminController::class, 'ebookPartsHub'])->name('ebook_parts.hub');
    Route::get('/products/{id}/parts', [AdminController::class, 'parts'])->name('products.parts');
    Route::post('/products/{id}/parts', [AdminController::class, 'storePart'])->name('products.parts.store');
    Route::delete('/products/parts/{part_id}', [AdminController::class, 'destroyPart'])->name('products.parts.destroy');

    // 13. Customer Management (Admin)
    Route::get('/customers', [AdminCustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/{id}/edit', [AdminCustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/customers/{id}', [AdminCustomerController::class, 'update'])->name('customers.update');
    Route::delete('/customers/{id}', [AdminCustomerController::class, 'destroy'])->name('customers.destroy');

    // 14. Live Chat (Admin Side)
    Route::get('/chat', [ChatController::class, 'adminIndex'])->name('chat.index');
    Route::get('/chat/conversations', [ChatController::class, 'adminGetConversations'])->name('chat.conversations');
    Route::get('/chat/messages/{userId}', [ChatController::class, 'adminGetMessages'])->name('chat.messages');
    Route::post('/chat/send', [ChatController::class, 'adminSendMessage'])->name('chat.send');
});
