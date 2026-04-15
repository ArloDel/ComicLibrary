<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiProxyController extends Controller
{
    /**
     * Proxy to MangaDex API.
     * Browser can't call MangaDex directly due to CORS on localhost.
     */
    public function mangadex(Request $request)
    {
        $query = $request->query('title', '');
        if (empty($query)) {
            return response()->json(['data' => []], 400);
        }

        try {
            // Build URL manually — http_build_query encodes [] to %5B%5D which MangaDex may reject
            $url = 'https://api.mangadex.org/manga'
                . '?title='             . urlencode($query)
                . '&limit=7'
                . '&includes[]=cover_art'
                . '&includes[]=author'
                . '&contentRating[]=safe'
                . '&contentRating[]=suggestive'
                . '&contentRating[]=erotica'
                . '&order[relevance]=desc';

            $response = Http::withHeaders([
                'User-Agent' => 'RoninCollect/1.0 (manga-library)',
            ])->timeout(15)->get($url);

            if ($response->successful()) {
                return response()->json($response->json());
            }

            return response()->json(['data' => [], 'error' => 'MangaDex API error'], $response->status());
        } catch (\Exception $e) {
            return response()->json(['data' => [], 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Proxy to AniList GraphQL API.
     */
    public function anilist(Request $request)
    {
        $query = $request->query('title', '');
        if (empty($query)) {
            return response()->json(['data' => null], 400);
        }

        $gql = <<<'GQL'
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

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
            ])->timeout(15)->post('https://graphql.anilist.co', [
                'query'     => $gql,
                'variables' => ['search' => $query],
            ]);

            if ($response->successful()) {
                return response()->json($response->json());
            }

            return response()->json(['data' => null, 'error' => 'AniList API error'], $response->status());
        } catch (\Exception $e) {
            return response()->json(['data' => null, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Proxy to Google Books API.
     */
    public function googlebooks(Request $request)
    {
        $query = $request->query('title', '');
        if (empty($query)) {
            return response()->json(['items' => []], 400);
        }

        try {
            $response = Http::timeout(15)->get('https://www.googleapis.com/books/v1/volumes', [
                'q'          => $query,
                'maxResults' => 7,
            ]);

            if ($response->successful()) {
                return response()->json($response->json());
            }

            return response()->json(['items' => [], 'error' => 'Google Books API error'], $response->status());
        } catch (\Exception $e) {
            return response()->json(['items' => [], 'error' => $e->getMessage()], 500);
        }
    }
}
