<?php

use App\Http\Controllers\ApprovisionnementController;
use App\Http\Controllers\CaController;
use App\Http\Controllers\CaiseController;
use App\Http\Controllers\chequecom;
use App\Http\Controllers\ChequeController;
use App\Http\Controllers\CommerciauxController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboreadController;
use App\Http\Controllers\ImportationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SkuController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\usersController;
use App\Http\Controllers\VersementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboreadController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('/users',usersController::class)->middleware(['auth', 'verified']);
Route::resource('/costumer',CustomerController::class)->middleware(['auth', 'verified']);
Route::resource('/ca',CaController::class)->middleware(['auth', 'verified']);
Route::resource('/importations',ImportationController::class)->middleware(['auth', 'verified']);
Route::resource('/sku',SkuController::class)->middleware(['auth', 'verified']);
Route::resource('/caise',CaiseController::class)->middleware(['auth', 'verified']);
Route::resource('/verement',VersementController::class)->middleware(['auth', 'verified']);
Route::resource('/stock',StockController::class)->middleware(['auth', 'verified']);
Route::resource('/cheque',ChequeController::class)->middleware(['auth', 'verified']);
Route::resource('/vendeur',CommerciauxController::class)->middleware(['auth', 'verified']);
Route::resource('/cheques',chequecom::class)->middleware(['auth', 'verified']);


Route::post('/import-stock-initial', [StockController::class, 'importStockInitial'])->name('si.import');
Route::post('/import-inventaire', [StockController::class, 'importInventaire'])->name('inventaire.import');
Route::post('/import-charge', [StockController::class, 'importCharge'])->name('charge.import');
Route::put('/chequeval/{id}',[chequecom::class,'valcheque'])->name('val');
Route::get('/contunier/{id}', [chequecom::class, 'contunier'])->name('jj');
Route::post('/cdn', [chequecom::class, 'storeContinued'])->name('cdn');

require __DIR__.'/auth.php';
