@props([
    'title',
    'image' => null,
    'category' => null,
    'excerpt' => null,
    'author' => 'Unknown',
    'date' => null,
    'link' => '#',
    'variant' => 'default', // default | lead | compact | slider
])
@php
    $imageHeight = match ($variant) {
        'lead' => 'h-72 md:h-[275px]',
        'kategori' => 'h-72 md:h-[300px]',
        'compact' => 'h-24',
        'slider' => 'h-32',
        'lensa' => 'h-[100vh]',
        default => 'h-48',
    };

    $titleClass = match ($variant) {
        'lead' => 'text-h2-custom font-medium-weight font-display',
        'compact' => 'text-h2-custom font-medium-weight font-display leading-snug',
        'slider' => 'text-h2-custom font-medium-weight font-display',
        default => 'text-h2-custom font-medium-weight font-display',
    };

@endphp

<article
    {{ $attributes->merge([
        'class' => collect([
            'overflow-hidden transition',
            $variant === 'slider' ? 'w-[320px]  flex-shrink-0 max-w-none' : '',
        ])->implode(' '),
    ]) }}>

    @if ($image)
        <div class="w-full {{ $imageHeight }} overflow-hidden">
            <a href="{{ $link }}"><img src="{{ $image }}" alt="{{ $title }}"
                    class="w-full h-full object-cover hover:scale-105 transition duration-300">
            </a>
        </div>
    @endif


    <div class="py-4">
        @if ($category)
            <span class="text-xs font-medium uppercase mb-2 inline-block">
                {{ $category }}
            </span>
        @endif

        <h2 class="{{ $titleClass }} mb-2">
            <a href="{{ $link }}" class="hover:underline">
                {{ $title }}
            </a>
        </h2>
        <div class="flex justify-between items-center text-author-custom mb-2">
            <span>{{ $author }}</span>
            {{-- <span>{{ $date }}</span> --}}
        </div>
        @if ($excerpt && $variant !== 'compact')
            <p class="text-excerpt-custom">
                {{ $excerpt }}
            </p>
        @endif
    </div>
</article>
