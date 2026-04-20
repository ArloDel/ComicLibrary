@extends('layouts.app')

@section('title', $comic->title . ' - Detail')

@section('extra_css')
<style>
/* For Detail Page, lower the overall background lightness to make the hero parallax image pop */
body { background: #040804; }
.perspective-1000 { perspective: 1200px; transform-style: preserve-3d; }
</style>
@endsection

@section('content')

<!-- Hero Full Screen Parallax Background -->
<div class="fixed inset-0 z-0 h-[100vh] pointer-events-none overflow-hidden" id="hero-bg-container">
    <img alt="{{ $comic->title }}" 
         class="w-full h-[120%] object-cover object-top opacity-30 select-none scale-105 transform origin-center mix-blend-lighten" 
         id="hero-bg-img"
         src="{{ $comic->cover_image ? asset($comic->cover_image) : '' }}"/>
    <!-- Heavy Vignette + Bottom Fade to Match Background color -->
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_transparent_0%,_#040804_100%)] opacity-90"></div>
    <div class="absolute inset-x-0 bottom-0 h-2/3 bg-gradient-to-t from-[#040804] via-[#040804]/80 to-transparent"></div>
</div>

<div class="max-w-[1400px] mx-auto py-12 relative z-10 pt-32">

<!-- Info Glass Panel -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-12 mb-32 animate-fade-up">
    <!-- Small Cover Poster -->
    <div class="lg:col-span-4 xl:col-span-3 perspective-1000">
        <div class="tilt-card relative group rounded-[18px] overflow-hidden glass p-2 bg-white/5 border-white/10 glow-red">
            <div class="card-tilt-target relative w-full h-full rounded-xl overflow-hidden shadow-2xl bg-[#080f09]" style="aspect-ratio: 2/3;">
                <img alt="{{ $comic->title }}" class="w-full h-[110%] object-cover transition-transform duration-700 group-hover:scale-105" src="{{ $comic->cover_image ? asset($comic->cover_image) : '' }}"/>
                <div class="absolute inset-0 border border-white/10 rounded-xl pointer-events-none mix-blend-overlay"></div>
                <div class="absolute inset-0 bg-gradient-to-tr from-primary/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
            </div>
        </div>
    </div>
    
    <!-- Meta Data -->
    <div class="lg:col-span-8 xl:col-span-9 flex flex-col justify-center">
        <!-- Badges -->
        <div class="flex flex-wrap items-center gap-4 mb-6">
            <span class="glass bg-primary-dim/40 border-primary/50 text-primary-fixed-dim font-label tracking-[0.3em] text-[10px] py-1.5 px-4 rounded-full font-bold uppercase shadow-[0_0_20px_rgba(183,16,42,0.5)]">
                {{ $comic->statusLabel() }}
            </span>
            
            @if($comic->tags->isNotEmpty())
            <span class="flex items-center gap-3">
                <span class="w-12 h-[1px] bg-white/20"></span>
                <span class="flex flex-wrap gap-2">
                    @foreach($comic->tags as $index => $tag)
                        <a href="{{ route('comics.index', ['tag' => $tag->name]) }}" class="glass border-white/10 bg-white/5 text-white/70 hover:text-white hover:bg-white/10 rounded-full px-4 py-1.5 text-[9px] font-label font-bold uppercase tracking-[0.2em] transition-all">
                            {{ $tag->name }}
                        </a>
                    @endforeach
                </span>
            </span>
            @endif
        </div>
        
        <h1 class="text-7xl md:text-8xl xl:text-9xl font-headline font-black tracking-tighter text-white uppercase mb-4 leading-[0.85] text-glow drop-shadow-2xl">{{ $comic->title }}</h1>
        <h2 class="text-xl md:text-2xl font-headline font-bold text-primary uppercase tracking-widest mb-10 flex items-center gap-4 drop-shadow-lg">
            {{ $comic->author }}
            <div class="flex-1 h-px bg-gradient-to-r from-primary/50 to-transparent"></div>
        </h2>
        
        <div class="glass-card p-8 md:p-10 mb-10 bg-[#080f0a]/60 border-white/10 backdrop-blur-2xl">
            <p class="font-body text-lg md:text-xl text-white/80 leading-relaxed font-medium mix-blend-screen">
                {{ $comic->description ?? 'Metadata naratif tidak tersedia. Log kosong.' }}
            </p>
        </div>
        
        <!-- Controls -->
        <div class="flex flex-wrap items-center gap-4">
            <a href="{{ route('comics.edit', $comic) }}" class="glass bg-white/5 border-white/10 text-white px-8 py-3.5 rounded-full font-label text-xs tracking-[0.3em] uppercase font-bold hover:bg-white/15 hover:shadow-[0_0_20px_rgba(255,255,255,0.1)] transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-[16px]">edit_square</span> Ubah Parameter
            </a>
            <form action="{{ route('comics.destroy', $comic) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="glass bg-primary/10 border-primary/30 text-primary-fixed-dim px-8 py-3.5 rounded-full font-label text-xs tracking-[0.3em] uppercase font-bold hover:bg-primary/40 hover:border-primary hover:text-white transition-all flex items-center gap-2 shadow-[0_0_15px_rgba(183,16,42,0.2)]" onclick="return confirm('Tindakan ini akan menghapus arsip selamanya. Yakin?')">
                    <span class="material-symbols-outlined text-[16px]">delete</span> Hapus Entitas
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Volumes Subsystem -->
<div class="relative pt-16 mt-8 border-t border-white/10 animate-fade-up animate-delay-200">
    <div class="absolute top-0 right-[20%] w-[600px] h-32 bg-primary/10 blur-[120px] rounded-full pointer-events-none mix-blend-screen"></div>

    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-6 mb-12">
        <div>
            <h3 class="font-headline font-black text-4xl uppercase tracking-tighter text-white mb-2 flex items-center gap-3 text-glow">
                <span class="w-2 h-8 bg-primary rounded-full glow-red shadow-[0_0_10px_rgba(183,16,42,1)]"></span> Sub_Volume
            </h3>
            <span class="font-label text-[10px] tracking-[0.3em] text-[#8aab8c] font-bold uppercase block pl-5">Total Sub-Node Terindeks: <span class="text-white">{{ $comic->volumes->count() }}</span></span>
        </div>
        <a href="{{ route('volumes.create', ['comic_id' => $comic->id]) }}" class="glass bg-primary border-primary/50 text-white rounded-full px-6 py-3 font-label text-[10px] tracking-[0.3em] font-bold hover:shadow-[0_0_25px_rgba(183,16,42,0.8)] hover:-translate-y-1 transition-all flex items-center justify-center gap-2 uppercase">
            <span class="material-symbols-outlined text-[14px]">add</span> Inisiasi Volume
        </a>
    </div>
    
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-6 md:gap-8 perspective-1000">
        @forelse($comic->volumes as $index => $volume)
        <div class="tilt-card group block w-full h-full" style="animation: fade-up 0.6s ease both; animation-delay: {{ $index*60 }}ms;">
            <div class="card-tilt-target glass-card flex flex-col p-2.5 bg-white/5 border-white/10 hover:border-primary/50 rounded-2xl transition-colors cursor-pointerglow-red-hover">
                <div class="relative overflow-hidden rounded-[10px] w-full bg-[#080f0a]" style="aspect-ratio: 2/3;">
                    <img class="w-full h-[110%] object-cover transition-all duration-700 group-hover:scale-[1.03] blur-[1px] group-hover:blur-0 opacity-80 group-hover:opacity-100" src="{{ $volume->cover_image ? asset($volume->cover_image) : ($comic->cover_image ? asset($comic->cover_image) : '') }}" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 group-hover:from-black/60 group-hover:via-transparent transition-colors"></div>
                    
                    <div class="absolute inset-x-0 top-1/2 -translate-y-1/2 text-center pointer-events-none origin-center transform group-hover:scale-[0.8] group-hover:opacity-0 transition-all duration-500">
                        <span class="text-7xl font-black font-headline text-white/90 drop-shadow-2xl">{{ str_pad($volume->volume_number, 2, '0', STR_PAD_LEFT) }}</span>
                    </div>

                    <!-- Vol Hover Badge -->
                    <div class="absolute bottom-3 left-3 translate-y-8 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                        <span class="glass bg-primary/80 backdrop-blur border-primary-bright/30 text-white px-3.5 py-1 rounded-full font-headline font-bold text-sm tracking-tight shadow-[0_0_10px_rgba(183,16,42,0.8)]">VOL. {{ $volume->volume_number }}</span>
                    </div>
                </div>
                
                <div class="flex justify-between items-center mt-4 px-2 pb-1.5 border-t border-white/5 pt-3">
                    <p class="font-label text-[9px] tracking-[0.2em] text-[#8aab8c] uppercase font-bold">
                        {{ $volume->acquisition_date ? $volume->acquisition_date->format('M Y') : 'Unknown' }}
                    </p>
                    <a href="{{ route('volumes.edit', $volume) }}" class="text-primary hover:text-white font-label text-[9px] tracking-[0.3em] font-bold uppercase transition-colors">EDIT</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-24 text-center flex flex-col justify-center items-center glass-card rounded-3xl bg-white/5 border-dashed border-white/10 mx-2">
            <span class="material-symbols-outlined text-4xl text-white/20 mb-4 drop-shadow">bookmark_remove</span>
            <span class="font-label tracking-[0.3em] text-white/40 uppercase text-xs font-bold">Arsip terfragmentasi. Indeks volume kosong.</span>
        </div>
        @endforelse
    </div>
</div>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Hero Bg Parallax Focus
    const bgImg = document.getElementById('hero-bg-img');
    let ticking = false;
    window.addEventListener('scroll', () => {
        if(!ticking) {
            window.requestAnimationFrame(() => {
                const s = window.scrollY;
                if(s < window.innerHeight) {
                    bgImg.style.transform = `translateY(${s * 0.4}px) scale(1.05)`;
                }
                ticking = false;
            });
            ticking = true;
        }
    }, {passive:true});

    // 3D Tilt Effect
    const tiltCards = document.querySelectorAll('.tilt-card');
    tiltCards.forEach(card => {
        const target = card.querySelector('.card-tilt-target');
        card.addEventListener('mousemove', e => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const xPct = (x / rect.width - 0.5) * 14; 
            const yPct = (y / rect.height - 0.5) * -14;
            target.style.transform = `rotateY(${xPct}deg) rotateX(${yPct}deg) scale3d(1.02, 1.02, 1.02)`;
        });
        card.addEventListener('mouseleave', () => {
            target.style.transform = `rotateY(0deg) rotateX(0deg) scale3d(1, 1, 1)`;
        });
    });
});
</script>
@endsection
