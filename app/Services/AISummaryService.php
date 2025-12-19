
<?php

namespace App\Services;

use App\Models\Article;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AISummaryService
{
    private Client $client;
    private array $config;

    public function __construct()
    {
        $this->config = [
            'api_key' => config('services.openai.api_key'),
            'model' => config('services.openai.model', 'gpt-3.5-turbo'),
            'max_tokens' => config('services.openai.max_tokens', 600),
            'temperature' => config('services.openai.temperature', 0.5),
            'timeout' => config('services.openai.timeout', 30),
        ];

        $this->client = new Client([
            'timeout' => $this->config['timeout'],
            'verify' => config('app.env') === 'production',
        ]);
    }

    public function generate(Article $article): array
    {
        $cacheKey = "article_summary_{$article->id}";

        return Cache::remember($cacheKey, 3600, function () use ($article) {
            return $this->generateFreshSummary($article);
        });
    }

    private function generateFreshSummary(Article $article): array
    {
        // Cek jika sudah ada summary yang fresh
        if ($article->ai_summary && $article->summary_generated_at > now()->subDays(7)) {
            return [
                'summary' => $article->ai_summary,
                'cached' => true,
                'model' => $article->summary_model_used,
            ];
        }

        try {
            // Coba OpenAI terlebih dahulu
            $result = $this->callOpenAI($article);

            $article->update([
                'ai_summary' => $result['summary'],
                'summary_generated_at' => now(),
                'summary_model_used' => $this->config['model'],
                'summary_tokens_used' => $result['tokens_used'] ?? null,
            ]);

            return $result;

        } catch (\Exception $e) {
            Log::error('OpenAI API failed, trying fallback', [
                'article_id' => $article->id,
                'error' => $e->getMessage(),
            ]);

            // Fallback 1: Alternatif API lain
            try {
                $result = $this->callAlternativeAI($article);
                return $result;
            } catch (\Exception $e) {
                Log::warning('Alternative AI also failed, using extractive summary', [
                    'article_id' => $article->id,
                ]);

                // Fallback 2: Extractive summary
                $summary = $this->generateExtractiveSummary($article);

                $article->update([
                    'ai_summary' => $summary,
                    'summary_generated_at' => now(),
                    'summary_model_used' => 'extractive',
                ]);

                return [
                    'summary' => $summary,
                    'model' => 'extractive',
                    'cached' => false,
                ];
            }
        }
    }

    private function callOpenAI(Article $article): array
    {
        if (empty($this->config['api_key'])) {
            throw new \Exception('OpenAI API key not configured');
        }

        $prompt = $this->buildPrompt($article);

        $response = $this->client->post('https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->config['api_key'],
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => $this->config['model'],
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $this->getSystemPrompt(),
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt,
                    ],
                ],
                'max_tokens' => $this->config['max_tokens'],
                'temperature' => $this->config['temperature'],
                'top_p' => 0.9,
                'frequency_penalty' => 0.3,
                'presence_penalty' => 0.3,
            ],
        ]);

        $data = json_decode($response->getBody(), true);

        if (!isset($data['choices'][0]['message']['content'])) {
            throw new \Exception('Invalid response from OpenAI API');
        }

        return [
            'summary' => trim($data['choices'][0]['message']['content']),
            'model' => $this->config['model'],
            'tokens_used' => $data['usage']['total_tokens'] ?? null,
            'cached' => false,
        ];
    }

    private function buildPrompt(Article $article): string
    {
        $content = $this->prepareContent($article->truncated_content);

        return <<<PROMPT
        Buat ringkasan artikel berita dalam bahasa Indonesia yang:
        1. Maksimal 5 kalimat (100-150 kata)
        2. Fokus pada fakta utama (5W+1H)
        3. Sertakan data/angka penting jika ada
        4. Gunakan bahasa formal tapi mudah dipahami
        5. Akhiri dengan implikasi/kesimpulan penting

        JUDUL: {$article->title}
        KATEGORI: {$article->category}
        TANGGAL: {$article->published_at?->format('d F Y') ?? $article->created_at->format('d F Y')}
        PENULIS: {$article->author}

        ISI ARTIKEL:
        {$content}

        RINGKASAN:
        PROMPT;
    }

    private function getSystemPrompt(): string
    {
        return "Anda adalah jurnalis senior di media berita TANEAN.ID. Buat ringkasan artikel dengan karakteristik:
        1. Objektif dan faktual
        2. Mengutamakan informasi penting
        3. Tidak menambahkan opini pribadi
        4. Menggunakan bahasa Indonesia yang baik dan benar
        5. Menghindari repetisi dan frasa klise";
    }

    private function prepareContent(string $content): string
    {
        // Bersihkan HTML tags
        $content = strip_tags($content);

        // Remove multiple spaces and newlines
        $content = preg_replace('/\s+/', ' ', $content);

        // Potong jika terlalu panjang
        if (strlen($content) > 8000) {
            $content = $this->extractKeySentences($content);
        }

        return trim($content);
    }

    private function extractKeySentences(string $content): string
    {
        $sentences = preg_split('/(?<=[.!?])\s+/', $content);

        if (count($sentences) <= 10) {
            return $content;
        }

        // Ambil: 30% awal, 30% akhir, 2 dari tengah
        $total = count($sentences);
        $firstCount = max(3, (int)($total * 0.3));
        $lastCount = max(3, (int)($total * 0.3));
        $middleIndex = (int)($total / 2);

        $selected = array_merge(
            array_slice($sentences, 0, $firstCount),
            array_slice($sentences, $middleIndex - 1, 2),
            array_slice($sentences, -$lastCount)
        );

        return implode(' ', $selected);
    }

    private function generateExtractiveSummary(Article $article): string
    {
        $content = strip_tags($article->content);
        $sentences = preg_split('/(?<=[.!?])\s+/', $content);

        if (count($sentences) <= 3) {
            return $content;
        }

        // Algoritma sederhana: ambil kalimat pertama, tengah, dan akhir
        $first = array_slice($sentences, 0, 2);
        $middleIndex = (int)(count($sentences) / 2);
        $middle = array_slice($sentences, $middleIndex, 1);
        $last = array_slice($sentences, -2);

        $selected = array_merge($first, $middle, $last);

        return implode(' ', $selected);
    }

    private function callAlternativeAI(Article $article): array
    {
        // Implementasi alternatif lain (Anthropic, Cohere, dll)
        // Untuk saat ini kita throw exception
        throw new \Exception('Alternative AI not configured');
    }
}
