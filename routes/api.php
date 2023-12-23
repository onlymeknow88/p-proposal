<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AreaController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CcowController;
use App\Http\Controllers\API\AmountController;
use App\Http\Controllers\API\BudgetController;
use App\Http\Controllers\API\PurpayController;
use App\Http\Controllers\API\FormNOPController;
use App\Http\Controllers\API\ProposalController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\GlAccountController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//upload ckeditor image proposal not using api middleware
Route::post('/uploadCkeditor', [ProposalController::class, 'uploadCkeditorProposal']);

Route::prefix('proposal')->name('proposal.')->middleware(['auth:api'])->group(function () {
    Route::get('', [ProposalController::class, 'fetch'])->name('fetch');
    Route::post('', [ProposalController::class, 'store'])->name('store');
    Route::post('{id}/update', [ProposalController::class, 'update'])->name('update');
    Route::delete('{id}', [ProposalController::class, 'destroy'])->name('delete');
    Route::post('return/{id}', [ProposalController::class, 'returnPrp'])->name('return');
    Route::post('approve/{id}', [ProposalController::class, 'approval'])->name('approval');

    //uploadFile
    Route::post('/uploadFile', [ProposalController::class, 'uploadFile'])->name('uploadFile');
    Route::delete('/deleteFile/{id}', [ProposalController::class, 'deleteFile'])->name('deleteFile');
});

Route::prefix('ccow')->name('ccow.')->middleware(['auth:api'])->group(function () {
    Route::get('', [CcowController::class, 'fetchAll'])->name('fetchAll');
    Route::post('', [CcowController::class, 'store'])->name('store');
    Route::post('{id}/update', [CcowController::class, 'update'])->name('update');
    Route::delete('{id}', [CcowController::class, 'destroy'])->name('destroy');

    //restore
    Route::post('{id}', [CcowController::class, 'restore'])->name('restore');

    //select2 autocomplete
    Route::get('opt-ccow', [CcowController::class, 'select2Ccow'])->name('select2Ccow');
});

Route::prefix('area')->name('area.')->middleware(['auth:api'])->group(function () {
    Route::get('', [AreaController::class, 'fetchAll'])->name('fetchAll');
    Route::post('', [AreaController::class, 'store'])->name('store');
    Route::post('{id}/update', [AreaController::class, 'update'])->name('update');
    Route::delete('{id}', [AreaController::class, 'destroy'])->name('destroy');

    //restore
    Route::post('{id}', [AreaController::class, 'restore'])->name('restore');

    //select2 autocomplete
    Route::get('opt-area', [AreaController::class, 'select2Area'])->name('select2Area');
});

Route::prefix('budget')->name('budget.')->middleware(['auth:api'])->group(function () {
    Route::get('', [BudgetController::class, 'fetchAll'])->name('fetchAll');
    Route::post('', [BudgetController::class, 'store'])->name('store');
    Route::post('{id}/update', [BudgetController::class, 'update'])->name('update');
    Route::delete('{id}', [BudgetController::class, 'destroy'])->name('destroy');

    //restore
    Route::post('{id}', [BudgetController::class, 'restore'])->name('restore');
    //select2 autocomplete
    Route::get('opt-budget', [BudgetController::class, 'select2Budget'])->name('select2Budget');
});

Route::prefix('gl-acc')->name('gl-acc.')->middleware(['auth:api'])->group(function () {
    Route::get('', [GlAccountController::class, 'fetchAll'])->name('fetchAll');
    Route::post('', [GlAccountController::class, 'store'])->name('store');
    Route::post('{id}/update', [GlAccountController::class, 'update'])->name('update');
    Route::delete('{id}', [GlAccountController::class, 'destroy'])->name('destroy');

    //restore
    Route::post('{id}', [GlAccountController::class, 'restore'])->name('restore');

    //select2 autocomplete
    Route::get('opt-gl-acc', [GlAccountController::class, 'select2GlAcc'])->name('select2GlAcc');
});

Route::prefix('amount')->name('amount.')->middleware(['auth:api'])->group(function () {
    Route::get('', [AmountController::class, 'fetchAll'])->name('fetchAll');
    Route::post('', [AmountController::class, 'store'])->name('store');
    Route::post('{id}/update', [AmountController::class, 'update'])->name('update');
    Route::delete('{id}', [AmountController::class, 'destroy'])->name('destroy');

    //restore
    Route::post('{id}', [AmountController::class, 'restore'])->name('restore');

    //select2 autocomplete
    Route::get('opt-amount', [AmountController::class, 'select2Amount'])->name('select2Amount');
});

Route::prefix('purpay')->name('purpay.')->middleware(['auth:api'])->group(function () {
    Route::get('', [PurpayController::class, 'fetchAll'])->name('fetchAll');
    Route::post('', [PurpayController::class, 'store'])->name('store');
    Route::post('{id}/update', [PurpayController::class, 'update'])->name('update');
    Route::delete('{id}', [PurpayController::class, 'destroy'])->name('destroy');

    //restore
    Route::post('{id}', [PurpayController::class, 'restore'])->name('restore');

    //select2 autocomplete
    Route::get('opt-purpay', [PurpayController::class, 'select2Purpay'])->name('select2Purpay');
});

Route::prefix('form-nop')->name('form-nop.')->middleware(['auth:api'])->group(function () {
    Route::get('', [FormNOPController::class, 'fetchAll'])->name('fetchAll');
    Route::post('', [FormNOPController::class, 'store'])->name('store');
    Route::post('{id}/update', [FormNOPController::class, 'update'])->name('update');
    Route::delete('{id}', [FormNOPController::class, 'destroy'])->name('destroy');

    //restore
    Route::post('{id}', [FormNOPController::class, 'restore'])->name('restore');

    //download pdf
    Route::get('pdf', [FormNOPController::class,'downloadPDF'])->name('downloadPDF');

    //select2 autocomplete
});

Route::prefix('dashboard')->name('dashboard.')->middleware(['auth:api'])->group(function () {
    Route::get('', [DashboardController::class, 'index'])->name('index');
});

// Auth API
Route::name('auth.')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('auto-login', [AuthController::class, 'autoLogin'])->name('auto-login');

    Route::middleware('auth:api')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('user-auth', [AuthController::class, 'fetch'])->name('fetch');
        Route::get('user-cek', [AuthController::class, 'cekUserHomepage'])->name('cekUserHomepage');
    });
});
