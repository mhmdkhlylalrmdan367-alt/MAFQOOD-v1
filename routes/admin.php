<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Users
        Route::resource('users', UserController::class)->except(['create', 'store', 'show']);
        Route::patch('/users/{user}/toggle', [UserController::class, 'toggle'])->name('users.toggle');

        // Items
        Route::resource('items', ItemController::class)->except(['create', 'store']);
        Route::patch('/items/{item}/status', [ItemController::class, 'updateStatus'])->name('items.status');

        // Categories
        Route::resource('categories', CategoryController::class);

        // Reports
        Route::resource('reports', ReportController::class)->only(['index', 'show', 'update']);
        Route::post('/reports/{report}/action', [ReportController::class, 'action'])->name('reports.action');
    });