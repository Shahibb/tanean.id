<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <div class="flex h-screen">

        <!-- Sidebar -->
        @auth
            <aside class="w-64 bg-gray-800 text-white">
                <div class="p-4">
                    <h2 class="text-2xl font-bold">BeritaKu Admin</h2>
                    <p class="text-sm text-gray-400">{{ ucfirst(Auth::user()->role) }}</p>
                </div>
                <nav class="mt-4">
                    @if (method_exists(Auth::user(), 'isAdmin') && Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"
                            class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">Dashboard</a>
                        <a href="{{ route('admin.articles.index') }}"
                            class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.articles.*') ? 'bg-gray-700' : '' }}">Artikel</a>
                        <a href="{{ route('admin.users.index') }}"
                            class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.users.*') ? 'bg-gray-700' : '' }}">Users</a>
                    @elseif(method_exists(Auth::user(), 'isEditor') && Auth::user()->isEditor())
                        <a href="{{ route('admin.dashboard') }}"
                            class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">Dashboard</a>
                        <a href="{{ route('admin.articles.index') }}"
                            class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.articles.*') ? 'bg-gray-700' : '' }}">Artikel</a>
                    @elseif(method_exists(Auth::user(), 'isWartawan') && Auth::user()->isWartawan())
                        <a href="{{ route('admin.dashboard') }}"
                            class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">Dashboard</a>
                        <a href="{{ route('admin.articles.index') }}"
                            class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.articles.*') ? 'bg-gray-700' : '' }}">Daftar
                            Artikel Saya</a>
                        <a href="{{ route('admin.articles.create') }}"
                            class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.articles.create') ? 'bg-gray-700' : '' }}">Tulis
                            Artikel</a>
                    @else
                        <a href="{{ route('admin.dashboard') }}"
                            class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">Dashboard</a>
                    @endif

                    <a href="{{ route('home') }}" class="block px-4 py-2 hover:bg-gray-700 mt-4" target="_blank">Lihat
                        Website</a>
                    <form method="POST" action="{{ route('logout') }}" class="mt-4">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-gray-700">Logout</button>
                    </form>
                </nav>
            </aside>
        @else
            <aside class="w-64 bg-gray-800 text-white p-6">
                <p class="text-sm">Silakan <a href="{{ route('login') }}" class="text-blue-300 hover:underline">login</a>
                    untuk mengakses panel admin.</p>
            </aside>
        @endauth

        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto">
            <!-- Header -->
            <header class="bg-white shadow-sm">
                @include('layouts.navigation')
            </header>

            <!-- Content -->
            <div class="px-6 py-4">

                    <h1 class="text-2xl font-semibold text-gray-800">@yield('header') </h1>
                </div>
            <main class="p-6">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>
