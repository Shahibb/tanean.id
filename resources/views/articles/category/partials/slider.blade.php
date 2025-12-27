@php
    $uniqueId = $uniqueId ?? 'slider-' . uniqid();
@endphp

<section class="{{ $bgColor }} py-4 overflow-hidden">
    <div class="relative max-w-7xl mx-auto px-8">
        {{-- JUDUL --}}
        <h2
            class="font-display font-medium text-3xl md:text-4xl text-tanean-dark pl-3 border-l-8 border-tanean-dark mb-4">
            <a href="{{ route('article.category', $route) }}">{{ $title }}</a>
        </h2>

        @include('articles.category.partials.slider-content', ['articles' => $articles, 'uniqueId' => $uniqueId])
    </div>
</section>
