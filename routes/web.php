<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('transactions');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// routes/web.php

use App\Http\Controllers\TransactionController;

Route::middleware(['auth'])->group(function () {
    Route::post('/deposit', [TransactionController::class, 'deposit'])->name('deposit');
    Route::post('/withdraw', [TransactionController::class, 'withdraw'])->name('withdraw');
});

