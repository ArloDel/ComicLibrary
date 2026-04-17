<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenAIService
{
    /**
     * Generate narrative report based on collection stats.
     */
    public function generateCollectionNarrative(
        int $totalOwned, 
        float $totalInvestment, 
        ?string $topGenre, 
        ?string $latestTitle
    ): string {
        $apiKey = env('GROQ_API_KEY');

        if (empty($apiKey)) {
            return "Koneksi ke Archival Node terputus. Token Groq tidak terdeteksi di matriks sistem.";
        }

        $formattedInvestment = 'Rp' . number_format($totalInvestment, 0, ',', '.');
        $topGenreStr = $topGenre ? "fokus utama arc pada genre {$topGenre}" : "diverse genre";
        $latestTitleStr = $latestTitle ? "Artefak terakhir yang diakuisisi adalah '{$latestTitle}'" : "Belum ada artefak batu rekam yang diakuisisi baru-baru ini";

        $prompt = "Kamu adalah sistem A.I. kurator tingkat tinggi (disebut Sang Kurator) dengan gaya bicara puitis, tajam, dan memiliki elemen cyberpunk / samurai (Ronin collect). "
            . "Buatlah laporan atau ringkasan 3-4 kalimat tentang status koleksi hari ini. "
            . "Gunakan penulisan bahasa Indonesia yang disiplin, elit, dan sedikit misterius. "
            . "Data saat ini: "
            . "- Total artefak/volume di brankas: {$totalOwned} "
            . "- Total investasi (estimasi harga aset): {$formattedInvestment} "
            . "- {$topGenreStr} "
            . "- {$latestTitleStr}. "
            . "Tulis narasinya saja tanpa sapaan pembuka/penutup. Jangan gunakan format markdown. Gunakan kata seperti 'silikon', 'arsip', 'katana', 'guratan', atau 'kolektor' jika dirasa cocok.";

        try {
            $response = Http::withToken($apiKey)
                ->timeout(15) // timeout so page doesn't hang indefinitely
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => 'llama-3.3-70b-versatile', // Groq's fast high-tier model
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => $prompt
                        ]
                    ],
                    'max_tokens' => 250,
                    'temperature' => 0.7,
                ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['choices'][0]['message']['content'] ?? "Gagal memutus sandi dari Archival Node (Response Empty).";
            }

            Log::error('Groq API Error: ' . $response->body());
            return "Terjadi gangguan transmisi dengan Archival Node. Gagal memproses naratif.";
            
        } catch (\Exception $e) {
            Log::error('Groq Service Exception: ' . $e->getMessage());
            return "Akses ke Archival Node terganggu: " . $e->getMessage();
        }
    }
}
