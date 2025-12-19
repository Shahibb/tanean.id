<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isWartawan()) {
            $articles = Article::where('user_id', $user->id)
                ->latest()
                ->paginate(10);
        } else {
            $articles = Article::with('user')
                ->latest()
                ->paginate(10);
        }

        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'excerpt' => 'required',
            'content' => 'required',
            'category' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['author'] = auth()->user()->name;
        // $validated['slug'] = Str::slug($validated['title']);
        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $count = 1;

        while (\App\Models\Article::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        $validated['slug'] = $slug;
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('articles', 'public');
        }

        Article::create($validated);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil dibuat dan menunggu persetujuan editor.');
    }

    public function edit(Article $article)
    {
        // Wartawan hanya bisa edit artikel sendiri
        if (auth()->user()->isWartawan() && $article->user_id !== auth()->id()) {
            abort(403);
        }

        return view('admin.articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        if (auth()->user()->isWartawan() && $article->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'excerpt' => 'required',
            'content' => 'required',
            'category' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            $validated['image'] = $request->file('image')->store('articles', 'public');
        }

        $article->update($validated);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil diupdate.');
    }

    public function destroy(Article $article)
    {
        if (auth()->user()->isWartawan() && $article->user_id !== auth()->id()) {
            abort(403);
        }

        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }

        $article->delete();

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }

    public function approve(Article $article)
    {
        if (!auth()->user()->isEditor() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $article->update([
            'is_published' => true,
            'published_at' => now(),
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'Artikel berhasil disetujui dan dipublikasikan.');
    }

    public function reject(Article $article)
    {
        if (!auth()->user()->isEditor() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $article->update([
            'is_published' => false,
            'published_at' => null,
        ]);

        return redirect()->back()
            ->with('success', 'Artikel ditolak.');
    }
    
}
