<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EstablishmentController;
use App\Http\Controllers\FsicController;
use App\Http\Controllers\UserController;
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
 
Route::get('/', function () {
    return view('index');
});

//Dashboard
Route::post('/authenticate', [UserController::class, 'authenticate']);
Route::get('/dashboard', [DashboardController::class, 'index']);

//Establishments route
Route::get('/establishments', [EstablishmentController::class, 'index']);
Route::get('/establishments/create', [EstablishmentController::class, 'create']);
Route::post('/establishments', [EstablishmentController::class, 'store']);

Route::get('/establishments/{id}', [EstablishmentController::class, 'show']);

//Fsic routes
Route::get('/establishments/fsic/{id}', [FsicController::class, 'index']);
Route::post('/establishments/fsic/{id}', [FsicController::class, 'store']);

Route::get('/establishments/fsic/payment/{id}', [FsicController::class, 'show_payment']);
Route::post('/establishments/fsic/payment/{id}', [FsicController::class, 'store_payment']);


Route::get('/establishments/fsic/attachment/{id}', [FsicController::class, 'show_attachment']);

