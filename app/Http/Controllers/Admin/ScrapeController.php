<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use HTMLPurifier;
use HTMLPurifier_Config;
use Illuminate\Support\Facades\Storage;

class ScrapeController extends Controller
{
    public function index()
    {
        return view('admin.scrape');
    }

    public function scrape(Request $request)
    {
        $request->validate([
            'url' => 'required|url'
        ]);

        $url = $request->url;

        try {
            // 🔹 Cek cache dulu
            if ($cached = cache()->get('scrape_' . md5($url))) {
                return redirect()->back()->with('success', 'Artikel berhasil diambil dari cache!');
            }

            // 🔹 Ambil HTML
            $client = new \GuzzleHttp\Client([
                'verify' => false, // ❌ bypass SSL
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)'
                ]
            ]);

            $response = $client->get($url);
            $html = $response->getBody()->getContents();

            $crawler = new Crawler($html);

            // 🔹 Judul
            $titleNode = $crawler->filter('h1')->first();
            $title = $titleNode->count() ? $titleNode->text() : 'Judul tidak ditemukan';

            // 🔹 Konten
            $contentNodes = $crawler->filter('.news-detail p');
            $contentArr = $contentNodes->count()
                ? $contentNodes->each(fn($node) => $node->html())
                : [];
            $content = implode("\n\n", $contentArr);

            // Ambil node gambar
            $imgNode = $crawler->filter('img[itemprop="image"]')->first();
            $imagePath = null;

            if ($imgNode->count()) {
                $imgUrl = $imgNode->attr('src'); // URL gambar

                // Ambil konten gambar
                $imgContent = @file_get_contents($imgUrl); // tanda @ untuk bypass warning

                // Simpan ke storage Laravel
                $imgName = 'articles/' . time() . '_' . basename($imgUrl);
                Storage::disk('public')->put($imgName, $imgContent); // simpan di storage/app/public/articles
                $imagePath = $imgName;
            }

            // 🔹 Bersihkan HTML
            $config = HTMLPurifier_Config::createDefault();
            $purifier = new HTMLPurifier($config);
            $cleanContent = $purifier->purify($content);

            // 🔹 Excerpt
            $excerpt = Str::limit(strip_tags($cleanContent), 200);

            // 🔹 User
            $user = auth()->user() ?? User::first();

            // 🔹 Simpan artikel
            Article::updateOrCreate(
                ['url' => $url],
                [
                    'title' => $title,
                    'content' => $cleanContent,
                    'user_id' => $user->id,
                    'category' => $request->category,
                    'author' => $user->name,
                    'slug' => Str::slug($title) . '-' . rand(1000, 9999),
                    'excerpt' => $excerpt,
                    'image' => $imagePath
                ]
            );

            // 🔹 Simpan ke cache 10 menit supaya tidak scrape berulang
            cache()->put('scrape_' . md5($url), true, now()->addMinutes(10));

            return redirect()->back()->with('success', 'Artikel berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal scrape artikel: ' . $e->getMessage());
        }
    }
}
