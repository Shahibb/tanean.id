<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TANEAN.ID')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'tanean-beige': '#ACA593',
                        'tanean-green': '#B8C5A8',
                        'tanean-pink': '#E5A9A1',
                        'tanean-dark': '#2C2C2C',
                        'tanean-logo': '#9D9385'
                    },
                    fontFamily: {
                        'display': ['Roboto Serif', 'serif'],
                        'holtwood': ['Holtwood One SC', 'serif'],
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
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto+Serif:opsz,wght@8..144,400;8..144,500;8..144,600;8..144,700;8..144,800;8..144,900&family=Holtwood+One+SC&family=Playfair+Display:wght@700;800;900&display=swap"
        rel="stylesheet">
    <style>
        .font-medium-weight {
            font-weight: 500;
        }

        .text-h2-custom {
            font-size: 20px;
            line-height: 1;
            letter-spacing: 0;
        }

        .text-excerpt-custom {
            font-family: 'Roboto Serif', serif;
            font-weight: 400;
            font-style: normal;
            font-size: 15px;
            line-height: 1;
            letter-spacing: 0;
            text-align: justify;
        }

        .text-author-custom {
            font-family: 'Roboto Serif', serif;
            font-weight: 400;
            font-style: italic;
            font-size: 14px;
            line-height: 1;
            letter-spacing: 0;
        }

        #category-navbar a.active-category {
            position: relative;
        }

        #category-navbar a.active-category::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
        }
    </style>
</head>

<body class="font-sans">
    <!-- Replace the existing <header> block with this -->
    @if (!isset($hideHeader) || !$hideHeader)
        <header class="bg-white sticky top-0 z-50">
            <!-- TOP BAR -->
            <div class="max-w-7xl mx-auto px-8 py-4">
                <div class="grid grid-cols-3 items-center">
                    <div class="flex items-center gap-1 md:gap-6">
                        <button id="mobile-menu-button" class="flex flex-col items-center gap-1 text-tanean-beige">
                            <svg class="w-4 h-4 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="2"
                                    d="M4 5h16M4 10h16M4 15h16M4 20h16" />
                            </svg>
                            <span class="hidden md:block text-xs tracking-widest font-semibold">MENU</span>
                        </button>

                        <button id="btn-search" class="flex flex-col items-center gap-1 text-tanean-beige">
                            <svg class="w-4 h-4 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <span class="hidden md:block text-xs tracking-widest font-semibold">CARI</span>
                        </button>
                    </div>

                    <!-- LOGO -->
                    <div class="flex justify-center">
                        <a href="{{ route('home') }}"
                            class="inline-block text-2xl md:text-4xl lg:text-5xl font-holtwood text-tanean-logo tracking-wide">
                            TANEAN.ID
                        </a>
                    </div>

                    <!-- RIGHT -->
                    <div class="flex justify-end gap-3">
                        <a href="#"
                            class="hidden md:inline-flex items-center px-5 py-2 rounded-full text-xs font-bold uppercase tracking-wide text-white bg-tanean-beige hover:bg-tanean-dark hover:border-tanean-dark border border-transparent transition">
                            Kirimkan Ceritamu
                        </a>
                        <a href="{{ route('login') }}"
                            class="hidden md:inline-flex items-center px-5 py-2 rounded-[15px] text-xs font-bold uppercase tracking-wide text-white bg-tanean-beige hover:bg-tanean-dark hover:border-tanean-dark border border-transparent transition"
                            target="_blank">
                            Masuk
                        </a>
                    </div>

                </div>
            </div>

            <!-- RUBRIK -->
            <nav id="category-navbar" class="hidden md:block border-t border-b border-tanean-beige py-1 bg-white">
                <ul
                    class="flex justify-center gap-56 py-1 text-sm font-semibold tracking-widest uppercase text-gray-800">
                    <li>
                        <a href="{{ route('article.category', 'warta') }}"
                            class="hover:text-tanean-beige {{ isset($category) && $category == 'warta' ? '!text-tanean-beige' : '' }}">
                            Warta
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('article.category', 'warita') }}"
                            class="hover:text-tanean-beige {{ isset($category) && $category == 'warita' ? '!text-tanean-beige' : '' }}">
                            Warita
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('article.category', 'swara') }}"
                            class="hover:text-tanean-beige {{ isset($category) && $category == 'swara' ? '!text-tanean-beige' : '' }}">
                            Swara
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('article.category', 'lensa') }}"
                            class="hover:text-tanean-beige {{ isset($category) && $category == 'lensa' ? '!text-tanean-beige' : '' }}">
                            Lensa
                        </a>
                    </li>
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
    @endif



    <!-- Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-tanean-beige">
        <div class="container mx-auto px-6 pt-16 md:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Brand -->
                <div>
                    <div>
                        <img src="{{ asset('build/assets/images/footer.png') }}" alt="footer logo"
                            class="h-[146px] w-[363px] mb-4">
                    </div>
                    <!-- Social Media -->
                    <div class="flex justify-center space-x-4 mt-10">
                        <a href="#" class="text-tanean-dark hover:text-gray-600">
                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                        <a href="#" class="text-tanean-dark hover:text-gray-600">
                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072zm0-2.163c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                            </svg>
                        </a>
                        <a href="#" class="text-tanean-dark hover:text-gray-600">
                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                            </svg>
                        </a>
                        <a href="#" class="text-tanean-dark hover:text-gray-600">
                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
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
                    <div>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li><a href="#" class="hover:text-tanean-dark">Disclaimer</a></li>
                            <li><a href="#" class="hover:text-tanean-dark">Kebijakan Privasi</a></li>
                            <li><a href="#" class="hover:text-tanean-dark">Syarat dan Ketentuan</a></li>
                            <div class="py-5">
                                <a href="#"
                                    class=" px-5 py-2 text-xs font-bold uppercase tracking-wide text-white bg-tanean-dark hover:bg-tanean-dark hover:border-tanean-dark border border-transparent transition">
                                    Kirimkan Ceritamu
                                </a>
                            </div>
                            <div>
                                <a href="{{ route('login') }}"
                                    class=" px-5 py-2 text-xs font-bold uppercase tracking-wide text-white bg-tanean-dark hover:bg-tanean-dark hover:border-tanean-dark border border-transparent transition"
                                    target="_blank">
                                    Masuk
                                </a>
                            </div>
                        </ul>
                    </div>


                </div>
            </div>
            <div class="border-t border-tanean-dark py-4 mt-4 text-center text-sm text-tanean-dark">
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
            // Fungsi untuk menginisialisasi slider
            // Slider Desktop
            function initDesktopSlider() {
                // Ambil semua slider desktop dengan kelas unik
                const sliders = document.querySelectorAll('[class*="lensaSliderDesktop-"]');

                sliders.forEach(slider => {
                    // Ekstrak ID unik dari kelas
                    const classList = Array.from(slider.classList);
                    const uniqueId = classList.find(cls => cls.includes('lensaSliderDesktop-')).split(
                        'lensaSliderDesktop-')[1];

                    // Cari elemen-elemen terkait dengan ID unik
                    const prevBtn = document.querySelector(`.lensaPrevDesktop-${uniqueId}`);
                    const nextBtn = document.querySelector(`.lensaNextDesktop-${uniqueId}`);
                    const container = slider.querySelector(`.carousel-container-${uniqueId}`);
                    const dots = document.querySelectorAll(`.dot-desktop-${uniqueId}`);

                    if (!slider || !prevBtn || !nextBtn || !container) return;

                    let currentIndex = 0;
                    const totalSlides = container.children.length;

                    function updateSlider() {
                        container.style.transform = `translateX(-${currentIndex * 100}%)`;

                        // Update dots
                        dots.forEach((dot, index) => {
                            dot.classList.toggle('bg-white', index === currentIndex);
                            dot.classList.toggle('bg-gray-400', index !== currentIndex);
                        });
                    }

                    // Next button
                    if (nextBtn) {
                        nextBtn.addEventListener('click', (e) => {
                            e.preventDefault();
                            if (currentIndex < totalSlides - 1) {
                                currentIndex++;
                            } else {
                                currentIndex = 0;
                            }
                            updateSlider();
                        });
                    }

                    // Previous button
                    if (prevBtn) {
                        prevBtn.addEventListener('click', (e) => {
                            e.preventDefault();
                            if (currentIndex > 0) {
                                currentIndex--;
                            } else {
                                currentIndex = totalSlides - 1;
                            }
                            updateSlider();
                        });
                    }

                    // Dot navigation
                    dots.forEach((dot, index) => {
                        dot.addEventListener('click', (e) => {
                            e.preventDefault();
                            currentIndex = index;
                            updateSlider();
                        });
                    });
                });
            }

            // Slider Mobile
            function initMobileSlider() {
                // Ambil semua slider mobile dengan kelas unik
                const sliders = document.querySelectorAll('[class*="lensaSliderMobile-"]');

                sliders.forEach(slider => {
                    // Ekstrak ID unik dari kelas
                    const classList = Array.from(slider.classList);
                    const uniqueId = classList.find(cls => cls.includes('lensaSliderMobile-')).split(
                        'lensaSliderMobile-')[1];

                    // Cari elemen-elemen terkait dengan ID unik
                    const prevBtn = document.querySelector(`.lensaPrevMobile-${uniqueId}`);
                    const nextBtn = document.querySelector(`.lensaNextMobile-${uniqueId}`);
                    const container = slider.querySelector(`.carousel-container-${uniqueId}`);
                    const dots = document.querySelectorAll(`.dot-mobile-${uniqueId}`);

                    if (!slider || !prevBtn || !nextBtn || !container) return;

                    let currentIndex = 0;
                    const totalSlides = container.children.length;

                    function updateSlider() {
                        container.style.transform = `translateX(-${currentIndex * 100}%)`;

                        // Update dots
                        dots.forEach((dot, index) => {
                            dot.classList.toggle('bg-white', index === currentIndex);
                            dot.classList.toggle('bg-gray-400', index !== currentIndex);
                        });
                    }

                    // Next button
                    if (nextBtn) {
                        nextBtn.addEventListener('click', (e) => {
                            e.preventDefault();
                            if (currentIndex < totalSlides - 1) {
                                currentIndex++;
                            } else {
                                currentIndex = 0;
                            }
                            updateSlider();
                        });
                    }

                    // Previous button
                    if (prevBtn) {
                        prevBtn.addEventListener('click', (e) => {
                            e.preventDefault();
                            if (currentIndex > 0) {
                                currentIndex--;
                            } else {
                                currentIndex = totalSlides - 1;
                            }
                            updateSlider();
                        });
                    }

                    // Dot navigation
                    dots.forEach((dot, index) => {
                        dot.addEventListener('click', (e) => {
                            e.preventDefault();
                            currentIndex = index;
                            updateSlider();
                        });
                    });
                });
            }

            // Inisialisasi slider
            initDesktopSlider();
            initMobileSlider();

        });
    </script>
    @stack('scripts')
</body>

</html>
