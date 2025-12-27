@extends('layouts.app')

@section('title', 'Beranda - TANEAN.ID')

@section('content')
    <!-- Hero Section -->
    @if (!request('q') && $featuredArticle)
        <section class="relative h-[420px] sm:h-[480px] md:h-[520px] overflow-hidden mt-6">

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
        <div class="grid grid-cols-1 md:grid-cols-12 gap-10">
            <div class="md:col-span-8 space-y-10">

                {{-- WARTA --}}
                <section>
                    <h2
                        class="text-2xl md:text-3xl font-display font-medium-weight text-tanean-dark mb-6 border-l-8 border-tanean-beige pl-3">
                        <a href="{{ route('article.category', 'warta') }}" class="hover:text-tanean-beige">Warta</a>
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @foreach ($wartaArticles as $article)
                            <x-article-card variant="lead" :title="$article->title" :image="asset('storage/' . $article->image)" :excerpt="Str::limit($article->excerpt, 300)"
                                :author="$article->author" :date="$article->published_at->format('d M Y')" :link="route('article.show', $article->slug)" />
                        @endforeach
                    </div>
                </section>

                {{-- WARITA --}}
                <section>
                    <h2
                        class="text-2xl md:text-3xl font-display font-medium-weight text-tanean-dark mb-6 border-l-8 border-tanean-green pl-3">
                        <a href="{{ route('article.category', 'warita') }}" class="hover:text-tanean-beige">Warita</a>
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @foreach ($waritaArticles as $article)
                            <x-article-card :title="$article->title" :image="asset('storage/' . $article->image)" :excerpt="Str::limit($article->excerpt, 320)" :author="$article->author"
                                :date="$article->published_at->format('d M Y')" :link="route('article.show', $article->slug)" />
                        @endforeach

                    </div>
                </section>

            </div>

            {{-- Swara --}}
            <aside class="md:col-span-4 md:border-l md:border-tanean-beige md:pl-8">
                <div class="sticky top-32 space-y-6">
                    <h2 class="text-2xl md:text-[32px] font-display font-medium-weight text-tanean-dark mb-6 border-l-8 md:border-tanean-beige pl-3"
                        style="font-style: italic;"><a href="{{ route('article.category', 'swara') }}"
                            class="hover:text-tanean-beige">Swara</a></h2>

                    @foreach ($swaraArticles as $article)
                        <x-article-card variant="compact" :title="$article->title" :image="asset('storage/' . $article->image)" :author="$article->author"
                            :excerpt="Str::limit($article->excerpt, 120)" :link="route('article.show', $article->slug)" :date="$article->published_at->format('d M Y')" />
                    @endforeach


                </div>
            </aside>

        </div>
    </section>
    {{-- LENSA --}}
    <div class="mb-4">
        @include('articles.category.partials.slider', [
            'articles' => $lensaArticles,
            'bgColor' => 'bg-tanean-beige',
            'title' => 'Lensa',
            'route' => 'lensa',
        ])
    </div>
    @include('articles.category.video')

@endsection
