<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InstallCategoryController;
use App\Http\Controllers\InstallController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\UserController;
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
    Route::get('/install-category', [InstallCategoryController::class, 'index'])->name('installCategory.index');
    Route::post('/install-category/store/', [InstallCategoryController::class, 'store'])->name('installCategory.store');
    Route::put('/install-category/update/{id}', [InstallCategoryController::class, 'update'])->name('installCategory.update');
    Route::delete('/install-category/delete/{id}', [InstallCategoryController::class, 'destroy'])->name('installCategory.destroy');


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
    Route::resource('group', GroupController::class)->except(['create', 'edit', 'show']);
    Route::get('/get-groups', [GroupController::class, 'getGroups'])->name('getGroups');
    Route::get('/group/one/{id}', [GroupController::class, 'getOne'])->name('group.getOne');

    // Group ball send text admin to telegram
    Route::get('/group-ball', [GroupController::class, 'index'])->name('groupBall');

    // Users
    Route::resource('user', UserController::class)->except(['create', 'edit', 'show']);
    Route::get('/get-users', [UserController::class, 'getUsers'])->name('getUsers');
    Route::get('/users/one/{id}', [UserController::class, 'getOne'])->name('user.getOne');



    Route::get('/report', [ReportController::class, 'index'])->name('report');


    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    // user profile
    Route::post('/user/profile', [AuthController::class, 'profile'])->name('user.profile');
});



// Route::post('/webhook', 'WebHookController');
