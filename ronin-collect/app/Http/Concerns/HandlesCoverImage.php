<?php

namespace App\Http\Concerns;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

/**
 * Trait HandlesCoverImage
 *
 * Menyediakan helper untuk upload cover image dari file lokal
 * maupun mengunduh dari URL remote. Gunakan trait ini di controller
 * mana pun yang perlu mengelola cover image.
 */
trait HandlesCoverImage
{
    /** Direktori penyimpanan relatif terhadap public_path(). */
    private const COVER_UPLOAD_DIR = 'uploads/covers';

    // -------------------------------------------------------------------------
    // Upload dari File Lokal
    // -------------------------------------------------------------------------

    /**
     * Pindahkan file cover yang diupload ke direktori penyimpanan.
     *
     * @param  Request $request
     * @param  string  $prefix  Prefix nama file, misalnya 'comic' atau 'vol'.
     * @return string|null      Jalur relatif file, atau null jika tidak ada file.
     */
    protected function uploadCoverFile(Request $request, string $prefix = 'cover'): ?string
    {
        if (! $request->hasFile('cover_image')) {
            return null;
        }

        $file     = $request->file('cover_image');
        $filename = time() . '_' . $prefix . '_' . str_replace(' ', '_', $file->getClientOriginalName());

        $file->move(public_path(self::COVER_UPLOAD_DIR), $filename);

        return self::COVER_UPLOAD_DIR . '/' . $filename;
    }

    // -------------------------------------------------------------------------
    // Download dari URL Remote
    // -------------------------------------------------------------------------

    /**
     * Unduh gambar dari URL remote dan simpan secara lokal.
     *
     * Mode "soft" — jika download gagal, kembalikan URL asli sebagai fallback
     * agar gambar tetap bisa ditampilkan via tag <img>.
     *
     * @param  string $url URL gambar remote.
     * @return string      Jalur relatif lokal, atau URL asli jika download gagal.
     */
    protected function downloadCoverFromUrl(string $url): string
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (compatible; RoninCollect/1.0)',
                'Accept'     => 'image/webp,image/apng,image/*,*/*;q=0.8',
                'Referer'    => parse_url($url, PHP_URL_SCHEME) . '://' . parse_url($url, PHP_URL_HOST) . '/',
            ])->timeout(15)->get($url);

            if ($response->successful()) {
                $ext      = $this->extensionFromContentType($response->header('Content-Type'));
                $filename = time() . '_api_cover.' . $ext;
                $dir      = public_path(self::COVER_UPLOAD_DIR);

                if (! file_exists($dir)) {
                    mkdir($dir, 0755, true);
                }

                file_put_contents($dir . '/' . $filename, $response->body());

                return self::COVER_UPLOAD_DIR . '/' . $filename;
            }
        } catch (\Exception) {
            // Jatuh ke fallback URL di bawah.
        }

        // Fallback: simpan URL remote langsung ke database.
        return $url;
    }

    /**
     * Unduh gambar dari URL remote dan simpan secara lokal.
     *
     * Mode "strict" — lempar RuntimeException jika download gagal.
     * Cocok untuk konteks yang ingin menampilkan pesan error ke user.
     *
     * @param  string $url URL gambar remote.
     * @return string      Jalur relatif lokal.
     *
     * @throws \RuntimeException Jika response tidak sukses.
     */
    protected function downloadCoverFromUrlStrict(string $url): string
    {
        $response = Http::timeout(15)->get($url);

        if (! $response->successful()) {
            throw new \RuntimeException('Gagal mengunduh gambar dari URL.');
        }

        $name = basename(parse_url($url, PHP_URL_PATH));
        $name = preg_replace('/[^a-zA-Z0-9._-]/', '', $name);

        if (empty($name) || ! preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $name)) {
            $name = 'downloaded_' . uniqid() . '.jpg';
        }

        $filename   = time() . '_vol_' . $name;
        $uploadPath = public_path(self::COVER_UPLOAD_DIR);

        if (! file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        file_put_contents($uploadPath . '/' . $filename, $response->body());

        return self::COVER_UPLOAD_DIR . '/' . $filename;
    }

    // -------------------------------------------------------------------------
    // Private Helpers
    // -------------------------------------------------------------------------

    /**
     * Resolusi ekstensi file dari nilai Content-Type header HTTP.
     */
    private function extensionFromContentType(string $contentType): string
    {
        return match (true) {
            str_contains($contentType, 'png')  => 'png',
            str_contains($contentType, 'webp') => 'webp',
            str_contains($contentType, 'gif')  => 'gif',
            default                            => 'jpg',
        };
    }
}
