<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Admin\Users\UserController;
use App\Http\Controllers\Auth\Login\LoginController;
use App\Http\Controllers\Admin\Wallets\WalletController;
use App\Http\Controllers\Auth\Register\RegisterController;
use App\Http\Controllers\Admin\Dashboard\AdminDashboardController;
use App\Http\Controllers\Admin\Transactions\TransactionController;
use Symfony\Component\Mailer\Transport\Smtp\Auth\LoginAuthenticator;

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

Route::fallback(function (){
    return redirect()->route('register-form');
});


Route::middleware('CheckLogin')->group(function () {
//Register
Route::get('/', [RegisterController::class, 'registerForm'])->name('register-form');
Route::middleware('throttle:user-register-limiter')->post('/register', [RegisterController::class, 'register'])->name('register');
Route::get('/register-confirm/{token}', [RegisterController::class, 'registerConfirmForm'])->name('register-confirm-form');
Route::middleware('throttle:user-register-confirm-limiter')->post('/register-confirm/{token}', [RegisterController::class, 'registerConfirm'])->name('register-confirm');
Route::middleware('throttle:user-register-resend-otp-limiter')->get('/register-resend-otp/{token}', [RegisterController::class, 'registerResendOtp'])->name('register-resend-otp');

//Login
Route::get('/login-form', [LoginController::class, 'loginForm'])->name('login-form');
Route::middleware('throttle:user-login-confirm-limiter')->post('/login-confirm', [LoginController::class, 'loginConfirm'])->name('login-confirm');
});
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');





Route::prefix('admin')->middleware('CheckActivation')->group(function () {

    //Admin dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/profile', [ProfileController::class, 'profile'])->name('admin.profile');
    Route::get('/edit-profile', [ProfileController::class, 'editProfile'])->name('admin.edit-profile');
    Route::put('/update-profile', [ProfileController::class, 'updateProfile'])->name('admin.update-profile');


    //Wallets
    Route::prefix('wallets')->group(function () {
        Route::get('/wallets', [WalletController::class, 'Wallets'])->name('admin.wallets.wallets');
        Route::get('/create-new-wallet', [WalletController::class, 'createNewWallet'])->name('admin.wallets.create-new-wallet');
        Route::post('/store', [WalletController::class, 'store'])->name('admin.wallets.store');
        Route::get('/edit/{wallet:slug}', [WalletController::class, 'edit'])->name('admin.wallets.edit');
        Route::put('/update/{wallet:slug}', [WalletController::class, 'update'])->name('admin.wallets.update');
    });

    //Transaction
    Route::prefix('transactions')->group(function () {
        Route::get('/{wallet:slug}', [TransactionController::class, 'transactions'])->name('admin.transactions.transactions');
        Route::get('/deposit/{wallet:slug}', [TransactionController::class, 'deposit'])->name('admin.transactions.deposit');
        Route::get('/withdraw/{wallet:slug}', [TransactionController::class, 'withdraw'])->name('admin.transactions.withdraw');
        Route::post('/store/{wallet:slug}', [TransactionController::class, 'store'])->name('admin.transactions.store');
    });


    //Users
    Route::prefix('users')->middleware('CheckAdmin')->group(function () {
        Route::get('/', [UserController::class, 'users'])->name('admin.users.users');
        Route::get('/edit/{user:slug}', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::get('/wallets/{user:slug}', [UserController::class, 'wallets'])->name('admin.users.wallets');
        Route::get('/wallets/transactions/{wallet:slug}', [UserController::class, 'transactions'])->name('admin.users.transactions');
        Route::put('/update/{user:slug}', [UserController::class, 'update'])->name('admin.users.update');
    });
});
