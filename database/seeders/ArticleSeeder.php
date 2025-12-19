<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        Article::create([
            'title' => 'Laravel 11 Dirilis dengan Fitur Baru',
            'excerpt' => 'Framework Laravel merilis versi terbaru dengan berbagai peningkatan performa.',
            'content' => 'Laravel 11 telah dirilis dengan berbagai fitur baru yang memudahkan developer dalam membangun aplikasi web. Beberapa fitur utama termasuk peningkatan performa, struktur yang lebih sederhana, dan integrasi yang lebih baik dengan ekosistem PHP modern.',
            'category' => 'teknologi',
            'author' => 'Admin',
            'is_published' => true,
            'published_at' => now(),
        ]);

        Article::create([
            'title' => 'Tim Nasional Indonesia Lolos ke Piala Dunia',
            'excerpt' => 'Keberhasilan gemilang tim nasional sepak bola Indonesia.',
            'content' => 'Dalam pertandingan yang penuh dramatis, Tim Nasional Indonesia berhasil mengalahkan lawannya dengan skor 2-1 dan lolos ke Piala Dunia untuk pertama kalinya dalam sejarah.',
            'category' => 'warta',
            'author' => 'Admin',
            'is_published' => true,
            'published_at' => now(),
        ]);
    }
}
