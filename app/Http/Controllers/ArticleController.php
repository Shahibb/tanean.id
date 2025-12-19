<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{

    public function index(Request $request)
    {
        // ===== SEARCH QUERY =====
        $search = $request->q;

        // ===== FEATURED =====
        $featuredArticle = null;

        if (!$search) {
            $featuredArticle = Article::published()
                ->latest('published_at')
                ->first();
        }


        // ===== MAIN ARTICLES =====
        $articles = Article::published()
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            })
            ->when($featuredArticle, function ($query) use ($featuredArticle) {
                $query->where('id', '!=', $featuredArticle->id);
            })
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();


        // ===== KATEGORI (non-search) =====
        if (!$search) {
            $wartaArticles = Article::published()
                ->where('category', 'warta')
                ->latest('published_at')
                ->take(4)
                ->get();

            $waritaArticles = Article::published()
                ->where('category', 'warita')
                ->latest('published_at')
                ->take(4)
                ->get();

            $swaraArticles = Article::published()
                ->where('category', 'swara')
                ->latest('published_at')
                ->take(4)
                ->get();
            $lensaArticles = Article::published()
                ->where('category', 'lensa')
                ->latest('published_at')
                ->take(3)
                ->get();
        } else {
            $wartaArticles = $waritaArticles = $swaraArticles = $lensaArticles = collect();
        }


        return view('articles.index', compact(
            'featuredArticle',
            'articles',
            'wartaArticles',
            'waritaArticles',
            'swaraArticles',
            'lensaArticles',
            'search'
        ));
    }


    public function show($slug)
    {
        $article = Article::where('slug', $slug)
            ->published()
            ->firstOrFail();

        $relatedArticles = Article::published()
            ->where('category', $article->category)
            ->where('id', '!=', $article->id)
            ->take(3)
            ->get();

        return view('articles.show', compact('article', 'relatedArticles'));
    }

    public function category($category)
    {
        $articles = Article::published()
            ->where('category', $category)
            ->latest('published_at')
            ->paginate(9);

        return view('articles.category', compact('articles', 'category'));
    }
}
