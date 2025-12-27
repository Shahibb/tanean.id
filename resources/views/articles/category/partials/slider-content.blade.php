{{-- Slider Desktop (3 artikel per slide) --}}
<div class="hidden md:block relative">
    <button
        class="lensaPrevDesktop-{{ $uniqueId ?? 'default' }} absolute -left-6 top-1/2 -translate-y-1/2 z-10
w-12 h-12 rounded-full
bg-white/90 backdrop-blur
shadow-md hover:shadow-lg
flex items-center justify-center
text-2xl text-tanean-dark
transition-all duration-200
hover:-translate-x-0.5
hover:bg-white
focus:outline-none focus:ring-2 focus:ring-tanean-beige">
        ‹
    </button>

    <button
        class="lensaNextDesktop-{{ $uniqueId ?? 'default' }} absolute -right-6 top-1/2 -translate-y-1/2 z-10
w-12 h-12 rounded-full
bg-white/90 backdrop-blur
shadow-md hover:shadow-lg
flex items-center justify-center
text-2xl text-tanean-dark
transition-all duration-200
hover:translate-x-0.5
hover:bg-white
focus:outline-none focus:ring-2 focus:ring-tanean-beige">
        ›
    </button>

    <div class="lensaSliderDesktop-{{ $uniqueId ?? 'default' }} flex gap-8 overflow-hidden">
        <div class="carousel-container-{{ $uniqueId ?? 'default' }} flex transition-transform duration-300 ease-in-out">
            @php
                $articlesCollection = collect($articles ?? []);
                $chunkedArticles = $articlesCollection->chunk(3);
            @endphp

            @forelse($chunkedArticles as $chunk)
                <div class="carousel-slide flex gap-8 min-w-full">
                    @foreach ($chunk as $article)
                        <div class="flex-1">
                            <x-article-card variant="masyarakat-adat" :title="$article->title"
                                :image="asset('storage/' . $article->image)" :link="route('article.show', $article->slug)" :author="$article->author" />
                        </div>
                    @endforeach

                    {{-- Jika kurang dari 3 artikel, tambahkan placeholder --}}
                    @for ($i = count($chunk); $i < 3; $i++)
                        <div class="flex-1 invisible">
                            <div class="h-32"></div>
                        </div>
                    @endfor
                </div>
            @empty
                <p class="text-gray-500 w-full text-center">Belum ada artikel.</p>
            @endforelse
        </div>
    </div>
</div>

{{-- Slider Mobile (1 artikel per slide) --}}
<div class="md:hidden relative">
    <button
        class="lensaPrevMobile-{{ $uniqueId ?? 'default' }} absolute -left-6 top-1/2 -translate-y-1/2 z-10
w-12 h-12 rounded-full
bg-white/90 backdrop-blur
shadow-md hover:shadow-lg
flex items-center justify-center
text-2xl text-tanean-dark
transition-all duration-200
hover:-translate-x-0.5
hover:bg-white
focus:outline-none focus:ring-2 focus:ring-tanean-beige">
        ‹
    </button>

    <button
        class="lensaNextMobile-{{ $uniqueId ?? 'default' }} absolute -right-6 top-1/2 -translate-y-1/2 z-10
w-12 h-12 rounded-full
bg-white/90 backdrop-blur
shadow-md hover:shadow-lg
flex items-center justify-center
text-2xl text-tanean-dark
transition-all duration-200
hover:translate-x-0.5
hover:bg-white
focus:outline-none focus:ring-2 focus:ring-tanean-beige">
        ›
    </button>

    <div class="lensaSliderMobile-{{ $uniqueId ?? 'default' }} flex gap-8 overflow-hidden">
        <div class="carousel-container-{{ $uniqueId ?? 'default' }} flex transition-transform duration-300 ease-in-out">
            @php
                $articlesCollection = collect($articles ?? []);
            @endphp
            
            @forelse($articlesCollection as $article)
                <div class="carousel-slide min-w-full">
                    <x-article-card variant="masyarakat-adat" :title="$article->title" :image="asset('storage/' . $article->image)"
                        :link="route('article.show', $article->slug)" :author="$article->author" />
                </div>
            @empty
                <p class="text-gray-500 w-full text-center">Belum ada artikel.</p>
            @endforelse
        </div>
    </div>
</div>

{{-- Dots untuk desktop --}}
<div class="hidden md:flex carousel-dots-desktop-{{ $uniqueId ?? 'default' }} justify-center gap-3">
    @php
        $articlesCollection = collect($articles ?? []);
        $totalArticles = $articlesCollection->count();
    @endphp
    
    @if ($totalArticles > 0)
        @for ($i = 0; $i < ceil($totalArticles / 3); $i++)
            <button class="dot-desktop-{{ $uniqueId ?? 'default' }} w-3 h-3 rounded-full {{ $i === 0 ? 'bg-white' : 'bg-gray-400' }}"
                data-index="{{ $i }}"></button>
        @endfor
    @endif
</div>

{{-- Dots untuk mobile --}}
<div class="md:hidden carousel-dots-mobile-{{ $uniqueId ?? 'default' }} justify-center gap-3 flex">
    @php
        $articlesCollection = collect($articles ?? []);
        $totalArticles = $articlesCollection->count();
    @endphp
    
    @if ($totalArticles > 0)
        @for ($i = 0; $i < $totalArticles; $i++)
            <button class="dot-mobile-{{ $uniqueId ?? 'default' }} w-3 h-3 rounded-full {{ $i === 0 ? 'bg-white' : 'bg-gray-400' }}"
                data-index="{{ $i }}"></button>
        @endfor
    @endif
</div>