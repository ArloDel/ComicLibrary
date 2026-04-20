@extends('layouts.app')

@section('title', 'Koleksiku')

@section('content')
<!-- Filter Area -->
<header class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6 animate-fade-in relative z-20 px-4 md:px-0">
    <div>
        <h1 class="font-headline text-5xl md:text-7xl font-black tracking-tighter uppercase mb-4 text-glow drop-shadow-2xl text-white">Perpustakaan</h1>
        <p class="inline-flex items-center gap-3 px-1 py-1 font-label text-[10px] tracking-[0.4em] text-white/60 uppercase font-bold">
            <span class="w-1.5 h-1.5 bg-primary rounded-full animate-pulse shadow-[0_0_8px_rgba(183,16,42,0.8)]"></span>
            Kapasitas: <span class="text-white">{{ $comics->count() }}</span> Entitas Terindeks
        </p>
    </div>
    
    <div class="flex flex-col sm:flex-row items-center gap-4 w-full md:w-auto mt-4 md:mt-0">
        <!-- Quick Search -->
        <form action="{{ route('comics.index') }}" method="GET" class="relative w-full sm:flex-1 md:w-[300px]">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-white/40 text-[18px]">search</span>
            <!-- preserve other filters -->
            @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
            @if(request('tag')) <input type="hidden" name="tag" value="{{ request('tag') }}"> @endif
            @if(request('author')) <input type="hidden" name="author" value="{{ request('author') }}"> @endif
            @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
            
            <input type="text" name="search" value="{{ request('search') }}" placeholder="CARI ARSIP..." 
                   class="w-full bg-[#030604]/80 border border-white/10 text-white font-label text-[10px] tracking-[0.2em] px-12 py-3.5 rounded-full outline-none focus:border-primary/50 focus:bg-black/80 transition-all uppercase placeholder-white/20 shadow-lg">
        </form>

        <!-- Tactical Filter Toggle -->
        <button id="toggleFilterBtn" type="button" class="w-full sm:w-auto bg-primary/10 hover:bg-primary/20 text-primary border border-primary/40 px-6 py-3.5 rounded-full font-label text-[10px] uppercase tracking-[0.3em] font-bold transition-all shadow-[0_0_15px_rgba(183,16,42,0.2)] hover:shadow-[0_0_20px_rgba(183,16,42,0.5)] flex items-center justify-center gap-3 flex-shrink-0">
            <span class="material-symbols-outlined text-[16px]">tune</span> Filter Spasial
        </button>
    </div>
</header>
<div class="w-full h-px bg-gradient-to-r from-white/10 to-transparent mb-12 hidden md:block"></div>

<!-- Active Filter Badges -->
@if(request()->only(['search', 'status', 'tag', 'author']))
<div class="flex flex-wrap gap-3 mb-8 px-4 md:px-0 z-20 relative">
    <a href="{{ route('comics.index') }}" class="font-label text-[9px] tracking-[0.3em] font-bold text-white/50 hover:text-white border border-white/20 px-3 py-1.5 rounded-full flex items-center gap-2 transition-colors">
        <span class="material-symbols-outlined text-[12px]">close</span> RESET FILTER
    </a>
    
    @if(request('search'))
        <span class="font-label text-[9px] tracking-[0.3em] font-bold text-primary border border-primary/30 bg-primary/10 px-3 py-1.5 rounded-full">Query: {{ request('search') }}</span>
    @endif
    @if(request('status'))
        <span class="font-label text-[9px] tracking-[0.3em] font-bold text-primary border border-primary/30 bg-primary/10 px-3 py-1.5 rounded-full">Status: {{ request('status') }}</span>
    @endif
    @if(request('tag'))
        <span class="font-label text-[9px] tracking-[0.3em] font-bold text-primary border border-primary/30 bg-primary/10 px-3 py-1.5 rounded-full">Tag: {{ request('tag') }}</span>
    @endif
    @if(request('author'))
        <span class="font-label text-[9px] tracking-[0.3em] font-bold text-primary border border-primary/30 bg-primary/10 px-3 py-1.5 rounded-full">Kurator: {{ request('author') }}</span>
    @endif
</div>
@endif

<!-- Parallax Background blobs for library -->
<div class="fixed inset-0 z-0 pointer-events-none overflow-hidden mix-blend-screen opacity-40">
    <div class="absolute top-[20%] right-[-10%] w-[800px] h-[800px] bg-primary/20 rounded-full blur-[200px] bg-parallax"></div>
    <div class="absolute bottom-[0%] left-[-10%] w-[600px] h-[600px] bg-[#0c2e15]/60 rounded-full blur-[150px] bg-parallax"></div>
</div>

<!-- Frameless Fluid Grid -->
<section class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-x-6 gap-y-16 grid-flow-row-dense relative z-10 perspective-1000 px-4 md:px-0 transition-transform duration-700 ease-out origin-left" id="mainGrid">
    @forelse($comics as $loopIndex => $comic)

        @if(($loopIndex + 1) % 5 == 0)
            <!-- Featured Size (2x2) - Frameless layout with image base -->
            <article class="col-span-2 row-span-2 tilt-card block animate-fade-up group" style="animation-delay: {{ min((($loopIndex % 15) * 50), 600) }}ms;">
                <a href="{{ route('comics.show', $comic) }}" class="relative h-full w-full flex flex-col cursor-pointer">
                    <!-- Image Box -->
                    <div class="card-tilt-target relative overflow-hidden rounded-[32px] bg-[#0a160c] mb-6 shadow-2xl group-hover:shadow-[0_20px_60px_rgba(183,16,42,0.15)] transition-all duration-700 w-full" style="aspect-ratio: 4/5;">
                        <img alt="{{ $comic->title }}" 
                             class="absolute inset-0 w-[110%] h-[110%] object-cover object-top opacity-70 group-hover:scale-105 group-hover:opacity-100 transition-all duration-1000 cover-parallax origin-center" 
                             src="{{ $comic->cover_image ? asset($comic->cover_image) : '' }}"/>
                        <div class="absolute inset-0 bg-gradient-to-t from-[#020603] via-[#020603]/40 to-transparent opacity-90 group-hover:opacity-70 transition-opacity duration-500"></div>
                        
                        <!-- Internal overlays -->
                        <div class="absolute top-6 left-6 right-6 flex justify-between items-start">
                            @if($comic->status == 'reading')
                                <span class="bg-primary-fixed/10 backdrop-blur-md border border-primary/30 text-primary-fixed font-label text-[9px] tracking-[0.3em] px-4 py-2 rounded-full uppercase shadow-[0_0_15px_rgba(183,16,42,0.8)] font-bold">FOCUS</span>
                            @else
                                <span></span> <!-- Spacer -->
                            @endif
                            <span class="bg-black/60 backdrop-blur-md text-white font-label text-[9px] tracking-[0.3em] px-3 py-1.5 rounded-full uppercase font-bold border border-white/10">{{ $comic->statusLabel() }}</span>
                        </div>
                        
                        <!-- Tags sitting inside bottom of image to save space -->
                        @if($comic->tags->isNotEmpty())
                        <div class="absolute bottom-6 left-6 right-6 flex flex-wrap gap-2">
                            @foreach($comic->tags->take(3) as $tag)
                                <span class="bg-white/5 backdrop-blur-sm text-white/90 px-3.5 py-1.5 rounded-full text-[9px] font-label uppercase tracking-[0.3em] border border-white/20">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    
                    <!-- Free Metadata Block -->
                    <div class="flex flex-col pl-4 border-l-2 border-primary/40 relative">
                        <h4 class="font-headline font-black text-3xl md:text-5xl text-white tracking-tighter uppercase leading-[0.9] mb-3 text-glow group-hover:drop-shadow-[0_0_20px_rgba(255,255,255,0.8)] transition-all">{{ $comic->title }}</h4>
                        <span class="font-label text-[10px] tracking-[0.3em] text-[#8aab8c] uppercase font-bold">{{ $comic->author }}</span>
                    </div>
                </a>
            </article>
        @else
            <!-- Standard Size (1x1) - Frameless -->
            <article class="col-span-1 tilt-card block animate-fade-up group" style="animation-delay: {{ min((($loopIndex % 15) * 50), 600) }}ms;">
                <a href="{{ route('comics.show', $comic) }}" class="flex flex-col h-full w-full cursor-pointer">
                    <!-- Image container -->
                    <div class="card-tilt-target relative overflow-hidden rounded-[20px] bg-[#080f0a] shadow-xl group-hover:shadow-[0_15px_40px_rgba(183,16,42,0.15)] transition-all duration-700 mb-5" style="aspect-ratio: 2/3;">
                        <img alt="{{ $comic->title }}" 
                             class="absolute inset-0 w-full h-[105%] object-cover opacity-80 group-hover:scale-105 group-hover:opacity-100 transition-all duration-700 origin-center" 
                             src="{{ $comic->cover_image ? asset($comic->cover_image) : '' }}"/>
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-[#020603]/90 via-transparent to-transparent opacity-80 z-0"></div>
                        
                        <!-- Top Badges -->
                        <div class="absolute top-3 right-3 z-10 flex gap-2">
                             @if(strtolower($comic->priority ?? '') == 'extreme')
                                <span class="bg-black/60 backdrop-blur-md px-2 py-1 rounded-full text-[10px] font-label font-bold text-primary shadow-[0_0_15px_rgba(183,16,42,0.8)] border border-primary/30 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[14px]">whatshot</span>
                                </span>
                            @endif
                        </div>
                        
                        <div class="absolute bottom-4 right-4 z-10">
                            @if($comic->status == 'completed' || $comic->status == 'reading')
                                <span class="bg-[#b7102a]/90 backdrop-blur-md text-white font-label text-[8px] tracking-[0.3em] px-3 py-1.5 rounded-full uppercase shadow-lg shadow-primary/60 font-bold">{{ $comic->statusLabel() }}</span>
                            @else
                                <span class="bg-black/60 backdrop-blur-md border border-white/10 text-white/80 font-label text-[8px] tracking-[0.3em] px-3 py-1.5 rounded-full uppercase font-bold">{{ $comic->statusLabel() }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Metadata below image (Frameless) -->
                    <div class="flex flex-col flex-1 pl-3 border-l border-white/10 group-hover:border-primary/50 transition-colors">
                        <h4 class="font-headline font-black text-lg tracking-tight uppercase leading-snug mb-2 line-clamp-2 text-white group-hover:text-primary-fixed drop-shadow-md transition-colors" title="{{ $comic->title }}">{{ $comic->title }}</h4>
                        <span class="font-label text-[9px] tracking-[0.3em] text-[#8aab8c] uppercase truncate mb-3" title="{{ $comic->author }}">{{ $comic->author }}</span>
                        
                        <div class="mt-auto pt-1">
                            @if($comic->tags->isNotEmpty())
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($comic->tags->take(2) as $tag)
                                        <span class="text-white/40 truncate max-w-[80px] text-[8px] font-label uppercase tracking-[0.3em]">#{{ $tag->name }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </a>
            </article>
        @endif

    @empty
        <div class="col-span-full py-32 text-center flex flex-col items-center justify-center mx-4">
            <div class="w-32 h-32 rounded-full border border-dashed border-white/20 flex flex-col items-center justify-center mb-8">
                <span class="material-symbols-outlined text-4xl text-white/10 drop-shadow-xl">manage_search</span>
            </div>
            <p class="font-label tracking-[0.4em] text-white/30 uppercase text-[10px] font-bold leading-relaxed max-w-sm">
                Sistem gagal menemukan anomali.<br>Konfigurasi ulang radar spasial Anda.
            </p>
            <a href="{{ route('comics.index') }}" class="mt-8 bg-white/5 hover:bg-primary/20 text-white/80 hover:text-primary border border-white/10 hover:border-primary/40 transition-all duration-300 px-6 py-3 rounded-full font-label text-[9px] tracking-[0.3em] uppercase font-bold">
                Reset Pencarian
            </a>
        </div>
    @endforelse
</section>

<!-- Frameless FAB -->
<a href="{{ route('comics.create') }}" class="fixed bottom-8 right-8 z-[60] w-14 h-14 rounded-full bg-white text-black flex items-center justify-center hover:scale-110 hover:-translate-y-2 transition-all duration-300 group shadow-[0_4px_30px_rgba(255,255,255,0.4)] hover:shadow-[0_8px_40px_rgba(255,255,255,0.6)] cursor-pointer">
    <div class="absolute inset-0 bg-primary/20 rounded-full scale-0 group-hover:scale-100 transition-transform duration-300 ease-out"></div>
    <span class="material-symbols-outlined relative z-10 text-2xl transition-colors font-bold group-hover:text-primary">add</span>
</a>

<!-- ============================================== -->
<!-- HOLOGRAPHIC TACTICAL FILTER SIDEBAR (SLIDE-OUT) -->
<!-- ============================================== -->
<div id="filterOverlay" class="fixed inset-0 bg-[#020603]/80 backdrop-blur-sm z-[90] opacity-0 pointer-events-none transition-opacity duration-500"></div>

<aside id="filterSidebar" class="fixed top-0 right-0 h-full w-full sm:w-[420px] bg-[#061008]/95 backdrop-blur-2xl border-l border-primary/30 shadow-[-30px_0_60px_rgba(0,0,0,0.8)] z-[100] translate-x-full transition-transform duration-500 ease-[cubic-bezier(0.19,1,0.22,1)] flex flex-col">
    <!-- Header -->
    <div class="p-8 border-b border-primary/20 flex justify-between items-center bg-gradient-to-r from-transparent to-primary/5">
        <div class="flex items-center gap-4">
            <span class="w-1.5 h-1.5 bg-primary rounded-full animate-pulse shadow-[0_0_8px_rgba(183,16,42,0.8)]"></span>
            <h2 class="font-headline font-black uppercase tracking-tighter text-2xl text-white text-glow">Terminal Pencarian</h2>
        </div>
        <button id="closeFilterBtn" class="text-white/40 hover:text-primary transition-colors p-2 rounded-full hover:bg-primary/10">
            <span class="material-symbols-outlined text-[20px]">close</span>
        </button>
    </div>

    <!-- Form Content -->
    <form action="{{ route('comics.index') }}" method="GET" class="flex flex-col flex-1 overflow-y-auto custom-scroll p-8 space-y-10">
        
        <!-- Search Keyword -->
        <div>
            <label class="font-label text-[9px] tracking-[0.4em] font-bold text-primary uppercase block mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-[14px]">search</span> Kata Kunci
            </label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Judul / Pengarang..." class="w-full bg-[#030604] border border-white/10 text-white rounded-xl px-5 py-4 outline-none focus:border-primary/50 text-sm font-label tracking-[0.1em] uppercase transition-colors shadow-inner">
        </div>

        <!-- Sorting -->
        <div>
            <label class="font-label text-[9px] tracking-[0.4em] font-bold text-primary uppercase block mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-[14px]">sort</span> Susun Berdasarkan
            </label>
            <div class="relative">
                <select name="sort" class="w-full bg-[#030604] border border-white/10 text-white/80 rounded-xl px-5 py-4 outline-none appearance-none focus:border-primary/50 text-xs font-label tracking-[0.2em] uppercase transition-colors cursor-pointer">
                    <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>A ➜ Z (Default)</option>
                    <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Z ➜ A</option>
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Ekstraksi Terbaru</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Tertua / Klasik</option>
                </select>
                <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-white/40 pointer-events-none">unfold_more</span>
            </div>
        </div>

        <!-- Status Filter -->
        <div>
            <label class="font-label text-[9px] tracking-[0.4em] font-bold text-primary uppercase block mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-[14px]">pending_actions</span> Status Terminasi
            </label>
            <div class="grid grid-cols-2 gap-3">
                @php $currentStatus = request('status'); @endphp
                
                <label class="cursor-pointer">
                    <input type="radio" name="status" value="" class="peer sr-only" {{ !$currentStatus ? 'checked' : '' }}>
                    <div class="text-center font-label text-[9px] tracking-[0.2em] font-bold p-3 rounded-xl border border-white/5 bg-white/5 text-white/40 peer-checked:border-primary peer-checked:bg-primary/20 peer-checked:text-primary transition-all uppercase">
                        Semua Status
                    </div>
                </label>
                <label class="cursor-pointer">
                    <input type="radio" name="status" value="reading" class="peer sr-only" {{ $currentStatus == 'reading' ? 'checked' : '' }}>
                    <div class="text-center font-label text-[9px] tracking-[0.2em] font-bold p-3 rounded-xl border border-white/5 bg-white/5 text-white/40 peer-checked:border-primary peer-checked:bg-primary/20 peer-checked:text-primary transition-all uppercase">
                        Berjalan
                    </div>
                </label>
                <label class="cursor-pointer">
                    <input type="radio" name="status" value="completed" class="peer sr-only" {{ $currentStatus == 'completed' ? 'checked' : '' }}>
                    <div class="text-center font-label text-[9px] tracking-[0.2em] font-bold p-3 rounded-xl border border-white/5 bg-white/5 text-white/40 peer-checked:border-primary peer-checked:bg-primary/20 peer-checked:text-primary transition-all uppercase">
                        Tamat
                    </div>
                </label>
                <label class="cursor-pointer">
                    <input type="radio" name="status" value="plan_to_read" class="peer sr-only" {{ $currentStatus == 'plan_to_read' ? 'checked' : '' }}>
                    <div class="text-center font-label text-[9px] tracking-[0.2em] font-bold p-3 rounded-xl border border-white/5 bg-white/5 text-white/40 peer-checked:border-primary peer-checked:bg-primary/20 peer-checked:text-primary transition-all uppercase">
                        Menunggu
                    </div>
                </label>
            </div>
        </div>

        <!-- Author / Kurator Filter -->
        <div>
            <label class="font-label text-[9px] tracking-[0.4em] font-bold text-primary uppercase block mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-[14px]">face</span> Entitas Kreator
            </label>
            <div class="relative">
                <select name="author" class="w-full bg-[#030604] border border-white/10 text-white/80 rounded-xl px-5 py-4 outline-none appearance-none focus:border-primary/50 text-xs font-label tracking-[0.2em] uppercase transition-colors cursor-pointer">
                    <option value="">Deteksi Semua Kreator</option>
                    @foreach($allAuthors ?? [] as $authorData)
                        <option value="{{ $authorData }}" {{ request('author') == $authorData ? 'selected' : '' }}>{{ $authorData }}</option>
                    @endforeach
                </select>
                <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-white/40 pointer-events-none">unfold_more</span>
            </div>
        </div>

        <!-- Tag Filter System -->
        <div>
            <label class="font-label text-[9px] tracking-[0.4em] font-bold text-primary uppercase block mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-[14px]">label</span> Anomali Genre
            </label>
            <div class="flex flex-wrap gap-2.5 max-h-[160px] overflow-y-auto custom-scroll pr-2">
                @php $currentTag = request('tag'); @endphp
                
                <label class="cursor-pointer">
                    <input type="radio" name="tag" value="" class="peer sr-only" {{ !$currentTag ? 'checked' : '' }}>
                    <div class="font-label text-[9px] tracking-[0.2em] font-bold px-4 py-2 rounded-full border border-white/5 bg-white/5 text-white/40 peer-checked:border-primary peer-checked:bg-primary/20 peer-checked:text-primary transition-all uppercase">
                        #SEMUA_TAG
                    </div>
                </label>

                @foreach($allTags ?? [] as $tagData)
                <label class="cursor-pointer">
                    <input type="radio" name="tag" value="{{ $tagData }}" class="peer sr-only" {{ $currentTag == $tagData ? 'checked' : '' }}>
                    <div class="font-label text-[9px] tracking-[0.2em] font-bold px-4 py-2 rounded-full border border-white/5 bg-white/5 text-white/40 peer-checked:border-primary peer-checked:bg-primary/20 peer-checked:text-primary transition-all uppercase shadow-sm">
                        #{{ $tagData }}
                    </div>
                </label>
                @endforeach
            </div>
        </div>

        <div class="flex-1"></div>

        <!-- Action Footer -->
        <div class="pt-8 border-t border-white/5 grid grid-cols-2 gap-4 pb-12 sm:pb-0 z-10 bg-[#061008]/95 sticky bottom-0">
            <a href="{{ route('comics.index') }}" class="flex items-center justify-center bg-transparent border border-white/10 hover:border-white/30 hover:bg-white/5 text-white/60 py-4 rounded-xl font-label text-[10px] tracking-[0.3em] font-bold uppercase transition-all duration-300">
                Bersihkan
            </a>
            <button type="submit" class="flex items-center justify-center gap-2 bg-primary hover:bg-[#ff1a3d] text-white py-4 rounded-xl font-label text-[10px] tracking-[0.3em] font-bold uppercase shadow-[0_0_15px_rgba(183,16,42,0.4)] hover:shadow-[0_0_25px_rgba(183,16,42,0.7)] transition-all duration-300 hover:-translate-y-1">
                <span class="material-symbols-outlined text-[16px]">radar</span> Pindai Area
            </button>
        </div>
    </form>
</aside>

@endsection

@section('extra_css')
<style>
    .perspective-1000 { perspective: 1500px; transform-style: preserve-3d; }
    .custom-scroll::-webkit-scrollbar { width: 4px; }
    .custom-scroll::-webkit-scrollbar-thumb { background: rgba(183,16,42,0.3); border-radius: 99px; }
    .custom-scroll::-webkit-scrollbar-thumb:hover { background: rgba(183,16,42,0.8); }
</style>
@endsection

@section('fab')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // 3D Tilt Effect applied just to images
    const tiltCards = document.querySelectorAll('.tilt-card');
    tiltCards.forEach(card => {
        const target = card.querySelector('.card-tilt-target');
        card.addEventListener('mousemove', e => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const xPct = (x / rect.width - 0.5) * 12; 
            const yPct = (y / rect.height - 0.5) * -12;
            target.style.transform = `rotateY(${xPct}deg) rotateX(${yPct}deg) scale3d(1.03, 1.03, 1.03)`;
        });
        card.addEventListener('mouseleave', () => {
            target.style.transform = `rotateY(0deg) rotateX(0deg) scale3d(1, 1, 1)`;
        });
    });

    // Simple Parallax scroll
    const bgs = document.querySelectorAll('.bg-parallax');
    const covers = document.querySelectorAll('.cover-parallax');
    
    let ticking = false;
    window.addEventListener('scroll', () => {
        if(!ticking) {
            requestAnimationFrame(() => {
                const sy = window.scrollY;
                bgs.forEach(bg => { bg.style.transform = `translateY(${sy * 0.25}px)`; });
                covers.forEach(c => {
                    const rect = c.getBoundingClientRect();
                    // if in viewport
                    if(rect.top < window.innerHeight && rect.bottom > 0) {
                        c.style.transform = `translateY(${(rect.top - window.innerHeight/2)* -0.15}px) scale(1.05)`;
                    }
                });
                ticking = false;
            });
            ticking = true;
        }
    }, {passive: true});

    // TACTICAL FILTER SIDEBAR LOGIC (SLIDE IN/OUT)
    const toggleBtn = document.getElementById('toggleFilterBtn');
    const closeBtn = document.getElementById('closeFilterBtn');
    const sidebar = document.getElementById('filterSidebar');
    const overlay = document.getElementById('filterOverlay');
    const mainGrid = document.getElementById('mainGrid');

    function openSidebar() {
        sidebar.classList.remove('translate-x-full');
        overlay.classList.remove('opacity-0', 'pointer-events-none');
        overlay.classList.add('opacity-100');
        
        // 3D Push back effect on main grid when sidebar opens
        if(window.innerWidth > 768) {
            mainGrid.style.transform = 'perspective(1500px) rotateY(-3deg) translateX(-2%) scale(0.95)';
            mainGrid.style.filter = 'blur(2px)';
            mainGrid.style.opacity = '0.4';
        }
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        sidebar.classList.add('translate-x-full');
        overlay.classList.add('opacity-0', 'pointer-events-none');
        overlay.classList.remove('opacity-100');
        
        // Restore main grid
        mainGrid.style.transform = '';
        mainGrid.style.filter = '';
        mainGrid.style.opacity = '1';
        document.body.style.overflow = '';
    }

    if (toggleBtn) toggleBtn.addEventListener('click', openSidebar);
    if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
    if (overlay) overlay.addEventListener('click', closeSidebar);
});
</script>
@endsection
