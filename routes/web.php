<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InstallController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\GroupController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


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

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // установка
    Route::get('/install', [InstallController::class, 'index'])->name('install.index');
    Route::post('/install/store/', [InstallController::class, 'store'])->name('install.store');
    Route::put('/install/update/{id}', [InstallController::class, 'update'])->name('install.update');
    Route::delete('/install/delete/{id}', [InstallController::class, 'destroy'])->name('install.destroy');

    // service
    Route::get('/service', [ServiceController::class, 'index'])->name('service.index');
    Route::post('/service/store/', [ServiceController::class, 'store'])->name('service.store');
    Route::put('/service/update/{id}', [ServiceController::class, 'update'])->name('service.update');
    Route::delete('/service/delete/{id}', [ServiceController::class, 'destroy'])->name('service.destroy');

    // group
    Route::get('/group', [GroupController::class, 'index'])->name('group.index');
    Route::post('/group/create/', [GroupController::class, 'store'])->name('group.store');
    Route::put('/group/update/{id}', [GroupController::class, 'update'])->name('group.update');
    Route::delete('/group/delete/{id}', [GroupController::class, 'destroy'])->name('group.destroy');

    // Group ball send text admin to telegram
    Route::get('/group-ball', [GroupController::class, 'index'])->name('groupBall');

    // master
    Route::resource('master', MasterController::class)->except(['create', 'edit', 'show']);
    Route::get('/master/one/{id}', [MasterController::class, 'getOne'])->name('master.getOne');


    Route::get('/report', [ReportController::class, 'index'])->name('report');


    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    // user profile
    Route::post('/user/profile', [AuthController::class, 'profile'])->name('user.profile');
});



// Route::post('/webhook', 'WebHookController');
