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

        Volume::create($validated);
        return redirect()->route('comics.show', $validated['comic_id'])->with('success', 'Volume added successfully!');
    }

    public function destroy(Volume $volume)
    {
        $comic_id = $volume->comic_id;
        $volume->delete();
        return redirect()->route('comics.show', $comic_id);
    }
}
