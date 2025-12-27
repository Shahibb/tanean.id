@extends('layouts.admin')

@section('title', 'Scrape Artikel')
@section('header', 'Scrape Artikel dari Website')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-4xl">

    {{-- Alert --}}
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.scrape.post') }}" method="POST">
        @csrf

        {{-- URL --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">URL Artikel</label>
            <input
                type="url"
                name="url"
                class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:border-blue-500"
                placeholder="https://alfikr.id/read/..."
                value="{{ old('url') }}"
                required
            >
            @error('url')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Kategori --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Kategori</label>
            <select
                name="category"
                class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:border-blue-500"
                required
            >
                <option value="">Pilih Kategori</option>
                <option value="warta" {{ old('category') == 'warta' ? 'selected' : '' }}>Warta</option>
                <option value="swara" {{ old('category') == 'swara' ? 'selected' : '' }}>Swara</option>
                <option value="warita" {{ old('category') == 'warita' ? 'selected' : '' }}>Warita</option>
                <option value="lensa" {{ old('category') == 'lensa' ? 'selected' : '' }}>Lensa</option>
            </select>
            @error('category')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Info --}}
        <div class="mb-6 p-4 bg-blue-50 text-blue-700 rounded text-sm">
            Sistem akan otomatis mengambil <strong>judul</strong>, <strong>konten</strong>,
            <strong>gambar utama</strong>, dan membuat <strong>ringkasan</strong>.
        </div>

        {{-- Action --}}
        <div class="flex space-x-2">
            <button
                type="submit"
                class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition"
            >
                Scrape & Simpan
            </button>

            <a
                href="{{ route('admin.articles.index') }}"
                class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400 transition"
            >
                Batal
            </a>
        </div>

    </form>
</div>
@endsection
