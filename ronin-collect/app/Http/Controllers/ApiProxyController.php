<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiProxyController extends Controller
{
    // -------------------------------------------------------------------------
    // Konstanta API
    // -------------------------------------------------------------------------

    private const TIMEOUT    = 15;
    private const USER_AGENT = 'RoninCollect/1.0 (manga-library)';

    private const MANGADEX_BASE_URL = 'https://api.mangadex.org/manga';
    private const ANILIST_URL       = 'https://graphql.anilist.co';
    private const GOOGLE_BOOKS_URL  = 'https://www.googleapis.com/books/v1/volumes';
    private const OPEN_LIBRARY_URL  = 'https://openlibrary.org/search.json';

    // -------------------------------------------------------------------------
    // Public Proxy Endpoints
    // -------------------------------------------------------------------------

    /**
     * Proxy ke MangaDex API.
     * Browser tidak dapat memanggil MangaDex langsung karena CORS di localhost.
     */
    public function mangadex(Request $request)
    {
        if (($title = $this->requireTitle($request)) === null) {
            return response()->json(['data' => []], 400);
        }

        try {
            $response = Http::withHeaders(['User-Agent' => self::USER_AGENT])
                ->timeout(self::TIMEOUT)
                ->get($this->buildMangaDexUrl($title));

            return $response->successful()
                ? response()->json($response->json())
                : response()->json(['data' => [], 'error' => 'MangaDex API error'], $response->status());
        } catch (\Exception $e) {
            return response()->json(['data' => [], 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Proxy ke AniList GraphQL API.
     */
    public function anilist(Request $request)
    {
        if (($title = $this->requireTitle($request)) === null) {
            return response()->json(['data' => null], 400);
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
            ])->timeout(self::TIMEOUT)->post(self::ANILIST_URL, [
                'query'     => $this->aniListGqlQuery(),
                'variables' => ['search' => $title],
            ]);

            return $response->successful()
                ? response()->json($response->json())
                : response()->json(['data' => null, 'error' => 'AniList API error'], $response->status());
        } catch (\Exception $e) {
            return response()->json(['data' => null, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Proxy ke Google Books API.
     */
    public function googlebooks(Request $request)
    {
        if (($title = $this->requireTitle($request)) === null) {
            return response()->json(['items' => []], 400);
        }

        try {
            $response = Http::timeout(self::TIMEOUT)->get(self::GOOGLE_BOOKS_URL, [
                'q'          => $title,
                'maxResults' => 7,
            ]);

            return $response->successful()
                ? response()->json($response->json())
                : response()->json(['items' => [], 'error' => 'Google Books API error'], $response->status());
        } catch (\Exception $e) {
            return response()->json(['items' => [], 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Proxy ke Open Library Search + Covers API.
     * Gratis sepenuhnya, tidak membutuhkan API key.
     * URL Cover: https://covers.openlibrary.org/b/id/{cover_i}-L.jpg
     */
    public function openlibrary(Request $request)
    {
        if (($title = $this->requireTitle($request)) === null) {
            return response()->json(['docs' => []], 400);
        }

        try {
            $response = Http::withHeaders(['User-Agent' => self::USER_AGENT])
                ->timeout(self::TIMEOUT)
                ->get(self::OPEN_LIBRARY_URL, [
                    'q'      => $title,
                    'fields' => 'key,title,author_name,isbn,cover_i,subject,first_publish_year',
                    'limit'  => 8,
                ]);

            return $response->successful()
                ? response()->json($response->json())
                : response()->json(['docs' => [], 'error' => 'Open Library API error'], $response->status());
        } catch (\Exception $e) {
            return response()->json(['docs' => [], 'error' => $e->getMessage()], 500);
        }
    }

    // -------------------------------------------------------------------------
    // Private Helpers
    // -------------------------------------------------------------------------

    /**
     * Ambil query parameter `title`, kembalikan null jika kosong.
     */
    private function requireTitle(Request $request): ?string
    {
        $title = $request->query('title', '');

        return empty($title) ? null : $title;
    }

    /**
     * Bangun URL MangaDex secara manual.
     * http_build_query mengkodekan [] menjadi %5B%5D yang bisa ditolak oleh MangaDex.
     */
    private function buildMangaDexUrl(string $title): string
    {
        return self::MANGADEX_BASE_URL
            . '?title='             . urlencode($title)
            . '&limit=7'
            . '&includes[]=cover_art'
            . '&includes[]=author'
            . '&contentRating[]=safe'
            . '&contentRating[]=suggestive'
            . '&contentRating[]=erotica'
            . '&order[relevance]=desc';
    }

    /**
     * Kembalikan string query GraphQL untuk pencarian manga di AniList.
     */
    private function aniListGqlQuery(): string
    {
        return <<<'GQL'
        query ($search: String) {
            Page(page: 1, perPage: 7) {
                media(search: $search, type: MANGA) {
                    title { romaji english }
                    description(asHtml: false)
                    coverImage { extraLarge large }
                    staff(perPage: 2) { edges { role node { name { full } } } }
                    genres
                }
            }
        }
        GQL;
    }
}
