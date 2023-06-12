<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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

Route::get("/",[HomeController::class, 'userHome'])->name("home");

Route::get("/searchBarang",[HomeController::class, 'searchBarang']);

Auth::routes();

// Route Admin
Route::middleware(['auth','user-role:admin'])->group(function()
{
    Route::get("/aktivasielasticsearch",[HomeController::class, 'createElasticSearch']);
    Route::get("/logaktivitas",[HomeController::class, 'getLog']);
});

Route::post('/postBarang',[HomeController::class, 'create'] )->name('postBarang');
Route::post('/updateBarang', [HomeController::class, 'update'] )->name('updateBarang');
Route::get('/deleteBarang/{idBarang}',[HomeController::class, 'delete'])->name("deleteBarang");