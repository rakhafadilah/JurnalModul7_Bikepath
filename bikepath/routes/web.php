<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AktivitasController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\JalurSepedaController;
use App\Http\Controllers\KomunitasController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('map') : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/map', [MapController::class, 'index'])->name('map');
    Route::post('/aktivitas', [AktivitasController::class, 'store'])->name('aktivitas.store');

    Route::get('/activity', [ActivityController::class, 'index'])->name('activity');

    Route::resource('jalur-sepeda', JalurSepedaController::class)
        ->except(['index'])
        ->parameters(['jalur-sepeda' => 'jalur'])
        ->names('jalur');
    Route::get('/jalur-sepeda', fn () => redirect()->route('activity'));

    Route::get('/community', [KomunitasController::class, 'index'])->name('community');
    Route::post('/community/{komunitas}/join', [KomunitasController::class, 'join'])->name('community.join');
    Route::post('/community/{komunitas}/leave', [KomunitasController::class, 'leave'])->name('community.leave');
    Route::post('/community/{komunitas}/messages', [KomunitasController::class, 'send'])->name('community.send');

    Route::get('/friends', [FriendController::class, 'index'])->name('friends');
    Route::post('/friends/{rider}', [FriendController::class, 'follow'])->name('friends.follow');
    Route::delete('/friends/{rider}', [FriendController::class, 'unfollow'])->name('friends.unfollow');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar', [ProfileController::class, 'avatar'])->name('profile.avatar');
});
