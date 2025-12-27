<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::latest()->paginate(10);
        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        return view('admin.videos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'author' => 'required|string|max:255',
            'thumbnail_url' => 'required|url',
            'video_url' => 'required|url',
            'featured' => 'nullable|boolean',
        ]);

        $data = $request->all();
        if ($data['featured']) {
            Video::where('featured', true)->update(['featured' => false]);
        }
        Video::create($data);

        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil ditambahkan');
    }

    public function edit(Video $video)
    {
        return view('admin.videos.edit', compact('video'));
    }

    public function update(Request $request, Video $video)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'author' => 'required|string|max:255',
            'thumbnail_url' => 'required|url',
            'video_url' => 'required|url',
            'featured' => 'boolean',
        ]);

        $data = $request->all();
        $data['featured'] = $request->has('featured');

        $video->update($data);

        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil diupdate.');
    }

    public function destroy(Video $video)
    {
        $video->delete();
        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil dihapus');
    }
}
