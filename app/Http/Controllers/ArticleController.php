<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Video; // Pastikan Model Video di-import
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{

    public function index(Request $request)
    {
        // ===== SEARCH QUERY =====
        $search = $request->q;

        // ===== FEATURED ARTICLE =====
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


        // Inisialisasi variabel video agar tidak error jika masuk mode search
        $mainVideo = null;
        $otherVideos = collect();

        // ===== KATEGORI & VIDEO (non-search) =====
        if (!$search) {
            // 1. Ambil Artikel per Kategori
            $wartaArticles = Article::published()->where('category', 'warta')->latest('published_at')->take(2)->get();
            $waritaArticles = Article::published()->where('category', 'warita')->latest('published_at')->take(2)->get();
            $swaraArticles = Article::published()->where('category', 'swara')->latest('published_at')->get();
            $lensaArticles = Article::published()->where('category', 'lensa')->latest('published_at')->get();

            // 2. LOGIKA BARU: AMBIL DATA VIDEO UNTUK HOMEPAGE
            // Cari video yang featured = true
            $mainVideo = Video::where('featured', true)->latest()->first();

            // Fallback: Jika tidak ada yg featured, ambil video terakhir yg diupload
            if (!$mainVideo) {
                $mainVideo = Video::latest()->first();
            }

            // Ambil video lainnya (kecuali video utama)
            $otherVideos = collect(); // Default kosong
            if ($mainVideo) {
                $otherVideos = Video::where('id', '!=', $mainVideo->id) // Jangan ambil video yang sudah jadi main
                    ->latest()
                    ->take(3)
                    ->get();
            }
        } else {
            // Jika sedang search, kosongkan section kategori
            $wartaArticles = $waritaArticles = $swaraArticles = $lensaArticles = collect();
        }

        // Jangan lupa masukkan 'mainVideo' dan 'otherVideos' ke compact
        return view('articles.index', compact(
            'featuredArticle',
            'articles',
            'wartaArticles',
            'waritaArticles',
            'swaraArticles',
            'lensaArticles',
            'search',
            'mainVideo',   // <--- PENTING
            'otherVideos'  // <--- PENTING
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
        // Ambil 2 artikel pertama untuk ditampilkan di bagian atas
        $topArticles = Article::published()
            ->where('category', $category)
            ->latest('published_at')
            ->take(2)
            ->get();

        // Ambil semua artikel untuk slider
        $allArticles = Article::published()
            ->where('category', $category)
            ->latest('published_at')
            ->get();

        // Ambil artikel swara
        $swaraArticles = collect();
        if ($category === 'warta') {
            $swaraArticles = Article::published()
                ->where('category', 'swara')
                ->latest('published_at')
                ->take(10)
                ->get();
        }

        // Paginasi
        $articles = Article::published()
            ->where('category', $category)
            ->latest('published_at')
            ->paginate(9);

        // Logika Video (Khusus halaman kategori /kategori/video)
        $mainVideo = null;
        $otherVideos = collect();

        // Perbaikan: Selalu ambil video jika kategorinya 'video', bukan null default
        if ($category === 'video') {
            $mainVideo = Video::where('featured', true)->latest()->first();

            if (!$mainVideo) {
                $mainVideo = Video::latest()->first();
            }

            if ($mainVideo) {
                $otherVideos = Video::where('featured', false)
                    ->where('id', '!=', $mainVideo->id)
                    ->latest()
                    ->take(3)
                    ->get();
            }
        }

        return view('articles.category', compact('articles', 'category', 'topArticles', 'allArticles', 'swaraArticles', 'mainVideo', 'otherVideos'));
    }
}
