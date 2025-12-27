<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index()
    {
        $mainVideo = Video::where('featured', true)->first();
        $otherVideos = Video::where('featured', false)->take(3)->get();
        
        return view('articles.category', [
            'category' => 'video',
            'mainVideo' => $mainVideo,
            'otherVideos' => $otherVideos,
            'articles' => collect(),
            'topArticles' => collect(),
            'allArticles' => collect(),
            'swaraArticles' => collect(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'author' => 'required|string|max:255',
            'thumbnail_url' => 'required|url',
            'video_url' => 'required|url',
            'featured' => 'boolean',
        ]);

        Video::create($request->all());

        return redirect()->back()->with('success', 'Video berhasil ditambahkan');
    }

    public function destroy($id)
    {
        Video::destroy($id);
        return redirect()->back()->with('success', 'Video berhasil dihapus');
    }
}