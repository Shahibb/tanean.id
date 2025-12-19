<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ArticleController;

Route::get('/', [ArticleController::class, 'index'])->name('home');
Route::get('/artikel/{slug}', [ArticleController::class, 'show'])->name('article.show');
Route::get('/kategori/{category}', [ArticleController::class, 'category'])->name('article.category');
Route::get('/search', [ArticleController::class, 'search'])->name('search');


Route::get('/home', function () {
    return redirect()->route('dashboard');
})->name('home');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard - accessible to any authenticated user; sidebar adapts by role
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Articles - semua role bisa akses
    Route::resource('articles', AdminArticleController::class);

    // Approve/Reject - hanya editor dan admin
    Route::middleware(['role:editor,admin'])->group(function () {
        Route::post('/articles/{article}/approve', [AdminArticleController::class, 'approve'])
            ->name('articles.approve');
        Route::post('/articles/{article}/reject', [AdminArticleController::class, 'reject'])
            ->name('articles.reject');
    });

    // Users - hanya admin
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class);
    });
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
