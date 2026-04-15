<?php

namespace App\Http\Controllers;

use App\Models\Comic;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ComicController extends Controller
{
    public function dashboard()
    {
        $latestAcquisitions = Comic::orderBy('created_at', 'desc')->take(3)->get();
        $currentlyReading = Comic::where('status', 'reading')->first();
        $wishlist = Comic::where('status', 'wishlist')->orderBy('priority', 'desc')->get();
        
        // Statistics Computation
        $ownedComicsQuery = Comic::where('status', '!=', 'wishlist');
        $totalOwned = $ownedComicsQuery->count();
        
        $ownedComics = $ownedComicsQuery->withCount('volumes')->get();
        $totalInvestment = $ownedComics->reduce(function ($carry, $comic) {
            $volCount = max(1, $comic->volumes_count);
            return $carry + ($comic->price * $volCount);
        }, 0);
        
        $completedCount = Comic::where('status', 'completed')->count();
        $completionRate = $totalOwned > 0 ? round(($completedCount / $totalOwned) * 100) : 0;
        
        $topGenres = Tag::withCount('comics')->orderBy('comics_count', 'desc')->take(3)->get();

        return view('home', compact(
            'latestAcquisitions', 
            'currentlyReading', 
            'wishlist', 
            'totalOwned', 
            'totalInvestment', 
            'completionRate', 
            'topGenres'
        ));
    }

    public function index(Request $request)
    {
        $query = Comic::withCount('volumes')->with('tags');

        if ($request->has('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('name', $request->tag);
            });
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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048',
            'cover_image_url' => 'nullable|url',
            'status' => 'required|in:reading,completed,wishlist,plan_to_read',
            'priority' => 'nullable|in:low,medium,high,extreme',
            'price' => 'nullable|numeric',
            'tags_input' => 'nullable|string'
        ]);

        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move(public_path('uploads/covers'), $filename);
            $validated['cover_image'] = 'uploads/covers/' . $filename;
        } elseif ($request->filled('cover_image_url')) {
            try {
                $url = $request->input('cover_image_url');
                // Add browser-like headers so CDNs (MangaDex, AniList, Google Books) don't block us
                $response = Http::withHeaders([
                    'User-Agent'  => 'Mozilla/5.0 (compatible; RoninCollect/1.0)',
                    'Accept'      => 'image/webp,image/apng,image/*,*/*;q=0.8',
                    'Referer'     => parse_url($url, PHP_URL_SCHEME) . '://' . parse_url($url, PHP_URL_HOST) . '/',
                ])->timeout(15)->get($url);

                if ($response->successful()) {
                    // Detect extension from Content-Type header
                    $contentType = $response->header('Content-Type');
                    $ext = match(true) {
                        str_contains($contentType, 'png')  => 'png',
                        str_contains($contentType, 'webp') => 'webp',
                        str_contains($contentType, 'gif')  => 'gif',
                        default                            => 'jpg',
                    };
                    $filename = time() . '_api_cover.' . $ext;
                    $dir = public_path('uploads/covers');
                    if (!file_exists($dir)) {
                        mkdir($dir, 0755, true);
                    }
                    file_put_contents($dir . '/' . $filename, $response->body());
                    $validated['cover_image'] = 'uploads/covers/' . $filename;
                } else {
                    // Fallback: store the remote URL directly so the image still shows
                    $validated['cover_image'] = $url;
                }
            } catch (\Exception $e) {
                // Last resort: store URL directly
                $validated['cover_image'] = $request->input('cover_image_url');
            }
        }
        unset($validated['cover_image_url']);
        
        $tagsInput = $validated['tags_input'] ?? null;
        unset($validated['tags_input']);

        $comic = Comic::create($validated);

        if ($tagsInput) {
            $tagNames = array_filter(array_map('trim', explode(',', $tagsInput)));
            $tagIds = [];
            foreach ($tagNames as $tagName) {
                if (!empty($tagName)) {
                    $tagItem = Tag::firstOrCreate(['name' => strtoupper($tagName)]);
                    $tagIds[] = $tagItem->id;
                }
            }
            $comic->tags()->sync($tagIds);
        }

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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048',
            'status' => 'required|in:reading,completed,wishlist,plan_to_read',
            'priority' => 'nullable|in:low,medium,high,extreme',
            'price' => 'nullable|numeric',
            'tags_input' => 'nullable|string'
        ]);

        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $filename = time() . '_comic_' . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move(public_path('uploads/covers'), $filename);
            $validated['cover_image'] = 'uploads/covers/' . $filename;
        }

        $tagsInput = $validated['tags_input'] ?? null;
        unset($validated['tags_input']);

        $comic->update($validated);

        if ($tagsInput !== null) {
            $tagNames = array_filter(array_map('trim', explode(',', $tagsInput)));
            $tagIds = [];
            foreach ($tagNames as $tagName) {
                if (!empty($tagName)) {
                    $tagItem = Tag::firstOrCreate(['name' => strtoupper($tagName)]);
                    $tagIds[] = $tagItem->id;
                }
            }
            $comic->tags()->sync($tagIds);
        }

        return redirect()->route('comics.show', $comic)->with('success', 'Comic updated successfully!');
    }

    public function destroy(Comic $comic)
    {
        $comic->delete();
        return redirect()->route('comics.index');
    }
}
