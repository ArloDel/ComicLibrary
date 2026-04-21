<?php

namespace App\Jobs;

use App\Models\Comic;
use App\Models\Tag;
use App\Services\OpenAIService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class UpdateNarrativeReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(OpenAIService $openAIService): void
    {
        $ownedComics = Comic::where('status', '!=', 'wishlist')->withCount('volumes')->get();
        $totalOwned = $ownedComics->count();

        $totalInvestment = $ownedComics->reduce(
            fn ($carry, $comic) => $carry + ($comic->price * max(1, $comic->volumes_count)),
            0
        );

        $latest = Comic::orderBy('created_at', 'desc')->first();
        $topGenre = Tag::withCount('comics')->orderBy('comics_count', 'desc')->first();

        // Call remote API (might take time)
        $narrative = $openAIService->generateCollectionNarrative(
            $totalOwned,
            $totalInvestment,
            $topGenre?->name,
            $latest?->title
        );

        if (!str_contains($narrative, 'Gagal memutus sandi') && !str_contains($narrative, 'Terjadi gangguan')) {
            Cache::forever('dashboard_narrative', $narrative);
        } else {
            // Jika api error, kita set cache dengan masa aktif singkat
            Cache::put('dashboard_narrative', $narrative, now()->addMinutes(15));
        }
    }
}
