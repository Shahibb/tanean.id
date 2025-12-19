@extends('layouts.app')

@section('title', 'Beranda - TANEAN.ID')

@section('content')
    <!-- Hero Section -->
    @if (!request('q') && $featuredArticle)
        <section class="relative h-[420px] sm:h-[480px] md:h-[520px] overflow-hidden">

            @if ($featuredArticle->image)
                <img src="{{ asset('storage/' . $featuredArticle->image) }}" alt="{{ $featuredArticle->title }}"
                    class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gradient-to-br from-tanean-green to-tanean-beige"></div>
            @endif

            <!-- Overlay -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>

            <!-- Content -->
            <div class="absolute bottom-0 left-0 right-0 p-8 md:p-16">
                <div class="container mx-auto max-w-4xl">
                    <span
                        class="inline-block px-3 py-1 bg-white/90 text-tanean-dark text-xs font-semibold uppercase tracking-wide rounded mb-4">
                        {{ $featuredArticle->category }}
                    </span>
                    <h1 class="text-2xl md:text-5xl font-bold text-white mb-4 leading-tight">
                        {{ $featuredArticle->title }}
                    </h1>
                    {{-- Mobile --}}
                    <p class="block sm:hidden text-sm text-white/90 mb-4 leading-relaxed">
                        {{ Str::limit($featuredArticle->excerpt, 90) }}
                    </p>

                    {{-- Tablet & Desktop --}}
                    <p class="hidden sm:block text-base md:text-lg text-white/90 mb-6 leading-relaxed">
                        {{ Str::limit($featuredArticle->excerpt, 150) }}
                    </p>

                    <div class="flex items-center text-white/80 text-sm space-x-4">
                        <span>{{ $featuredArticle->author }}</span>
                        <span>•</span>
                        <span>{{ $featuredArticle->published_at->diffForHumans() }}</span>
                    </div>
                    <a href="{{ route('article.show', $featuredArticle->slug) }}"
                        class="inline-block mt-4 px-5 py-2.5 bg-white text-tanean-dark text-sm font-semibold rounded hover:bg-gray-100 transition">
                        Baca Selengkapnya
                    </a>
                </div>
            </div>
        </section>
    @endif

    <section class="container mx-auto px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

            {{-- KIRI --}}
            <div class="lg:col-span-8 space-y-20">

                {{-- WARTA --}}
                <section>
                    <h2 class="text-2xl md:text-3xl font-bold text-tanean-dark mb-6 border-l-8 border-tanean-beige pl-3"><a href="{{ route('article.category', 'warta') }}"
                            class="hover:text-tanean-beige">Warta</a></h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @foreach ($wartaArticles as $article)
                            <x-article-card :title="$article->title" :image="asset('storage/' . $article->image)" :excerpt="Str::limit($article->excerpt, 120)" :author="$article->author"
                                :date="$article->published_at->format('d M Y')" :link="route('article.show', $article->slug)" />
                        @endforeach
                    </div>
                </section>

                {{-- WARITA --}}
                <section>
                    <h2 class="text-2xl md:text-3xl font-bold text-tanean-dark mb-6 border-l-8 border-tanean-beige pl-3"><a href="{{ route('article.category', 'warita') }}"
                            class="hover:text-tanean-beige">Warita</a></h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @foreach ($waritaArticles as $article)
                            <x-article-card :title="$article->title" :image="asset('storage/' . $article->image)" :excerpt="Str::limit($article->excerpt, 120)" :author="$article->author"
                                :date="$article->published_at->format('d M Y')" :link="route('article.show', $article->slug)" />
                        @endforeach

                    </div>
                </section>

            </div>

            {{-- KANAN --}}
            <aside class="lg:col-span-4 border-l-2 border-tanean-beige pl-8">
                <div class="sticky top-32 space-y-6">
                    <h2 class="text-2xl md:text-3xl font-bold text-tanean-dark mb-6 border-l-8 border-tanean-beige pl-3"><a href="{{ route('article.category', 'swara') }}"
                            class="hover:text-tanean-beige">Swara</a></h2>

                    @foreach ($swaraArticles as $article)
                        <x-article-card variant="compact" :title="Str::limit($article->title, 60)" :image="asset('storage/' . $article->image)" :link="route('article.show', $article->slug)"
                            :date="$article->published_at->format('d M Y')" />
                    @endforeach

                </div>
            </aside>

        </div>
    </section>
    {{-- LENSA --}}
    <section class="bg-[#C9C4B7] py-8">
        <div class="container mx-auto px-8 relative">
            {{-- JUDUL --}}
            <h2 class="text-2xl md:text-3xl font-bold text-tanean-dark mb-6 border-l-8 border-tanean-beige pl-3"><a href="{{ route('article.category', 'lensa') }}"
                    class="hover:text-tanean-beige">Lensa</a></h2>

            {{-- WRAPPER SLIDER --}}
            <div class="relative">

                {{-- PANAH KIRI --}}
                <button
                    class="absolute -left-6 top-1/3 z-10 bg-white/80 backdrop-blur
           text-black w-10 h-10 rounded-full flex items-center justify-center
           hover:bg-white transition shadow">
                    ‹
                </button>


                {{-- PANAH KANAN --}}
                <button
                    class="absolute -right-6 top-1/3 z-10 bg-white/80 backdrop-blur
           text-black w-10 h-10 rounded-full flex items-center justify-center
           hover:bg-white transition shadow">
                    ›
                </button>

                {{-- GRID LENSA --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach ($lensaArticles as $article)
                        <x-article-card :title="$article->title" :image="asset('storage/' . $article->image)" :excerpt="Str::limit($article->excerpt, 120)" :author="$article->author"
                            :date="$article->published_at->format('d M Y')" :link="route('article.show', $article->slug)" />
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- <!-- Pagination -->
    <div class="container mx-auto px-6 py-8">
        {{ $articles->links() }}
    </div> --}}
@endsection
