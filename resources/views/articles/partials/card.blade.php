<article class="article-card">
    <a href="{{ route('articles.show', $article->slug) }}">
        <img src="{{ asset('storage/'.$article->image) }}" alt="{{ $article->title }}">
        <h3>{{ $article->title }}</h3>
        <p>{{ $article->excerpt }}</p>
        <span class="meta">
            {{ $article->created_at->format('d M Y') }}
        </span>
    </a>
</article>
