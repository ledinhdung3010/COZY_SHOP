<?php


use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\LoginController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\ReviewController;
use Doctrine\DBAL\Logging\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\OderController;

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
Route::as('frontend.')->group(function(){
    Route::get('login',[LoginController::class,'index'])->name('login');
    Route::Post('handle-login',[LoginController::class,'handle'])->name('handle.login');
    Route::get('home',[HomeController::class,'index'])->name('home');
    Route::get('home/index',[HomeController::class,'viewIndex'])->name('home.index');
    Route::get('handleProductDetail',[ProductController::class,'detail'])->name('product.detail');
    Route::get('productDetail',[ProductController::class,'view'])->name('product.detail.view');
    Route::get('about',[AboutController::class,'index'])->name('about');
    Route::get('blog',[BlogController::class,'index'])->name('blog');
});
Route::as('frontend.')->group(function(){
    Route::Post('add-cart',[CartController::class,'add'])->name('cart.add');
    Route::Post('createReview',[ReviewController::class,'createReview'])->name('createReview');
    Route::Post('remove-cart',[CartController::class,'delete'])->name('cart.delete');
    Route::get('detail-cart',[CartController::class,'detail'])->name('cart.detail');
    Route::Post('editdetail-cart',[CartController::class,'editdetail'])->name('cart.editdetail');
    Route::get('checkout',[OderController::class,'checkout'])->name('order.checkout');
    Route::get('Cart',[OderController::class,'cart'])->name('order.cart');
    Route::post('payment',[OderController::class,'payment'])->name('order.payment');
    Route::get('order_detail',[OderController::class,'showorder'])->name('order_detail');
    Route::get('order_detail_vnpay',[OderController::class,'handleVnPayCallback'])->name('order.order_detail_vnpay');
    Route::get('callBackVnpay',[OderController::class,'callBackVnpay'])->name('view.vnpay');
    Route::get('billDetail',[OderController::class,'viewBillDetail'])->name('view.billdetail');
});
