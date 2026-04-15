@extends('layouts.app')

@section('title', 'Tambah Komik Baru')

@section('content')
<div class="max-w-[1400px] mx-auto py-12">
<!-- Asymmetric Layout Container -->
<div class="flex flex-col md:flex-row gap-16 items-start">
<!-- Vertical Branding Accent -->
<div class="hidden lg:flex flex-col items-center gap-8">
    <span class="vertical-text font-label text-xs tracking-widest text-primary uppercase">Formulir Pengarsipan Manga</span>
    <div class="w-[2px] h-32 bg-primary"></div>
    <span class="vertical-text font-label text-xs tracking-widest text-on-surface-variant uppercase">Tokyo / Kyoto</span>
</div>

<!-- Form Section -->
<div class="flex-1 w-full space-y-12">
<header class="space-y-2 mb-8">
    <p class="font-label text-primary tracking-[0.2em] text-xs font-bold uppercase">Submisi Arsip</p>
    <h1 class="text-5xl md:text-7xl font-headline font-extrabold tracking-tighter text-on-surface uppercase">Tambah Judul Komik</h1>
</header>

<!-- Multi-Source Auto-fill UI -->
<div class="bg-surface-container-low p-6 mb-12 space-y-4 border-l-4 border-primary shadow-sm relative" id="autofill_panel">
    <label class="font-label text-[10px] uppercase tracking-widest text-primary block font-bold">Isi Otomatis — Pilih Sumber API</label>

    <!-- Source Tabs -->
    <div class="flex gap-0 border border-outline/20 overflow-hidden">
        <button type="button" data-source="anilist"
            class="source-tab flex-1 px-3 py-2.5 font-label text-[10px] uppercase tracking-widest font-bold transition-all"
            title="AniList GraphQL — metadata manga lengkap">
            🎌 AniList
        </button>
        <button type="button" data-source="mangadex"
            class="source-tab flex-1 px-3 py-2.5 font-label text-[10px] uppercase tracking-widest font-bold transition-all border-l border-outline/20"
            title="MangaDex — cover resolusi tinggi">
            📖 MangaDex
        </button>
        <button type="button" data-source="googlebooks"
            class="source-tab flex-1 px-3 py-2.5 font-label text-[10px] uppercase tracking-widest font-bold transition-all border-l border-outline/20"
            title="Google Books — cover buku fisik (ISBN)">
            📚 Google Books
        </button>
    </div>

    <p id="source_description" class="text-[10px] text-on-surface-variant font-label tracking-wide italic"></p>

    <div class="flex flex-col md:flex-row gap-4 relative">
        <input type="text" id="mal_search_input"
            class="flex-1 bg-surface border-0 focus:ring-2 focus:ring-primary px-4 py-3 font-body text-on-surface placeholder:text-outline/40"
            placeholder="Masukkan judul manga...">
        <button type="button" id="mal_search_btn"
            class="px-8 py-3 bg-primary text-on-primary font-headline font-bold tracking-widest uppercase hover:bg-primary-container hover:text-on-primary-container transition-all flex items-center justify-center gap-2">
            <span class="material-symbols-outlined text-sm" data-icon="search">search</span> Cari
        </button>
    </div>
    <!-- Dropdown for API results -->
    <div id="mal_results" class="hidden absolute top-full left-0 right-0 mt-2 bg-surface-container-high border-t-2 border-primary shadow-2xl max-h-96 overflow-y-auto z-[100] divide-y divide-outline/10"></div>
</div>

<form action="{{ route('comics.store') }}" method="POST" class="grid grid-cols-1 xl:grid-cols-12 gap-12" enctype="multipart/form-data">
    @csrf
    <!-- Content Entry (8 columns) -->
    <div class="xl:col-span-8 space-y-10">

        <!-- Title Input -->
        <div class="group">
        <label class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant block mb-2">Identifikasi Primer (Judul)</label>
        <input name="title" value="{{ old('title') }}" required class="w-full bg-transparent border-t-0 border-x-0 border-b-2 border-primary focus:ring-0 focus:border-on-surface px-0 py-4 text-4xl md:text-5xl font-headline font-black tracking-tight uppercase placeholder:opacity-20 transition-all" placeholder="MASUKKAN NAMA JUDUL" type="text"/>
        @error('title') <span class="text-xs text-primary font-bold">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
        <!-- Author -->
        <div>
        <label class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant block mb-2">Kreator / Penulis</label>
        <input name="author" value="{{ old('author') }}" required class="w-full bg-surface-container-low border-0 focus:ring-2 focus:ring-primary px-4 py-3 font-body text-on-surface placeholder:text-outline/40" placeholder="misal: Akira Toriyama" type="text"/>
        @error('author') <span class="text-xs text-primary font-bold">{{ $message }}</span> @enderror
        </div>

        <!-- Status -->
        <div>
        <label class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant block mb-2">Status Membaca</label>
        <select name="status" required class="w-full bg-surface-container-low border-0 focus:ring-2 focus:ring-primary px-4 py-3 font-body text-on-surface uppercase text-sm tracking-widest">
            <option value="plan_to_read" {{ old('status') == 'plan_to_read' ? 'selected' : '' }}>Rencana Dibaca</option>
            <option value="reading" {{ old('status') == 'reading' ? 'selected' : '' }}>Sedang Dibaca</option>
            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
            <option value="wishlist" {{ old('status') == 'wishlist' ? 'selected' : '' }}>Incaran / Wishlist</option>
        </select>
        </div>

        <!-- Priority -->
        <div>
        <label class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant block mb-2">Prioritas (Untuk Incaran)</label>
        <select name="priority" class="w-full bg-surface-container-low border-0 focus:ring-2 focus:ring-primary px-4 py-3 font-body text-on-surface uppercase text-sm tracking-widest">
            <option value="">Tidak Ada</option>
            <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Rendah</option>
            <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Menengah</option>
            <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Tinggi</option>
            <option value="extreme" {{ old('priority') == 'extreme' ? 'selected' : '' }}>Ekstrem</option>
        </select>
        </div>

        <!-- Price -->
        <div>
        <label class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant block mb-2">Estimasi Harga (Untuk Incaran/Koleksi)</label>
        <input name="price" value="{{ old('price') }}" type="number" step="1000" class="w-full bg-surface-container-low border-0 focus:ring-2 focus:ring-primary px-4 py-3 font-body text-on-surface placeholder:text-outline/40" placeholder="40000"/>
        </div>
        </div>

        <!-- Tags / Genres -->
        <div>
        <label class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant block mb-2">Tag / Genre (Pisahkan dengan koma)</label>
        <input name="tags_input" value="{{ old('tags_input') }}" class="w-full bg-surface-container-low border-0 focus:ring-2 focus:ring-primary px-4 py-3 font-body text-on-surface placeholder:text-outline/40 uppercase text-sm tracking-widest" placeholder="misal: Action, Shonen" type="text"/>
        </div>

        <!-- Description -->
        <div>
        <label class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant block mb-2">Sinopsis Naratif</label>
        <textarea name="description" class="w-full bg-surface-container-low border-0 focus:ring-2 focus:ring-primary px-4 py-4 font-body text-on-surface leading-relaxed resize-none" placeholder="Deskripsikan perjalanan, dunianya, dan keadaannya..." rows="6">{{ old('description') }}</textarea>
        </div>

        <!-- CTA -->
        <div class="pt-6">
        <button type="submit" class="group relative inline-flex items-center justify-center w-full md:w-auto px-12 py-5 bg-gradient-to-br from-primary to-primary-container text-on-primary font-headline font-extrabold tracking-tighter text-xl uppercase transition-all active:scale-95 shadow-lg shadow-primary/10">
        <span>SIMPAN_JUDUL</span>
        <span class="material-symbols-outlined ml-3 group-hover:translate-x-1 transition-transform" data-icon="arrow_forward">arrow_forward</span>
        </button>
        </div>
    </div>

    <!-- Asset Entry (4 columns) -->
    <div class="xl:col-span-4 space-y-6">
        <label class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant block">Representasi Visual (Unggah Gambar)</label>
        <input name="cover_image" id="cover_image" type="file" accept="image/*" class="w-full bg-surface-container-low border-0 focus:ring-2 focus:ring-primary px-4 py-3 font-body text-on-surface"/>
        <input type="hidden" name="cover_image_url" id="cover_image_url">

        <!-- API Cover Preview -->
        <div id="cover_preview_container" class="hidden mt-6">
            <div class="flex items-center justify-between mb-2">
                <label class="font-label text-[10px] uppercase tracking-widest text-primary block font-bold">Pratinjau Sampul</label>
                <span id="cover_source_badge" class="text-[8px] font-label tracking-widest uppercase px-2 py-0.5 bg-primary/10 text-primary border border-primary/20"></span>
            </div>
            <div id="cover_preview" class="w-full aspect-[2/3] bg-surface-container-high bg-cover bg-center border border-outline/20 shadow-md transition-all"></div>
            <button type="button" id="clear_cover_btn" class="mt-3 text-[10px] font-label uppercase tracking-widest text-on-surface-variant hover:text-primary transition-colors flex items-center gap-1">
                <span class="material-symbols-outlined text-sm" data-icon="close">close</span> Hapus Sampul Otomatis
            </button>
        </div>

        <div class="p-6 bg-surface-container-low mt-8">
        <h3 class="font-label text-[10px] uppercase tracking-widest text-primary mb-4 font-bold">Daftar Periksa Metadata</h3>
        <ul class="space-y-3">
        <li class="flex items-center gap-3 text-xs font-body text-on-surface-variant">
        <span class="material-symbols-outlined text-sm text-primary" data-icon="check_circle" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                                Aset Sampul Resolusi Tinggi
                                            </li>
        <li class="flex items-center gap-3 text-xs font-body text-on-surface-variant">
        <span class="material-symbols-outlined text-sm text-outline-variant" data-icon="radio_button_unchecked">radio_button_unchecked</span>
                                                Nomor Registrasi ISBN-13
                                            </li>
        </ul>
        </div>
    </div>
</form>

</div>
</div>
</div>

<style>
    .source-tab {
        background: transparent;
        color: rgba(var(--color-on-surface-variant-rgb, 100,116,139), 1);
        cursor: pointer;
    }
    .source-tab:hover {
        background: rgba(0,0,0,0.04);
    }
    .source-tab.active-tab {
        background: var(--color-primary, #4f46e5);
        color: white;
    }
    @media (prefers-color-scheme: dark) {
        .source-tab.active-tab { background: var(--color-primary, #818cf8); color: #111; }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchBtn = document.getElementById('mal_search_btn');
    const searchInput = document.getElementById('mal_search_input');
    const resultsContainer = document.getElementById('mal_results');
    const sourceDesc = document.getElementById('source_description');

    // Form fields to autofill
    const inputTitle = document.querySelector('input[name="title"]');
    const inputAuthor = document.querySelector('input[name="author"]');
    const inputTags = document.querySelector('input[name="tags_input"]');
    const inputDesc = document.querySelector('textarea[name="description"]');
    const hiddenCoverUrl = document.getElementById('cover_image_url');

    // Preview container
    const previewContainer = document.getElementById('cover_preview_container');
    const previewDiv = document.getElementById('cover_preview');
    const sourceBadge = document.getElementById('cover_source_badge');
    const clearCoverBtn = document.getElementById('clear_cover_btn');

    // Source state
    let activeSource = 'anilist';
    const sourceMeta = {
        anilist: {
            label: 'AniList',
            placeholder: 'Cari judul manga (romaji/english)...',
            desc: 'Sumber: AniList GraphQL API — metadata lengkap, cover medium-large',
        },
        mangadex: {
            label: 'MangaDex',
            placeholder: 'Cari judul manga di MangaDex...',
            desc: 'Sumber: MangaDex API — cover resolusi tinggi, database terlengkap',
        },
        googlebooks: {
            label: 'Google Books',
            placeholder: 'Cari judul buku/manga (cocok untuk ISBN)...',
            desc: 'Sumber: Google Books API — ideal untuk cover buku fisik & versi cetak',
        },
    };

    // Init tabs
    const tabs = document.querySelectorAll('.source-tab');
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active-tab'));
            tab.classList.add('active-tab');
            activeSource = tab.dataset.source;
            searchInput.placeholder = sourceMeta[activeSource].placeholder;
            sourceDesc.textContent = sourceMeta[activeSource].desc;
            resultsContainer.classList.add('hidden');
            resultsContainer.innerHTML = '';
        });
    });

    // Set initial state
    tabs[0].classList.add('active-tab');
    searchInput.placeholder = sourceMeta.anilist.placeholder;
    sourceDesc.textContent = sourceMeta.anilist.desc;

    // Search trigger
    searchBtn.addEventListener('click', performSearch);
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') { e.preventDefault(); performSearch(); }
    });

    // Clear cover
    clearCoverBtn.addEventListener('click', () => {
        hiddenCoverUrl.value = '';
        previewContainer.classList.add('hidden');
        previewDiv.style.backgroundImage = '';
    });

    async function performSearch() {
        const query = searchInput.value.trim();
        if (!query) return;

        searchBtn.innerHTML = '<span class="material-symbols-outlined text-sm animate-spin" data-icon="progress_activity">progress_activity</span>';
        resultsContainer.innerHTML = '';
        resultsContainer.classList.remove('hidden');

        try {
            switch(activeSource) {
                case 'anilist':    await searchAniList(query); break;
                case 'mangadex':   await searchMangaDex(query); break;
                case 'googlebooks': await searchGoogleBooks(query); break;
            }
        } catch (error) {
            console.error('Search error:', error);
            resultsContainer.innerHTML = '<div class="p-4 text-primary text-sm font-bold text-center">Gagal mengambil data. Coba lagi.</div>';
        } finally {
            searchBtn.innerHTML = '<span class="material-symbols-outlined text-sm" data-icon="search">search</span> Cari';
        }
    }

    // Proxy base URL (server-side, no CORS)
    const PROXY = {
        anilist:     '{{ route('proxy.anilist') }}',
        mangadex:    '{{ route('proxy.mangadex') }}',
        googlebooks: '{{ route('proxy.googlebooks') }}',
    };
    const CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '';

    // ─── AniList (via proxy) ───────────────────────────────────────────────────
    async function searchAniList(query) {
        const res = await fetch(`${PROXY.anilist}?title=${encodeURIComponent(query)}`, {
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
        });
        const data = await res.json();
        const mangas = data.data?.Page?.media || [];

        if (!mangas.length) {
            resultsContainer.innerHTML = '<div class="p-4 text-on-surface-variant text-sm text-center">Tidak ada hasil di AniList.</div>';
            return;
        }

        renderResults(mangas.map(m => ({
            title: m.title.english || m.title.romaji,
            author: m.staff?.edges?.[0]?.node?.name?.full || '',
            coverUrl: m.coverImage?.extraLarge || m.coverImage?.large || '',
            tags: m.genres || [],
            description: m.description ? m.description.replace(/<[^>]*>/gm, '').trim() : '',
            source: 'AniList',
        })));
    }

    // ─── MangaDex (via proxy) ─────────────────────────────────────────────────
    async function searchMangaDex(query) {
        const res = await fetch(`${PROXY.mangadex}?title=${encodeURIComponent(query)}`, {
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
        });
        const data = await res.json();
        const mangas = data.data || [];

        if (!mangas.length) {
            resultsContainer.innerHTML = '<div class="p-4 text-on-surface-variant text-sm text-center">Tidak ada hasil di MangaDex.</div>';
            return;
        }

        const results = mangas.map(m => {
            const attrs = m.attributes;
            const title = attrs.title?.en
                || attrs.title?.['ja-ro']
                || attrs.title?.ja
                || Object.values(attrs.title || {})[0]
                || 'Unknown';

            const authorRel = m.relationships?.find(r => r.type === 'author');
            const author = authorRel?.attributes?.name || '';

            // Debug: log relationships to console so we can inspect
            console.log('[MangaDex] relationships for', title, ':', m.relationships);

            const coverRel = m.relationships?.find(r => r.type === 'cover_art');
            // MangaDex API uses 'fileName' (camelCase) per the API spec
            const coverFile = coverRel?.attributes?.fileName
                           || coverRel?.attributes?.filename  // fallback
                           || null;

            // Format: https://uploads.mangadex.org/covers/:manga-id/:cover-filename.512.jpg
            // Note: coverFile already includes the original extension (e.g. ".png"),
            // so we append ".512.jpg" AFTER the full filename per docs.
            const coverUrl = coverFile
                ? `https://uploads.mangadex.org/covers/${m.id}/${coverFile}.png.512.jpg`
                : '';

            console.log('[MangaDex] coverFile:', coverFile, '→ URL:', coverUrl);

            const tags = attrs.tags?.map(t => t.attributes?.name?.en).filter(Boolean) || [];
            const desc = attrs.description?.en || attrs.description?.['ja-ro'] || '';

            return { title, author, coverUrl, tags, description: desc, source: 'MangaDex' };
        });

        renderResults(results);
    }

    // ─── Google Books (via proxy) ──────────────────────────────────────────────
    async function searchGoogleBooks(query) {
        const res = await fetch(`${PROXY.googlebooks}?title=${encodeURIComponent(query)}`, {
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
        });
        const data = await res.json();
        const items = data.items || [];

        if (!items.length) {
            resultsContainer.innerHTML = '<div class="p-4 text-on-surface-variant text-sm text-center">Tidak ada hasil di Google Books.</div>';
            return;
        }

        const results = items.map(item => {
            const info = item.volumeInfo;
            const covers = info.imageLinks || {};
            // Upgrade zoom level for higher resolution
            const coverUrl = (covers.extraLarge || covers.large || covers.medium || covers.thumbnail || '')
                .replace('http://', 'https://')
                .replace('zoom=1', 'zoom=3')
                .replace('&edge=curl', '');

            return {
                title: info.title || '',
                author: (info.authors || []).join(', '),
                coverUrl,
                tags: info.categories || [],
                description: info.description || '',
                source: 'Google Books',
            };
        });

        renderResults(results);
    }

    // ─── Render Results ────────────────────────────────────────────────────────
    function renderResults(items) {
        resultsContainer.innerHTML = '';
        items.forEach(item => {
            const el = document.createElement('div');
            el.className = 'flex items-center gap-4 p-4 hover:bg-surface-container cursor-pointer transition-colors';
            el.innerHTML = `
                <div class="w-12 h-16 flex-shrink-0 bg-surface-container-high border border-outline/20 overflow-hidden">
                    ${item.coverUrl
                        ? `<img src="${item.coverUrl}" alt="Cover" class="w-full h-full object-cover" loading="lazy" onerror="this.parentElement.innerHTML='<span class=\\'text-xs text-outline-variant flex items-center justify-center h-full\\'>?</span>'">`
                        : '<span class="text-xs text-outline-variant flex items-center justify-center h-full">?</span>'}
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="font-headline font-bold text-on-surface text-sm leading-tight uppercase line-clamp-1">${escapeHtml(item.title)}</h4>
                    <span class="text-xs font-label uppercase tracking-widest text-on-surface-variant block">${escapeHtml(item.author)}</span>
                    ${item.tags.length ? `<span class="text-[9px] text-primary tracking-widest font-label">${item.tags.slice(0,3).join(' · ')}</span>` : ''}
                </div>
            `;
            el.addEventListener('click', () => {
                fillForm(item);
                resultsContainer.classList.add('hidden');
                searchInput.value = '';
            });
            resultsContainer.appendChild(el);
        });
    }

    // ─── Fill Form ─────────────────────────────────────────────────────────────
    function fillForm(item) {
        if (item.title)       inputTitle.value  = item.title;
        if (item.author)      inputAuthor.value = item.author;
        if (item.tags.length) inputTags.value   = item.tags.slice(0, 8).join(', ');
        if (item.description) inputDesc.value   = item.description;

        if (item.coverUrl) {
            hiddenCoverUrl.value = item.coverUrl;
            previewContainer.classList.remove('hidden');
            previewDiv.style.backgroundImage = `url('${item.coverUrl}')`;
            sourceBadge.textContent = item.source;

            // Pulse animation
            previewDiv.style.opacity = '0.5';
            setTimeout(() => { previewDiv.style.opacity = '1'; }, 300);
        }
    }

    function escapeHtml(str) {
        const div = document.createElement('div');
        div.appendChild(document.createTextNode(str || ''));
        return div.innerHTML;
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!resultsContainer.contains(e.target) && e.target !== searchInput && !searchBtn.contains(e.target)) {
            resultsContainer.classList.add('hidden');
        }
    });
});
</script>

@endsection
