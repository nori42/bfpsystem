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
use App\Http\Controllers\PrintController;
use App\Http\Controllers\FSICReportController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SearchEstablishment;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Authenticate;
use App\Models\Firedrill;
use Illuminate\Auth\Events\PasswordReset;
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

Route::get('/passwordreset', function () {
    return view('users.passwordReset');
})->name('passwordreset');

Route::get('/logout', [LoginController::class, 'logout']);
Route::post('/login', [LoginController::class, 'login']);

//Dashboard
Route::get('/dashboard', [DashboardController::class, 'index']);
//Search
Route::get('/search/establishment',[SearchEstablishment::class,'index']);

//Establishments route
Route::get('/establishments', [EstablishmentController::class, 'index'])->middleware(['auth','userType:ADMIN,FSIC,FIREDRILL'])->name("establishments");
Route::post('/establishments/search', [EstablishmentController::class, 'search'])->middleware(['auth','userType:ADMIN,FSIC,FIREDRILL']);
Route::get('/establishments/create', [EstablishmentController::class, 'create'])->middleware(['auth','userType:ADMIN,FSIC']);
Route::get('/establishments/{id}', [EstablishmentController::class, 'show'])->middleware(['auth','userType:ADMIN,FSIC']);
Route::get('/establishments/{id}/edit', [EstablishmentController::class, 'edit'])->middleware(['auth','userType:ADMIN,FSIC,FIREDRILL']);
Route::get('/establishments/create/{id}', [EstablishmentController::class, 'create_from_owner']);
Route::post('/establishments', [EstablishmentController::class, 'store']);
Route::post('/establishments/store_from_owner/{store_from_owner_id}', [EstablishmentController::class, 'store']);
Route::post('/establishments/{id}/delete', [EstablishmentController::class, 'destroy']);
Route::post('/establishments/{id}/update', [EstablishmentController::class, 'update']);

//Attachments
Route::get('/establishments/fsec/attachment/{id}/{attachFor}', [FsecController::class, 'show_attachment']);
Route::get('/establishments/fsic/attachment/{id}/{attachFor}', [FsicController::class, 'show_attachment']);
Route::get('/establishments/{id}/{attachFor}/attachment', [Firedrillcontroller::class, 'show_attachment']);
Route::post('/establishments/attachment/{attachFor}/{id}/upload', FileUpload::class);

//Fsec routes
Route::get('/establishments/fsec/print/{id}', [FsecController::class, 'print_fsec']);
Route::get('/fsec', [FsecController::class, 'index'])->middleware(['auth','userType:ADMIN,FSEC'])->name('fsec');
Route::post('/fsec', [FsecController::class, 'store']);
Route::get('/fsec/create',[FsecController::class,'create'])->middleware(['auth','userType:ADMIN,FSEC']);
Route::post('/fsec/search', [FsecController::class, 'search'])->middleware(['auth','userType:ADMIN,FSEC']);
Route::get('/fsec/{id}/edit', [FsecController::class, 'edit'])->middleware(['auth','userType:ADMIN,FSEC']);
Route::get('/fsec/{id}', [FsecController::class, 'show'])->middleware(['auth','userType:ADMIN,FSEC']);
Route::put('/fsec/{id}',[FsecController::class,'update'])->middleware(['auth','userType:ADMIN,FSEC']);

//Fsic routes
Route::get('/establishments/{id}/fsic', [FsicController::class, 'index'])->middleware(['auth','userType:ADMIN,FSIC']);
Route::post('/establishments/{id}/fsic', [FsicController::class, 'store']);
Route::put('/establishments/{id}/fsic', [FsicController::class, 'update']);

Route::get('/establishments/fsic/print/{id}', [FsicController::class, 'show_print_fsic'])->middleware(['auth','userType:ADMIN,FSIC']);
Route::put('/establishments/fsic/print/{id}', [FsicController::class, 'print_fsic']);

Route::post('/establishments/fsic/payment/{id}', [FsicController::class, 'store_payment']);
Route::get('/establishments/fsic/payment/{id}', [FsicController::class, 'show_payment'])->middleware('auth');

//Owner routes
Route::get('/owner/{id}/edit', [OwnerController::class, 'edit'])->middleware(['auth','userType:ADMIN,FSIC,FIREDRILL']);
Route::post('/owner/{id}/edit', [OwnerController::class, 'update'])->middleware(['auth','userType:ADMIN,FSIC,FIREDRILL']);

//Firedrill
Route::get('/establishments/{id}/firedrill', [FiredrillController::class, 'index'])->middleware(['auth','userType:ADMIN,FIREDRILL']);
Route::post('/establishments/firedrill/{id}',[FiredrillController::class,'store']);
Route::put('/establishments/firedrill/{id}',[Firedrillcontroller::class,'update']);
Route::get('/establishments/firedrill/print/{id}',[FiredrillController::class, 'show_print_firedrill'])->middleware(['auth','userType:ADMIN,FIREDRILL']);
Route::put('/establishments/firedrill/print/{id}',[Firedrillcontroller::class,'print_firedrill']);

//Print Route
Route::get('/fsic/print/{id}', [PrintController::class, 'show_print_fsic'])->middleware(['auth','userType:ADMIN,FSIC']);
Route::put('/fsic/print/{id}', [PrintController::class, 'print_fsic']);

Route::get('/establishments/fsec/print/{id}', [FsecController::class, 'print_fsec']);

Route::get('/firedrill/print/{id}',[FiredrillController::class, 'show_print_firedrill'])->middleware(['auth','userType:ADMIN,FIREDRILL']);
Route::put('/firedrill/print/{id}',[Firedrillcontroller::class,'print_firedrill']);

Route::get('/fsec/print/{id}',[PrintController::class,'show_print_fsec'])->middleware(['auth','userType:ADMIN,FSEC']);
Route::put('/fsec/print/{id}',[PrintController::class,'print_fsec']);

Route::get('/fsecdisapprove/print/{id}',[PrintController::class,'show_print_fsecdisapprove'])->middleware(['auth','userType:ADMIN,FSEC']);
Route::put('/fsecdisapprove/print/{id}',[PrintController::class,'print_fsecdisapprove']);

Route::get('/fsecchecklist/print/{id}',[PrintController::class,'show_print_fsecchecklist'])->middleware(['auth','userType:ADMIN,FSEC']);
Route::put('/fsecchecklist/print/{id}',[PrintController::class,'']);
//Personnel
Route::get('/personnel',[PersonnelController::class,'index'])->middleware(['auth','userType:ADMIN'])->name('personnel');
Route::post('/personnel',[PersonnelController::class,'store']);

//Users
Route::get('/users',[UserController::class,'index'])->middleware(['auth','userType:ADMIN'])->name('users');
Route::post('/users',[UserController::class,'store']);
Route::get('/users/{id}',[UserController::class,'show'])->middleware('auth');
Route::put('/users/{id}',[UserController::class,'update'])->middleware('auth');

//Reports
Route::get('/reports',[FSICReportController::class,'index'])->middleware('auth')->name('reports');

//Activity Log
Route::get('/activity',function(){ return view('activityLog');})->middleware('auth')->name('activity');

//Archived routes
Route::get('/archived',ArchivedEstablishments::class)->middleware('auth')->name('archived');

//Download routes
Route::get('/download/attachments/{foldername}/{attachFor}/{filename}',FileDownload::class);

Route::get('/settings',function () {
    return view('printSettings');
})->middleware(['auth','userType:ADMIN']);

Route::post('/settings',[SettingsController::class,'update'])->middleware(['auth','userType:ADMIN']);

//Unauathenticated Resources
Route::get('resources/owners',[SearchController::class,'searchOwner']);
Route::get('resources/establishments',[SearchController::class,'searchEstablishment']);
Route::get('resources/buildingplans',[SearchController::class,'searchBuildingPlan']);
Route::get('resources/reports/fsic',[FSICReportController::class,'getFSICReport']);
Route::get('resources/inspection/{id}',[FsicController::class,'getInspection']);

//Others
Route::get('/unauthorized',function () {
    return view('errors.unauthorized');
});

Route::put('/request/passwordreset',[PasswordResetController::class,'resetPassword']);

Route::post('/request/passwordreset',[PasswordResetController::class,'requestPasswordReset']);
