<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MasterSalesController;

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
        Route::resource('/', MasterSalesController::class);
    });

});

