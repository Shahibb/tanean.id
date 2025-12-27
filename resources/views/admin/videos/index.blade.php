@extends('layouts.admin')

@section('title', 'Kelola Video')
@section('header', 'Kelola Video')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.videos.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Tambah Video Baru
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Author</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Featured</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($videos as $video)
            <tr>
                <td class="px-6 py-4">{{ Str::limit($video->title, 50) }}</td>
                <td class="px-6 py-4">{{ $video->author }}</td>
                <td class="px-6 py-4">
                    @if($video->featured)
                    <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded">Yes</span>
                    @else
                    <span class="px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded">No</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.videos.edit', $video) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                        <form action="{{ route('admin.videos.destroy', $video) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-6 py-4 text-center text-gray-500">Tidak ada video</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $videos->links() }}
</div>
@endsection
