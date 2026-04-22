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
