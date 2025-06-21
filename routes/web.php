<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Login (tanpa middleware auth)
Route::middleware(['prevent-back-history'])->group(function () {
    Route::get('/', function () {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    })->name('login');

    Route::post('/', [AuthController::class, 'login']);
});

Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Semua route yang membutuhkan login
Route::middleware(['auth', 'prevent-back-history'])->group(function () {

    // Dashboard (berdasarkan role)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Superadmin
    Route::prefix('superadmin')->middleware(['role:superadmin', 'role_prefix_check'])->name('superadmin.')->group(function () {
        Route::resource('companies', CompanyController::class);
        Route::resource('divisions', DivisionController::class);
        Route::resource('tokens', TokenController::class);
        Route::resource('users', UserController::class);
    });

    // Admin
    Route::prefix('admin')->middleware(['role:admin', 'role_prefix_check'])->name('admin.')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('leaves', LeaveController::class)->only(['index', 'show', 'update']);
        Route::resource('salaries', SalaryController::class)->only(['index', 'create', 'store']);
        Route::put('leaves/{leave}/approve', [LeaveController::class, 'approve'])->name('leaves.approve');
        Route::put('leaves/{leave}/reject', [LeaveController::class, 'reject'])->name('leaves.reject');
    });


    Route::patch('salaries/{salary}/toggle-status', [SalaryController::class, 'toggleStatus'])->name('salaries.toggleStatus');

    // Manager
    Route::prefix('manager')->middleware(['role:manager', 'role_prefix_check'])->name('manager.')->group(function () {
        Route::get('users/division', [UserController::class, 'listDivisionEmployees'])->name('users.division');
        Route::resource('leaves', LeaveController::class)->only(['index', 'show', 'update']);
        Route::resource('salaries', SalaryController::class)->only(['index', 'show']);
    });

    // Employee
    Route::prefix('employee')->middleware(['role:employee', 'role_prefix_check'])->name('employee.')->group(function () {
        Route::resource('leaves', LeaveController::class)->only(['create', 'store', 'index', 'show']);
        Route::resource('salaries', SalaryController::class)->only(['index', 'show']);
        Route::get('salary', [SalaryController::class, 'showByUser'])->name('salaries.byUser');
    });

    // Akses detail user (role: admin/manager/employee + perusahaan sama)
    Route::middleware(['role:admin,manager,employee', 'company.match'])->group(function () {
        Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
    });
});
