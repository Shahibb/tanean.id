<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TANEAN.ID')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'tanean-beige': '#ACA593',
                        'tanean-green': '#B8C5A8',
                        'tanean-pink': '#E5A9A1',
                        'tanean-dark': '#2C2C2C',
                    },
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                        'display': ['Holtwood One SC', 'serif'], // Tambahkan ini
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Holtwood+One+SC&family=Playfair+Display:wght@700;800;900&display=swap"
        rel="stylesheet">
</head>

<body class="font-sans">

    <header class="bg-white relative z-50">

        <!-- TOP BAR -->
        <div class="max-w-7xl mx-auto px-8 py-4">
            <div class="grid grid-cols-3 items-center">

                <!-- LEFT -->
                <div class="flex items-center gap-6">
                    <button id="mobile-menu-button" class="flex flex-col items-center gap-1 text-tanean-beige">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="2"
                                d="M4 5h16M4 10h16M4 15h16M4 20h16" />
                        </svg>
                        <span class="text-xs tracking-widest font-semibold">MENU</span>
                    </button>

                    <button id="btn-search" class="flex flex-col items-center gap-1 text-tanean-beige">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <span class="text-xs tracking-widest font-semibold">CARI</span>
                    </button>
                </div>

                <!-- LOGO -->
                <div class="text-center">
                    <a href="{{ route('home') }}"
                        class="inline-block text-4xl md:text-5xl lg:text-5xl font-normal text-tanean-beige tracking-wide font-display">
                        TANEAN.ID
                    </a>
                </div>

                <!-- RIGHT -->
                <div class="flex justify-end gap-3">
                    <a href="#"
                        class="hidden md:inline-flex items-center px-5 py-2 rounded-full text-xs font-bold uppercase tracking-wide text-white bg-tanean-beige hover:bg-tanean-dark hover:border-tanean-dark border border-transparent transition">
                        Kirimkan Ceritamu
                    </a>
                    <a href="#"
                        class="hidden md:inline-flex items-center px-5 py-2 rounded-full text-xs font-bold uppercase tracking-wide border-2 border-tanean-beige text-tanean-beige hover:bg-tanean-dark hover:text-white transition">
                        Masuk
                    </a>
                </div>

            </div>
        </div>

        <!-- RUBRIK -->
        <nav class="hidden md:block border-t-2 border-b-2 border-tanean-beige mb-4 py-1 bg-white">
            <ul class="flex justify-center gap-56 py-1 text-sm font-semibold tracking-widest uppercase text-gray-800">
                <li><a href="{{ route('article.category', 'warta') }}" class="hover:text-tanean-beige">Warta</a></li>
                <li><a href="{{ route('article.category', 'warita') }}" class="hover:text-tanean-beige">Warita</a></li>
                <li><a href="{{ route('article.category', 'swara') }}" class="hover:text-tanean-beige">Swara</a></li>
                <li><a href="{{ route('article.category', 'lensa') }}" class="hover:text-tanean-beige">Lensa</a></li>
            </ul>
        </nav>

    </header>
    <div id="search-overlay"
        class="fixed inset-0 bg-black/70 hidden z-50 flex items-center justify-center
           transition-opacity duration-300">
        <div class="bg-white w-full max-w-xl p-6 rounded">
            <form action="{{ route('home') }}" method="GET">
                <input type="text" name="q" placeholder="Cari artikel..."
                    class="w-full border px-4 py-3 text-lg focus:outline-none" autofocus>
            </form>
            <button id="close-search" class="mt-4 text-sm text-gray-500">Tutup</button>
        </div>
    </div>



    <!-- Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-tanean-beige">
        <div class="container mx-auto px-6 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Brand -->
                <div>
                    <h3 class="text-xl font-bold text-tanean-dark mb-4">TANEAN.ID</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Platform berita dan informasi terkini untuk Anda.
                    </p>
                    <!-- Social Media -->
                    <div class="flex space-x-4 mt-6">
                        <a href="#" class="text-tanean-dark hover:text-gray-600">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                        <a href="#" class="text-tanean-dark hover:text-gray-600">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                            </svg>
                        </a>
                        <a href="#" class="text-tanean-dark hover:text-gray-600">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                            </svg>
                        </a>
                        <a href="#" class="text-tanean-dark hover:text-gray-600">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Kontak -->
                <div>
                    <h4 class="font-semibold text-tanean-dark mb-4">Kontak</h4>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li><a href="#" class="hover:text-tanean-dark">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-tanean-dark">Redaksi</a></li>
                        <li><a href="#" class="hover:text-tanean-dark">Pedoman Media Siber</a></li>
                        <li><a href="#" class="hover:text-tanean-dark">Kontak</a></li>
                    </ul>
                </div>

                <!-- Rubrik -->
                <div>
                    <h4 class="font-semibold text-tanean-dark mb-4">Rubrik</h4>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li><a href="{{ route('article.category', 'warta') }}"
                                class="hover:text-tanean-dark">Warta</a>
                        </li>
                        <li><a href="{{ route('article.category', 'swara') }}"
                                class="hover:text-tanean-dark">Swara</a>
                        </li>
                        <li><a href="{{ route('article.category', 'warita') }}"
                                class="hover:text-tanean-dark">warita</a>
                        </li>
                        <li><a href="#" class="hover:text-tanean-dark">Arsip</a></li>
                    </ul>
                </div>

                <!-- Info -->
                <div>
                    <h4 class="font-semibold text-tanean-dark mb-4">Info</h4>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li><a href="#" class="hover:text-tanean-dark">Disclaimer</a></li>
                        <li><a href="#" class="hover:text-tanean-dark">Kebijakan Privasi</a></li>
                        <li><a href="#" class="hover:text-tanean-dark">Syarat dan Ketentuan</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-tanean-dark mt-4 pt-8 text-center text-sm text-tanean-dark">
                <p>&copy; 2025 SHAHIB. All rights reserved.</p>
            </div>
        </div>
    </footer>
    <!-- MOBILE MENU -->
    <div id="mobile-menu" class="fixed inset-0 bg-black/50 hidden z-50
           transition-opacity duration-300">
        <div class="bg-white w-72 h-full p-6">
            <button id="close-menu" class="mb-6 text-sm">✕ Tutup</button>

            <nav class="space-y-4 uppercase font-semibold text-sm">
                <a href="{{ route('home') }}" class="block">Beranda</a>
                <a href="{{ route('article.category', 'warta') }}" class="block">Warta</a>
                <a href="{{ route('article.category', 'swara') }}" class="block">Swara</a>
                <a href="{{ route('article.category', 'warita') }}" class="block">warita</a>
                <a href="{{ route('article.category', 'lensa') }}" class="block">Lensa</a>
            </nav>

            <div class="mt-8 space-y-3">
                <a href="#" class="block bg-tanean-green text-center py-2 rounded">Kirim Cerita</a>
                <a href="{{ route('login') }}" class="block border text-center py-2 rounded">Masuk</a>
            </div>
        </div>
    </div>
    <!-- Mobile Menu Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const body = document.body;

            // ===== ELEMENTS =====
            const menuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const closeMenuButton = document.getElementById('close-menu');

            const searchButton = document.getElementById('btn-search');
            const searchOverlay = document.getElementById('search-overlay');
            const closeSearchButton = document.getElementById('close-search');

            // ===== HELPERS =====
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

            // ===== MOBILE MENU =====
            if (menuButton && mobileMenu) {
                menuButton.addEventListener('click', () => {
                    closeModal(searchOverlay); // tutup search kalau kebuka
                    openModal(mobileMenu);
                });
            }

            if (closeMenuButton && mobileMenu) {
                closeMenuButton.addEventListener('click', () => {
                    closeModal(mobileMenu);
                });
            }

            if (mobileMenu) {
                mobileMenu.addEventListener('click', (e) => {
                    if (e.target === mobileMenu) closeModal(mobileMenu);
                });
            }

            // ===== SEARCH =====
            if (searchButton && searchOverlay) {
                searchButton.addEventListener('click', () => {
                    closeModal(mobileMenu); // tutup menu kalau kebuka
                    openModal(searchOverlay);
                });
            }

            if (closeSearchButton && searchOverlay) {
                closeSearchButton.addEventListener('click', () => {
                    closeModal(searchOverlay);
                });
            }

            if (searchOverlay) {
                searchOverlay.addEventListener('click', (e) => {
                    if (e.target === searchOverlay) closeModal(searchOverlay);
                });
            }

            // ===== ESC KEY =====
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    closeModal(mobileMenu);
                    closeModal(searchOverlay);
                }
            });

        });
    </script>

</body>

</html>
