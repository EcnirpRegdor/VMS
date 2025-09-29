<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AddUserController;

use Illuminate\Http\Request;

use Illuminate\Auth\Events\Login;

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

Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/visitors/filter', [VisitorController::class, 'searchFilter'])->name('search.filter');
    Route::get('/visitors/spfilter', [VisitorController::class, 'searchFilterVisitors'])->name('search.spfilter');
    Route::get('/visitors', [VisitorController::class,'viewVisitor'])->name('view.visitors');

    Route::put('/visitors/edit', [VisitorController::class,'editVisitor'])->name('edit.visitor');
    Route::post('/create-visitor', [VisitorController::class,'createVisitor'])->name('create.visitor');

    Route::get('/logs'  , [LogsController::class,'viewLogs'])->name('view.logs');
    Route::get('/logs/{id}'  , [LogsController::class,'viewLogsAdmin'])->name('view.logsadmin')->where('id', '[0-9]+') ;
    Route::get('/logs/filter', [LogsController::class, 'searchFilterLogs'])->name('search.filterlogs');
    Route::get('/logs/spfilter', [LogsController::class,'spsearchFilterLogs'])->name('search.spfilterlogs');
    Route::get('/logs/spfilter/{id}', [LogsController::class, 'spsearchFilterLogsAdmin'])->name('search.spfilterlogsadmin');
    Route::get('/logs/filter/{id}', [LogsController::class, 'searchFilterLogsAdmin'])->name('search.filterlogsadmin');

    Route::post('/logs/add' , [LogsController::class,'createLog'])->name('add.log');
    Route::put('/logs/edit', [LogsController::class,'editLog'])->name('edit.log');

    Route::post('/logs/downloadexcel', [LogsController::class, 'downloadExcel'])->name('download.log');
    Route::post('/logs/delete', [LogsController::class,'deleteLog'])->name('delete.log');
    Route::get('/dashboard', [DashboardController::class,'viewDashboard'])->name('view.dashboard');
    Route::get('/dashboard/{id}', [DashboardController::class, 'sViewDashboard'])->name('sview.dashboard');

    Route::get('/add-user', [AddUserController::class, 'viewUser'])->name('view.user');
    Route::put('/add-user/edit', [AddUserController::class, 'editUser'])->name('edit.user');
    Route::post('/add-user/add', [AddUserController::class, 'addUser'])->name('add.user');
    Route::post('/add-user/delete', [AddUserController::class, 'deleteUser'])->name('delete.user');
    Route::get('/add-user/filter', [AddUserController::class, 'searchUser'])->name('search.user');
    Route::get('/add-user/spfilter', [AddUserController::class, 'spSearchUser'])->name('spsearch.user');
    Route::get('/api/visits/{deptId}', [DashboardController::class, 'getVisitsData'])->name('getvisits');

    Route::put('/config-user', [UserController::class, 'configUser'])->name('config.user');
});

Route::fallback(function(){ return response()->view('errors.404', [], 404); });

Route::view('/captcha', 'login-captcha');
Route::post('/captcha-submit', [UserController::class, 'handleCaptcha'])->name('handle.captcha');

Route::get('/login/azure/redirect', [UserController::class, 'handleAzureCallback'])->name('azure.login');
Route::get('/login/azure', [UserController::class, 'redirectToAzure'])->name('azure.redirectlogin');

Route::post('/login', [UserController::class,'login']);
Route::get('/logout', [UserController::class, 'logout']);