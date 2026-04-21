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

    public function store(\App\Http\Requests\StoreVolumeRequest $request)
    {
        $validated = $request->validated();

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

        \App\Jobs\UpdateNarrativeReport::dispatch();

        return redirect()
            ->route('comics.show', $validated['comic_id'])
            ->with('success', 'Volumes added successfully!');
    }

    public function edit(Volume $volume)
    {
        $comics = Comic::all();

        return view('volumes.edit', compact('volume', 'comics'));
    }

    public function update(\App\Http\Requests\UpdateVolumeRequest $request, Volume $volume)
    {
        $validated = $request->validated();

        $dispatchCoverUrl = null;

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $this->uploadCoverFile($request, 'vol');
        } elseif (!empty($validated['cover_image_url'])) {
            $validated['cover_image'] = $validated['cover_image_url'];
            $dispatchCoverUrl = $validated['cover_image_url'];
        }

        unset($validated['cover_image_url']);

        $volume->update($validated);

        if ($dispatchCoverUrl) {
            \App\Jobs\DownloadCoverImage::dispatch($volume, $dispatchCoverUrl);
        }

        \App\Jobs\UpdateNarrativeReport::dispatch();

        return redirect()
            ->route('comics.show', $validated['comic_id'])
            ->with('success', 'Volume updated successfully!');
    }

    public function destroy(Volume $volume)
    {
        $comicId = $volume->comic_id;
        $volume->delete();

        \App\Jobs\UpdateNarrativeReport::dispatch();

        return redirect()->route('comics.show', $comicId);
    }
}
