@extends('layouts.app')

@section('title', 'Kategori ' . ucfirst($category) . ' - TANEAN.ID')

@section('content')
<!-- Category Header -->
@php
    $bg = $category == 'warta' ? 'bg-tanean-green' : ($category == 'warita' ? 'bg-tanean-pink' : 'bg-tanean-beige');
    $textIsLight = in_array($category, ['warta','warita']);
@endphp

<section class="{{ $bg }} py-16">
    <div class="container mx-auto px-6">
        <h1 class="text-4xl md:text-5xl font-bold {{ $textIsLight ? 'text-white' : 'text-tanean-dark' }} mb-4 capitalize">{{ $category }}</h1>
        <p class="text-lg {{ $textIsLight ? 'text-white/90' : 'text-gray-700' }}">Temukan artikel terbaru dalam kategori {{ $category }}</p>
    </div>
</section>

<!-- Articles Grid -->
<section class="container mx-auto px-6 py-16">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($articles as $article)
        <div>
            <a href="{{ route('article.show', $article->slug) }}" class="block">
                @component('components.article-card', [
                    'image' => $article->image ? asset('storage/' . $article->image) : null,
                    'title' => $article->title,
                    'excerpt' => Str::limit($article->excerpt, 120),
                    'author' => $article->author,
                    'date' => $article->published_at ? $article->published_at->format('d M Y') : '',
                    'category' => $article->category,
                    'link' => route('article.show', $article->slug),
                ])
                @endcomponent
            </a>
        </div>
        @empty
        <div class="col-span-3 text-center py-16">
            <div class="text-gray-400 mb-4">
                <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <p class="text-xl text-gray-600 font-medium">Tidak ada artikel dalam kategori ini.</p>
            <a href="{{ route('home') }}" class="inline-block mt-6 px-6 py-3 bg-tanean-dark text-white rounded hover:bg-gray-800 transition">
                Kembali ke Beranda
            </a>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($articles->hasPages())
    <div class="mt-12">
        {{ $articles->links() }}
    </div>
    @endif
</section>
@endsection
