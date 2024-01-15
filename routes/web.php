<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LabelController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProjectController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/',[HomeController::class,'redirectUser'])->name('dashboard');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:user'])->group(function () {
    Route::get('/home',function(){
        return Inertia::render('Dashboard');
    })->name('user.dashboard');

    Route::group(['prefix' => 'project'], function () {
        Route::get('/',[ProjectController::class,'index'])->name('user.project.index');
        Route::post('/add',[ProjectController::class,'store'])->name('user.project.store');
        Route::put('/edit/{id}',[ProjectController::class,'update'])->name('user.project.update');
        Route::delete('/delete/{id}',[ProjectController::class,'destroy'])->name('user.project.destroy');
        Route::get('/{project_id}',[ProjectController::class,'detail'])->name('user.project.detail');
    });

    Route::group(['prefix' => 'image'], function () {
        Route::get('/',[ImageController::class,'index'])->name('user.image.index');
        Route::post('/add/{project_id}',[ImageController::class,'store'])->name('user.image.upload');
        Route::put('/edit/{id}',[ImageController::class,'update'])->name('user.image.update');
        Route::delete('/delete/{id}',[ImageController::class,'destroy'])->name('user.image.destroy');
    });

});


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:admin'])->group(function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/',[AdminController::class,'homepage'])->name('admin.homepage');
        Route::get('/user-manager',[UserController::class,'index'])->name('admin.user.index');
        Route::group(['prefix' => 'label-manager'], function(){
            Route::get('/{label_type}',[LabelController::class,'index'])->name('admin.label.index');
            Route::post('/add',[LabelController::class,'store'])->name('admin.label.store');
            Route::put('/edit/{id}',[LabelController::class,'update'])->name('admin.label.update');
            Route::delete('/delete/{id}',[LabelController::class,'destroy'])->name('admin.label.destroy');
        });
    });
});

