<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CommonController;
use App\Http\Controllers\Admin\OptionController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PracticeController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StockOrderController;
use App\Http\Controllers\Admin\AuthorizationController;
use App\Http\Controllers\Admin\ProfileUpdateController;
use App\Http\Controllers\Admin\ContentManagementController;
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

    /*Roles*/
    Route::resource('roles', RoleController::class);

    /*Users*/
    Route::resource('users', UserController::class);

    /* Brands */
    Route::resource('brands', BrandController::class);

    /* Suppliers */
    Route::resource('suppliers', SupplierController::class);

    /* Practices */
    Route::resource('practices', PracticeController::class);

    /* Stock order */
    Route::get('stock-orders/brand/{supplierId}', [StockOrderController::class,'getBrandsBySupplier'])->name('brands.by_supplier');
    Route::get('stock-orders/delete_document/{id}/{type}', [StockOrderController::class,'deleteReceiveStockOrderDocuments'])->name('stock-orders.receive_stock_order_and_documents');
    Route::get('stock-orders/get_documents/{id}', [StockOrderController::class,'getReceiveStockOrderDocuments'])->name('stock-orders.get_documents');
    Route::get('/index_receive_stock_order', [StockOrderController::class, 'index_receive_stock_order'])->name('stock-orders.index_receive_stock_order');
    Route::post('stock-orders/store_receive', [StockOrderController::class,'storeReceiveDocuments'])->name('stock-orders.receive-documents');
    Route::post('stock-orders/update_receive', [StockOrderController::class,'updateReceiveDocuments'])->name('stock-orders.edit-receive-documents');

    Route::get('stock-orders/{id}/receive', [StockOrderController::class,'receiveStockOrder'])->name('stock-orders.receive');
    Route::get('receive-stock-orders/{id}/edit', [StockOrderController::class,'receiveStockOrderEdit'])->name('receive-stock-orders.edit');
    Route::post('stock-orders/add_history', [StockOrderController::class,'addStockOrderStatusHistory'])->name('stock-orders.add_history');
    Route::get('stock-orders/get_history/{id}', [StockOrderController::class,'getStockOrderStatusHistory'])->name('stock-orders.get_history');
    Route::post('stock-orders/update_status', [StockOrderController::class,'updateStockOrderStatus'])->name('stock-orders.update_status');
    Route::resource('stock-orders', StockOrderController::class);

    /* report */
    Route::resource('reports', ReportController::class);
});
