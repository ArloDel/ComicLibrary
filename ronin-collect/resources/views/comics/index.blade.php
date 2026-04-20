@extends('layouts.app')

@section('title', 'Koleksiku')

@section('content')
<!-- Filter Area -->
<header class="mb-16 flex flex-col md:flex-row md:items-end justify-between gap-8 animate-fade-in relative z-20 px-4 md:px-0">
    <div>
        <h1 class="font-headline text-5xl md:text-7xl font-black tracking-tighter uppercase mb-4 text-glow drop-shadow-2xl text-white">Perpustakaan</h1>
        <p class="inline-flex items-center gap-3 px-1 py-1 font-label text-[10px] tracking-[0.4em] text-white/60 uppercase font-bold">
            <span class="w-1.5 h-1.5 bg-primary rounded-full animate-pulse shadow-[0_0_8px_rgba(183,16,42,0.8)]"></span>
            Kapasitas: <span class="text-white">{{ $comics->count() }}</span> Entitas Terindeks
        </p>
    </div>
    
    <div class="flex flex-wrap gap-3">
        @if(request('tag'))
            <a href="{{ route('comics.index') }}" class="flex items-center gap-2 font-label text-[10px] tracking-[0.3em] font-bold text-center border-b-2 border-primary text-primary pb-1">
                {{ request('tag') }} 
                <span class="material-symbols-outlined text-[14px]">close</span>
            </a>
        @else
            <a href="{{ route('comics.index') }}" class="font-label text-[10px] tracking-[0.3em] font-bold text-center flex items-center border-b-2 border-white text-white pb-1">SEMUA INDEX</a>
        @endif
        
        <span class="font-label text-[10px] tracking-[0.3em] text-white/40 hover:text-white uppercase cursor-pointer transition-colors flex items-center border-b-2 border-transparent hover:border-white/50 pb-1">DIBACA</span>
        <span class="font-label text-[10px] tracking-[0.3em] text-white/40 hover:text-white uppercase cursor-pointer transition-colors flex items-center border-b-2 border-transparent hover:border-white/50 pb-1">FAVORIT</span>
    </div>
</header>
<div class="w-full h-px bg-gradient-to-r from-white/10 to-transparent mb-12 hidden md:block"></div>

<!-- Parallax Background blobs for library -->
<div class="fixed inset-0 z-0 pointer-events-none overflow-hidden mix-blend-screen opacity-40">
    <div class="absolute top-[20%] right-[-10%] w-[800px] h-[800px] bg-primary/20 rounded-full blur-[200px] bg-parallax"></div>
    <div class="absolute bottom-[0%] left-[-10%] w-[600px] h-[600px] bg-[#0c2e15]/60 rounded-full blur-[150px] bg-parallax"></div>
</div>

<!-- Frameless Fluid Grid -->
<section class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-x-6 gap-y-16 grid-flow-row-dense relative z-10 perspective-1000 px-4 md:px-0">
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
                <span class="material-symbols-outlined text-4xl text-white/10 drop-shadow-xl">inventory_2</span>
            </div>
            <p class="font-label tracking-[0.4em] text-white/30 uppercase text-[10px] font-bold">Arsip Kosong. Hubungi Kurator.</p>
        </div>
    @endforelse
</section>

<!-- Frameless FAB -->
@endsection

@section('extra_css')
<style>
    .perspective-1000 { perspective: 1500px; transform-style: preserve-3d; }
</style>
@endsection

@section('fab')
<a href="{{ route('comics.create') }}" class="fixed bottom-8 right-8 z-[60] w-14 h-14 rounded-full bg-white text-black flex items-center justify-center hover:scale-110 hover:-translate-y-2 transition-all duration-300 group shadow-[0_4px_30px_rgba(255,255,255,0.4)] hover:shadow-[0_8px_40px_rgba(255,255,255,0.6)] cursor-pointer">
    <div class="absolute inset-0 bg-primary/20 rounded-full scale-0 group-hover:scale-100 transition-transform duration-300 ease-out"></div>
    <span class="material-symbols-outlined relative z-10 text-2xl transition-colors font-bold group-hover:text-primary">add</span>
</a>

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
});
</script>
@endsection
