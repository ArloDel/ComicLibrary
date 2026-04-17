<?php

namespace App\Http\Controllers;

use App\Http\Concerns\HandlesCoverImage;
use App\Models\Comic;
use App\Models\Tag;
use App\Services\TagSyncService;
use Illuminate\Http\Request;

class ComicController extends Controller
{
    use HandlesCoverImage;

    public function __construct(private readonly TagSyncService $tagSync) {}

    // -------------------------------------------------------------------------
    // Dashboard
    // -------------------------------------------------------------------------

    public function dashboard()
    {
        $latestAcquisitions = Comic::orderBy('created_at', 'desc')->take(3)->get();
        $currentlyReading   = Comic::where('status', 'reading')->first();
        $wishlist           = Comic::where('status', 'wishlist')->orderBy('priority', 'desc')->get();
        $topGenres          = Tag::withCount('comics')->orderBy('comics_count', 'desc')->take(3)->get();

        [$totalOwned, $totalInvestment, $completionRate] = $this->computeStats();

        return view('home', compact(
            'latestAcquisitions',
            'currentlyReading',
            'wishlist',
            'totalOwned',
            'totalInvestment',
            'completionRate',
            'topGenres',
        ));
    }

    public function narrativeReport(\App\Services\OpenAIService $openAIService)
    {
        // Get high level stats
        $latest = Comic::orderBy('created_at', 'desc')->first();
        $topGenre = Tag::withCount('comics')->orderBy('comics_count', 'desc')->first();
        
        [$totalOwned, $totalInvestment] = $this->computeStats();

        // Use the service to generate text
        $narrative = $openAIService->generateCollectionNarrative(
            $totalOwned,
            $totalInvestment,
            $topGenre?->name,
            $latest?->title
        );

        return response()->json(['narrative' => $narrative]);
    }

    // -------------------------------------------------------------------------
    // Resource CRUD
    // -------------------------------------------------------------------------

    public function index(Request $request)
    {
        $query = Comic::withCount('volumes')->with('tags');

        if ($request->has('tag')) {
            $query->whereHas('tags', fn ($q) => $q->where('name', $request->tag));
        }

        $comics = $query->orderBy('title')->get();

        return view('comics.index', compact('comics'));
    }

    public function create()
    {
        return view('comics.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->comicValidationRules(isStore: true));

        $validated['cover_image'] = $this->resolveCoverImage($request, $validated);

        unset($validated['cover_image_url'], $validated['tags_input']);

        $comic = Comic::create($validated);

        $this->tagSync->sync($comic, $request->input('tags_input'));

        return redirect()->route('comics.index')->with('success', 'Comic added successfully!');
    }

    public function show(Comic $comic)
    {
        $comic->load('volumes', 'tags');

        return view('comics.show', compact('comic'));
    }

    public function edit(Comic $comic)
    {
        $comic->load('tags');
        $tagsString = $comic->tags->pluck('name')->implode(', ');

        return view('comics.edit', compact('comic', 'tagsString'));
    }

    public function update(Request $request, Comic $comic)
    {
        $validated = $request->validate($this->comicValidationRules(isStore: false));

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $this->uploadCoverFile($request, 'comic');
        }

        $tagsInput = $validated['tags_input'] ?? null;
        unset($validated['tags_input']);

        $comic->update($validated);

        $this->tagSync->sync($comic, $tagsInput);

        return redirect()->route('comics.show', $comic)->with('success', 'Comic updated successfully!');
    }

    public function destroy(Comic $comic)
    {
        $comic->delete();

        return redirect()->route('comics.index');
    }

    // -------------------------------------------------------------------------
    // Private Helpers
    // -------------------------------------------------------------------------

    /**
     * Aturan validasi bersama untuk store dan update.
     *
     * @param  bool  $isStore  Jika true, sertakan aturan `cover_image_url` (hanya untuk store).
     * @return array<string, string>
     */
    private function comicValidationRules(bool $isStore): array
    {
        $rules = [
            'title'       => 'required|string|max:255',
            'author'      => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048',
            'status'      => 'required|in:reading,completed,wishlist,plan_to_read',
            'priority'    => 'nullable|in:low,medium,high,extreme',
            'price'       => 'nullable|numeric',
            'tags_input'  => 'nullable|string',
        ];

        if ($isStore) {
            $rules['cover_image_url'] = 'nullable|url';
        }

        return $rules;
    }

    /**
     * Tentukan nilai `cover_image` akhir untuk comic baru:
     * upload file lokal diprioritaskan, download URL kedua, null jika tidak ada keduanya.
     */
    private function resolveCoverImage(Request $request, array $validated): ?string
    {
        if ($request->hasFile('cover_image')) {
            return $this->uploadCoverFile($request, 'comic');
        }

        if ($request->filled('cover_image_url')) {
            return $this->downloadCoverFromUrl($request->input('cover_image_url'));
        }

        return $validated['cover_image'] ?? null;
    }

    /**
     * Hitung statistik kepemilikan untuk dashboard.
     *
     * Menghindari dua query terpisah dengan memanfaatkan satu koleksi
     * yang sudah di-load untuk totalOwned, totalInvestment, dan completionRate.
     *
     * @return array{int, float, int}  [totalOwned, totalInvestment, completionRate]
     */
    private function computeStats(): array
    {
        $ownedComics     = Comic::where('status', '!=', 'wishlist')->withCount('volumes')->get();
        $totalOwned      = $ownedComics->count();

        $totalInvestment = $ownedComics->reduce(
            fn ($carry, $comic) => $carry + ($comic->price * max(1, $comic->volumes_count)),
            0
        );

        $completedCount  = $ownedComics->where('status', 'completed')->count();
        $completionRate  = $totalOwned > 0 ? round(($completedCount / $totalOwned) * 100) : 0;

        return [$totalOwned, $totalInvestment, $completionRate];
    }
}
