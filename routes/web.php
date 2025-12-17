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
    });
    
    Route::resource('projects', ProjectController::class);
    Route::middleware(['role:admin,manager'])->group(function () {
        Route::post('projects/{project}/approve', [ProjectController::class, 'approve'])->name('projects.approve');
        Route::post('projects/{project}/reject', [ProjectController::class, 'reject'])->name('projects.reject');
    });
    
    Route::resource('customers', CustomerController::class)->except(['create', 'store', 'destroy']);
    
    // Routes untuk manage services customer
    Route::get('customers/{customer}/manage-services', [CustomerController::class, 'manageServices'])
        ->name('customers.manage-services');
    Route::post('customers/{customer}/add-service', [CustomerController::class, 'addService'])
        ->name('customers.add-service');
    Route::post('customers/{customer}/services/{customerService}/change', [CustomerController::class, 'changeService'])
        ->name('customers.change-service');
    Route::post('customers/{customer}/services/{customerService}/suspend', [CustomerController::class, 'suspendService'])
        ->name('customers.suspend-service');
    Route::post('customers/{customer}/services/{customerService}/activate', [CustomerController::class, 'activateService'])
        ->name('customers.activate-service');
    Route::post('customers/{customer}/services/{customerService}/terminate', [CustomerController::class, 'terminateService'])
        ->name('customers.terminate-service');
});