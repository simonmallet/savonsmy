<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PurchaseOrdersController;
use App\Http\Controllers\Admin\AdminDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::group(['middleware' => 'auth'], function() {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::group(['middleware' => ['can:'.\App\Models\User::PERMISSION_FILL_PURCHASE_ORDER]], function () {
        Route::get('/purchase-orders', [PurchaseOrdersController::class, 'index'])->name('purchase_orders.index');
        Route::get('/purchase-orders/add', [PurchaseOrdersController::class, 'addIndex'])->name('purchase_orders.add.index');
        Route::post('/purchase-orders/add', [PurchaseOrdersController::class, 'addSubmit'])->name('purchase_orders.add.submit');
        Route::get('/purchase-orders/update/{orderId}', [PurchaseOrdersController::class, 'updateIndex'])->name('purchase_orders.update.index');
        Route::post('/purchase-orders/update/{orderId}', [PurchaseOrdersController::class, 'updateSubmit'])->name('purchase_orders.update.submit');
    });

    Route::group(['prefix' => 'admin', 'middleware' => ['role:super-admin']], function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('poform', [\App\Http\Controllers\Admin\POFormUpdateController::class, 'index'])->name('admin.poform.index');
        Route::post('poform', [\App\Http\Controllers\Admin\POFormUpdateController::class, 'submit'])->name('admin.poform.submit');
    });
});

//require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
