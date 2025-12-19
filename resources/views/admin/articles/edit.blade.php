@extends('layouts.admin')

@section('title', 'Edit Artikel')
@section('header', 'Edit Artikel')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-4xl">
    <form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Judul</label>
            <input type="text" name="title" class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:border-blue-500" value="{{ old('title', $article->title) }}" required>
            @error('title')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Kategori</label>
            <select name="category" class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:border-blue-500" required>
                <option value="">Pilih Kategori</option>
                <option value="warta" {{ old('category', $article->category) == 'warta' ? 'selected' : '' }}>Warta</option>
                <option value="warita" {{ old('category', $article->category) == 'warita' ? 'selected' : '' }}>Warita</option>
                <option value="swara" {{ old('category', $article->category) == 'swara' ? 'selected' : '' }}>Swara</option>
                <option value="lensa" {{ old('category', $article->category) == 'lensa' ? 'selected' : '' }}>Lensa</option>
            </select>
            @error('category')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Ringkasan</label>
            <textarea name="excerpt" rows="3" class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:border-blue-500" required>{{ old('excerpt', $article->excerpt) }}</textarea>
            @error('excerpt')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Konten</label>
            <textarea name="content" rows="10" class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:border-blue-500" required>{{ old('content', $article->content) }}</textarea>
            @error('content')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Gambar</label>
            @if($article->image)
            <div class="mb-2">
                <img src="{{ asset('storage/' . $article->image) }}" alt="Current image" class="w-32 h-32 object-cover rounded">
            </div>
            @endif
            <input type="file" name="image" class="w-full border border-gray-300 rounded px-4 py-2" accept="image/*">
            @error('image')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex space-x-2">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Update
            </button>
            <a href="{{ route('admin.articles.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
