<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Configuration\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
// use App\Http\Controllers\Home\RequestQuoteController;

    // Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    // Route::get('/', function () {
    //     return view('dashboard');
    // });
    // Route::view('dashboard', 'dashboard' )->name('dashboard' );
    Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/', function () {
        return view('index');
    });
    Route::view('dashboard', 'dashboard' )->name('dashboard' );

    Route::get('lang/{locale}', [LanguageController::class, 'switchLang'])->name('lang.switch');
    
    Route::get('/index', [HomeController::class, 'index'])->name('index');
    Route::get('/{purchasingOrder}', [HomeController::class, 'show'])->name('show');
    // Route::get('/Configuration/users/pdf', [UserController::class, 'pdf'])->name('Configuration.User.pdf');
});
