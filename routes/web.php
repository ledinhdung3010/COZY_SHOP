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
     // bill detail
     Route::get('billDetail',[OderController::class,'viewBillDetail'])->name('view.billdetail');
  
    //checkout
    Route::get('checkout/index',[OderController::class,'viewCheckout'])->name('order.viewCheckout');
 
    Route::get('callBackVnpay',[OderController::class,'callBackVnpay'])->name('view.vnpay');
});
Route::as('frontend.')->middleware(['check.user.login'])->group(function(){
    //logout
    Route::get('logout',[LoginController::class,'logout'])->name('logout');
    //add cart
    Route::Post('add-cart',[CartController::class,'add'])->name('cart.add');
    // delete cart
    Route::Post('remove-cart',[CartController::class,'delete'])->name('cart.delete');
    //detail cart
    Route::get('detail-cart',[CartController::class,'detail'])->name('cart.detail');
    //edit cart
    Route::Post('editdetail-cart',[CartController::class,'editdetail'])->name('cart.editdetail');
    //checkout
    Route::get('checkout',[OderController::class,'checkout'])->name('order.checkout');
    //order_detail
    Route::get('order_detail',[OderController::class,'showorder'])->name('order_detail');
    //show cart
    Route::get('Cart',[OderController::class,'cart'])->name('order.cart');
    //payment
    Route::post('payment',[OderController::class,'payment'])->name('order.payment');
 
    //review
    Route::Post('createReview',[ReviewController::class,'createReview'])->name('createReview');
    //vnpay
    Route::get('order_detail_vnpay',[OderController::class,'handleVnPayCallback'])->name('order.order_detail_vnpay');
   
});
