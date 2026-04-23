<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminServiceController;
use App\Http\Controllers\AdminServiceMenuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/services/{service}', [HomeController::class, 'showService'])->name('services.show');

Route::prefix('admin')->name('admin.')->middleware('guest')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
});

Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    Route::resource('/services', AdminServiceController::class)->except('show');
    Route::get('/services/{service}/menus', [AdminServiceMenuController::class, 'index'])->name('services.menus.index');
    Route::get('/services/{service}/menus/create', [AdminServiceMenuController::class, 'create'])->name('services.menus.create');
    Route::post('/services/{service}/menus', [AdminServiceMenuController::class, 'store'])->name('services.menus.store');
    Route::get('/services/{service}/menus/{menu}/edit', [AdminServiceMenuController::class, 'edit'])->name('services.menus.edit');
    Route::put('/services/{service}/menus/{menu}', [AdminServiceMenuController::class, 'update'])->name('services.menus.update');
    Route::delete('/services/{service}/menus/{menu}', [AdminServiceMenuController::class, 'destroy'])->name('services.menus.destroy');
});
