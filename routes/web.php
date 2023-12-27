<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\HomeController;
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
});


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:admin'])->group(function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/',[AdminController::class,'homepage'])->name('admin.homepage');
    });

});

