<?php

use App\Http\Controllers\CostcalculateController;
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

Route::get('/',[CostcalculateController::class,'index']);
Route::post('cost-calculation-pdf', [CostcalculateController::class, 'costCalculate'])->name('cost-calculator');
 
