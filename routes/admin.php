<?php
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ChangePasswordController;
use App\Http\Controllers\Admin\ChartController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\ExportUserController;
use App\Http\Controllers\Admin\LoginFacebookController;
use App\Http\Controllers\Admin\LoginGoogleController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\QrCodeController;
use App\Http\Controllers\Admin\RegisterController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Frontend\EmailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
// use App\Http\Middleware\CheckAdminLogin;
use App\Http\Controllers\Admin\ProductController;
Route::prefix('admin')->as('admin.')->group(function(){
    Route::get('login',[LoginController::class,'index'])->middleware('is.login.admin')->name('login');
    Route::post('handle-login',[LoginController::class,'handleLogin'])->name('handle.login');
    
    // login by google
    Route::get('auth/google',[LoginGoogleController::class,'redirectToGoogle'])->name('login.google');
    Route::get('auth/google/callback',[LoginGoogleController::class,'handleGoogleCallback']);
    Route::post('auth/gg',[LoginGoogleController::class,'gg']);
    //login by facebook
    Route::get('auth/facebook',[LoginFacebookController::class,'redirectToFacebook'])->name('login.facebook');
    Route::get('auth/facebook/callback',[LoginFacebookController::class,'handleFacebookCallback']);
    // register
    Route::get('register',[RegisterController::class,'index'])->name('register');
    Route::post('register/create',[RegisterController::class,'create'])->name('register.add');
    Route::get('register/verify',[RegisterController::class,'verify'])->name('register.verify');
    Route::get('register/resendEmail',[RegisterController::class,'resendEmail'])->name('register.resend');
    Route::get('register/resend',[RegisterController::class,'indexResend'])->name('register.resend.index');
    Route::get('register/abc',[RegisterController::class,'checkEmail'])->name('register.resend.abc');
    // resetpassword
    Route::get('resetpassword',[LoginController::class,'resetPassword'])->name('resetpassword');
    Route::post('resetpassword/checkEmail',[LoginController::class,'checkEmail'])->name('resetpassword.checkEmail');
    Route::get('resetpassword/viewResend',[LoginController::class,'viewResend'])->name('resetpassword.viewResend');
    Route::get('sendEmail~id={id}~code={code}',[LoginController::class,'handleResetPassword'])->name('login.emailreset');
    Route::get('resend/resetpassword/sendEmail',[LoginController::class,'resend_ResetPassword'])->name('login.resend_password');
    Route::post('resetpassword/updatePassword~id={id}~code={code}',[LoginController::class,'updatePassword'])->name('login.handleResetPassword');
    Route::get('dashboard',[DashboardController::class,'index'])->name('dashboard');
 
    Route::get('addProduct',[ProductController::class,'add'])->name('product.add');
    Route::get('qrcode',[QrCodeController::class,'generateQRCode'])->name('qrcode');
    Route::post('excelRegister',[LoginController::class,'registerExcel'])->name('excelRegister');
    Route::post('product/export', [ExportUserController::class, 'export'])->name('product.export');
    Route::post('deletesProduct',[ProductController::class,'deletes'])->name('product.deletes');
    Route::get('product',[ProductController::class,'index'])->name('product');
    Route::get('changePassword',[ChangePasswordController::class,'index'])->name('changepassword');
    Route::get('viewProduct',[ProductController::class,'view'])->name('product.view');
    Route::post('renderProduct',[ProductController::class,'renderProduct'])->name('product.render');
    // charts
    Route::get('charts/quantity',[ChartController::class,'index'])->name('charts.quantity');
    Route::post('charts/get',[ChartController::class,'statistical'])->name('charts.get');
    Route::get('charts/amount',[ChartController::class,'amount'])->name('charts.amount');
    Route::post('charts/amount/get',[ChartController::class,'byAmount'])->name('charts.amount.get');
    Route::get('meail',[OrderController::class,'sendEmail'])->name('send');
});

Route::prefix('admin')->middleware(['check.admin.login'])->as('admin.')->group(function(){
    // rep comment
    Route::post('repComment',[ProductController::class,'repComment'])->name('product.repComment');
    //delete comment
    Route::post('deleteComment',[ProductController::class,'deleteComment'])->name('product.deleteComment');
    // tat ca cac routing deu bi middleware kiem soat
    Route::get('checkTimeToken',[LoginController::class,'checkToken'])->name('checkToken');
    Route::post('logout',[LoginController::class,'logout'])->name('logout');
    //user
    Route::get('user',[UserController::class,'index'])->name('user');
    Route::get('add',[UserController::class,'add'])->name('user.add');
    Route::post('user/create',[UserController::class,'create'])->name('user.create');
    Route::get('user/edit/{id}',[UserController::class,'edit'])->name('user.edit');
    Route::post('user/update/{id}',[UserController::class,'update'])->name('user.update');
    Route::delete('user/delete/{id}',[UserController::class,'delete'])->name('user.delete');
    //size
    Route::get('size',[SizeController::class,'index'])->name('size');
    Route::get('size/add',[SizeController::class,'add'])->name('size.add');
    Route::post('size/create',[SizeController::class,'create'])->name('size.create');
    Route::delete('size/delete/{id}',[SizeController::class,'delete'])->name('size.delete');
    Route::get('size/edit/{id}',[SizeController::class,'edit'])->name('size.edit');
    Route::post('size/update/{id}',[SizeController::class,'update'])->name('size.update');
    //dashboard
  
    //order
    Route::get('order',[OrderController::class,'index'])->name('order');
    Route::post('order/no_accept/{extrs_code}',[OrderController::class,'no_accept'])->name('order.no_accept');
    Route::get('accept/{extrs_code}/{id}',[OrderController::class,'accept'])->name('order.accept');
    Route::get('view_order/{id}',[OrderController::class,'view'])->name('view');
    //product
    Route::post('create',[ProductController::class,'create'])->name('product.create');
    Route::delete('delete',[ProductController::class,'delete'])->name('product.delete');
    Route::get('edit/{id}',[ProductController::class,'edit'])->name('product.edit');
    Route::post('update/{id}',[ProductController::class,'update'])->name('product.update');
    //color
    Route::get('color',[ColorController::class,'index'])->name('color');
    Route::get('color/add',[ColorController::class,'add'])->name('color.add');
    Route::get('color/edit/{id}',[ColorController::class,'edit'])->name('color.edit');
    Route::post('color/update/{id}',[ColorController::class,'update'])->name('color.update');
    Route::delete('color/delete/{id}',[ColorController::class,'delete'])->name('color.delete');
    Route::post('color/create',[ColorController::class,'create'])->name('color.create');
    //category
    Route::get('category',[CategoryController::class,'index'])->name('category');
    Route::delete('category/delete/{id}',[CategoryController::class,'delete'])->name('category.delete');
    Route::get('category/edit/{id}',[CategoryController::class,'edit'])->name('category.edit');
    Route::get('category/add',[CategoryController::class,'add'])->name('category.add');
    Route::post('category/create',[CategoryController::class,'create'])->name('category.create');
    Route::post('category/update/{id}',[CategoryController::class,'update'])->name('category.update');
    //tag
    Route::get('tag',[TagController::class,'index'])->name('tag');
    // charts
   
    // change password
    Route::post('changePassword/update',[ChangePasswordController::class,'change'])->name('changepassword.update');
});