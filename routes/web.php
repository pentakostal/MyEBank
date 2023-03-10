<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/account', [\App\Http\Controllers\AccountFunctions::class, 'index'])->name('account');
Route::get('/account/create', [\App\Http\Controllers\AccountFunctions::class, 'addAccount']);
Route::post('/deleteAccount', [\App\Http\Controllers\AccountFunctions::class, 'deleteAccount']);
Route::post('/addMoney', [\App\Http\Controllers\AccountFunctions::class, 'addMoney']);
Route::post('/transactionAccount', [\App\Http\Controllers\AccountFunctions::class, 'transitInternal']);
Route::get('/payment', [\App\Http\Controllers\PaymentController::class, 'index'])->name('payment');
Route::post('/makePayment', [\App\Http\Controllers\PaymentController::class, 'payment']);
Route::get('/history', [\App\Http\Controllers\TransactionHistoryController::class, 'index'])->name('history');
Route::get('/historySearch', [\App\Http\Controllers\TransactionHistoryController::class, 'search']);
Route::get('/coinMarket', [\App\Http\Controllers\CoinMarketController::class, 'index'])->name('coinMarket');
Route::post('/buyCoin', [\App\Http\Controllers\CoinMarketController::class, 'buyCrypto']);
Route::post('/sellCoin', [\App\Http\Controllers\CoinMarketController::class, 'sellCrypto']);
Route::get('/keyCard', [\App\Http\Controllers\KeyCardController::class, 'index'])->name('keyCard');
