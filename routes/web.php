<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

// Role-based redirect
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'redirect'])->name('dashboard');
});

// Super Admin routes
Route::middleware(['auth', 'role:super_admin'])->prefix('super-admin')->name('super-admin.')->group(function () {
    Route::get('/', fn () => redirect('/super-admin/dashboard'));
    Route::get('/dashboard', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/companies', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'companies'])->name('companies.index');
    Route::get('/companies/create', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'companiesCreate'])->name('companies.create');
    Route::post('/companies', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'companiesStore'])->name('companies.store');
    Route::get('/companies/{company}', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'companiesShow'])->name('companies.show');
    Route::get('/companies/{company}/edit', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'companiesEdit'])->name('companies.edit');
    Route::put('/companies/{company}', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'companiesUpdate'])->name('companies.update');
    Route::post('/companies/{company}/suspend', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'companiesSuspend'])->name('companies.suspend');
    Route::post('/companies/{company}/activate', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'companiesActivate'])->name('companies.activate');
    Route::get('/companies/{company}/admins', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'companiesAdmins'])->name('companies.admins');
});

// Admin (company-scoped)
Route::middleware(['auth', 'role:admin', 'company'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn () => redirect('/admin/dashboard'));
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/employees', [App\Http\Controllers\Admin\DashboardController::class, 'employees'])->name('employees.index');
    Route::get('/employees/create', [App\Http\Controllers\Admin\DashboardController::class, 'employeesCreate'])->name('employees.create');
    Route::post('/employees', [App\Http\Controllers\Admin\DashboardController::class, 'employeesStore'])->name('employees.store');
    Route::get('/employees/{employee}', [App\Http\Controllers\Admin\DashboardController::class, 'employeesShow'])->name('employees.show');
    Route::get('/employees/{employee}/edit', [App\Http\Controllers\Admin\DashboardController::class, 'employeesEdit'])->name('employees.edit');
    Route::put('/employees/{employee}', [App\Http\Controllers\Admin\DashboardController::class, 'employeesUpdate'])->name('employees.update');
    Route::get('/positions', [App\Http\Controllers\Admin\DashboardController::class, 'positions'])->name('positions.index');
    Route::get('/positions/create', [App\Http\Controllers\Admin\DashboardController::class, 'positionsCreate'])->name('positions.create');
    Route::post('/positions', [App\Http\Controllers\Admin\DashboardController::class, 'positionsStore'])->name('positions.store');
    Route::get('/positions/{position}', [App\Http\Controllers\Admin\DashboardController::class, 'positionsShow'])->name('positions.show');
    Route::get('/positions/{position}/edit', [App\Http\Controllers\Admin\DashboardController::class, 'positionsEdit'])->name('positions.edit');
    Route::put('/positions/{position}', [App\Http\Controllers\Admin\DashboardController::class, 'positionsUpdate'])->name('positions.update');
});

// Employee
Route::middleware(['auth', 'role:employee'])->group(function () {
    Route::get('/dashboard/employee', [App\Http\Controllers\EmployeeDashboardController::class, 'index'])->name('employee.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', function () { return view('welcome'); });
