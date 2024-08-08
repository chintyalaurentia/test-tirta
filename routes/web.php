<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\MasterSalesController;
use App\Http\Controllers\TransactionController;

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
Route::get('/index', [HomeController::class, 'index'])->name('index');


Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/master')->name('master.')->group(function(){
    Route::prefix('/sales')->name('sales.')->group(function(){
        Route::put('/{id}', [MasterSalesController::class, 'update'])->name('update'); // Update route
        Route::get('/{id}/edit', [MasterSalesController::class, 'edit'])->name('edit'); // New edit route
        Route::delete('/{id}', [MasterSalesController::class, 'destroy'])->name('destroy'); // Destroy route
        Route::get('datatable', [MasterSalesController::class, 'datatable'])->name('datatable');
        Route::post('/import/', [MasterSalesController::class, 'import'])->name('import');
        Route::get('/export/', [MasterSalesController::class, 'export'])->name('export');
        Route::resource('/', MasterSalesController::class);
    });

});

Route::prefix('/transaction')->name('transaction.')->group(function(){
        Route::put('/{id}', [TransactionController::class, 'update'])->name('update'); // Update route
        Route::get('/{id}/edit', [TransactionController::class, 'edit'])->name('edit'); // New edit route
        Route::delete('/{id}', [TransactionController::class, 'destroy'])->name('destroy'); // Destroy route
        Route::get('datatable', [TransactionController::class, 'datatable'])->name('datatable');
        Route::post('/import/', [TransactionController::class, 'import'])->name('import');
        Route::get('/export/', [TransactionController::class, 'export'])->name('export');
        Route::resource('/', TransactionController::class);
});

Route::prefix('/penjualan')->name('penjualan.')->group(function(){
    Route::put('/{id}', [PenjualanController::class, 'update'])->name('update'); // Update route
    Route::get('/{id}/edit', [PenjualanController::class, 'edit'])->name('edit'); // New edit route
    Route::delete('/{id}', [PenjualanController::class, 'destroy'])->name('destroy'); // Destroy route
    Route::get('datatable', [PenjualanController::class, 'datatable'])->name('datatable');
    Route::post('/import/', [PenjualanController::class, 'import'])->name('import');
    Route::get('/export/', [PenjualanController::class, 'export'])->name('export');
    Route::resource('/', PenjualanController::class);
});

