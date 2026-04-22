<!-- Frameless Info Layout -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-12 md:gap-20 mb-32 animate-fade-up">
    <!-- Cover Poster -->
    <div class="lg:col-span-4 xl:col-span-3 perspective-1000">
        <div class="tilt-card relative group rounded-[24px] overflow-hidden drop-shadow-[0_30px_60px_rgba(0,0,0,0.8)]">
            <div class="card-tilt-target relative w-full h-full rounded-[24px] overflow-hidden bg-[#080f09]" style="aspect-ratio: 2/3;">
                <img alt="{{ $comic->title }}" class="w-full h-[105%] object-cover transition-transform duration-1000 group-hover:scale-[1.03]" src="{{ $comic->cover_image ? asset($comic->cover_image) : '' }}"/>
                <div class="absolute inset-0 border-[0.5px] border-white/20 rounded-[24px] pointer-events-none mix-blend-overlay"></div>
                <div class="absolute inset-0 bg-gradient-to-tr from-primary/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700 pointer-events-none mix-blend-screen"></div>
            </div>
        </div>
    </div>
    
    <!-- Meta Data (Text Pure) -->
    <div class="lg:col-span-8 xl:col-span-9 flex flex-col justify-center">
        <!-- Badges -->
        <div class="flex flex-wrap items-center gap-6 mb-8">
            <span class="font-label tracking-[0.4em] text-[10px] flex items-center gap-2 font-bold uppercase drop-shadow-[0_0_15px_rgba(183,16,42,0.8)] text-primary">
                <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                {{ $comic->statusLabel() }}
            </span>
            
            @if($comic->tags->isNotEmpty())
            <span class="flex items-center gap-4">
                <span class="w-12 h-[1px] bg-white/20"></span>
                <span class="flex flex-wrap gap-4">
                    @foreach($comic->tags as $index => $tag)
                        <a href="{{ route('comics.index', ['tag' => $tag->name]) }}" class="text-white/50 hover:text-white text-[9px] font-label font-bold uppercase tracking-[0.3em] transition-colors hover:underline underline-offset-4 decoration-primary">
                            #{{ $tag->name }}
                        </a>
                    @endforeach
                </span>
            </span>
            @endif
        </div>
        
        <h1 class="text-6xl md:text-8xl xl:text-[120px] font-headline font-black tracking-tighter text-white uppercase mb-6 leading-[0.8] text-glow drop-shadow-2xl">{{ $comic->title }}</h1>
        <h2 class="text-2xl md:text-3xl font-headline font-bold text-[#8aab8c] uppercase tracking-[0.2em] mb-12 drop-shadow-md">
            {{ $comic->author }}
        </h2>
        
        <!-- Frameless Description -->
        <div class="mb-14 pl-0 md:pl-8 md:border-l-2 border-primary/40 relative">
            <!-- Decorative quote mark -->
            <div class="absolute -left-12 top-0 text-[100px] text-white/5 font-headline font-black pointer-events-none leading-none hidden md:block">"</div>
            <p class="font-body text-xl md:text-2xl text-white/80 leading-relaxed font-medium mix-blend-screen max-w-4xl tracking-wide">
                {{ $comic->description ?? 'Deskripsi tidak tersedia dalam indeks arsip utama.' }}
            </p>
        </div>
        
        <!-- Controls - Minimalist Buttons -->
        <div class="flex flex-wrap items-center gap-6">
            <a href="{{ route('comics.edit', $comic) }}" class="border border-white/20 hover:border-white text-white px-8 py-4 rounded-full font-label text-[10px] tracking-[0.4em] uppercase font-bold transition-all flex items-center gap-3 group bg-black/20 backdrop-blur-sm">
                <span class="material-symbols-outlined text-[16px] group-hover:-rotate-12 transition-transform">edit_square</span> Konfigurasi
            </a>
            <form action="{{ route('comics.destroy', $comic) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-primary/70 px-6 py-4 font-label text-[10px] tracking-[0.4em] uppercase font-bold hover:text-primary transition-all flex items-center gap-2 group border-b border-transparent hover:border-primary" onclick="return confirm('Tindakan ini akan menghapus arsip selamanya. Lanjutkan destruksi?')">
                    <span class="material-symbols-outlined text-[16px] group-hover:scale-110 transition-transform">delete</span> Hapus
                </button>
            </form>
        </div>
    </div>
</div>
