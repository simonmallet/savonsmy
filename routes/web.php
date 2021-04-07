<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PurchaseOrdersController;

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

    Route::get('/purchase-orders', [PurchaseOrdersController::class, 'index'])->name('purchase_orders.index');
    Route::get('/purchase-orders/add', [PurchaseOrdersController::class, 'addIndex'])->name('purchase_orders.add.index');
    Route::post('/purchase-orders/add', [PurchaseOrdersController::class, 'addSubmit'])->name('purchase_orders.add.submit');
});

require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
