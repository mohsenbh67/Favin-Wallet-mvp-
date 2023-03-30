<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ApiWalletController;
use App\Http\Controllers\API\ApiTransactionController;
use App\Http\Controllers\API\ApiUserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::fallback(function (){
    return response()->json([
        'msg' => 'Route Not Found'
    ],404);
});

//Register and login user
Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');

});

//User API routes
Route::controller(ApiUserController::class)->group(function () {
    Route::get('all-users', 'allUsers');
    Route::put('edit-users/{user_id}', 'editUsers');
    
});

//Wallets API routes
Route::controller(ApiWalletController::class)->group(function () {
    Route::get('all-wallets', 'allWallets');
    Route::get('user-wallets/{user_id}', 'userWallets');
    Route::post('wallets', 'store');
    Route::put('wallets/{wallet_id}', 'update');
});

//Transactions API  routes
Route::controller(ApiTransactionController::class)->group(function () {
    Route::get('all-transactions', 'allTransactions');
    Route::get('user-transactions/{user_id}', 'userTransactions');
    Route::get('my-transactions', 'myTransactions');
    Route::get('wallet-transactions/{wallet_id}', 'walletTransactions');
    Route::post('transactions/{wallet_id}', 'store');
});
