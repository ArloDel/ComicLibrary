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

<!-- MAL Auto-fill UI -->
<div class="bg-surface-container-low p-6 mb-12 space-y-4 border-l-4 border-primary shadow-sm relative">
    <label class="font-label text-[10px] uppercase tracking-widest text-primary block font-bold">Isi Otomatis via AniList (GraphQL API)</label>
    <div class="flex flex-col md:flex-row gap-4 relative">
        <input type="text" id="mal_search_input" class="flex-1 bg-surface border-0 focus:ring-2 focus:ring-primary px-4 py-3 font-body text-on-surface placeholder:text-outline/40" placeholder="Masukkan judul manga...">
        <button type="button" id="mal_search_btn" class="px-8 py-3 bg-primary text-on-primary font-headline font-bold tracking-widest uppercase hover:bg-primary-container hover:text-on-primary-container transition-all flex items-center justify-center gap-2">
            <span class="material-symbols-outlined text-sm" data-icon="search">search</span> Cari
        </button>
    </div>
    <!-- Dropdown for API results -->
    <div id="mal_results" class="hidden absolute top-full left-0 w-full mt-2 bg-surface-container-high border-t-2 border-primary shadow-2xl max-h-96 overflow-y-auto z-[100] divide-y divide-outline/10"></div>
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
            <label class="font-label text-[10px] uppercase tracking-widest text-primary block mb-2 font-bold">Pratinjau Sampul yang Diambil</label>
            <div id="cover_preview" class="w-full aspect-[2/3] bg-surface-container-high bg-cover bg-center border border-outline/20 shadow-md"></div>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchBtn = document.getElementById('mal_search_btn');
    const searchInput = document.getElementById('mal_search_input');
    const resultsContainer = document.getElementById('mal_results');

    // Form fields to autofill
    const inputTitle = document.querySelector('input[name="title"]');
    const inputAuthor = document.querySelector('input[name="author"]');
    const inputTags = document.querySelector('input[name="tags_input"]');
    const inputDesc = document.querySelector('textarea[name="description"]');
    const hiddenCoverUrl = document.getElementById('cover_image_url');
    
    // Preview container
    const previewContainer = document.getElementById('cover_preview_container');
    const previewDiv = document.getElementById('cover_preview');

    searchBtn.addEventListener('click', performSearch);
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            performSearch();
        }
    });

    async function performSearch() {
        const query = searchInput.value.trim();
        if (!query) return;

        searchBtn.innerHTML = '<span class="material-symbols-outlined text-sm animate-spin" data-icon="progress_activity">progress_activity</span>';
        resultsContainer.innerHTML = '';
        resultsContainer.classList.remove('hidden');

        const graphqlQuery = `
        query ($search: String) {
            Page(page: 1, perPage: 5) {
                media(search: $search, type: MANGA) {
                    title { romaji english }
                    description(asHtml: false)
                    coverImage { large }
                    staff(perPage: 1) { edges { node { name { full } } } }
                    genres
                }
            }
        }`;

        try {
            const response = await fetch('https://graphql.anilist.co', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    query: graphqlQuery,
                    variables: { search: query }
                })
            });
            const result = await response.json();
            const mangas = result.data?.Page?.media || [];

            if (mangas.length > 0) {
                renderResults(mangas);
            } else {
                resultsContainer.innerHTML = '<div class="p-4 text-on-surface-variant text-sm text-center">Tidak ada hasil ditemukan di AniList.</div>';
            }
        } catch (error) {
            console.error('Error fetching data:', error);
            resultsContainer.innerHTML = '<div class="p-4 text-primary text-sm font-bold text-center">Gagal mengambil data. Coba lagi.</div>';
        } finally {
            searchBtn.innerHTML = '<span class="material-symbols-outlined text-sm" data-icon="search">search</span> Cari';
        }
    }

    function renderResults(mangas) {
        resultsContainer.innerHTML = '';
        mangas.forEach(manga => {
            const item = document.createElement('div');
            item.className = 'flex items-center gap-4 p-4 hover:bg-surface-container cursor-pointer transition-colors';
            
            const title = manga.title.english || manga.title.romaji;
            let author = '';
            if (manga.staff && manga.staff.edges && manga.staff.edges.length > 0) {
                author = manga.staff.edges[0].node.name.full;
            }
            const imgUrl = manga.coverImage?.large;
            
            item.innerHTML = `
                <img src="${imgUrl}" alt="Cover" class="w-12 h-16 object-cover border border-outline/20">
                <div>
                    <h4 class="font-headline font-bold text-on-surface text-lg leading-tight uppercase line-clamp-1">${title}</h4>
                    <span class="text-xs font-label uppercase tracking-widest text-on-surface-variant">${author}</span>
                </div>
            `;
            
            item.addEventListener('click', () => {
                selectManga(manga);
                resultsContainer.classList.add('hidden');
                searchInput.value = '';
            });
            
            resultsContainer.appendChild(item);
        });
    }

    function selectManga(manga) {
        inputTitle.value = manga.title.english || manga.title.romaji || '';
        
        if (manga.staff && manga.staff.edges && manga.staff.edges.length > 0) {
            inputAuthor.value = manga.staff.edges[0].node.name.full || '';
        }
        
        let allTags = [];
        if (manga.genres) allTags = manga.genres;
        inputTags.value = allTags.join(', ');
        
        if (manga.description) {
            let cleanSynopsis = manga.description.replace(/<[^>]*>?/gm, '').trim();
            inputDesc.value = cleanSynopsis;
        }
        
        const imgUrl = manga.coverImage?.large;
        if (imgUrl) {
            hiddenCoverUrl.value = imgUrl;
            previewContainer.classList.remove('hidden');
            previewDiv.style.backgroundImage = `url('${imgUrl}')`;
        }
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!resultsContainer.contains(e.target) && e.target !== searchInput && e.target !== searchBtn) {
            resultsContainer.classList.add('hidden');
        }
    });
});
</script>

@endsection
