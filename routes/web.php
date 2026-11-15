<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/items', [ItemController::class, 'index'])->name('items.index');
Route::get('/items/{item}', [ItemController::class, 'show'])->whereNumber('item')->name('items.show');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('/search', [SearchController::class, 'index'])->name('search');

Route::view('/how-it-works', 'pages.how-it-works')->name('how-it-works');
Route::view('/faq', 'pages.faq')->name('faq');
Route::view('/privacy', 'pages.privacy')->name('privacy');

Route::get('/lang/{locale}', function ($locale) {
    if (!in_array($locale, ['ar', 'en'])) abort(400);
    session(['locale' => $locale]);
    app()->setLocale($locale);
    return redirect()->back();
})->name('lang.switch');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    Route::get('/items/{item}/edit', [ItemController::class, 'edit'])->whereNumber('item')->name('items.edit');
    Route::put('/items/{item}', [ItemController::class, 'update'])->whereNumber('item')->name('items.update');
    Route::delete('/items/{item}', [ItemController::class, 'destroy'])->whereNumber('item')->name('items.destroy');
    Route::patch('/items/{item}/status', [ItemController::class, 'updateStatus'])->whereNumber('item')->name('items.status');
    Route::delete('/items/{item}/images/{image}', [ItemController::class, 'destroyImage'])->whereNumber('item')->whereNumber('image')->name('items.images.destroy');

    Route::get('/conversations', [ConversationController::class, 'index'])->name('conversations.index');
    Route::post('/conversations', [ConversationController::class, 'store'])->name('conversations.store');
    Route::get('/conversations/{conversation}', [ConversationController::class, 'show'])->whereNumber('conversation')->name('conversations.show');
    Route::post('/conversations/{conversation}/messages', [MessageController::class, 'store'])->whereNumber('conversation')->name('messages.store');

    Route::get('/items/{item}/report', [ReportController::class, 'create'])->whereNumber('item')->name('reports.create');
    Route::post('/items/{item}/report', [ReportController::class, 'store'])->whereNumber('item')->name('reports.store');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});