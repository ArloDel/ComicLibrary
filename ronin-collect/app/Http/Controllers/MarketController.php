<?php

namespace App\Http\Controllers;

use App\Models\Comic;
use Illuminate\Http\Request;

class MarketController extends Controller
{
    /**
     * Menampilkan daftar target "wishlist" (bounty) pada terminal pasar.
     */
    public function index()
    {
        // Mengambil komik yang berada dalam wishlist, diurutkan berdasarkan prioritas Custom Rank.
        $bounties = Comic::where('status', 'wishlist')
            ->orderByRaw("CASE priority WHEN 'extreme' THEN 1 WHEN 'high' THEN 2 WHEN 'medium' THEN 3 WHEN 'low' THEN 4 ELSE 5 END")
            ->orderBy('created_at', 'desc')
            ->get();

        return view('market.index', compact('bounties'));
    }
}
