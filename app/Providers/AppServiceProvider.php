<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Video;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */


    public function boot(): void
    {
        Paginator::useTailwind();
        // atau jika pakai custom: Paginator::defaultView('pagination.custom');
        View::composer('articles.category.video', function ($view) {
        $view->with('mainVideo', Video::where('featured', true)->first());
        $view->with('otherVideos', Video::where('featured', false)->latest()->take(3)->get());
    });
    }
}
