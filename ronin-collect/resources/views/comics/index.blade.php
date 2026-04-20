@extends('layouts.app')

@section('title', 'Koleksiku')

@section('content')
<!-- Filter Area -->
<header class="mb-14 flex flex-col md:flex-row md:items-end justify-between gap-8 animate-fade-in relative z-20">
    <div>
        <h1 class="font-headline text-5xl md:text-6xl font-black tracking-tighter uppercase mb-4 text-glow">Perpustakaan</h1>
        <p class="glass inline-flex px-4 py-1.5 rounded-full font-label text-[10px] tracking-[0.3em] text-primary uppercase font-bold border-primary/20 bg-primary/5">
            Kapasitas: {{ $comics->count() }} Entitas / Node Aktif
        </p>
    </div>
    
    <div class="flex flex-wrap gap-2">
        @if(request('tag'))
            <a href="{{ route('comics.index') }}" class="nav-pill-active flex items-center gap-2 font-label text-[10px] tracking-[0.2em] font-bold text-center border border-primary/30">
                {{ request('tag') }} 
                <span class="material-symbols-outlined text-[12px]">close</span>
            </a>
        @else
            <a href="{{ route('comics.index') }}" class="nav-pill-active font-label text-[10px] tracking-[0.2em] font-bold text-center flex items-center h-[34px] border border-primary/30 shadow-[0_0_15px_rgba(183,16,42,0.3)]">SEMUA</a>
        @endif
        
        <span class="glass px-5 py-1.5 rounded-full font-label text-[10px] tracking-[0.2em] text-white/60 hover:text-white uppercase cursor-pointer hover:bg-white/10 transition-colors h-[34px] flex items-center border-[0.5px] border-white/5">DIBACA</span>
        <span class="glass px-5 py-1.5 rounded-full font-label text-[10px] tracking-[0.2em] text-white/60 hover:text-white uppercase cursor-pointer hover:bg-white/10 transition-colors h-[34px] flex items-center border-[0.5px] border-white/5">FAVORIT</span>
    </div>
</header>

<!-- Parallax Background blobs for library -->
<div class="fixed inset-0 z-0 pointer-events-none overflow-hidden mix-blend-screen opacity-60">
    <div class="absolute top-[20%] right-[-10%] w-[800px] h-[800px] bg-primary/10 rounded-full blur-[150px] bg-parallax"></div>
    <div class="absolute bottom-[0%] left-[-10%] w-[600px] h-[600px] bg-[#0c2e15]/60 rounded-full blur-[120px] bg-parallax"></div>
</div>

<!-- Fluid Grid -->
<section class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-6 md:gap-7 grid-flow-row-dense relative z-10 perspective-1000">
    @forelse($comics as $loopIndex => $comic)

        @if(($loopIndex + 1) % 5 == 0)
            <!-- Featured Size Card (2x2) -->
            <article class="col-span-2 row-span-2 tilt-card block animate-fade-up" style="animation-delay: {{ min((($loopIndex % 15) * 50), 600) }}ms;">
                <a href="{{ route('comics.show', $comic) }}" class="relative h-full w-full flex flex-col min-h-[380px] md:min-h-[480px] glass-card card-tilt-target overflow-hidden group hover:border-primary/50 cursor-pointer">
                    <img alt="{{ $comic->title }}" 
                         class="absolute inset-0 w-[110%] h-[110%] object-cover object-top opacity-80 group-hover:scale-105 group-hover:opacity-100 transition-all duration-1000 cover-parallax origin-center" 
                         src="{{ $comic->cover_image ? asset($comic->cover_image) : '' }}"/>
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0a160c] via-[#0c1a0e]/60 to-transparent"></div>
                    
                    <div class="absolute bottom-0 left-0 p-8 w-full z-10 flex flex-col justify-end">
                        @if($comic->status == 'reading')
                            <span class="glass text-primary-fixed border-primary/30 font-label text-[9px] tracking-[0.2em] px-3.5 py-1 rounded-full uppercase mb-5 inline-flex shadow-[0_0_15px_rgba(183,16,42,0.8)] font-bold self-start backdrop-blur-md bg-primary/20">FOCUS ACHIEVE</span>
                        @endif
                        
                        <h4 class="font-headline font-black text-3xl md:text-5xl text-white tracking-tighter uppercase leading-[0.9] mb-5 text-glow group-hover:drop-shadow-[0_0_20px_rgba(255,255,255,0.5)] transition-all">{{ $comic->title }}</h4>
                        
                        @if($comic->tags->isNotEmpty())
                            <div class="flex flex-wrap gap-2 mb-6">
                                @foreach($comic->tags->take(3) as $tag)
                                    <span class="glass px-3 py-1 rounded-full text-white/80 bg-white/5 text-[9px] font-label uppercase tracking-[0.2em] border-white/20">{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        @endif
                        
                        <div class="flex flex-wrap gap-2 justify-between items-center border-t border-white/20 pt-5">
                            <span class="font-label text-[10px] tracking-[0.2em] text-white/60 uppercase">{{ $comic->author }}</span>
                            <span class="font-label text-[10px] tracking-[0.2em] text-primary uppercase font-bold drop-shadow-[0_0_5px_rgba(183,16,42,0.8)]">{{ $comic->statusLabel() }}</span>
                        </div>
                    </div>
                    <!-- Hover flare -->
                    <div class="absolute inset-0 bg-gradient-to-tr from-primary/10 via-transparent to-white/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                </a>
            </article>
        @else
            <!-- Standard Size Card (1x1) -->
            <article class="col-span-1 tilt-card block animate-fade-up" style="animation-delay: {{ min((($loopIndex % 15) * 50), 600) }}ms;">
                <a href="{{ route('comics.show', $comic) }}" class="flex flex-col h-full w-full glass-card card-tilt-target relative overflow-hidden group hover:border-primary/40 cursor-pointer">
                    <div class="relative overflow-hidden w-full rounded-t-2xl bg-[#080f0a]" style="aspect-ratio: 2/3;">
                        <img alt="{{ $comic->title }}" 
                             class="absolute inset-0 w-[110%] h-[110%] object-cover opacity-[0.85] group-hover:scale-[1.03] group-hover:opacity-100 transition-all duration-700 origin-center" 
                             src="{{ $comic->cover_image ? asset($comic->cover_image) : '' }}"/>
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0a160c] via-transparent to-transparent opacity-90 z-0 group-hover:opacity-70 transition-opacity"></div>
                        
                        <!-- Status Badge -->
                        <div class="absolute top-3 right-3 z-10 flex gap-2">
                             @if(strtolower($comic->priority ?? '') == 'extreme')
                                <span class="glass px-2 py-1 bg-black/60 rounded-full text-[10px] font-label font-bold text-primary shadow-[0_0_10px_rgba(183,16,42,0.8)] border-primary/30 flex items-center h-[24px]">
                                    <span class="material-symbols-outlined text-[12px]">whatshot</span>
                                </span>
                            @endif
                            @if($comic->status == 'completed' || $comic->status == 'reading')
                                <span class="bg-primary/90 backdrop-blur-md text-white font-label text-[8px] tracking-[0.2em] px-2.5 py-1 rounded-full uppercase shadow-lg shadow-primary/40 font-bold border border-primary-bright/30 h-[24px] flex items-center">{{ $comic->statusLabel() }}</span>
                            @else
                                <span class="glass text-white/80 bg-black/40 border-white/10 font-label text-[8px] tracking-[0.2em] px-2.5 py-1 rounded-full uppercase font-bold h-[24px] flex items-center">{{ $comic->statusLabel() }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="p-5 flex-1 flex flex-col -mt-10 z-10 pt-0 relative bg-gradient-to-t from-transparent via-[#0a160c]/50 to-transparent">
                        <h4 class="font-headline font-extrabold text-base tracking-tight uppercase leading-snug mb-3 line-clamp-2 drop-shadow-lg text-white group-hover:text-primary-fixed transition-colors mt-4" title="{{ $comic->title }}">{{ $comic->title }}</h4>
                        
                        <div class="mt-auto">
                            @if($comic->tags->isNotEmpty())
                                <div class="flex flex-wrap gap-1.5 mb-4">
                                    @foreach($comic->tags->take(2) as $tag)
                                        <span class="glass bg-white/5 border-white/10 text-white/70 px-2.5 py-0.5 rounded-full text-[8px] font-label uppercase tracking-widest">{{ $tag->name }}</span>
                                    @endforeach
                                    @if($comic->tags->count() > 2)
                                        <span class="text-white/40 px-1 py-0.5 text-[8px] font-label uppercase tracking-[0.2em]">+{{ $comic->tags->count() - 2 }}</span>
                                    @endif
                                </div>
                            @endif
                            <div class="flex justify-between items-end border-t border-white/10 pt-3">
                                <span class="font-label text-[9px] tracking-widest text-[#8aab8c] uppercase truncate flex-1 pr-2" title="{{ $comic->author }}">{{ $comic->author }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            </article>
        @endif

    @empty
        <div class="col-span-full py-32 text-center h-[50vh] flex flex-col items-center justify-center glass-card border-dashed border-white/10 bg-white/5 mx-4">
            <span class="material-symbols-outlined text-6xl text-white/20 mb-6 drop-shadow-xl text-glow">inventory_2</span>
            <p class="font-label tracking-[0.3em] text-white/40 uppercase text-[10px] font-bold">Arsip Kosong. Hubungi Kurator Tertinggi.</p>
        </div>
    @endforelse
</section>
@endsection

@section('extra_css')
<style>
    .perspective-1000 { perspective: 1200px; transform-style: preserve-3d; }
</style>
@endsection

@section('fab')
<!-- Default FAB styled as glowing glass node -->
<a href="{{ route('comics.create') }}" class="fixed bottom-8 right-8 z-[60] w-14 h-14 rounded-full glass bg-primary/10 backdrop-blur-xl border-primary/40 flex items-center justify-center hover:scale-110 hover:-translate-y-2 transition-all duration-300 group shadow-[0_4px_30px_rgba(183,16,42,0.4)] hover:shadow-[0_8px_40px_rgba(183,16,42,0.8)] cursor-pointer overflow-hidden">
    <div class="absolute inset-0 bg-primary/30 rounded-full scale-0 group-hover:scale-100 transition-transform duration-300 ease-out"></div>
    <span class="material-symbols-outlined text-primary-fixed group-hover:text-white relative z-10 text-2xl transition-colors drop-shadow-[0_0_5px_rgba(255,255,255,0.5)]">add</span>
</a>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // 3D Tilt Effect
    const tiltCards = document.querySelectorAll('.tilt-card');
    tiltCards.forEach(card => {
        const target = card.querySelector('.card-tilt-target');
        card.addEventListener('mousemove', e => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const xPct = (x / rect.width - 0.5) * 15; 
            const yPct = (y / rect.height - 0.5) * -15;
            target.style.transform = `rotateY(${xPct}deg) rotateX(${yPct}deg) scale3d(1.02, 1.02, 1.02)`;
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
                bgs.forEach(bg => { bg.style.transform = `translateY(${sy * 0.2}px)`; });
                covers.forEach(c => {
                    const rect = c.getBoundingClientRect();
                    // if in viewport
                    if(rect.top < window.innerHeight && rect.bottom > 0) {
                        c.style.transform = `translateY(${(rect.top - window.innerHeight/2)* -0.15}px) scale(1.1)`;
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
