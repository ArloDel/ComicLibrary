{{-- ============================================================
     _autofill_panel.blade.php
     Panel multi-sumber autofill API (khusus halaman create).
     Menampilkan tab sumber, search bar, dan dropdown hasil.
     ============================================================ --}}
<div class="bg-surface-container-low p-6 mb-12 space-y-4 border-l-4 border-primary shadow-sm relative" id="autofill_panel">
    <label class="font-label text-[10px] uppercase tracking-widest text-primary block font-bold">
        Isi Otomatis — Pilih Sumber API
    </label>

    {{-- Source Tabs --}}
    <div class="flex gap-0 border border-outline/20 overflow-hidden">
        @php
            $apiSources = [
                'anilist'     => ['emoji' => '🎌', 'label' => 'AniList',      'title' => 'AniList GraphQL — metadata manga lengkap'],
                'mangadex'    => ['emoji' => '📖', 'label' => 'MangaDex',     'title' => 'MangaDex — cover resolusi tinggi'],
                'googlebooks' => ['emoji' => '📚', 'label' => 'Google Books', 'title' => 'Google Books — cover buku fisik (ISBN)'],
                'openlibrary' => ['emoji' => '🏛️', 'label' => 'Open Library', 'title' => 'Open Library — gratis, tanpa API key, berbasis ISBN'],
            ];
        @endphp

        @foreach($apiSources as $source => $meta)
            <button type="button"
                    data-source="{{ $source }}"
                    class="source-tab flex-1 px-3 py-2.5 font-label text-[10px] uppercase tracking-widest font-bold transition-all {{ !$loop->first ? 'border-l border-outline/20' : '' }}"
                    title="{{ $meta['title'] }}">
                {{ $meta['emoji'] }} {{ $meta['label'] }}
            </button>
        @endforeach
    </div>

    <p id="source_description" class="text-[10px] text-on-surface-variant font-label tracking-wide italic"></p>

    {{-- Search Bar --}}
    <div class="flex flex-col md:flex-row gap-4 relative">
        <input type="text" id="mal_search_input"
               class="flex-1 bg-surface border-0 focus:ring-2 focus:ring-primary px-4 py-3 font-body text-on-surface placeholder:text-outline/40"
               placeholder="Masukkan judul manga...">
        <button type="button" id="mal_search_btn"
                class="px-8 py-3 bg-primary text-on-primary font-headline font-bold tracking-widest uppercase hover:bg-primary-container hover:text-on-primary-container transition-all flex items-center justify-center gap-2">
            <span class="material-symbols-outlined text-sm" data-icon="search">search</span> Cari
        </button>
    </div>

    {{-- Dropdown Hasil Pencarian --}}
    <div id="mal_results"
         class="hidden absolute top-full left-0 right-0 mt-2 bg-surface-container-high border-t-2 border-primary shadow-2xl max-h-96 overflow-y-auto z-[100] divide-y divide-outline/10">
    </div>
</div>
