<!-- Grid Layout untuk Warta (Hanya 2 artikel) -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-8 px-16">
    @forelse($topArticles as $article)
        <div>
            <x-article-card variant="kategori" :title="$article->title" :image="asset('storage/' . $article->image)" :excerpt="Str::limit($article->excerpt, 300)" :author="$article->author"
                :date="$article->published_at->format('d M Y')" :link="route('article.show', $article->slug)" />
        </div>
    @empty
        <div class="col-span-2 text-center py-16">
            <div class="text-gray-400 mb-4">
                <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
            </div>
            <p class="text-xl text-gray-600 font-medium">Tidak ada artikel dalam kategori ini.</p>
            <a href="{{ route('home') }}"
                class="inline-block mt-6 px-6 py-3 bg-tanean-dark text-white rounded hover:bg-gray-800 transition">
                Kembali ke Beranda
            </a>
        </div>
    @endforelse
</div>

<!-- Slider 1 warta -->
@include('articles.category.partials.slider', [
    'articles' => $swaraArticles,
    'bgColor' => 'bg-tanean-beige',
    'title' => 'Swara',
    'route' => 'swara',
    'uniqueId' => 'warta-1',
])

<!-- Slider Section 2 warta -->
@include('articles.category.partials.slider', [
    'articles' => $swaraArticles,
    'bgColor' => 'bg-tanean-beige',
    'title' => 'Swara',
    'route' => 'swara',
    'uniqueId' => 'warta-2',
])
