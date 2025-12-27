@extends('layouts.admin')

@section('title', 'Edit Video')
@section('header', 'Edit Video')

@section('content')
<div class="max-w-2xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Edit Video</h1>
    
    <form action="{{ route('admin.videos.update', $video) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700">Judul</label>
            <input type="text" name="title" id="title" value="{{ old('title', $video->title) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
        </div>
        
        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea name="description" id="description" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>{{ old('description', $video->description) }}</textarea>
        </div>
        
        <div class="mb-4">
            <label for="author" class="block text-sm font-medium text-gray-700">Penulis</label>
            <input type="text" name="author" id="author" value="{{ old('author', $video->author) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
        </div>
        
        <div class="mb-4">
            <label for="thumbnail_url" class="block text-sm font-medium text-gray-700">URL Thumbnail</label>
            <input type="url" name="thumbnail_url" id="thumbnail_url" value="{{ old('thumbnail_url', $video->thumbnail_url) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
        </div>
        
        <div class="mb-4">
            <label for="video_url" class="block text-sm font-medium text-gray-700">URL Video</label>
            <input type="url" name="video_url" id="video_url" value="{{ old('video_url', $video->video_url) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
        </div>
        
        <div class="mb-6">
            <label for="featured" class="inline-flex items-center">
                <input type="checkbox" name="featured" id="featured" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" @if(old('featured', $video->featured)) checked @endif>
                <span class="ml-2 text-sm text-gray-700">Tampilkan sebagai video utama</span>
            </label>
        </div>
        
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Update Video
        </button>
    </form>
</div>
@endsection
