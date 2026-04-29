<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminBookingController;
use App\Http\Controllers\AdminPaymentMethodController;
use App\Http\Controllers\AdminSettingController;
use App\Http\Controllers\AdminServiceController;
use App\Http\Controllers\AdminServiceMenuController;
use App\Http\Controllers\BookingController;
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
Route::get('/book', [BookingController::class, 'create'])->name('bookings.create');
Route::post('/book', [BookingController::class, 'store'])->name('bookings.store');
Route::get('/book/success', [BookingController::class, 'success'])->name('bookings.success');
Route::get('/book/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
Route::get('/book/unavailable-slots', [BookingController::class, 'unavailableSlots'])->name('bookings.unavailable-slots');
Route::post('/stripe/webhook', [BookingController::class, 'webhook'])->name('stripe.webhook');
Route::get('/language/{locale}', [HomeController::class, 'setLanguage'])->name('language.switch');

Route::prefix('admin')->name('admin.')->middleware('guest')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
});

Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::post('/settings/language-selector', [AdminSettingController::class, 'updateLanguageSelector'])->name('settings.language-selector');
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings');
    Route::get('/bookings/events', [AdminBookingController::class, 'events'])->name('bookings.events');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    Route::resource('/services', AdminServiceController::class)->except('show');
    Route::resource('/payments', AdminPaymentMethodController::class)
        ->except('show')
        ->parameters(['payments' => 'payment']);
    Route::get('/services/{service}/menus', [AdminServiceMenuController::class, 'index'])->name('services.menus.index');
    Route::get('/services/{service}/menus/create', [AdminServiceMenuController::class, 'create'])->name('services.menus.create');
    Route::post('/services/{service}/menus', [AdminServiceMenuController::class, 'store'])->name('services.menus.store');
    Route::get('/services/{service}/menus/{menu}/edit', [AdminServiceMenuController::class, 'edit'])->name('services.menus.edit');
    Route::put('/services/{service}/menus/{menu}', [AdminServiceMenuController::class, 'update'])->name('services.menus.update');
    Route::delete('/services/{service}/menus/{menu}', [AdminServiceMenuController::class, 'destroy'])->name('services.menus.destroy');
});
