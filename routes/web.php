<?php

use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\ProfileUpdateController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AuthorizationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OptionController;
use App\Http\Controllers\Admin\CommonController;
use App\Http\Controllers\Admin\ContentManagementController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\OrderController;
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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// ------------------main routes------------------------------------------


Route::get('/admin', [AuthorizationController::class, 'adminLoginForm'])->name('admin.login');
Route::post('/adminLogin', [AuthorizationController::class, 'adminLogin'])->name('admin.signin');

Route::prefix('admin')->middleware(['admin'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('logout', [AuthorizationController::class, 'adminLogout'])->name('admin.logout');

    /*IMAGE UPLOAD IN SUMMER NOTE*/
    Route::post('image/upload', [ImageController::class,'upload_image']);
    Route::resource('profile_update', ProfileUpdateController::class);

    /*Common*/
    Route::post('common/changestatus', [CommonController::class,'changeStatus'])->name('common.changestatus');

    /*Users*/
    Route::resource('users', UserController::class);

    /*Categories*/
    Route::resource('category', CategoryController::class);

    /*Products*/
    Route::get('products/import-product', [ProductController::class,'importProduct'])->name('products.import.product');
    Route::post('products/import-product-store', [ProductController::class,'importProductStore'])->name('products.import.product.store');
    Route::post('products/removeimage', [ProductController::class,'removeImage'])->name('products.removeimage');
    Route::post('products/getoptions', [ProductController::class,'getOptions'])->name('products.getoptions');
    Route::resource('products', ProductController::class);

    /*Options*/
    Route::post('options/removeoptionvalues', [OptionController::class,'removeOptionValues'])->name('options.removeoptionvalues');
    Route::resource('options', OptionController::class);

    /*Content Management*/
    Route::resource('content', ContentManagementController::class);

    /*Contact Us*/
    Route::resource('contactus', ContactUsController::class);

    /*Orders*/
    Route::post('orders/addproduct', [OrderController::class,'addProductToCart'])->name('orders.addproduct');
    Route::get('/index_product', [OrderController::class, 'index_product'])->name('orders.index_product');
    Route::resource('orders',OrderController::class);
});
