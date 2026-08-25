<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\install\InstallController;



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
// Route::get('/', function () {
//     return view('welcome');
// });

 
Route::get('/',[InstallController::class,'step0'])->name('step0');
Route::get('/step0',[InstallController::class,'step0'])->name('step0');
Route::get('/step1',[InstallController::class,'step1'])->name('step1');

Route::get('/step2',[InstallController::class,'step2'])->name('step2');
Route::post('purchase_code', [InstallController::class,'purchase_code'])->name('purchase.code');

Route::get('/step3/{error?}',[InstallController::class,'step3'])->name('step3');
Route::post('/database_installation', [InstallController::class,'database_installation'])->name('install.db');

Route::get('/step4', [InstallController::class,'step4'])->name('step4');
Route::get('import_sql', [InstallController::class,'import_sql'])->name('import_sql');

Route::get('/step5', [InstallController::class,'step5'])->name('step5');
Route::post('system_settings', [InstallController::class,'system_settings'])->name('system_settings');





