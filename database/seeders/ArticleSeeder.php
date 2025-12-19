<?php

namespace Database\Seeders;

use App\Models\User;      // ✅ INI YANG BENAR
use App\Models\Article;   // ✅
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        $user = User::first(); // ambil admin

        Article::create([
            'user_id' => $user->id,
            'title' => 'Laravel 11 Dirilis dengan Fitur Baru',
            'excerpt' => 'Framework Laravel merilis versi terbaru dengan berbagai peningkatan performa.',
            'content' => 'Laravel 11 telah dirilis dengan berbagai fitur baru...',
            'category' => 'teknologi',
            'author' => 'Admin',
            'is_published' => true,
            'published_at' => now(),
        ]);

        Article::create([
            'user_id' => $user->id,
            'title' => 'Tim Nasional Indonesia Lolos ke Piala Dunia',
            'excerpt' => 'Keberhasilan gemilang tim nasional sepak bola Indonesia.',
            'content' => 'Dalam pertandingan yang penuh dramatis...',
            'category' => 'warta',
            'author' => 'Admin',
            'is_published' => true,
            'published_at' => now(),
        ]);
    }
}
