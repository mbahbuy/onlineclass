<?php

use App\Http\Controllers\{BimbelController, DashboardController,  ProfileController, SiswaController, UserController};
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    // Bimbel/CLass
    Route::get('/class', [BimbelController::class, 'index'])->name('class');
    Route::post('/class/json', [BimbelController::class, 'json'])->name('class.json');
    Route::post('/class/store', [BimbelController::class, 'store'])->name('class.store');
    Route::put('/class/{bimbel}/update', [BimbelController::class, 'update'])->name('class.update');
    Route::delete('/class/{bimbel}/delete', [BimbelController::class, 'destroy'])->name('class.delete');
    
    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::post('/users/json', [UserController::class, 'json'])->name('users.json');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}/update', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}/delete', [UserController::class, 'destroy'])->name('users.delete');

    // Siswa
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa');
    Route::post('/siswa/json', [SiswaController::class, 'json'])->name('siswa.json');
    Route::put('/siswa/{siswa}/approve', [SiswaController::class, 'approve'])->name('siswa.approve');
    Route::put('/siswa/{siswa}/block', [SiswaController::class, 'block'])->name('siswa.block');
    
});

require __DIR__.'/auth.php';
