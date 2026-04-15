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
            'cover_image_url' => 'nullable|url',
            'acquisition_date' => 'nullable|date',
            'is_owned' => 'boolean'
        ]);

        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $filename = time() . '_vol_' . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move(public_path('uploads/covers'), $filename);
            $validated['cover_image'] = 'uploads/covers/' . $filename;
        } elseif ($request->filled('cover_image_url')) {
            try {
                $url = $request->input('cover_image_url');
                $response = \Illuminate\Support\Facades\Http::get($url);
                
                if ($response->successful()) {
                    $name = basename(parse_url($url, PHP_URL_PATH));
                    $name = preg_replace("/[^a-zA-Z0-9\._-]/", "", $name);
                    if (empty($name) || !preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $name)) {
                        $name = 'downloaded_' . uniqid() . '.jpg';
                    }
                    $filename = time() . '_vol_' . $name;
                    $uploadPath = public_path('uploads/covers');
                    if (!file_exists($uploadPath)) {
                        mkdir($uploadPath, 0755, true);
                    }
                    file_put_contents($uploadPath . '/' . $filename, $response->body());
                    $validated['cover_image'] = 'uploads/covers/' . $filename;
                } else {
                    return back()->withInput()->withErrors(['cover_image_url' => 'Gagal mengunduh gambar dari URL.']);
                }
            } catch (\Exception $e) {
                return back()->withInput()->withErrors(['cover_image_url' => 'Gagal mengunduh gambar dari URL. Pastikan URL valid dan dapat diakses.']);
            }
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
