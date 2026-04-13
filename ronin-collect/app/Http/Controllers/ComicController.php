<?php

namespace App\Http\Controllers;

use App\Models\Comic;
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

    public function index()
    {
        $comics = Comic::withCount('volumes')->orderBy('title')->get();
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
            'price' => 'nullable|numeric'
        ]);

        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move(public_path('uploads/covers'), $filename);
            $validated['cover_image'] = 'uploads/covers/' . $filename;
        }

        Comic::create($validated);
        return redirect()->route('comics.index')->with('success', 'Comic added successfully!');
    }

    public function show(Comic $comic)
    {
        $comic->load('volumes');
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
