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
        return view('home', compact('latestAcquisitions', 'currentlyReading', 'wishlist'));
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
                $response = Http::get($url);
                if ($response->successful()) {
                    $filename = time() . '_api_cover.jpg';
                    $dir = public_path('uploads/covers');
                    if (!file_exists($dir)) {
                        mkdir($dir, 0755, true);
                    }
                    file_put_contents($dir . '/' . $filename, $response->body());
                    $validated['cover_image'] = 'uploads/covers/' . $filename;
                }
            } catch (\Exception $e) {
                // Silently fail and leave cover_image null
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
