<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Product\ProductDashboard;
use App\Http\Controllers\Product\ItemController as ProductItemController;
use App\Http\Controllers\Product\TransactionController as ProductTransactionController;
use App\Http\Controllers\Product\StockController as ProductStockController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\Setting\ResetPasswordController as SettingResetPasswordController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [AuthController::class, 'index'])->name("login");
Route::post('login', [AuthController::class, 'Login']);
Route::post('logout', [AuthController::class, 'Logout']);

Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['permission:product-admin']], function () {
        Route::prefix('product')->group(function () {
            Route::get('', [ProductDashboard::class, 'index'])->name('product.dashboard');

            Route::prefix('item')->group(function () {
                Route::get("", [ProductItemController::class, 'index'])->name('product.item.index');
                Route::get('/data', [ProductItemController::class, 'GetData'])->name("product.item.list");

                Route::group(['middleware' => ['permission:product-item-admin']], function () {
                    Route::get('/add', [ProductItemController::class, 'Create'])->name("product.item.create");
                    Route::post('/add', [ProductItemController::class, 'CreateSubmit'])->name("product.item.create_submit");
                    // Route::post('/import', [ProductItemController::class, 'Import'])->name('product.item.import');

                    Route::get('/{id}', [ProductItemController::class, 'Update'])->name("product.item.edit");
                    Route::post('/{id}', [ProductItemController::class, 'UpdateSubmit'])->name('product.item.edit_submit');

                    Route::delete('/{id}', [ProductItemController::class, 'Delete'])->name('product.item.delete');
                });
            });

            Route::prefix('transaction')->group(function () {
                Route::get("", [ProductTransactionController::class, 'index'])->name('product.transaction.index');
                Route::get('/data', [ProductTransactionController::class, 'GetData'])->name("product.transaction.list");

                Route::group(['middleware' => ['permission:product-transaction-admin']], function () {
                    Route::get('/add', [ProductTransactionController::class, 'Create'])->name("product.transaction.create");
                    Route::post('/add', [ProductTransactionController::class, 'CreateSubmit'])->name("product.transaction.create_submit");
                    // Route::post('/import', [ProductTransactionController::class, 'Import'])->name('product.transaction.import');

                    Route::get('/{id}', [ProductTransactionController::class, 'Update'])->name("product.transaction.edit");
                    Route::post('/{id}', [ProductTransactionController::class, 'UpdateSubmit'])->name('product.transaction.edit_submit');

                    Route::delete('/{id}', [ProductTransactionController::class, 'Delete'])->name('product.transaction.delete');
                });
            });

            Route::prefix('stock')->group(function () {
                Route::get("", [ProductStockController::class, 'index'])->name('product.stock.index');
                Route::get('/data', [ProductStockController::class, 'GetData'])->name("product.stock.list");

                Route::group(['middleware' => ['permission:product-stock-admin']], function () {
                    Route::get('/add', [ProductStockController::class, 'Create'])->name("product.stock.create");
                    Route::post('/add', [ProductStockController::class, 'CreateSubmit'])->name("product.stock.create_submit");
                    // Route::post('/import', [ProductStockController::class, 'Import'])->name('product.stock.import');

                    Route::get('/{id}', [ProductStockController::class, 'Update'])->name("product.stock.edit");
                    Route::post('/{id}', [ProductStockController::class, 'UpdateSubmit'])->name('product.stock.edit_submit');

                    Route::delete('/{id}', [ProductStockController::class, 'Delete'])->name('product.stock.delete');
                });
            });
        });
    });

    Route::prefix('log')->group(function () {
        Route::get("", [LogController::class, 'index'])->name('log.index');
        Route::get('/data', [LogController::class, 'GetData'])->name("log.list");

        Route::get('/add', [LogController::class, 'Create'])->name("log.create");
        Route::post('/add', [LogController::class, 'CreateSubmit'])->name("log.create_submit");
        // Route::post('/import', [LogController::class, 'Import'])->name('log.import');

        Route::get('/{id}', [LogController::class, 'Update'])->name("log.edit");
        Route::post('/{id}', [LogController::class, 'UpdateSubmit'])->name('log.edit_submit');

        Route::delete('/{id}', [LogController::class, 'Delete'])->name('log.delete');
    });

    Route::prefix('setting')->group(function () {
        Route::prefix('reset_password')->group(function () {
            Route::get('/', [SettingResetPasswordController::class, 'index'])->name("setting.reset_password.index");
            Route::post('/', [SettingResetPasswordController::class, 'Submit'])->name("setting.reset_password.submit");
        });
    });
});