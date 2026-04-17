@extends('layouts.app')

@section('title', 'Dasbor')

@section('sidebar')
<!-- SideNav (Vertical Accent for Desktop) -->
<aside class="hidden xl:flex fixed left-0 top-0 h-screen w-20 flex-col items-center justify-center bg-surface-container-low z-40 gap-12 pt-20">
<span class="vertical-text font-label text-[10px] tracking-[0.5em] text-on-surface/40 uppercase">Sistem_Arsip_v.01</span>
<div class="flex flex-col gap-8 text-on-surface/60">
<a href="{{ route('comics.index') }}" class="material-symbols-outlined hover:text-primary cursor-pointer transition-colors">menu_book</a>
<a href="{{ route('comics.index') }}" class="material-symbols-outlined hover:text-primary cursor-pointer transition-colors">visibility</a>
<a href="{{ route('comics.index') }}" class="material-symbols-outlined hover:text-primary cursor-pointer transition-colors">favorite</a>
<a href="{{ route('comics.index') }}" class="material-symbols-outlined hover:text-primary cursor-pointer transition-colors">auto_stories</a>
</div>
</aside>

<main class="xl:ml-20 pt-24 pb-20 min-h-screen">
<!-- Hero Section -->
<section class="px-8 md:px-16 grid grid-cols-1 lg:grid-cols-12 gap-8 items-end border-b border-surface-variant/30 pb-16">
<div class="lg:col-span-8">
<h1 class="text-7xl md:text-9xl font-black font-headline tracking-tighter leading-none uppercase mb-6">
                    Sang<br/><span class="text-primary">Kurator</span><br/>Ronin.
                </h1>
<p class="max-w-xl text-lg text-on-surface-variant font-body">
                    Sebuah suaka digital terkurasi untuk koleksi Shonen berenergi tinggi dan minimalisme Jepang yang displin. Setiap volume adalah guratan penting dalam narasi besar.
                </p>
</div>
<div class="lg:col-span-4 flex flex-col items-start lg:items-end gap-4">
<div class="bg-primary px-6 py-4 w-full lg:w-auto mt-8 md:mt-0">
<span class="font-label text-xs tracking-widest text-on-primary block mb-2 uppercase">Status Saat Ini</span>
<span class="font-headline font-extrabold text-2xl text-on-primary uppercase leading-none">Kurator Utama</span>
</div>
<div class="font-label text-[10px] tracking-widest text-on-surface/50 uppercase text-left lg:text-right">
                    Pembaruan Terakhir: {{ date('d.M.Y') }}<br/>
                    Arsip Pusat Tokyo
                </div>
</div>
</section>

<!-- Archival Telemetry / Statistics -->
<section class="mt-20 px-8 md:px-16 grid grid-cols-1 lg:grid-cols-3 gap-12 lg:gap-8">
    <!-- Value -->
    <div class="border-t-2 border-on-surface pt-6 pb-8 relative group">
        <div class="absolute w-full h-0 bg-surface-container-high left-0 bottom-0 top-0 -z-10 group-hover:top-0 transition-all duration-500"></div>
        <span class="font-label text-[10px] tracking-widest text-on-surface-variant uppercase block mb-4">Estimasi Nilai Total</span>
        <div class="text-6xl md:text-7xl font-headline font-black tracking-tighter text-on-surface flex items-start">
            <span class="text-primary text-3xl mt-2 mr-2 font-bold">Rp</span>
            <span>{{ number_format($totalInvestment, 0, ',', '.') }}</span>
        </div>
    </div>
    
    <!-- Count & Completion -->
    <div class="border-t-4 border-primary pt-6 pb-8 bg-surface-container px-8 flex justify-between items-end group relative overflow-hidden">
        <!-- Abstract shape -->
        <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-primary/5 rounded-full blur-xl group-hover:scale-150 transition-transform duration-700"></div>
        <div class="z-10">
            <span class="font-label text-[10px] tracking-[0.2em] text-primary uppercase block mb-2 font-bold">Arsip Terindeks</span>
            <div class="text-7xl font-headline font-black tracking-tighter text-on-surface leading-none">{{ $totalOwned }}</div>
        </div>
        <div class="text-right z-10 pb-1">
            <span class="font-label text-[10px] tracking-widest text-on-surface-variant uppercase block mb-2">Batas Penyelesaian</span>
            <div class="text-4xl text-on-surface font-headline font-extrabold">{{ $completionRate }}<span class="text-primary ml-1">%</span></div>
        </div>
    </div>

    <!-- Top Genres -->
    <div class="border-t-2 border-on-surface pt-6 pb-8 flex flex-col justify-between">
        <span class="font-label text-[10px] tracking-widest text-on-surface-variant uppercase block mb-4">Arc Tema Dominan</span>
        <div class="space-y-4">
            @forelse($topGenres as $genre)
            <div class="group/genre">
                <div class="flex justify-between items-end mb-1">
                    <span class="font-headline font-bold text-sm uppercase text-on-surface tracking-widest group-hover/genre:text-primary transition-colors">{{ $genre->name }}</span>
                    <span class="font-label text-[10px] font-bold text-on-surface-variant">{{ $genre->comics_count }} VOL</span>
                </div>
                <!-- Subtle line bar -->
                <div class="w-full h-[2px] bg-outline/10">
                    <div class="h-full bg-primary origin-left scale-x-0 group-hover/genre:scale-x-100 transition-transform duration-500 ease-out" style="width: {{ min(($genre->comics_count / max($totalOwned, 1)) * 100, 100) }}%"></div>
                </div>
            </div>
            @empty
            <span class="text-xs font-label text-on-surface-variant uppercase font-bold">Tidak ada data kategori.</span>
            @endforelse
        </div>
    </div>
</section>

<!-- AI Narrative Report -->
<section class="mt-12 px-8 md:px-16" id="ai-narrative-section">
    <div class="border border-surface-variant/50 bg-surface-container-low p-8 md:p-10 relative overflow-hidden group">
        <!-- Decoration -->
        <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-bl-full blur-2xl group-hover:bg-primary/10 transition-colors duration-1000"></div>
        <div class="absolute right-4 top-4">
            <span class="font-label text-[10px] tracking-[0.3em] font-bold text-primary uppercase border border-primary/30 px-3 py-1 flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                AI GENERATED
            </span>
        </div>
        
        <h2 class="font-headline font-bold text-lg uppercase tracking-widest text-on-surface mb-2">Pesan Dari Kurator</h2>
        <span class="font-label text-[10px] tracking-widest text-on-surface-variant uppercase block mb-6">Status Log: {{ date('d.m.y / H:i') }}</span>
        
        <div id="narrative-content" class="min-h-[80px]">
            <!-- Skeleton Loader -->
            <div class="animate-pulse flex flex-col gap-3 max-w-4xl">
                <div class="h-4 bg-surface-variant/60 rounded w-full"></div>
                <div class="h-4 bg-surface-variant/60 rounded w-11/12"></div>
                <div class="h-4 bg-surface-variant/60 rounded w-4/5"></div>
            </div>
        </div>
    </div>
</section>

<!-- Spotlight: Currently Reading -->
<section class="mt-20 px-8 md:px-16">
<div class="flex items-center gap-4 mb-12">
<span class="h-[2px] w-12 bg-primary"></span>
<h2 class="font-label text-xs tracking-[0.3em] uppercase font-bold text-primary">Sedang_Dibaca</h2>
</div>
<div class="relative group bg-surface-container-low grid grid-cols-1 lg:grid-cols-2 gap-0 overflow-hidden">
@if($currentlyReading)
<div class="overflow-hidden" style="aspect-ratio: 4/5;">
<img alt="{{ $currentlyReading->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" data-alt="{{ $currentlyReading->title }}" src="{{ $currentlyReading->cover_image ? asset($currentlyReading->cover_image) : 'https://lh3.googleusercontent.com/aida-public/AB6AXuCZzS7gEQGQo0X2hEMgP46WiWvQJ4_WU1ZzWW8bT4xaCSdtcqg-CwsUW7KMVg_gh1BBaJgRhunVHupVPUgaXyvZ51EyThQGwFA9syhqF6u0EO7dUC1tuGb06Ol1BVwhWgJ7bCEgKLrQzxwDXQr3ajouSs2aGAzY_dseu6OcepiINdx87RYlf6V0V5Rl-YTcbodnTBxDNrCfkM-slkeN1POOecxQKA4FGFvUEjbxNvZRdW1EFn7hUt-K7bVjEOzcW0yglBKJnxPPK-4' }}"/>
</div>
<div class="p-8 md:p-16 flex flex-col justify-between">
<div>
<span class="font-label text-xs text-primary font-bold tracking-widest uppercase mb-4 block underline underline-offset-8">Fokus Volume Saat Ini</span>
<h3 class="text-5xl md:text-6xl font-headline font-extrabold tracking-tighter uppercase mb-6 leading-tight">{{ $currentlyReading->title }}</h3>
<p class="text-on-surface-variant text-lg max-w-md mb-8">
                            {{ $currentlyReading->description ?? 'Rasakan perjalanan mendalam sang ahli pedang legendaris. Edisi arsip ini menampilkan ulang plat tinta yang disempurnakan dan komentar eksklusif penulis mengenai filosofi pedang.' }}
                        </p>
</div>
<div class="flex flex-wrap gap-4 mt-8 md:mt-0">
<a href="{{ route('comics.show', $currentlyReading) }}" class="bg-primary text-on-primary px-10 py-5 font-headline font-bold uppercase tracking-widest hover:bg-primary-container transition-colors inline-block text-center">
                            Lanjutkan Membaca
                        </a>
</div>
</div>
@else
<div class="p-8 md:p-16 flex flex-col items-center justify-center col-span-2 text-center py-24">
    <span class="material-symbols-outlined text-6xl text-primary opacity-50 mb-4 block">bookmark_border</span>
    <p class="text-on-surface-variant text-lg font-body uppercase tracking-widest">Tidak ada bacaan saat ini. Silakan mulai volume baru.</p>
</div>
@endif
<!-- Stylized Vertical Watermark -->
<div class="absolute right-4 top-1/2 -translate-y-1/2 vertical-text hidden lg:block select-none pointer-events-none">
<span class="text-[120px] font-black text-on-surface/[0.03] font-headline">SAMURAI</span>
</div>
</div>
</section>

<!-- Bento Grid: Acquisitions & Wishlist -->
<section class="mt-32 px-8 md:px-16 grid grid-cols-1 lg:grid-cols-12 gap-8">
<!-- Latest Acquisitions -->
<div class="lg:col-span-8">
<div class="flex justify-between items-end mb-10 border-b-2 border-on-surface pb-4">
<h2 class="font-headline font-extrabold text-4xl uppercase tracking-tighter">Akuisisi_Terbaru</h2>
<a class="font-label text-xs tracking-widest text-primary font-bold hover:underline" href="{{ route('comics.index') }}">LIHAT SEMUA</a>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

@forelse($latestAcquisitions as $comic)
    <a href="{{ route('comics.show', $comic) }}" class="group block cursor-pointer">
    <div class="bg-surface-container-highest overflow-hidden mb-4 border border-transparent group-hover:border-primary transition-colors" style="aspect-ratio: 2/3;">
    <img alt="{{ $comic->title }}" class="w-full h-full object-cover transition-transform group-hover:scale-110" src="{{ $comic->cover_image ? asset($comic->cover_image) : 'https://lh3.googleusercontent.com/aida-public/AB6AXuAsVVa9HFIaPIkgr3U-gxt5M7P4iPWzH4jCMU8sEu8p3hRWLfPMsGemiWkrHu3V8KpE3xp04tnSzkaClnY6sf4I2pxU67LPJMOu_IALpnurC8YTlAyJB2U_ZgqJFcJyonmQhof5XqeuhYcani6SlbyDScR9ZrQtVvBjOuDHmc0KOz4ZeRmxZ_ZvnY0Un6swucEU6faZM8iyeCa0PDNYnKVQcTRmXlCwL9UZopV8lh2ssN02RFTYWCT8ATiIamBZMnHSlGg5czK56nw' }}"/>
    </div>
    <span class="font-label text-[10px] tracking-widest text-primary uppercase font-bold">{{ $comic->created_at->diffForHumans() }}</span>
    <h4 class="font-headline font-bold text-lg uppercase tracking-tight group-hover:text-primary transition-colors mt-1">{{ $comic->title }}</h4>
    <p class="font-label text-xs text-on-surface/50 uppercase">{{ $comic->author }}</p>
    </a>
@empty
    <div class="col-span-3 text-center py-12 text-on-surface/50 uppercase tracking-widest font-label font-bold text-sm">
        Tidak ada akuisisi terbaru ditemukan.
    </div>
@endforelse

</div>
</div>

<!-- Wishlist Sidebar -->
<div class="lg:col-span-4 bg-on-background text-surface p-8">
<div class="flex items-center gap-3 mb-8">
<span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">favorite</span>
<h2 class="font-headline font-extrabold text-2xl uppercase tracking-tighter">Antrean_Wishlist</h2>
</div>
<div class="space-y-8 min-h-[300px]">

@forelse($wishlist as $wish)
    <div class="flex gap-4 items-start border-b border-surface/10 pb-6 group cursor-pointer">
    <div class="w-16 h-20 bg-surface/10 flex-shrink-0 overflow-hidden">
    <img alt="{{ $wish->title }}" class="w-full h-full object-cover opacity-60 group-hover:opacity-100 transition-opacity" src="{{ $wish->cover_image ? asset($wish->cover_image) : 'https://lh3.googleusercontent.com/aida-public/AB6AXuAz4dKzSvm70-_RQjOgJRFdgPvqvdqGhw6j-PVrWSw9T4DOUwecaItvuNIc7KXDOzH8UQG1P6sT1P2XALjfxmEbxo4XjFVyhpqIfpmgO_OiEDFCcm0t3UAt_tV4GRnxdFdorf2QbgzDD1WHCA-nK893GqJx9TYK0llxTyaKoZMkp8Yev78byiO9bt9VkjGhJDf2UW7WcZIpqHoea7ceDfx6tOCym7s2iTRlxe6yxRgUc5LqUil24nwaK_L5Q9x0JOs0Q9Pnei7fsKo' }}"/>
    </div>
    <div>
    <h5 class="font-headline font-bold text-sm uppercase group-hover:text-primary transition-colors">{{ $wish->title }}</h5>
    <p class="font-label text-[10px] tracking-widest text-surface/40 uppercase mb-2">Prioritas: {{ $wish->priority }}</p>
    <span class="text-xs font-bold text-primary">{{ $wish->price ? 'Rp'.number_format($wish->price, 0, ',', '.') : 'HARGA TIDAK DIKETAHUI' }}</span>
    </div>
    </div>
@empty
    <div class="text-center py-12 text-surface/50 uppercase tracking-widest font-label font-bold text-xs mt-12">
        Antrean wishlist kosong.
    </div>
@endforelse

</div>
<a href="{{ route('comics.create') }}" class="w-full mt-12 border-2 border-surface/20 py-4 font-label text-xs tracking-widest uppercase hover:bg-surface hover:text-on-background transition-all font-bold block text-center">
                    Tambah Incaran Baru
                </a>
</div>
</section>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fetchNarrative = async () => {
            const container = document.getElementById('narrative-content');
            try {
                const response = await fetch("{{ route('api.narrative') }}", {
                    headers: { 'Accept': 'application/json' }
                });
                
                if (!response.ok) throw new Error('API Error');
                
                const data = await response.json();
                
                // Remove skeleton and insert text with type-in effect
                container.innerHTML = '';
                const p = document.createElement('p');
                p.className = 'font-body text-xl text-on-surface leading-relaxed relative z-10';
                container.appendChild(p);
                
                // Simple typewriter effect
                let i = 0;
                const text = data.narrative;
                const speed = 25; // ms per char
                
                function typeWriter() {
                    if (i < text.length) {
                        p.innerHTML += text.charAt(i);
                        i++;
                        setTimeout(typeWriter, speed);
                    }
                }
                typeWriter();

            } catch (error) {
                container.innerHTML = '<p class="font-body text-xl text-error leading-relaxed">Koneksi transmisi neural gagal. Silakan periksa kunci A.I. pada matriks sistem (.env).</p>';
                console.error(error);
            }
        };

        fetchNarrative();
    });
</script>
@endsection
