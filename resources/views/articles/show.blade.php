@php
    $hideHeader = true;
@endphp
@extends('layouts.app')

@section('title', $article->title . ' - TANEAN.ID')

@section('content')

    {{-- Hero Section dengan Gambar dan Judul --}}
    <section id="hero-section" class="relative w-full h-[70vh] min-h-[100vh] overflow-hidden">
        {{-- Gambar Latar Belakang --}}
        @if ($article->image)
            <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}"
                class="absolute inset-0 w-full h-full object-cover">
        @else
            <div class="absolute inset-0 w-full h-full bg-gradient-to-br from-tanean-green to-tanean-pink"></div>
        @endif

        {{-- Overlay Gelap --}}
        <div class="absolute inset-0 bg-black/50"></div>

        {{-- Navbar Inside Hero --}}
        <nav id="hero-navbar"
            class="absolute top-0 left-0 w-full px-4 py-2 flex justify-between items-center z-20 transition-all duration-300 ease-in-out">
            <div class="flex items-center gap-4">
                <button id="mobile-menu-button-hero" class="flex flex-col items-center gap-1 text-white">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="2"
                            d="M4 5h16M4 10h16M4 15h16M4 20h16" />
                    </svg>
                </button>
                <button id="btn-search-hero" class="flex flex-col items-center gap-1 text-white">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>

            <div class="text-center">
                <a href="{{ route('home') }}"
                    class="inline-block text-3xl md:text-4xl font-holtwood text-white tracking-wide">
                    TANEAN.ID
                </a>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('login') }}"
                    class="hidden md:inline-flex items-center px-4 py-2 rounded-full text-xl font-bold tracking-wide text-white">
                    Masuk
                </a>
            </div>
        </nav>

        {{-- Konten Overlay --}}
        <div class="relative z-10 h-full flex items-center justify-center px-4">
            <div class="max-w-4xl mx-auto text-center">

                {{-- Judul --}}
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-black text-white leading-tight mb-6"
                    style="font-family: 'Playfair Display', serif; text-shadow: 0 2px 20px rgba(0,0,0,0.5);">
                    {{ $article->title }}
                </h1>


            </div>
        </div>
        </div>

        {{-- Indikator Scroll --}}
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </section>

    {{-- Article Content --}}
    <div class="max-w-4xl mx-auto px-4 py-12">

        {{-- Article Content --}}
        <article
            class="bg-white p-8 mb-8 text-left w-full max-w-[624px] px-4 md:px-0 md:mx-auto paragraph break-words mb-4 text-body font-lora rendered-component">
            <!-- Meta Info di atas isi artikel -->
            <div class="flex items-start justify-between border-b shadow-sm p-2 rounded-md relative z-[1]">
                <div class="flex flex-col items-start">
                    <div>
                        <span class="text-sm text-gray-500">Oleh </span>
                        <span class="text-sm font-semibold">{{ $article->author }}</span>
                    </div>

                    <div class="flex items-center">
                        <span
                            class="text-sm text-gray-500">{{ $article->published_at?->format('d M Y H:i') ?? $article->created_at->format('d M Y H:i') }}
                            WIB</span>
                        <svg class="w-1 h-1 mx-2 rounded-full bg-grey-600 flex-shrink-0" fill="currentColor"
                            viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="8" />
                        </svg>
                        <span class="text-sm font-semibold capitalize">{{ $article->category }}</span>
                    </div>
                </div>
                <div class="relative flex items-center justify-center gap-2 py-2">
                    <button id="text-size-button" class="size-text flex items-center hover:text-gray-700">
                        <span class="iconify text-grey-60 text-lg tanean-dark" data-icon="fa6-solid:font"></span>
                        <span class="iconify text-xs text-grey-60" data-icon="fa6-solid:chevron-down"
                            aria-hidden="true"></span>
                    </button>

                    <button id="share-button" class="flex items-center hover:text-gray-700">
                        <span class="iconify text-lg font-semibold" data-icon="fa6-solid:share-nodes"></span>
                    </button>


                    <!-- Dropdown Menu - Horizontal Compact -->
                    <div id="text-size-dropdown"
                        class="hidden absolute top-full mt-2 bg-white border rounded-md shadow-lg z-10">
                        <ul class="flex flex-row divide-x divide-gray-200 rounded-md overflow-hidden">
                            <li>
                                <button
                                    class="text-size-option block px-3 py-2 text-sm hover:bg-gray-100 first:rounded-l-md last:rounded-r-md"
                                    data-size="small">A-</button>
                            </li>
                            <li>
                                <button
                                    class="text-size-option block px-3 py-2 text-sm hover:bg-gray-100 first:rounded-l-md last:rounded-r-md"
                                    data-size="normal">A</button>
                            </li>
                            <li>
                                <button
                                    class="text-size-option block px-3 py-2 text-sm hover:bg-gray-100 first:rounded-l-md last:rounded-r-md"
                                    data-size="large">A+</button>
                            </li>
                        </ul>
                    </div>
                    <div id="share-dropdown"
                        class="hidden absolute top-full right-0 mt-2 bg-white border rounded-md shadow-lg z-10 w-56">
                        <div class="py-2">
                            <!-- Header -->
                            <div class="px-4 py-2 border-b bg-tanean-beige">
                                <h3 class="font-semibold text-gray-800">Bagikan</h3>
                            </div>

                            <!-- Share buttons horizontal -->
                            <div class="flex justify-around py-3 border-b">

                                <button id="share-facebook"
                                    class="share-option flex flex-col items-center p-2 hover:bg-gray-100 rounded">
                                    <span class="iconify text-xl" data-icon="fa6-brands:facebook"></span>
                                </button>
                                <button id="share-twitter"
                                    class="share-option flex flex-col items-center p-2 hover:bg-gray-100 rounded w-10 h-10">
                                    <img src="{{ asset('build/assets/images/x.png') }}" alt="" class="">
                                </button>
                                <button id="share-whatsapp"
                                    class="share-option flex flex-col items-center p-2 hover:bg-gray-100 rounded">
                                    <span class="iconify text-xl" data-icon="fa6-brands:whatsapp"></span>
                                </button>
                            </div>

                            <!-- Copy link section -->
                            <!-- Copy link section -->
                            <div class="px-2 py-1">
                                <div class="flex items-center justify-between">
                                    <div class="text-xs text-gray-600 truncate flex-grow">
                                        {{ request()->url() }}
                                    </div>
                                    <button id="share-copy"
                                        class="share-option py-1 px-2 hover:bg-gray-100 rounded flex items-center">
                                        <span class="iconify mr-1" data-icon="fa6-solid:link"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="article-content text-left mt-8">
                {!! nl2br(e($article->content)) !!}
            </div>
        </article>

    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Setup mobile menu and search for hero navbar
                const mobileMenuButtonHero = document.getElementById('mobile-menu-button-hero');
                const btnSearchHero = document.getElementById('btn-search-hero');
                const mobileMenu = document.getElementById('mobile-menu');
                const searchOverlay = document.getElementById('search-overlay');
                const closeMenuButton = document.getElementById('close-menu');
                const closeSearchButton = document.getElementById('close-search');
                const body = document.body;

                // Helper functions
                const openModal = (el) => {
                    if (!el) return;
                    el.classList.remove('hidden');
                    body.classList.add('overflow-hidden');
                };

                const closeModal = (el) => {
                    if (!el) return;
                    el.classList.add('hidden');
                    body.classList.remove('overflow-hidden');
                };

                // Event listeners for hero navbar
                if (mobileMenuButtonHero && mobileMenu) {
                    mobileMenuButtonHero.addEventListener('click', () => {
                        closeModal(searchOverlay);
                        openModal(mobileMenu);
                    });
                }

                if (btnSearchHero && searchOverlay) {
                    btnSearchHero.addEventListener('click', () => {
                        closeModal(mobileMenu);
                        openModal(searchOverlay);
                    });
                }

                // Close buttons
                if (closeMenuButton && mobileMenu) {
                    closeMenuButton.addEventListener('click', () => {
                        closeModal(mobileMenu);
                    });
                }

                if (closeSearchButton && searchOverlay) {
                    closeSearchButton.addEventListener('click', () => {
                        closeModal(searchOverlay);
                    });
                }

                // Close modals when clicking outside
                if (mobileMenu) {
                    mobileMenu.addEventListener('click', (e) => {
                        if (e.target === mobileMenu) closeModal(mobileMenu);
                    });
                }

                if (searchOverlay) {
                    searchOverlay.addEventListener('click', (e) => {
                        if (e.target === searchOverlay) closeModal(searchOverlay);
                    });
                }

                // ESC key to close modals
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') {
                        closeModal(mobileMenu);
                        closeModal(searchOverlay);
                    }
                });

                // Text size functionality - PINDAHKAN KE SINI
                const textSizeButton = document.getElementById('text-size-button');
                const textSizeDropdown = document.getElementById('text-size-dropdown');
                const textSizeOptions = document.querySelectorAll('.text-size-option');

                // Toggle dropdown
                textSizeButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    textSizeDropdown.classList.toggle('hidden');
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!textSizeButton.contains(e.target) && !textSizeDropdown.contains(e.target)) {
                        textSizeDropdown.classList.add('hidden');
                    }
                });

                // Handle size selection
                textSizeOptions.forEach(option => {
                    option.addEventListener('click', function() {
                        const size = this.getAttribute('data-size');
                        changeTextSize(size);
                        textSizeDropdown.classList.add('hidden');
                    });
                });

                // Function to change text size
                function changeTextSize(size) {
                    const articleContent = document.querySelector('.article-content');
                    if (!articleContent) return;

                    // Remove existing size classes
                    articleContent.classList.remove('text-base', 'text-lg', 'text-xl');

                    // Add new size class
                    switch (size) {
                        case 'small':
                            articleContent.classList.add('text-base');
                            break;
                        case 'normal':
                            articleContent.classList.add('text-lg');
                            break;
                        case 'large':
                            articleContent.classList.add('text-xl');
                            break;
                        default:
                            articleContent.classList.add('text-lg');
                    }

                    // Save preference to localStorage
                    localStorage.setItem('articleTextSize', size);
                }

                // Load saved preference
                const savedSize = localStorage.getItem('articleTextSize');
                if (savedSize) {
                    changeTextSize(savedSize);
                }

                // Navbar transition effect - versi sederhana
                const heroSection = document.getElementById('hero-section');
                const heroNavbar = document.getElementById('hero-navbar');

                if (heroSection && heroNavbar) {
                    window.addEventListener('scroll', function() {
                        const rect = heroSection.getBoundingClientRect();

                        if (rect.bottom <= 100) {
                            // Add scrolled class
                            heroNavbar.classList.remove('absolute', 'text-white');
                            heroNavbar.classList.add('fixed', 'top-0');
                            heroNavbar.setAttribute('data-scrolled', 'true');
                            heroNavbar.classList.remove('bg-transparent');
                            heroNavbar.classList.add('bg-white');
                            heroNavbar.classList.add('border-b');
                            heroNavbar.classList.add('shadow-sm');

                            // Update button colors
                            const buttons = heroNavbar.querySelectorAll('button');
                            buttons.forEach(btn => {
                                btn.classList.remove('text-white');
                                btn.classList.add('text-gray-800');
                            });

                            // Update link colors
                            const links = heroNavbar.querySelectorAll('a');
                            links.forEach(link => {
                                link.classList.remove('text-white');
                                link.classList.add('text-gray-800');
                            });
                        } else {
                            // Remove scrolled class
                            heroNavbar.classList.remove('fixed', 'top-0');
                            heroNavbar.classList.add('absolute', 'text-white');
                            heroNavbar.removeAttribute('data-scrolled');
                            heroNavbar.classList.remove('bg-white');
                            heroNavbar.classList.add('bg-transparent');
                            heroNavbar.classList.remove('border-b');
                            heroNavbar.classList.remove('shadow-sm');

                            // Revert button colors
                            const buttons = heroNavbar.querySelectorAll('button');
                            buttons.forEach(btn => {
                                btn.classList.remove('text-gray-800');
                                btn.classList.add('text-white');
                            });

                            // Revert link colors
                            const links = heroNavbar.querySelectorAll('a');
                            links.forEach(link => {
                                link.classList.remove('text-gray-800');
                                link.classList.add('text-white');
                            });
                        }
                    });
                }
                // Share functionality
                const shareButton = document.getElementById('share-button');
                const shareDropdown = document.getElementById('share-dropdown');
                const shareOptions = document.querySelectorAll('.share-option');

                // Toggle share dropdown
                shareButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    shareDropdown.classList.toggle('hidden');
                    // Tutup dropdown ukuran teks jika terbuka
                    textSizeDropdown.classList.add('hidden');
                });

                // Close share dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!shareButton.contains(e.target) && !shareDropdown.contains(e.target)) {
                        shareDropdown.classList.add('hidden');
                    }
                });

                // Share options functionality
                document.getElementById('share-facebook').addEventListener('click', function() {
                    const url = encodeURIComponent(window.location.href);
                    window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank');
                });

                document.getElementById('share-twitter').addEventListener('click', function() {
                    const url = encodeURIComponent(window.location.href);
                    const title = encodeURIComponent(document.title);
                    window.open(`https://twitter.com/intent/tweet?url=${url}&text=${title}`, '_blank');
                });

                document.getElementById('share-whatsapp').addEventListener('click', function() {
                    const url = encodeURIComponent(window.location.href);
                    const text = encodeURIComponent('Lihat artikel ini: ');
                    window.open(`https://wa.me/?text=${text}%20${url}`, '_blank');
                });

                document.getElementById('share-copy').addEventListener('click', async function() {
                    try {
                        await navigator.clipboard.writeText(window.location.href);
                        alert('Tautan berhasil disalin!');
                    } catch (err) {
                        console.error('Gagal menyalin tautan: ', err);
                        // Fallback untuk browser lama
                        const textArea = document.createElement('textarea');
                        textArea.value = window.location.href;
                        document.body.appendChild(textArea);
                        textArea.select();
                        document.execCommand('copy');
                        document.body.removeChild(textArea);
                        alert('Tautan berhasil disalin!');
                    }
                });
            });
        </script>
    @endpush


@endsection
