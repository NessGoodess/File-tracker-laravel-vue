<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        //'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DocumentController::class, 'controlPanel'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/create', [DocumentController::class, 'create'])->name('documents.create');
    Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::get('/documents/{document}', [DocumentController::class, 'show'])->name('documents.show');
    Route::get('/documents/{document}/edit', [DocumentController::class, 'edit'])->name('documents.edit');
    Route::patch('/documents/{document}', [DocumentController::class, 'update'])->name('documents.update');
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');

    Route::match(['get', 'post'], '/filters', [DocumentController::class, 'filters'])->name('documents.filters');


    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('/Users', [ProfileController::class, 'index'])->name('users.index');
        Route::get('/Users/Create', [RegisteredUserController::class, 'create'])->name('users.create');
        Route::post('/Users', [RegisteredUserController::class, 'store'])->name('users.store');
        Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
    });
});

Route::get('/search', [DocumentController::class, 'search'])
    ->middleware(['auth', 'verified'])
    ->name('documents.search');

Route::post('/comments', [CommentController::class, 'store'])
    ->middleware(['auth', 'verified'])
    ->name('comments.store');

Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
    ->middleware(['auth', 'verified'])
    ->name('comments.destroy');

require __DIR__ . '/auth.php';
