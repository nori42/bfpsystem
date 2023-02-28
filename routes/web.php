<?php

use App\Http\Controllers\EstablishmentController;
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

//Establishments route
Route::get('/establishments', [EstablishmentController::class, 'index']);
Route::get('/establishments/create', [EstablishmentController::class, 'create']);
Route::post('/establishments', [EstablishmentController::class, 'store']);

Route::get('/establishments/{id}', [EstablishmentController::class, 'show']);

Route::get('/establishments/fsic/{id}', [EstablishmentController::class, 'show_fsic']);