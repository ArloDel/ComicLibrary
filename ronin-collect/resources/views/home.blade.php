@extends('layouts.app')

@section('title', 'Dasbor')

@section('content')
<!-- Parallax BG Layer -->
<div class="fixed inset-0 z-[-1] pointer-events-none overflow-hidden">
    <div id="blob1" class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] bg-primary/10 rounded-full blur-[100px] parallax-blob"></div>
    <div id="blob2" class="absolute top-[40%] right-[-5%] w-[600px] h-[600px] bg-[#0c2e15]/40 rounded-full blur-[120px] parallax-blob"></div>
    <div id="blob3" class="absolute bottom-[-10%] left-[20%] w-[400px] h-[400px] bg-primary/5 rounded-full blur-[80px] parallax-blob"></div>
</div>

<div class="relative z-10 pt-12 pb-24">
    <!-- Hero Section -->
    <header class="mb-24 px-4 md:px-0" id="hero-section">
        <div class="flex flex-col md:flex-row justify-between items-end gap-12">
            <div id="hero-text" class="will-change-transform">
                <p class="font-label text-primary tracking-[0.4em] font-bold text-xs uppercase mb-6 pl-1 drop-shadow-[0_0_8px_rgba(183,16,42,0.8)]">Sistem_Arsip_v.01</p>
                <h1 class="text-7xl md:text-9xl/[.85] font-black font-headline tracking-tighter uppercase text-glow drop-shadow-2xl">
                    Sang<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary via-primary-bright to-white/80">Kurator</span><br>
                    Ronin.
                </h1>
                <p class="mt-10 max-w-xl text-lg md:text-xl text-on-surface-variant font-body leading-relaxed font-medium mix-blend-screen text-white/70">
                    Suaka digital terkurasi untuk koleksi Shonen berenergi tinggi dan minimalisme Jepang yang disiplin. Tidak ada dinding yang membatasi.
                </p>
            </div>
            
            <div class="flex flex-col items-end min-w-[240px] text-right reveal-on-scroll">
                <span class="font-label text-[10px] tracking-[0.3em] text-white/30 uppercase mb-2">Status Terminal</span>
                <span class="font-headline font-black text-3xl text-primary uppercase leading-tight mb-4 drop-shadow-[0_0_10px_rgba(183,16,42,0.6)]">Kurator Utama</span>
                <div class="w-24 h-[1px] bg-primary/50 my-3 relative">
                    <span class="absolute right-0 top-1/2 -translate-y-1/2 w-1.5 h-1.5 bg-primary rounded-full animate-pulse"></span>
                </div>
                <span class="font-label text-[10px] tracking-[0.3em] text-white/40 uppercase font-bold">Pembaruan: {{ date('d.m.Y') }}</span>
                <span class="font-label text-[10px] tracking-[0.3em] text-white/30 uppercase mt-1">Arsip Pusat Tokyo</span>
            </div>
        </div>
    </header>

    <!-- Stats Archival Telemetry - Frameless -->
    <div class="w-full h-px bg-gradient-to-r from-transparent via-white/10 to-transparent my-10"></div>
    <section class="grid grid-cols-1 md:grid-cols-3 gap-12 lg:gap-20 mb-24 reveal-on-scroll px-4 md:px-0">
        <!-- Value -->
        <div class="group">
            <span class="font-label text-[10px] tracking-[0.3em] text-white/40 uppercase block mb-6 font-bold flex items-center gap-3">
                <span class="material-symbols-outlined text-[16px] text-primary drop-shadow-[0_0_5px_rgba(183,16,42,0.8)]">payments</span> Nilai Total
            </span>
            <div class="text-5xl md:text-[70px] font-headline font-black tracking-tighter text-white flex items-start group-hover:-translate-y-2 transition-transform duration-500 drop-shadow-lg">
                <span class="text-primary text-2xl mt-1.5 mr-3 font-bold font-label tracking-widest drop-shadow-[0_0_10px_rgba(183,16,42,0.6)]">Rp</span>
                {{ number_format($totalInvestment, 0, ',', '.') }}
            </div>
        </div>

        <!-- Count -->
        <div class="group relative overflow-hidden md:border-l border-white/5 md:pl-12 lg:pl-20 border-dashed">
            <span class="font-label text-[10px] tracking-[0.3em] text-white/40 uppercase block mb-6 font-bold flex items-center gap-3">
                <span class="material-symbols-outlined text-[16px] text-white/60">library_books</span> Arsip Terindeks
            </span>
            <div class="text-7xl md:text-[100px] font-headline font-black tracking-tighter text-white leading-none text-glow pb-2">{{ $totalOwned }}</div>
            
            <div class="flex items-center gap-4 mt-6">
                <span class="font-label text-[9px] tracking-[0.3em] text-[#8aab8c] uppercase font-bold">Penyelesaian</span>
                <div class="h-px flex-1 bg-white/10"></div>
                <div class="text-3xl text-white font-headline font-black">{{ $completionRate }}<span class="text-primary text-xl ml-1">%</span></div>
            </div>
        </div>

        <!-- Genres -->
        <div class="md:border-l border-white/5 md:pl-12 lg:pl-20 border-dashed group">
            <span class="font-label text-[10px] tracking-[0.3em] text-white/40 uppercase block mb-8 font-bold flex items-center gap-3">
                <span class="material-symbols-outlined text-[16px] text-white/60">category</span> Arc Tema Dominan
            </span>
            <div class="space-y-6">
                @forelse($topGenres as $genre)
                <div class="group/genre cursor-default">
                    <div class="flex justify-between items-end mb-2">
                        <span class="font-headline font-bold text-sm uppercase text-white/90 tracking-widest">{{ $genre->name }}</span>
                        <span class="font-label text-[10px] font-bold text-white/40">{{ $genre->comics_count }} VOL</span>
                    </div>
                    <!-- Minimalist line progress -->
                    <div class="w-full h-[2px] bg-white/10 overflow-hidden relative">
                        <div class="absolute top-0 left-0 h-full bg-primary origin-left scale-x-0 group-hover/genre:scale-x-100 transition-transform duration-700 ease-out shadow-[0_0_8px_rgba(183,16,42,0.8)]" 
                             style="width: {{ min(($genre->comics_count / max($totalOwned, 1)) * 100, 100) }}%"></div>
                    </div>
                </div>
                @empty
                <span class="text-xs font-label text-white/30 uppercase font-bold tracking-[0.2em]">Belum ada arc dominan.</span>
                @endforelse
            </div>
        </div>
    </section>
    <div class="w-full h-px bg-gradient-to-r from-transparent via-white/10 to-transparent mb-24"></div>

    <!-- Spotlight Full Bleed - Frameless Variant -->
    @if($currentlyReading)
    <section class="mb-32 reveal-on-scroll px-4 md:px-0">
        <div class="flex items-center gap-4 mb-8">
            <div class="w-2 h-2 rounded-full bg-primary animate-pulse shadow-[0_0_10px_rgba(183,16,42,0.8)]"></div>
            <h2 class="font-label text-[10px] tracking-[0.4em] uppercase font-bold text-primary drop-shadow-[0_0_8px_rgba(183,16,42,0.6)]">Sedang Diurai</h2>
        </div>
        
        <div class="relative w-full rounded-[40px] overflow-hidden group cursor-pointer" style="min-height: 520px;">
            <!-- Background Image -->
            <div class="absolute inset-0 overflow-hidden bg-[#0c1a0e]">
                <img alt="{{ $currentlyReading->title }}" 
                     class="w-full h-[120%] object-cover object-top opacity-60 group-hover:scale-[1.03] group-hover:opacity-80 transition-all duration-1000 parallax-img select-none origin-center"
                     src="{{ $currentlyReading->cover_image ? asset($currentlyReading->cover_image) : '' }}"/>
            </div>
            
            <!-- Sleek Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-t from-[#020603] via-[#020603]/80 to-transparent opacity-90"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-[#020603] via-[#020603]/60 to-transparent opacity-80"></div>
            
            <!-- Content -->
            <div class="absolute inset-0 p-10 md:p-16 lg:p-24 flex flex-col justify-end items-start md:w-3/4">
                <span class="border border-white/20 bg-white/5 backdrop-blur px-5 py-2 rounded-full font-label text-[9px] tracking-[0.3em] uppercase text-white/80 mb-8 flex items-center gap-3">
                    <span class="material-symbols-outlined text-[14px] text-primary">bookmark</span>
                    Fokus Volume
                </span>
                <h3 class="text-5xl md:text-8xl font-headline font-black tracking-tighter uppercase mb-6 leading-[0.9] text-white drop-shadow-2xl group-hover:text-primary-fixed transition-colors text-glow">
                    {{ $currentlyReading->title }}
                </h3>
                <p class="text-white/60 text-lg md:text-xl font-medium mb-10 line-clamp-3 md:line-clamp-none leading-relaxed max-w-2xl mix-blend-screen">
                    {{ $currentlyReading->description ?? 'Menyelami lautan panel dan dialog. Setiap goresan tinta adalah jejak para master.' }}
                </p>
                <a href="{{ route('comics.show', $currentlyReading) }}" 
                   class="relative inline-flex group/btn overflow-hidden items-center justify-center border border-white/30 text-white px-10 py-5 rounded-full font-label text-[10px] tracking-[0.3em] font-bold uppercase transition-all">
                    <span class="absolute inset-0 w-full h-full bg-primary -translate-x-full group-hover/btn:translate-x-0 transition-transform duration-500 ease-in-out"></span>
                    <span class="relative z-10 flex items-center gap-3">Lanjutkan Membaca <span class="material-symbols-outlined text-[14px] transition-transform group-hover/btn:translate-x-2">arrow_forward</span></span>
                </a>
            </div>
            <!-- Watermark -->
            <div class="absolute right-10 top-1/2 -translate-y-1/2 vertical-text select-none pointer-events-none opacity-[0.02]">
                <span class="text-[200px] font-black font-headline tracking-tighter">SAMURAI</span>
            </div>
        </div>
    </section>
    @endif

    <!-- AI Report - Frameless -->
    <section class="mb-32 reveal-on-scroll px-4 md:px-0">
        <div class="relative group max-w-5xl">
            <!-- Organic decorative element behind text -->
            <div class="absolute -left-10 top-10 w-[300px] h-[300px] bg-primary/10 rounded-full blur-[100px] pointer-events-none mix-blend-screen opacity-0 group-hover:opacity-100 transition-opacity duration-1000"></div>

            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10 border-b border-white/10 pb-6">
                <div>
                    <h2 class="font-headline font-black text-4xl uppercase tracking-tighter text-white mb-2 group-hover:text-glow transition-colors">Intelijen Kurator</h2>
                    <span class="font-label text-[10px] tracking-[0.4em] text-[#8aab8c] uppercase font-bold">A.I. Log / {{ date('d.m.y') }}</span>
                </div>
                <span class="border border-primary/30 px-4 py-1.5 rounded-full font-label text-[9px] tracking-[0.3em] font-bold text-primary flex items-center gap-2 self-start shadow-[0_0_15px_rgba(183,16,42,0.3)]">
                    <span class="w-1.5 h-1.5 rounded-full bg-primary animate-[pulse-orb_2s_infinite]"></span>
                    SYSTEM ACTIVE
                </span>
            </div>
            
            <div id="narrative-content" class="min-h-[120px] pl-0 md:pl-8 md:border-l border-primary/20 transition-all duration-700">
                <div class="animate-pulse space-y-4 max-w-4xl opacity-50">
                    <div class="h-2 bg-white/20 rounded-full w-full"></div>
                    <div class="h-2 bg-white/20 rounded-full w-10/12"></div>
                    <div class="h-2 bg-white/20 rounded-full w-8/12"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bento Grid Collections - Frameless Concept -->
    <section class="grid grid-cols-1 lg:grid-cols-12 gap-16 reveal-on-scroll px-4 md:px-0">
        
        <!-- Ekstraksi Terbaru (Latest Acq) -->
        <div class="lg:col-span-8">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-end gap-4 mb-12">
                <h2 class="font-headline font-black text-4xl uppercase tracking-tighter text-white drop-shadow-lg">Ekstraksi Terbaru</h2>
                <a href="{{ route('comics.index') }}" class="font-label text-[10px] tracking-[0.3em] text-primary font-bold hover:text-white transition-colors flex items-center gap-2 underline underline-offset-8 decoration-primary/30 hover:decoration-white">
                    LIHAT SEMUA INDEKS <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-x-8 gap-y-12 perspective-1000">
                @forelse($latestAcquisitions as $index => $comic)
                <a href="{{ route('comics.show', $comic) }}" class="block tilt-card w-full animate-fade-up group" style="animation-delay: {{ ($index+1)*100 }}ms">
                    <!-- Image bounds -->
                    <div class="card-tilt-target relative overflow-hidden rounded-[24px] bg-[#0a160c] mb-6 shadow-2xl transition-all duration-500 group-hover:shadow-[0_20px_50px_rgba(0,0,0,0.8)] border border-white/5 group-hover:border-primary/40" style="aspect-ratio: 2/3;">
                        <img alt="{{ $comic->title }}" 
                             class="absolute inset-0 w-full h-[110%] object-cover object-center transition-all duration-700 group-hover:scale-105 opacity-80 group-hover:opacity-100"
                             src="{{ $comic->cover_image ? asset($comic->cover_image) : '' }}"/>
                        
                        <!-- Priority Pill Hover -->
                        @if(strtolower($comic->priority ?? '') == 'extreme')
                        <div class="absolute top-4 right-4 bg-black/60 backdrop-blur-md px-2.5 py-1.5 rounded-full text-[10px] font-label font-bold text-primary tracking-widest uppercase flex items-center gap-1 shadow-[0_0_15px_rgba(183,16,42,0.8)] border border-primary/30 z-10">
                            <span class="material-symbols-outlined text-[14px]">whatshot</span>
                        </div>
                        @endif

                        <div class="absolute inset-0 bg-gradient-to-t from-[#020603]/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    
                    <!-- Metadata block below image -->
                    <div class="flex flex-col z-10 pl-2 border-l border-white/10 group-hover:border-primary/50 transition-colors">
                        <span class="font-label text-[9px] tracking-[0.3em] text-primary uppercase font-bold mb-2 flex items-center gap-2">
                            <span class="w-1 h-1 rounded-full bg-primary/70"></span> {{ $comic->created_at->diffForHumans() }}
                        </span>
                        <h4 class="font-headline font-bold text-lg md:text-xl leading-tight uppercase tracking-tight text-white mb-2 line-clamp-2 drop-shadow-md group-hover:text-primary-fixed transition-colors">{{ $comic->title }}</h4>
                        <p class="font-label text-[10px] tracking-[0.2em] text-white/40 uppercase truncate font-medium">{{ $comic->author }}</p>
                    </div>
                </a>
                @empty
                <div class="col-span-3 text-center py-16 text-white/30 uppercase tracking-[0.3em] font-label font-bold text-[10px] border border-dashed border-white/10 rounded-3xl w-full">
                    Sistem tidak mendeteksi anomali.
                </div>
                @endforelse
            </div>
        </div>

        <!-- Wishlist Sidebar Frameless -->
        <div class="lg:col-span-4 flex flex-col h-full">
            <div class="flex items-center gap-3 mb-10 pl-2">
                <span class="material-symbols-outlined text-primary text-2xl drop-shadow-[0_0_8px_rgba(183,16,42,0.6)]">bookmark_add</span>
                <h2 class="font-headline font-black text-3xl uppercase tracking-tighter text-white">Antrean Log</h2>
            </div>
            
            <div class="flex-1 flex flex-col pl-2 border-l border-white/10 relative">
                <!-- Watermark -->
                <div class="absolute right-0 top-1/2 -translate-y-1/2 text-[100px] text-white/[0.015] font-black font-headline pointer-events-none rotate-90 origin-right">WHISH</div>
                
                <div class="space-y-6 flex-1 relative z-10 overflow-auto pr-2 custom-scroll max-h-[500px] lg:max-h-none">
                    @forelse($wishlist as $wish)
                    <div class="group flex gap-5 items-center cursor-pointer w-full">
                        <div class="w-16 h-24 rounded-xl overflow-hidden bg-white/5 border border-transparent group-hover:border-primary/30 flex-shrink-0 transition-all shadow-lg group-hover:shadow-[0_10px_20px_rgba(183,16,42,0.15)] relative">
                            <img src="{{ $wish->cover_image ? asset($wish->cover_image) : '' }}" class="w-full h-full object-cover opacity-60 group-hover:opacity-100 transition-all duration-700 group-hover:scale-110"/>
                        </div>
                        <div class="flex-1 min-w-0 flex flex-col pt-1">
                            <h5 class="font-headline font-bold text-sm md:text-base uppercase group-hover:text-primary-fixed transition-colors truncate text-white mb-2 leading-tight drop-shadow-md">{{ $wish->title }}</h5>
                            <div class="mt-auto flex items-center justify-between">
                                <span class="font-label text-[9px] tracking-[0.3em] font-bold text-primary flex items-center gap-1.5"><span class="w-1 h-3 bg-primary rounded-full"></span> P{{ $wish->priority }}</span>
                                <span class="font-label text-[10px] font-bold text-white/50 tracking-widest group-hover:text-white transition-colors">{{ $wish->price ? 'Rp'.number_format($wish->price,0,',','.') : 'H?RGA' }}</span>
                            </div>
                        </div>
                    </div>
                    @empty
                        <div class="text-center py-12 text-white/30 font-label text-[10px] tracking-[0.3em] uppercase font-bold">Antrean Kosong</div>
                    @endforelse
                </div>
                
                <a href="{{ route('comics.create') }}" class="w-full mt-10 border border-white/20 py-4 rounded-full font-label text-[10px] tracking-[0.4em] font-bold text-center uppercase hover:bg-primary hover:text-white hover:border-primary transition-all duration-300 relative z-10 flex items-center justify-center gap-3 group">
                    Incaran Baru <span class="material-symbols-outlined text-[14px] group-hover:translate-x-1 transition-transform">east</span>
                </a>
            </div>
        </div>
    </section>
</div>

@endsection

@section('extra_css')
<style>
    .perspective-1000 { perspective: 1200px; transform-style: preserve-3d; }
    .custom-scroll::-webkit-scrollbar { width: 3px; }
    .custom-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 99px; }
</style>
@endsection

@section('fab')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // 1. Mouse Tilt Effect for Cards
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

    // 2. Parallax Blobs & Section logic
    const blobs = document.querySelectorAll('.parallax-blob');
    const heroText = document.getElementById('hero-text');
    const parallaxImgs = document.querySelectorAll('.parallax-img');
    
    let ticking = false;

    window.addEventListener('scroll', () => {
        if (!ticking) {
            window.requestAnimationFrame(() => {
                const scrolled = window.scrollY;
                
                // Blobs
                if(blobs.length) {
                    blobs[0] && (blobs[0].style.transform = `translateY(${scrolled * 0.3}px)`);
                    blobs[1] && (blobs[1].style.transform = `translateY(${scrolled * 0.15}px) scale(${1 + scrolled * 0.0005})`);
                    blobs[2] && (blobs[2].style.transform = `translateY(${scrolled * -0.2}px)`);
                }
                
                // Hero text subtle move
                if(heroText && scrolled < 800) {
                    heroText.style.transform = `translateY(${scrolled * 0.25}px)`;
                    heroText.style.opacity = 1 - (scrolled * 0.0015);
                }
                
                // Image parallax inside wrappers
                if(parallaxImgs.length) {
                    parallaxImgs.forEach(img => {
                        const wrapper = img.parentElement;
                        if (wrapper) {
                            const rect = wrapper.getBoundingClientRect();
                            if(rect.top < window.innerHeight && rect.bottom > 0) {
                                const yOffset = (rect.top - window.innerHeight/2) * -0.2;
                                img.style.transform = `translateY(${yOffset}px) scale(1.03)`;
                            }
                        }
                    });
                }
                ticking = false;
            });
            ticking = true;
        }
    }, {passive: true});

    // AI Fetch
    const fetchNarrative = async () => {
        const container = document.getElementById('narrative-content');
        if(!container) return;
        try {
            const response = await fetch("{{ route('api.narrative') }}", { headers: { 'Accept': 'application/json' } });
            if (!response.ok) throw new Error('API Error');
            const data = await response.json();
            
            container.innerHTML = '';
            const p = document.createElement('p');
            p.className = 'font-body text-xl md:text-2xl text-white/90 leading-relaxed font-medium drop-shadow-md';
            container.appendChild(p);
            
            let i = 0;
            const text = data.narrative;
            const typeWriter = () => {
                if (i < text.length) {
                    p.innerHTML += text.charAt(i);
                    i++;
                    setTimeout(typeWriter, 25);
                }
            };
            typeWriter();
        } catch (error) {
            container.innerHTML = '<p class="font-label text-xs text-error font-bold tracking-widest uppercase pb-4 drop-shadow-[0_0_8px_rgba(183,16,42,0.8)]"><span class="material-symbols-outlined text-sm align-text-bottom mr-1">warning</span>Koneksi transmisi neural gagal.</p>';
        }
    };
    if(document.getElementById('narrative-content')) {
        fetchNarrative();
    }
});
</script>
@endsection
