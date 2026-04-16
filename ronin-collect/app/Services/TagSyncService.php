<?php

namespace App\Services;

use App\Models\Comic;
use App\Models\Tag;

/**
 * TagSyncService
 *
 * Bertanggung jawab atas satu pekerjaan:
 * mengubah string "tag1, tag2, tag3" menjadi relasi BelongsToMany
 * yang tersinkron di database.
 */
class TagSyncService
{
    /**
     * Sinkronkan tag dari input string ke relasi tags() pada comic.
     *
     * - Tag yang belum ada di database akan dibuat secara otomatis.
     * - Semua nama tag disimpan dalam huruf kapital penuh (UPPERCASE).
     * - Passing `null` akan melewati sync (tidak mengubah tag yang ada).
     *   Berguna untuk method update ketika field tags tidak diisi ulang.
     *
     * @param  Comic       $comic     Entitas comic target.
     * @param  string|null $tagsInput String tag yang dipisahkan koma.
     */
    public function sync(Comic $comic, ?string $tagsInput): void
    {
        if ($tagsInput === null) {
            return;
        }

        $tagNames = array_filter(array_map('trim', explode(',', $tagsInput)));

        $tagIds = collect($tagNames)
            ->filter(fn (string $name) => $name !== '')
            ->map(fn (string $name) => Tag::firstOrCreate(['name' => strtoupper($name)])->id)
            ->all();

        $comic->tags()->sync($tagIds);
    }
}
