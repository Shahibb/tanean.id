{{--
    CATATAN PENTING:
    1. Pastikan Anda telah mengonfigurasi 'font-serif' di tailwind.config.js Anda (misal: menggunakan font Lora atau Playfair Display) agar tipografinya mirip dengan gambar referensi.
    2. Warna background bg-[#f4dcd3] dan warna ikon text-[#cda45e] adalah pendekatan arbitrary untuk meniru gambar. Sesuaikan jika ada kode warna yang lebih pas.
--}}

<section class="bg-white font-serif text-gray-900 py-12 md:py-16 px-6 md:px-12 lg:px-20">
    <div class="container mx-auto p-6 md:p-12 lg:p-20 border shadow-lg">
        <div class="mb-8">
            <h2 class="text-3xl md:text-4xl font-bold tracking-wide">Video</h2>
        </div>

        @if ($mainVideo)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12 items-start">
                <div class="relative group cursor-pointer w-full">
                    <img src="{{ $mainVideo->thumbnail_url }}" alt="{{ $mainVideo->title }}"
                        class="w-full h-auto object-cover aspect-video shadow-sm">
                    {{-- Play Button Overlay --}}
                    <div class="absolute inset-0 flex items-center justify-center transition-colors bg-black/10 group-hover:bg-black/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 md:h-24 md:w-24 text-grey-200 opacity-90 group-hover:opacity-100 transition-transform group-hover:scale-105" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                            <circle cx="12" cy="12" r="10" />
                            <polygon points="10 8 16 12 10 16 10 8" fill="currentColor" stroke="none"/>
                        </svg>
                    </div>
                </div>

                <div class="flex flex-col justify-center">
                    <h3 class="text-1xl md:text-2xl font-bold leading-tight capitalize">{{ $mainVideo->title }}</h3>
                    <p class="text-xs md:text-md font-medium text-gray-700 mt-3 mb-4 capitalize">{{ $mainVideo->author }}</p>
                    <p class="text-xs md:text-md leading-relaxed text-justify text-gray-800">
                        {{ Str::limit($mainVideo->description, 350) }} {{-- Limit sedikit diperpanjang --}}
                    </p>
                </div>
            </div>
        @else
            <div class="text-center py-16 text-gray-600 italic border-2 border-dashed border-gray-400 rounded-lg">
                <p>Tidak ada video utama yang tersedia saat ini.</p>
            </div>
        @endif

        @if ($otherVideos->count() > 0)
        <div class="mt-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-6 lg:gap-10">
                @foreach ($otherVideos as $video)
                    <div class="flex flex-col group cursor-pointer">
                        <div class="relative w-full aspect-video overflow-hidden mb-4">
                            <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            {{-- Play Button Overlay (Smaller) --}}
                            <div class="absolute inset-0 flex items-center justify-center transition-colors bg-black/10 group-hover:bg-black/20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-grey-200 opacity-90 group-hover:opacity-100 transition-transform group-hover:scale-105" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                                    <circle cx="12" cy="12" r="10" />
                                    <polygon points="10 8 16 12 10 16 10 8" fill="currentColor" stroke="none"/>
                                </svg>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-lg md:text-xl font-bold leading-tight group-hover:underline decoration-[#cda45e] capitalize decoration-2 underline-offset-4 transition-all">
                                {{ $video->title }}
                            </h4>
                            <p class="text-sm font-medium text-gray-700 mt-2 capitalize">{{ $video->author }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>
