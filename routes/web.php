<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\InboxAppController;
use App\Http\Controllers\API\FormNOPController;
use App\Http\Controllers\API\ProposalController;

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

Route::get('/inbox', [InboxAppController::class,'index']);
Route::get('/handle', [InboxAppController::class,'handle']);


Route::get('/redirect', [AuthController::class,'redirect']);
Route::get('/callback', [AuthController::class,'callback']);

Route::get('form-nop/pdf', [FormNOPController::class,'downloadPDF'])->name('downloadPDF');
//internal memo
Route::get('proposal/toPDF', [ProposalController::class, 'internalMemoPDF'])->name('internalMemoPDF');

