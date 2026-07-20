<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Auth routes (Breeze)
require __DIR__.'/auth.php';

// Role-based redirect
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'redirect'])
        ->name('dashboard');
});

// Super Admin routes
Route::middleware(['auth', 'role:super_admin'])->prefix('super-admin')->name('super-admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'index'])
        ->name('dashboard');
});

// Admin routes (company-scoped)
Route::middleware(['auth', 'role:admin', 'company'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
        ->name('dashboard');
});

// Employee routes
Route::middleware(['auth', 'role:employee'])->group(function () {
    Route::get('/dashboard/employee', [App\Http\Controllers\EmployeeDashboardController::class, 'index'])
        ->name('employee.dashboard');
});

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Welcome / landing
Route::get('/', function () {
    return view('welcome');
});
