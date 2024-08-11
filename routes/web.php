<?php

use App\Http\Controllers\SSEController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryInstallController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GroupBallController;
use App\Http\Controllers\InstallController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use SergiX44\Nutgram\Nutgram;


Route::get('/', function () {
    if (!Auth::check()) {
        return redirect('login');
    }
    return redirect()->intended('dashboard');
});

Route::get('login', function () {
    return view('auth.login');
});

Route::post('login', [AuthController::class, 'login'])->name('login');


Route::middleware('auth')->group(function () {

    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/get-group', [DashboardController::class, 'getGroup'])->name('getGroup');
    });

    // установка
    Route::get('/category-install', [CategoryInstallController::class, 'index'])->name('categoryInstall.index');
    Route::get('/category-install/all', [CategoryInstallController::class, 'all'])->name('getCategoryInstall');
    Route::get('/category-install/get/{id}', [CategoryInstallController::class, 'getOne'])->name('categoryInstall.getOne');
    Route::post('/category-install/create/', [CategoryInstallController::class, 'store'])->name('categoryInstall.store');
    Route::put('/category-install/update/{id}', [CategoryInstallController::class, 'update'])->name('categoryInstall.update');
    Route::delete('/category-install/delete/{id}', [CategoryInstallController::class, 'destroy'])->name('categoryInstall.destroy');


    // установка
    Route::get('/install', [InstallController::class, 'index'])->name('install.index');
    Route::get('/install/get/{id}', [InstallController::class, 'getInstall'])->name('getInstall');
    Route::get('/install/one/{id}', [InstallController::class, 'getOne'])->name('install.getOne');
    Route::post('/install/store/', [InstallController::class, 'store'])->name('install.store');
    Route::put('/install/update/{id}', [InstallController::class, 'update'])->name('install.update');
    Route::put('/install/stop/{id}', [InstallController::class, 'stop'])->name('install.stop');

    // service
    Route::get('/service', [ServiceController::class, 'index'])->name('service.index');
    Route::get('/service/get', [ServiceController::class, 'getServices'])->name('getServices');
    Route::get('/service/one/{id}', [ServiceController::class, 'getOne'])->name('service.getOne');
    Route::post('/service/store/', [ServiceController::class, 'store'])->name('service.store');
    Route::put('/service/update/{id}', [ServiceController::class, 'update'])->name('service.update');
    Route::delete('/service/delete/{id}', [ServiceController::class, 'destroy'])->name('service.destroy');

    // group
    Route::resource('group', GroupController::class)->except(['create', 'edit', 'show']);
    Route::get('/get-groups', [GroupController::class, 'getGroups'])->name('getGroups');
    Route::get('/group/one/{id}', [GroupController::class, 'getOne'])->name('group.getOne');
    Route::get('/group/capitan-phone/{id}', [GroupController::class, 'getCapitanPhone'])->name('group.getCapitanPhone');

    // Group ball send text admin to telegram
    Route::get('/group-ball', [GroupBallController::class, 'index'])->name('groupBallAndElon');
    Route::get('/group-ball/all', [GroupBallController::class, 'getBall'])->name('getGroupBall');
    Route::get('/group-ball/get/{id}', [GroupBallController::class, 'getOneBall'])->name('groupBallAndElon.getOne');
    Route::put('/group-ball/update/{id}', [GroupBallController::class, 'updateBAll'])->name('groupBallAndElon.update');
    Route::get('/elon/get', [GroupBallController::class, 'getElon'])->name('getElon');
    Route::post('/elon/create', [GroupBallController::class, 'storeElon'])->name('elon.store');
    Route::delete('/elon/delete/{id}', [GroupBallController::class, 'destroyElon'])->name('elon.destroy');

    // Master
    Route::get('master', [MasterController::class, 'index'])->name('master.index');
    Route::get('/get-masters', [MasterController::class, 'getMasters'])->name('getMasters');
    Route::post('master/create', [MasterController::class, 'store'])->name('master.store');
    Route::get('/masters/one/{id}', [MasterController::class, 'getOne'])->name('master.getOne');
    Route::post('master/edit/{id}', [MasterController::class, 'update'])->name('master.update');
    Route::delete('master/delete/{id}', [MasterController::class, 'destroy'])->name('master.destroy');


    // Users
    Route::get('user', [UserController::class, 'index'])->name('user.index');
    Route::get('/get-users', [UserController::class, 'getUsers'])->name('getUsers');
    Route::post('user/create', [UserController::class, 'store'])->name('user.store');
    Route::get('/users/one/{id}', [UserController::class, 'getOne'])->name('user.getOne');
    Route::post('user/edit/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('user/delete/{id}', [UserController::class, 'destroy'])->name('user.destroy');


    Route::get('/report', [ReportController::class, 'index'])->name('report');

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    // user profile
    Route::post('/user/profile/{id}', [AuthController::class, 'profile'])->name('user.profile');

    Route::get('notification/service', [SSEController::class, 'installNotification'])->name('install-notification');
    Route::get('notification/install', [SSEController::class, 'serviceNotification'])->name('service-notification');

});
