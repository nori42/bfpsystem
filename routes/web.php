<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\ArchivedEstablishments;
use App\Http\Controllers\ChangeProfilePicture;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EstablishmentController;
use App\Http\Controllers\ExpiredController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FileDownload;
use App\Http\Controllers\FileUpload;
use App\Http\Controllers\Firedrillcontroller;
use App\Http\Controllers\FiredrillReportController;
use App\Http\Controllers\FireIncidentsController;
use App\Http\Controllers\FsicController;
use App\Http\Controllers\FsecController;
use App\Http\Controllers\FSECReportController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\FSICReportController;
use App\Http\Controllers\PasswordNewController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SearchEstablishment;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Authenticate;
use App\Models\Firedrill;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;
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
    auth()->logout();
    return view('index');
})->name('login');

Route::get('/passwordreset', function () {
    return view('users.passwordReset');
})->name('passwordreset');

Route::get('/logout', [LoginController::class, 'logout']);
Route::post('/login', [LoginController::class, 'login']);

//Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth','userType:ADMINISTRATOR','personnelChecker'])->name('dashboard');
//Search
Route::get('/search/establishment',[SearchEstablishment::class,'index']);

//Establishments route

Route::middleware(['auth','userType:ADMINISTRATOR,FSIC','personnelChecker'])->group(function () {
    Route::get('/establishments/create', [EstablishmentController::class, 'create'])->name("establishments");
    Route::get('/establishments/{id}/edit', [EstablishmentController::class, 'edit']);
    Route::post('/establishments', [EstablishmentController::class, 'store']);
    // Route::get('/establishments/create/{id}', [EstablishmentController::class, 'create_from_owner']);

    Route::post('/establishments/store_from_owner/{store_from_owner_id}', [EstablishmentController::class, 'store']);
    Route::post('/establishments/{id}/delete', [EstablishmentController::class, 'destroy']);
    Route::post('/establishments/{id}/update', [EstablishmentController::class, 'update']);
});

Route::get('/establishments', [EstablishmentController::class, 'index'])->middleware(['auth','userType:ADMINISTRATOR,FSIC,FIREDRILL','personnelChecker'])->name("establishments");
Route::post('/establishments/search', [EstablishmentController::class, 'search'])->middleware(['auth','userType:ADMINISTRATOR,FSIC,FIREDRILL']);
Route::get('/establishments/{id}', [EstablishmentController::class, 'show'])->middleware(['auth','userType:ADMINISTRATOR,FSIC,FIREDRILL']);

Route::middleware(['auth','userType:ADMINISTRATOR,FSIC,FIREDRILL','personnelChecker'])->group(function (){
    //Attachments
    // Route::get('/establishments/{id}/{attachFor}/attachment', [FsecController::class, 'show_attachment']);
    Route::get('/establishments/{id}/firedrill/attachment', [Firedrillcontroller::class, 'show_attachment']);
    Route::get('/establishments/{id}/fsic/attachment', [FsicController::class, 'show_attachment']);
    Route::post('/establishments/attachment/{attachFor}/{id}/upload', FileUpload::class);
});

Route::middleware(['auth','userType:ADMINISTRATOR,FSEC','personnelChecker'])->group(function (){
    //Fsec routes
    Route::get('/establishments/fsec/print/{id}', [FsecController::class, 'print_fsec']);
    Route::get('/fsec', [FsecController::class, 'index'])->name('fsec');
    Route::post('/fsec', [FsecController::class, 'store']);
    Route::get('/fsec/create',[FsecController::class,'create'])->name('fsec');
    Route::post('/fsec/search', [FsecController::class, 'search']);
    Route::put('/fsec/release',[FsecController::class,'release']);
    Route::get('/fsec/pending/',[FsecController::class,'pending']);
    Route::post('/fsec/upload/{for}',[FsecController::class,'uploadDisapproval']);
    Route::post('/fsec/upload/{for}',[FsecController::class,'uploadDisapproval']);
    Route::get('/fsec/{id}/edit', [FsecController::class, 'edit']);
    Route::post('/fsec/{id}/delete', [FsecController::class, 'destroy']);
    Route::get('/fsec/{id}', [FsecController::class, 'show']);
    Route::put('/fsec/{id}',[FsecController::class,'update']);
});

//Fsic routes
Route::middleware(['auth','userType:ADMINISTRATOR,FSIC'])->group(function () {
    
    Route::get('/establishments/{id}/fsic', [FsicController::class, 'index']);
    Route::post('/establishments/{id}/fsic', [FsicController::class, 'store']);
    Route::put('/establishments/{id}/fsic', [FsicController::class, 'update']);

    Route::get('/establishments/fsic/print/{id}', [FsicController::class, 'show_print_fsic']);
    Route::put('/establishments/fsic/print/{id}', [FsicController::class, 'print_fsic']);
});

//Owner routes
Route::get('/owner/{id}/edit', [OwnerController::class, 'edit'])->middleware(['auth','userType:ADMINISTRATOR,FSIC,FIREDRILL']);
Route::post('/owner/{id}/edit', [OwnerController::class, 'update'])->middleware(['auth','userType:ADMINISTRATOR,FSIC,FIREDRILL']);

//Firedrill
Route::get('/establishments/{id}/firedrill', [FiredrillController::class, 'index'])->middleware(['auth','userType:ADMINISTRATOR,FIREDRILL']);
Route::post('/establishments/firedrill/{id}',[FiredrillController::class,'store']);
Route::put('/establishments/firedrill/{id}',[FiredrillController::class,'update']);
// Route::get('/establishments/firedrill/print/{id}',[PrintController::class, 'show_print_firedrill'])->middleware(['auth','userType:ADMINISTRATOR,FIREDRILL']);
// Route::put('/establishments/firedrill/print/{id}',[PrintController::class,'print_firedrill']);

//Print Route
Route::get('/fsic/print/{id}', [PrintController::class, 'show_print_fsic'])->middleware(['auth','userType:ADMINISTRATOR,FSIC']);
Route::put('/fsic/print/{id}', [PrintController::class, 'print_fsic']);

Route::get('/establishments/fsec/print/{id}', [FsecController::class, 'print_fsec']);

Route::get('/firedrill/print/{id}',[PrintController::class, 'show_print_firedrill'])->middleware(['auth','userType:ADMINISTRATOR,FIREDRILL']);
Route::put('/firedrill/print/{id}',[Printcontroller::class,'print_firedrill']);

Route::get('/fsec/print/{id}',[PrintController::class,'show_print_fsec'])->middleware(['auth','userType:ADMINISTRATOR,FSEC']);
Route::put('/fsec/print/{id}',[PrintController::class,'print_fsec']);

Route::get('/fsecdisapprove/print/{id}',[PrintController::class,'show_print_fsecdisapprove'])->middleware(['auth','userType:ADMINISTRATOR,FSEC']);
Route::put('/fsecdisapprove/print/{id}',[PrintController::class,'print_fsecdisapprove']);

Route::get('/fsecchecklistform/print/{id}',[PrintController::class,'show_print_fsecchecklistform'])->middleware(['auth','userType:ADMINISTRATOR,FSEC']);
Route::get('/fsecchecklist/print/{id}',[PrintController::class,'show_print_fsecchecklist'])->middleware(['auth','userType:ADMINISTRATOR,FSEC']);
Route::put('/fsecchecklist/print/{id}',[PrintController::class,'']);

//Personnel
Route::get('/personnel',[PersonnelController::class,'index'])->middleware(['auth','userType:ADMINISTRATOR'])->name('personnel');
Route::post('/personnel',[PersonnelController::class,'store'])->middleware(['auth']);
Route::get('/personnel/create',[PersonnelController::class,'create'])->middleware(['auth'])->name('personnel');
Route::get('/personnel/{id}',[PersonnelController::class,'show'])->middleware(['auth','userType:ADMINISTRATOR'])->name('personnel');
Route::get('/personnel/{id}/edit',[PersonnelController::class,'edit'])->middleware(['auth'])->name('personnel');
Route::put('/personnel/{id}/update',[PersonnelController::class,'update']);
Route::post('/personnel/{id}/delete',[PersonnelController::class,'destroy'])->middleware(['auth']);


Route::middleware(['auth','userType:ADMINISTRATOR','personnelChecker'])->group(function(){
    
    // Fireincidents
    Route::get('fireincidents',[FireIncidentsController::class,'index'])->name('fireincidents');
    Route::post('fireincidents',[FireIncidentsController::class,'store']);
    Route::post('fireincidents/delete',[FireIncidentsController::class,'destroy']);
});

//Users
Route::get('/users',[UserController::class,'index'])->middleware(['auth','userType:ADMINISTRATOR'])->name('users');
Route::post('/users',[UserController::class,'store']);
Route::get('/users/{id}',[UserController::class,'show'])->middleware('auth');
Route::put('/users/{id}',[UserController::class,'update'])->middleware('auth');
Route::post('/users/{id}/changeprofile',ChangeProfilePicture::class)->middleware('auth');
Route::put('/users/{id}/updatedesignation',[UserController::class,'updateDesignation'])->middleware('auth');

//Passwords
Route::get('/newpassword',[PasswordNewController::class,'index'])->middleware('auth');
Route::put('/updatepassword',[PasswordNewController::class,'updatePassword'])->middleware('auth');
Route::put('/request/passwordreset',[PasswordResetController::class,'resetPassword']);
Route::post('/request/passwordreset',[PasswordResetController::class,'requestPasswordReset']);

//Reports
Route::get('/reports',[ReportsController::class,'index'])->middleware('auth')->name('reports');
Route::get('/reports/fsic',[FSICReportController::class,'index'])->middleware('auth')->name('reports');
Route::get('/reports/firedrill',[FiredrillReportController::class,'index'])->middleware('auth')->name('reports');
Route::get('/reports/fsec',[FsecReportController::class,'index'])->middleware('auth')->name('reports');
// Route::get('/reports/print/firedrill',[ReportsController::class,'show_firedrill'])->middleware('auth')->name('reports');
// Route::get('/reports/print/fsic',[ReportsController::class,'show_fsic'])->middleware('auth')->name('reports');
// Route::get('/reports/print/fsec',[ReportsController::class,'show_fsec'])->middleware('auth')->name('reports');

//Expired List
Route::get('/expired/inspections',[ExpiredController::class,'inspections'])->middleware('auth')->name('expired');
Route::get('/expired/firedrills',[ExpiredController::class,'firedrills'])->middleware('auth')->name('expired');

//Activity Log
Route::get('/activity',[ActivityController::class,'index'])->middleware('auth')->name('activity');

//Archived routes
Route::get('/archived/establishments',[ArchiveController::class,'establishments'])->middleware('auth')->name('archived');
Route::get('/archived/fsec',[ArchiveController::class,'fsec'])->middleware('auth')->name('archived');
Route::get('/archived/users',[ArchiveController::class,'users'])->middleware('auth')->name('archived');
Route::get('/archived/fsic',[ArchiveController::class,'fsic'])->middleware('auth')->name('archived');
Route::get('/archived/firedrill',[ArchiveController::class,'firedrill'])->middleware('auth')->name('archived');

//Download routes
Route::get('/download/attachments/{foldername}/{attachFor}/{filename}',FileDownload::class);
Route::post('/delete/attachments/{foldername}/{attachFor}/{filename}/{id}',[FileController::class,'delete']);
Route::get('/download/evaluations/{for}/_{id}',[FsecController::class,'downloadDisapproval']);

//Prints Settings
Route::get('/settings',function () {
    return view('printSettings');
})->middleware(['auth','userType:ADMINISTRATOR']);

Route::post('/settings',[SettingsController::class,'update'])->middleware(['auth','userType:ADMINISTRATOR']);

//Search Resources
Route::middleware(['auth'])->group(function(){
    // Route::get('resources/owners',[SearchController::class,'searchOwner']);
    Route::get('resources/establishments',[SearchController::class,'searchEstablishment']);
    Route::get('resources/buildingplans',[SearchController::class,'searchBuildingPlan']);
});

//Others
Route::get('/unauthorized',function () {
    return view('errors.unauthorized');
});
