<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TANEAN.ID')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'tanean-beige': '#E8E4DD',
                        'tanean-green': '#B8C5A8',
                        'tanean-pink': '#E5A9A1',
                        'tanean-dark': '#2C2C2C',
                    },
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-tanean-beige font-sans">
    <!-- Navbar -->
    <nav class="bg-tanean-beige border-b border-gray-300 sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="text-2xl font-bold text-tanean-dark tracking-tight">
                    TANEAN.ID
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="{{ route('home') }}"
                        class="text-tanean-dark hover:text-gray-600 transition {{ request()->routeIs('home') ? 'font-semibold' : '' }}">
                        Beranda
                    </a>
                    <a href="{{ route('article.category', 'media') }}"
                        class="text-tanean-dark hover:text-gray-600 transition {{ request()->routeIs('article.category') && request()->category == 'media' ? 'font-semibold' : '' }}">
                        Media
                    </a>
                    <a href="{{ route('article.category', 'fiksi') }}"
                        class="text-tanean-dark hover:text-gray-600 transition {{ request()->routeIs('article.category') && request()->category == 'fiksi' ? 'font-semibold' : '' }}">
                        Fiksi
                    </a>
                    <a href="{{ route('article.category', 'info') }}"
                        class="text-tanean-dark hover:text-gray-600 transition {{ request()->routeIs('article.category') && request()->category == 'info' ? 'font-semibold' : '' }}">
                        Info
                    </a>

                    <!-- Search Icon -->
                    <button class="text-tanean-dark hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>

                <!-- Mobile Menu Button -->
                <button class="md:hidden text-tanean-dark" id="mobile-menu-button">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div class="hidden md:hidden mt-4 pb-4" id="mobile-menu">
                <a href="{{ route('home') }}" class="block py-2 text-tanean-dark hover:text-gray-600">Beranda</a>
                <a href="{{ route('article.category', 'media') }}"
                    class="block py-2 text-tanean-dark hover:text-gray-600">Media</a>
                <a href="{{ route('article.category', 'fiksi') }}"
                    class="block py-2 text-tanean-dark hover:text-gray-600">Fiksi</a>
                <a href="{{ route('article.category', 'info') }}"
                    class="block py-2 text-tanean-dark hover:text-gray-600">Info</a>
            </div>
        </div>
    </nav>
    <!-- Navbar -->
    <nav class="bg-tanean-beige border-b border-gray-300 sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4">
            {{-- <div class="container mx-auto px-6 py-3"> --}}

            <div class="flex justify-between items-center">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="text-2xl font-bold text-tanean-dark tracking-tight">
                    TANEAN.ID
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="{{ route('home') }}"
                        class="text-tanean-dark hover:text-gray-600 transition {{ request()->routeIs('home') ? 'font-semibold' : '' }}">
                        Beranda
                    </a>
                    <a href="{{ route('article.category', 'warta') }}"
                        class="text-tanean-dark hover:text-gray-600 transition {{ request()->routeIs('article.category') && request()->category == 'warta' ? 'font-semibold' : '' }}">
                        Warta
                    </a>
                    <a href="{{ route('article.category', 'swara') }}"
                        class="text-tanean-dark hover:text-gray-600 transition {{ request()->routeIs('article.category') && request()->category == 'swara' ? 'font-semibold' : '' }}">
                        Swara
                    </a>
                    <a href="{{ route('article.category', 'warita') }}"
                        class="text-tanean-dark hover:text-gray-600 transition {{ request()->routeIs('article.category') && request()->category == 'warita' ? 'font-semibold' : '' }}">
                        warita
                    </a>

                    <!-- Search Icon -->
                    <button class="text-tanean-dark hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>

                <!-- Mobile Menu Button -->
                <button class="md:hidden text-tanean-dark" id="mobile-menu-button">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div class="hidden md:hidden mt-4 pb-4" id="mobile-menu">
                <a href="{{ route('home') }}" class="block py-2 text-tanean-dark hover:text-gray-600">Beranda</a>
                <a href="{{ route('article.category', 'warta') }}"
                    class="block py-2 text-tanean-dark hover:text-gray-600">warta</a>
                <a href="{{ route('article.category', 'info') }}"
                    class="block py-2 text-tanean-dark hover:text-gray-600">Info</a>
                <a href="{{ route('article.category', 'warita') }}"
                    class="block py-2 text-tanean-dark hover:text-gray-600">warita</a>
            </div>
        </div>
    </nav>
    <!-- Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-tanean-beige border-t border-gray-300 mt-16">
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
                        <li><a href="{{ route('article.category', 'media') }}"
                                class="hover:text-tanean-dark">Media</a></li>
                        <li><a href="{{ route('article.category', 'fiksi') }}"
                                class="hover:text-tanean-dark">Fiksi</a></li>
                        <li><a href="{{ route('article.category', 'info') }}" class="hover:text-tanean-dark">Info</a>
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

            <div class="border-t border-gray-300 mt-8 pt-8 text-center text-sm text-gray-600">
                <p>&copy; 2024 TANEAN.ID. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Mobile Menu Toggle Script -->
    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>
</body>

</html>
