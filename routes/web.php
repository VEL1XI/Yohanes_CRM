<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CustomerController;

Route::get('/', function () {
    return redirect('/login');
});

// Login Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('leads', LeadController::class);
    
    Route::middleware(['role:admin,manager'])->group(function () {
    Route::get('services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('services/{service}', [ServiceController::class, 'show'])->name('services.show');
    Route::get('services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
    Route::put('services/{service}', [ServiceController::class, 'update'])->name('services.update');
    // Tidak ada create, store, destroy
});
    
    Route::resource('projects', ProjectController::class);
    Route::middleware(['role:admin,manager'])->group(function () {
        Route::post('projects/{project}/approve', [ProjectController::class, 'approve'])->name('projects.approve');
        Route::post('projects/{project}/reject', [ProjectController::class, 'reject'])->name('projects.reject');
    });
    
    Route::resource('customers', CustomerController::class)->except(['create', 'store', 'destroy']);
});