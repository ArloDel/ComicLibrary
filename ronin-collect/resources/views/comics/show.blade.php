@extends('layouts.app')

@section('title', $comic->title . ' - Detail')

@section('extra_css')
<style>
/* For Detail Page, dark moody background */
body { background: #020603; }
.perspective-1000 { perspective: 1500px; transform-style: preserve-3d; }
</style>
@endsection

@section('content')

<!-- Hero Full Screen Parallax Background -->
<div class="fixed inset-0 z-0 h-[100vh] pointer-events-none overflow-hidden" id="hero-bg-container">
    <img alt="{{ $comic->title }}" 
         class="w-full h-[120%] object-cover object-top opacity-[0.25] select-none scale-105 transform origin-center mix-blend-screen" 
         id="hero-bg-img"
         src="{{ $comic->cover_image ? asset($comic->cover_image) : '' }}"/>
    <!-- Vignette / Fade out -->
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_transparent_0%,_#020603_100%)] opacity-95"></div>
    <div class="absolute inset-x-0 bottom-0 h-3/4 bg-gradient-to-t from-[#020603] via-[#020603]/90 to-transparent"></div>
</div>

<div class="max-w-[1400px] mx-auto py-12 relative z-10 pt-32 px-4 md:px-0">

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

<!-- Subsystem / Volumes (Frameless Layout) -->
<div class="relative pt-16 mt-12 border-t border-white/5 animate-fade-up animate-delay-200">
    <div class="absolute top-0 right-[20%] w-[600px] h-40 bg-primary/10 blur-[150px] rounded-full pointer-events-none mix-blend-screen"></div>

    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-6 mb-16 px-4 md:px-0">
        <div>
            <h3 class="font-headline font-black text-4xl md:text-5xl uppercase tracking-tighter text-white mb-3 text-glow">
                Log Sub_Volume
            </h3>
            <span class="font-label text-[10px] tracking-[0.4em] text-[#8aab8c] font-bold uppercase block pl-1">Total Entitas Terhubung: <span class="text-white">{{ $comic->volumes->count() }}</span></span>
        </div>
        <a href="{{ route('volumes.create', ['comic_id' => $comic->id]) }}" class="border-b-2 border-primary text-white pb-1 font-label text-[10px] tracking-[0.4em] font-bold hover:text-primary transition-colors flex items-center gap-2 uppercase">
            Tambah Volume Baru <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
        </a>
    </div>
    
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-x-6 gap-y-12 perspective-1000 px-4 md:px-0">
        @forelse($comic->volumes as $index => $volume)
        <div class="tilt-card group block w-full cursor-pointer" style="animation: fade-up 0.6s ease both; animation-delay: {{ $index*60 }}ms;" onclick="window.location='{{ route('volumes.edit', $volume) }}'">
            <!-- Pure Image Block -->
            <div class="card-tilt-target relative overflow-hidden rounded-[20px] w-full bg-[#080f0a] shadow-2xl group-hover:shadow-[0_15px_40px_rgba(183,16,42,0.15)] transition-all duration-700 mb-5 border border-transparent group-hover:border-primary/30" style="aspect-ratio: 2/3;">
                <img class="absolute inset-0 w-[110%] h-[110%] object-cover transition-all duration-700 group-hover:scale-105 opacity-80 group-hover:opacity-100" src="{{ $volume->cover_image ? asset($volume->cover_image) : ($comic->cover_image ? asset($comic->cover_image) : '') }}" />
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 group-hover:from-black/70 group-hover:via-transparent transition-colors"></div>
                
                <div class="absolute inset-x-0 top-1/2 -translate-y-1/2 text-center pointer-events-none origin-center transform group-hover:scale-[0.8] group-hover:opacity-0 transition-all duration-500">
                    <span class="text-[80px] font-black font-headline text-white/90 drop-shadow-2xl">{{ str_pad($volume->volume_number, 2, '0', STR_PAD_LEFT) }}</span>
                </div>

                <!-- Hover Text Overlay -->
                <div class="absolute bottom-4 inset-x-0 flex justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                    <span class="text-white font-headline font-bold text-lg tracking-tight drop-shadow-[0_0_10px_rgba(183,16,42,1)]">VOL. {{ $volume->volume_number }}</span>
                </div>
            </div>
            
            <!-- Metadata under Image -->
            <div class="flex justify-between items-start px-2 border-l border-white/10 group-hover:border-primary/50 transition-colors">
                <p class="font-label text-[9px] tracking-[0.3em] text-[#8aab8c] uppercase font-bold mb-1">
                    {{ $volume->acquisition_date ? $volume->acquisition_date->format('M Y') : 'WAKTU [N/A]' }}
                </p>
                <span class="text-white/20 group-hover:text-primary font-label text-[9px] tracking-[0.3em] font-bold uppercase transition-colors">EDIT</span>
            </div>
        </div>
        @empty
        <div class="col-span-full py-32 text-center flex flex-col justify-center items-center rounded-3xl w-full">
            <span class="material-symbols-outlined text-4xl text-white/10 mb-6 drop-shadow">bookmark_remove</span>
            <span class="font-label tracking-[0.4em] text-white/30 uppercase text-[10px] font-bold">Fragmen data kosong. Menunggu inisiasi volume.</span>
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
            target.style.transform = `rotateY(${xPct}deg) rotateX(${yPct}deg) scale3d(1.03, 1.03, 1.03)`;
        });
        card.addEventListener('mouseleave', () => {
            target.style.transform = `rotateY(0deg) rotateX(0deg) scale3d(1, 1, 1)`;
        });
    });
});
</script>
@endsection
