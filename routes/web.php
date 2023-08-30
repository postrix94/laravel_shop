<?php


use App\Http\Controllers\Ajax\RemoveImageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\{DashboardController,CategoryController,ProductController};
use App\Http\Controllers\{Ajax\Payments\PaypalController,
    CartController,
    CategoriesController,
    CheckoutController,
    Orders\ThankYouPageController,
    ProductsController};
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout');

    Route::get('order/{orderId}/thank-you', [ThankYouPageController::class, 'thankYou'])->name('payment.thank-you');



});

require __DIR__.'/auth.php';



Route::prefix('admin')->middleware(['auth', 'role:admin|moderator'])->name('admin.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories',CategoryController::class)->except(['show']);
    Route::resource('products',ProductController::class);
});

Route::name('ajax.')->middleware(['auth'])->prefix('ajax')->group(function() {
    Route::group(['role:admin|moderator'], function() {
        Route::delete('images/{image}', RemoveImageController::class)->name('images.delete');
    });

    Route::prefix('paypal')->name('paypal.')->group(function () {
        Route::post('order/create', [PaypalController::class, 'create'])->name('orders.create');
        Route::post('order/{orderId}/capture', [PaypalController::class, 'capture'])->name('orders.capture');
    });
});

Route::get('/', HomeController::class)->name('home');
Route::resource('products', ProductsController::class)->only(['index','show']);
Route::resource('categories',CategoriesController::class)->only(['index','show']);

Route::name('cart.')->prefix('cart')->group(function() {
   Route::get('/', [CartController::class, 'index'])->name('index');
   Route::post('{product}', [CartController::class, 'add'])->name('product');
   Route::delete('/', [CartController::class, 'delete'])->name('delete');
   Route::post('{product}/count', [CartController::class, 'countUpdate'])->name('count.update');
});

Route::fallback(fn()=> abort(404));

