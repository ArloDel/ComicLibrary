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
