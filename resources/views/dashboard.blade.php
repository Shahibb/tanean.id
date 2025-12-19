<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @auth
                        <p class="mb-2">Selamat datang, {{ Auth::user()->name }}!</p>
                        @if(method_exists(Auth::user(), 'isAdmin') && Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="text-sm text-blue-600 hover:underline">Buka Admin Dashboard</a>
                        @else
                            <p class="text-sm text-gray-600">Anda sudah login. Kunjungi <a href="{{ route('home') }}" class="text-blue-600 hover:underline">halaman utama</a> untuk melihat artikel.</p>
                        @endif
                    @else
                        <p>{{ __("You're logged in!") }}</p>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
