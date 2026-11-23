<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SiteReportController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;


// Route::get('/admin/login', function () {
//     if (auth()->check() && auth()->user()->isAdmin()) {
//         return redirect()->route('admin.dashboard');
//     }
//     return view('auth.admin-login');
// })->name('admin.login');

Route::post('/admin/login', [\Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::class, 'store'])
    ->middleware('throttle:login')->name('admin.login.store');


Route::middleware(['auth:admin'])
    ->prefix('/admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/site-reports', [SiteReportController::class, 'index'])->name('site-reports.index');
        Route::get('/site-reports/export', [SiteReportController::class, 'export'])->name('site-reports.export');

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
