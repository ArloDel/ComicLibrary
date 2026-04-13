<?php

namespace App\Http\Controllers;

use App\Models\Comic;
use App\Models\Tag;
use Illuminate\Http\Request;

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
        }
        
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
        // For later
    }

    public function update(Request $request, Comic $comic)
    {
        // For later
    }

    public function destroy(Comic $comic)
    {
        $comic->delete();
        return redirect()->route('comics.index');
    }
}
