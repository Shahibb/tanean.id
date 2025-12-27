@extends('layouts.app')

@section('title', 'Kategori ' . ucfirst($category) . ' - TANEAN.ID')

@section('content')
    <!-- Category Header -->

    <!-- Articles with Different Layouts Based on Category -->
    <section class="container mx-auto space-y-6 py-6">
        @if ($category == 'warta')
            @include('articles.category.warta')
        @elseif($category == 'warita')
            @include('articles.category.warita')
        @elseif($category == 'swara')
            @include('articles.category.swara')
        @elseif($category == 'lensa')
            @include('articles.category.lensa')
        @elseif($category == 'video')
            @include('articles.category.video')
        @else
            <div class="text-center py-16">
                <div class="text-gray-400 mb-4">
                    <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
                <p class="text-xl text-gray-600 font-medium">Kategori tidak ditemukan.</p>
                <a href="{{ route('home') }}"
                    class="inline-block mt-6 px-6 py-3 bg-tanean-dark text-white rounded hover:bg-gray-800 transition">
                    Kembali ke Beranda
                </a>
            </div>
        @endif
    </section>
@endsection
