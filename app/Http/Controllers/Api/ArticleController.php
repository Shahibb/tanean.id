<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Exception;

class ArticleController extends Controller
{
    public function summarize(Request $request, $id)
    {
        try {
            $article = Article::findOrFail($id);

            \Log::info('Summarize API called', [
                'article_id' => $id,
                'force_refresh' => $request->input('force_refresh'),
                'has_summary' => !empty($article->ai_summary)
            ]);

            if (!$article->is_published) {
                return response()->json([
                    'success' => false,
                    'message' => 'Artikel belum dipublikasikan'
                ], 400);
            }

            // Cek force refresh
            $forceRefresh = $request->input('force_refresh') == '1' ||
                $request->input('force_refresh') === true;

            // Jika tidak force refresh dan sudah ada summary, return cached
            if (!$forceRefresh && !empty($article->ai_summary)) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'summary' => $article->ai_summary,
                        'cached' => true,
                        'generated_at' => $article->summary_generated_at?->toDateTimeString(),
                        'article' => [
                            'id' => $article->id,
                            'title' => $article->title,
                        ]
                    ]
                ]);
            }

            // Generate new summary
            $summary = $this->generateAISummary($article);

            $article->update([
                'ai_summary' => $summary,
                'summary_generated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'data' => [
                    'summary' => $summary,
                    'cached' => false,
                    'generated_at' => now()->toDateTimeString(),
                    'article' => [
                        'id' => $article->id,
                        'title' => $article->title,
                        'category' => $article->category,
                    ]
                ]
            ]);
        } catch (Exception $e) {
            \Log::error('AI Summary Generation Failed', [
                'article_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat ringkasan. Silakan coba lagi nanti.',
                'debug' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    private function generateAISummary(Article $article)
    {
        // Logging untuk debugging
        \Log::info('Summarize request for article ID: ' . $article->id);
        \Log::info('API Key exists: ' . (env('OPENAI_API_KEY') ? 'Yes' : 'No'));
        $apiKey = env('OPENAI_API_KEY');

        // Jika tidak ada API key, gunakan ringkasan statis sebagai fallback
        if (empty($apiKey)) {
            return $this->generateStaticSummary($article);
        }

        $client = new Client([
            'timeout' => 30,
            'verify' => false // Hanya untuk development, hapus di production
        ]);

        // Siapkan prompt untuk AI dengan instruksi yang lebih spesifik
        $prompt = "Buat ringkasan dalam bahasa Indonesia yang jelas dan ringkas dari artikel berikut. Ringkasan harus berupa 3-4 paragraf pendek dengan informasi spesifik:\n\n"
            . "Judul: {$article->title}\n"
            . "Kategori: {$article->category}\n"
            . "Penulis: {$article->author}\n\n"
            . "Konten:\n" . strip_tags($article->content) . "\n\n"
            . "Instruksi untuk membuat ringkasan:\n"
            . "1. Buat ringkasan dengan 3-4 paragraf pendek\n"
            . "2. Sertakan nama orang-orang penting yang disebutkan dalam artikel\n"
            . "3. Sebutkan lokasi geografis yang relevan\n"
            . "4. Jelaskan peristiwa utama yang terjadi\n"
            . "5. Sebutkan tanggal-tanggal penting yang disebutkan\n"
            . "6. Jangan gunakan frasa umum seperti 'penulis memberikan analisis komprehensif'\n"
            . "7. Fokus pada fakta-fakta spesifik dari artikel ini";

        try {
            $response = $client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'Anda adalah jurnalis profesional yang ahli dalam membuat ringkasan artikel berita dalam bahasa Indonesia. Anda selalu membuat ringkasan yang spesifik, informatif, dan berdasarkan fakta nyata dari artikel yang diberikan. Hindari frasa-frasa umum dan fokus pada informasi spesifik dari artikel.'
                        ],
                        [
                            'role' => 'user',
                            'content' => $prompt
                        ]
                    ],
                    'max_tokens' => 500,
                    'temperature' => 0.5
                ]
            ]);

            $result = json_decode($response->getBody(), true);

            if (isset($result['choices'][0]['message']['content'])) {
                // Bersihkan dan format ringkasan
                $summary = trim($result['choices'][0]['message']['content']);
                return !empty($summary) ? $summary : $this->generateStaticSummary($article);
            } else {
                throw new Exception('Invalid response structure from AI service');
            }
        } catch (Exception $e) {
            // Jika API gagal, gunakan ringkasan statis sebagai fallback
            \Log::error('OpenAI API Error: ' . $e->getMessage());
            return $this->generateStaticSummary($article);
        }
    }

    private function generateStaticSummary(Article $article)
    {
        // Ringkasan statis sebagai fallback ketika AI tidak tersedia
        // Gunakan informasi spesifik dari artikel daripada template umum
        $content = strip_tags($article->content);

        // Ambil kalimat-kalimat pertama sebagai dasar ringkasan
        $sentences = preg_split('/(?<=[.!?])\s+/', $content, -1, PREG_SPLIT_NO_EMPTY);
        $summarySentences = array_slice($sentences, 0, 4);
        $summaryText = implode(' ', $summarySentences);

        // Jika terlalu pendek, tambahkan informasi lain
        if (strlen($summaryText) < 100) {
            $summaryText .= " Artikel ini membahas tentang {$article->category} di {$article->title}, yang ditulis oleh {$article->author}.";
        }

        return $summaryText;
    }
}
