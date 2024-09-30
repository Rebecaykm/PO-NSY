<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\MenuController;
use App\Http\Controllers\Home\ReportsController;
use App\Http\Controllers\Purchasing\QuoteAssignmentController;
use App\Http\Controllers\Purchasing\AssignedRFQController;
use App\Http\Controllers\Purchasing\AssignedRQController;
use App\Http\Controllers\Configuration\UserController;
use App\Http\Controllers\LanguageController;
// use App\Http\Controllers\Home\RequestQuoteController;

    Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/', function () {
        return view('dashboard');
    });

    Route::get('lang/{locale}', [LanguageController::class, 'switchLang'])->name('lang.switch');
    
    // Route::get('/Configuration/users/pdf', [UserController::class, 'pdf'])->name('Configuration.User.pdf');

    /***************************      PURCHASING    ****************************************/
    Route::get('/Purchasing/quoteAssignment/index',              [QuoteAssignmentController::class,'index'])->name('Purchasing.quoteAssignment.index'   );
    Route::get('/Purchasing/requestQuote/index',                 [AssignedRFQController::class,    'index'])->name('Purchasing.requestQuote.index'      );
    Route::get('/Purchasing/requestQuote/{selectedRQ}/pdf',[AssignedRFQController::class,    'pdf'  ])->name('Purchasing.requestQuote.pdf'              );
    Route::get('/Purchasing/requestRequisition/index',           [AssignedRQController::class,     'index'])->name('Purchasing.requestRequisition.index');
    Route::get('/Purchasing/requestRequisition/{selectedRQ}/pdf',[AssignedRQController::class,     'pdf'  ])->name('Purchasing.requestRequisition.pdf'  );

     /***************************         HOME       ****************************************/
    Route::get('/Home/Menu/index',  [MenuController::class,    'index'])->name('Home.Menu.index'  );
    Route::get('/Home/Report/index',[ReportsController::class, 'index'])->name('Home.Report.index');
});
