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
        Route::delete('/purchase-orders/delete/{orderId}', [PurchaseOrdersController::class, 'deleteSubmit'])->name('purchase_orders.delete.submit');
    });

    Route::group(['prefix' => 'admin', 'middleware' => ['role:super-admin']], function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('poform', [\App\Http\Controllers\Admin\POFormUpdateController::class, 'index'])->name('admin.poform.index');
        Route::post('poform', [\App\Http\Controllers\Admin\POFormUpdateController::class, 'submit'])->name('admin.poform.submit');
        Route::get('orders/{orderId}', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('admin.order.view.index');
        Route::get('orders/{orderId}/status', [\App\Http\Controllers\Admin\OrderController::class, 'indexStatus'])->name('admin.order.view.status');
        Route::put('orders/{orderId}/status', [\App\Http\Controllers\Admin\OrderController::class, 'statusSubmit'])->name('admin.order.view.statusSubmit');
        Route::get('orders/{orderId}/download', [\App\Http\Controllers\Admin\OrderController::class, 'download'])->name('admin.order.download');
        Route::get('user/{userId}/assign_client', [\App\Http\Controllers\Admin\UserController::class, 'assignClientIndex'])->name('admin.user.assign_client.index');
        Route::post('user/{userId}/assign_client', [\App\Http\Controllers\Admin\UserController::class, 'assignClientSubmit'])->name('admin.user.assign_client.submit');
        Route::get('user/{userId}/approve', [\App\Http\Controllers\Admin\UserController::class, 'approveSubmit'])->name('admin.user.approve.submit');
        Route::get('user/{userId}/suspend', [\App\Http\Controllers\Admin\UserController::class, 'suspendSubmit'])->name('admin.user.suspend.submit');
        Route::get('clients', [\App\Http\Controllers\Admin\ClientController::class, 'index'])->name('admin.clients.index');
        Route::get('clients/new', [\App\Http\Controllers\Admin\ClientController::class, 'addIndex'])->name('admin.clients.add.index');
        Route::post('clients/new', [\App\Http\Controllers\Admin\ClientController::class, 'addSubmit'])->name('admin.clients.add.submit');
    });
});

//require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
