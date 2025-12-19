@extends('layouts.admin')

@section('title', 'Kelola Artikel')
@section('header', 'Kelola Artikel')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.articles.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Tambah Artikel Baru
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Penulis</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($articles as $article)
            <tr>
                <td class="px-6 py-4">{{ Str::limit($article->title, 50) }}</td>
                <td class="px-6 py-4">{{ $article->user->name }}</td>
                <td class="px-6 py-4">{{ ucfirst($article->category) }}</td>
                <td class="px-6 py-4">
                    @if($article->is_published)
                    <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded">Published</span>
                    @else
                    <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded">Pending</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.articles.edit', $article) }}" class="text-blue-600 hover:text-blue-900">Edit</a>

                        @if(!$article->is_published && (auth()->user()->isEditor() || auth()->user()->isAdmin()))
                        <form action="{{ route('admin.articles.approve', $article) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-green-600 hover:text-green-900">Setujui</button>
                        </form>
                        @endif

                        <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada artikel</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>



<div class="mt-4">
    {{ $articles->links() }}
</div>
@endsection
