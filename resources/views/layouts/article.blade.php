@extends('layouts.app')

@section('title', 'Berita - ' . config('app.name'))

@section('header')
    {{-- optional header can be overridden by pages --}}
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    {{-- Hero / featured --}}
    @if(!request('q') && ($featured = $articles->first()))
    <section class="mb-12 relative">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2 relative overflow-hidden rounded-lg">
                @if($featured->image)
                    <div class="h-[640px] md:h-[720px] w-full relative">
                        <img src="{{ asset('storage/' . $featured->image) }}" alt="{{ $featured->title }}" class="absolute inset-0 w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                        <div class="absolute bottom-12 left-6 md:left-12 text-white max-w-3xl px-4 md:px-0">
                            <span class="inline-block px-3 py-1 bg-white/20 text-white text-sm font-semibold uppercase tracking-wide rounded mb-4">{{ $featured->category }}</span>
                            <h1 class="text-5xl sm:text-6xl md:text-7xl lg:text-8xl leading-tight font-extrabold mb-4">{{ $featured->title }}</h1>
                            <p class="text-lg md:text-xl max-w-3xl text-white/95 leading-relaxed">{{ Str::limit($featured->excerpt, 300) }}</p>
                        </div>
                    </div>
                @else
                    <div class="w-full h-80 bg-gray-200"></div>
                @endif
            </div>
            <aside class="bg-white rounded shadow p-4 h-fit sticky top-28">
                <h3 class="font-semibold mb-3">Populer</h3>
                @foreach($articles->take(5) as $a)
                    <a href="{{ route('article.show', $a->slug) }}" class="block text-sm text-tanean-dark mb-2">{{ Str::limit($a->title, 60) }}</a>
                @endforeach
            </aside>
        </div>
    </section>
    @endif

    {{-- Grid --}}
    <section>
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-8 md:gap-10">
            @foreach($articles as $article)
                <div>
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

                </div>
            @endforeach
        </div>
    </section>

    <div class="mt-8">
        {{ $articles->links() }}
    </div>

    @include('partials.footer')
</div>
@endsection
