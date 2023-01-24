<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Product\ProductDashboard;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Product\StockController as ProductStockController;

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
        Route::prefix('admin/product')->group(function () {
            Route::get('', [ProductDashboard::class, 'index'])->name('product.dashboard');

            Route::prefix('stock')->group(function () {
                Route::get("", [ProductStockController::class, 'index'])->name('product.stock.index');
                Route::get('/data', [ProductStockController::class, 'GetData'])->name("product.stock.list");

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