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
