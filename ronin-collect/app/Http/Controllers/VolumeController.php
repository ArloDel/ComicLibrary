<?php

namespace App\Http\Controllers;

use App\Models\Volume;
use Illuminate\Http\Request;

class VolumeController extends Controller
{
    public function create()
    {
        $comics = \App\Models\Comic::all();
        return view('volumes.create', compact('comics'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'comic_id' => 'required|exists:comics,id',
            'volume_start' => 'required|integer|min:1',
            'volume_end' => 'nullable|integer|gte:volume_start',
            'cover_image' => 'nullable|image|max:2048',
            'acquisition_date' => 'nullable|date',
            'is_owned' => 'boolean'
        ]);

        $coverImagePath = null;
        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $filename = time() . '_vol_' . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move(public_path('uploads/covers'), $filename);
            $coverImagePath = 'uploads/covers/' . $filename;
        }

        $start = $validated['volume_start'];
        $end = $validated['volume_end'] ?? $start;

        for ($i = $start; $i <= $end; $i++) {
            Volume::create([
                'comic_id' => $validated['comic_id'],
                'volume_number' => (string) $i,
                'cover_image' => $coverImagePath,
                'acquisition_date' => $validated['acquisition_date'] ?? null,
            ]);
        }

        return redirect()->route('comics.show', $validated['comic_id'])->with('success', 'Volumes added successfully!');
    }

    public function edit(Volume $volume)
    {
        $comics = \App\Models\Comic::all();
        return view('volumes.edit', compact('volume', 'comics'));
    }

    public function update(Request $request, Volume $volume)
    {
        $validated = $request->validate([
            'comic_id' => 'required|exists:comics,id',
            'volume_number' => 'required|string',
            'cover_image' => 'nullable|image|max:2048',
            'acquisition_date' => 'nullable|date',
            'is_owned' => 'boolean'
        ]);

        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $filename = time() . '_vol_' . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move(public_path('uploads/covers'), $filename);
            $validated['cover_image'] = 'uploads/covers/' . $filename;
        }

        $volume->update($validated);
        return redirect()->route('comics.show', $validated['comic_id'])->with('success', 'Volume updated successfully!');
    }

    public function destroy(Volume $volume)
    {
        $comic_id = $volume->comic_id;
        $volume->delete();
        return redirect()->route('comics.show', $comic_id);
    }
}
