<?php

use Illuminate\Support\Facades\Route;

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

use App\Http\Controllers\ImportController;

Route::get('/import', [ImportController::class, 'index'])->name('import.index');
Route::post('/import/process', [ImportController::class, 'process'])->name('import.process');

Route::get('/', function () {
    return view('welcome');
});
