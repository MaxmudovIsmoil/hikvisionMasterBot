<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TypeWorkController;
use App\Http\Controllers\WorkController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    if (!Auth::check()) {
        return redirect('login');
    }
    return redirect()->intended('home');
});

Route::get('login', function () {
    return view('auth.login');
});

Route::get('/home', function () {
    return view('home');
})->name('dashboard');

Route::post('login', [AuthController::class, 'login'])->name('login');

//Route::middleware('auth')->group(function () {

//    Route::get('/home', function () {
//        return view('home');
//    });
    // master
    Route::resource('master', MasterController::class)->except(['create', 'edit', 'show']);
    Route::get('/master/one/{id}', [MasterController::class, 'getOne'])->name('master.getOne');

    // type of work
    Route::get('/type-work', [TypeWorkController::class, 'index'])->name('typeWork.index');
//    Route::post('/type-work/store/', [TypeWorkController::class, 'store'])->name('typeWork.store');
//    Route::put('/type-work/update/{id}', [TypeWorkController::class, 'update'])->name('typeWork.update');
//    Route::delete('/type-work/delete/{id}', [TypeWorkController::class, 'destroy'])->name('typeWork.destroy');

    // work
    Route::get('/work', [WorkController::class, 'index'])->name('work.index');
    Route::post('/work/create/', [WorkController::class, 'store'])->name('work.store');
    Route::put('/work/update/{id}', [WorkController::class, 'update'])->name('work.update');
    Route::delete('/work/delete/{id}', [WorkController::class, 'destroy'])->name('work.destroy');


    Route::get('/report', [ReportController::class, 'index'])->name('report');


    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    // user profile
    Route::post('/user/profile', [AuthController::class, 'profile'])->name('user.profile');
//});



