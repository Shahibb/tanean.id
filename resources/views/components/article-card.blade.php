@props([
    'title',
    'image' => null,
    'category' => null,
    'excerpt' => null,
    'author' => 'Unknown',
    'date' => null,
    'link' => '#',
    'variant' => 'default', // default | lead | compact
])
@php
    $imageHeight = match ($variant) {
        'lead' => 'h-72 md:h-80',
        'compact' => 'h-24',
        default => 'h-48',
    };

    $titleClass = match ($variant) {
        'lead' => 'text-2xl md:text-3xl font-bold',
        'compact' => 'text-sm font-semibold leading-snug',
        default => 'text-xl font-bold',
    };
@endphp


<article
    {{ $attributes->merge([
        'class' => 'bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition',
    ]) }}>
    @if ($image)
        <div class="w-full {{ $imageHeight }} overflow-hidden">
            <img src="{{ $image }}" alt="{{ $title }}"
                class="w-full h-full object-cover hover:scale-105 transition duration-300">
        </div>
    @endif


    <div class="p-5">
        @if ($category)
            <span class="text-xs font-semibold uppercase mb-2 inline-block">
                {{ $category }}
            </span>
        @endif

        <h2 class="{{ $titleClass }} mb-2">
            <a href="{{ $link }}" class="hover:underline">
                {{ $title }}
            </a>
        </h2>
        @if ($excerpt && $variant !== 'compact')
            <p class="text-gray-600 text-sm mb-3 leading-relaxed">
                {{ $excerpt }}
            </p>
        @endif

        <div class="flex justify-between items-center text-xs text-gray-500">
            <span>{{ $author }}</span>
            <span>{{ $date }}</span>
        </div>

    </div>
</article>
