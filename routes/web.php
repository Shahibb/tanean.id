<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ScrapeController as AdminScrapeController;;
use App\Http\Controllers\Admin\VideoController as AdminVideoController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\VideoController;

Route::get('/', [ArticleController::class, 'index'])->name('home');
Route::get('/artikel/{slug}', [ArticleController::class, 'show'])->name('article.show');
Route::get('/kategori/{category}', [ArticleController::class, 'category'])->name('article.category');
Route::get('/search', [ArticleController::class, 'search'])->name('search');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard - accessible to any authenticated user; sidebar adapts by role
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Articles - semua role bisa akses
    Route::resource('articles', AdminArticleController::class);
    Route::resource('videos', AdminVideoController::class);

    // Approve/Reject - hanya editor dan admin
    Route::middleware(['role:editor,admin'])->group(function () {
        Route::post('/articles/{article}/approve', [AdminArticleController::class, 'approve'])
            ->name('articles.approve');
        Route::post('/articles/{article}/reject', [AdminArticleController::class, 'reject'])
            ->name('articles.reject');
        Route::get('/scrape', [AdminScrapeController::class, 'index'])->name('scrape');
        Route::post('/scrape', [AdminScrapeController::class, 'scrape'])->name('scrape.post');
    });

    // Users - hanya admin
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class);
    });
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// Route::get('/videos', [VideoController::class, 'index'])->name('videos.index');
// Route::post('/videos', [VideoController::class, 'store'])->middleware('auth');
// Route::delete('/videos/{id}', [VideoController::class, 'destroy'])->middleware('auth');
