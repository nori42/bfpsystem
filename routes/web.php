<?php

use App\Http\Controllers\ArchivedEstablishments;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EstablishmentController;
use App\Http\Controllers\FileDownload;
use App\Http\Controllers\FileUpload;
use App\Http\Controllers\Firedrillcontroller;
use App\Http\Controllers\FsicController;
use App\Http\Controllers\FsecController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SearchEstablishment;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Authenticate;
use App\Models\Firedrill;
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
 
//Authenticate
Route::get('/', function () {
    return view('index');
})->name('login');

Route::get('/logout', [LoginController::class, 'logout']);
Route::post('/login', [LoginController::class, 'login']);

//Dashboard
Route::get('/dashboard', [DashboardController::class, 'index']);
//Search
Route::get('/search/establishment',[SearchEstablishment::class,'index']);

//Establishments route
Route::get('/establishments', [EstablishmentController::class, 'index'])->middleware('auth');
Route::get('/establishments/search', [EstablishmentController::class, 'search'])->middleware('auth');
Route::get('/establishments/create', [EstablishmentController::class, 'create'])->middleware('auth');
Route::get('/establishments/{id}', [EstablishmentController::class, 'show'])->middleware('auth');
Route::get('/establishments/create/{id}', [EstablishmentController::class, 'create_from_owner']);
Route::post('/establishments', [EstablishmentController::class, 'store']);
Route::post('/establishments/store_from_owner/{store_from_owner_id}', [EstablishmentController::class, 'store']);
Route::post('/establishments/{id}/delete', [EstablishmentController::class, 'destroy']);
Route::post('/establishments/{id}/update', [EstablishmentController::class, 'update']);
Route::get('/establishments/{id}', [EstablishmentController::class, 'show'])->middleware('auth');

//Attachments
Route::get('/establishments/fsec/attachment/{id}/{attachFor}', [FsecController::class, 'show_attachment']);
Route::get('/establishments/fsic/attachment/{id}/{attachFor}', [FsicController::class, 'show_attachment']);
Route::get('/establishments/{id}/{attachFor}/attachment', [Firedrillcontroller::class, 'show_attachment']);
Route::post('/establishments/attachment/{attachFor}/{id}/upload', FileUpload::class);

//Fsec routes
Route::get('/establishments/fsec/print/{id}', [FsecController::class, 'print_fsec']);
Route::get('/fsec', [FsecController::class, 'index']);
Route::get('/fsec/create',[FsecController::class,'create']);
Route::post('/establishments/fsec/{id}', [FsecController::class, 'store']);

//Fsic routes
Route::get('/establishments/{id}/fsic', [FsicController::class, 'index'])->middleware('auth');
Route::post('/establishments/{id}/fsic', [FsicController::class, 'store']);
Route::put('/establishments/{id}/fsic', [FsicController::class, 'update']);

Route::get('/establishments/fsic/print/{id}', [FsicController::class, 'show_print_fsic'])->middleware('auth');
Route::put('/establishments/fsic/print/{id}', [FsicController::class, 'print_fsic']);

Route::post('/establishments/fsic/payment/{id}', [FsicController::class, 'store_payment']);
Route::get('/establishments/fsic/payment/{id}', [FsicController::class, 'show_payment'])->middleware('auth');

//Firedrill
Route::get('/establishments/{id}/firedrill', [FiredrillController::class, 'index'])->middleware('auth');
Route::post('/establishments/firedrill/{id}',[FiredrillController::class,'store']);
Route::put('/establishments/firedrill/{id}',[Firedrillcontroller::class,'update']);
Route::get('/establishments/firedrill/print/{id}',[FiredrillController::class, 'show_print_firedrill'])->middleware('auth');
Route::put('/establishments/firedrill/print/{id}',[Firedrillcontroller::class,'print_firedrill']);

//Print Route
Route::get('/fsic/print/{id}', [FsicController::class, 'show_print_fsic'])->middleware('auth');
Route::put('/fsic/print/{id}', [FsicController::class, 'print_fsic']);

Route::get('/establishments/fsec/print/{id}', [FsecController::class, 'print_fsec']);

Route::get('/firedrill/print/{id}',[FiredrillController::class, 'show_print_firedrill'])->middleware('auth');
Route::put('/firedrill/print/{id}',[Firedrillcontroller::class,'print_firedrill']);

//Personnel
Route::get('/personnel',[PersonnelController::class,'index'])->middleware('auth');
Route::post('/personnel',[PersonnelController::class,'store']);

//Users
Route::get('/users',[UserController::class,'index'])->middleware('auth');
Route::post('/users',[UserController::class,'store']);

//Archived routes
Route::get('/archived',ArchivedEstablishments::class)->middleware('auth');

//Download routes
Route::get('/download/attachments/{foldername}/{attachFor}/{filename}',FileDownload::class);

//Unauathenticated Resources
Route::get('resources/owners',[SearchController::class,'searchOwner']);
Route::get('resources/establishments',[SearchController::class,'searchEstablishment']);
Route::get('resources/inspection/{id}',[FsicController::class,'getInspection']);

