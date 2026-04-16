<?php

namespace App\Http\Controllers;

use App\Http\Concerns\HandlesCoverImage;
use App\Models\Comic;
use App\Models\Volume;
use Illuminate\Http\Request;

class VolumeController extends Controller
{
    use HandlesCoverImage;

    public function create()
    {
        $comics = Comic::all();

        return view('volumes.create', compact('comics'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'comic_id'         => 'required|exists:comics,id',
            'volume_start'     => 'required|integer|min:1',
            'volume_end'       => 'nullable|integer|gte:volume_start',
            'cover_image'      => 'nullable|image|max:2048',
            'acquisition_date' => 'nullable|date',
            'is_owned'         => 'boolean',
        ]);

        // Upload satu file cover yang akan dipakai bersama oleh semua volume dalam range.
        $coverImagePath = $this->uploadCoverFile($request, 'vol');

        $start = $validated['volume_start'];
        $end   = $validated['volume_end'] ?? $start;

        for ($i = $start; $i <= $end; $i++) {
            Volume::create([
                'comic_id'         => $validated['comic_id'],
                'volume_number'    => (string) $i,
                'cover_image'      => $coverImagePath,
                'acquisition_date' => $validated['acquisition_date'] ?? null,
            ]);
        }

        return redirect()
            ->route('comics.show', $validated['comic_id'])
            ->with('success', 'Volumes added successfully!');
    }

    public function edit(Volume $volume)
    {
        $comics = Comic::all();

        return view('volumes.edit', compact('volume', 'comics'));
    }

    public function update(Request $request, Volume $volume)
    {
        $validated = $request->validate([
            'comic_id'         => 'required|exists:comics,id',
            'volume_number'    => 'required|string',
            'cover_image'      => 'nullable|image|max:2048',
            'cover_image_url'  => 'nullable|url',
            'acquisition_date' => 'nullable|date',
            'is_owned'         => 'boolean',
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $this->uploadCoverFile($request, 'vol');
        } elseif ($request->filled('cover_image_url')) {
            try {
                $validated['cover_image'] = $this->downloadCoverFromUrlStrict(
                    $request->input('cover_image_url')
                );
            } catch (\RuntimeException $e) {
                return back()->withInput()->withErrors(['cover_image_url' => $e->getMessage()]);
            }
        }

        unset($validated['cover_image_url']);

        $volume->update($validated);

        return redirect()
            ->route('comics.show', $validated['comic_id'])
            ->with('success', 'Volume updated successfully!');
    }

    public function destroy(Volume $volume)
    {
        $comicId = $volume->comic_id;
        $volume->delete();

        return redirect()->route('comics.show', $comicId);
    }
}
