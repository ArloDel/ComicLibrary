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
    <header class="mb-20 px-4 md:px-0" id="hero-section">
        <div class="flex flex-col md:flex-row justify-between items-end gap-8">
            <div id="hero-text" class="will-change-transform">
                <p class="font-label text-primary tracking-[0.3em] font-bold text-xs uppercase mb-4 pl-1">Sistem_Arsip_v.01</p>
                <h1 class="text-7xl md:text-9xl font-black font-headline tracking-tighter leading-[0.9] uppercase text-glow">
                    Sang<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-primary-bright">Kurator</span><br>
                    Ronin.
                </h1>
                <p class="mt-8 max-w-xl text-lg text-on-surface-variant font-body leading-relaxed glass rounded-2xl p-6 shadow-2xl">
                    Suaka digital terkurasi untuk koleksi Shonen berenergi tinggi dan minimalisme Jepang yang disiplin.
                </p>
            </div>
            
            <div class="glass-card p-6 flex flex-col items-end min-w-[240px] text-right reveal-on-scroll">
                <span class="font-label text-[10px] tracking-widest text-on-surface/50 uppercase mb-2">Status Terminal</span>
                <span class="font-headline font-black text-2xl text-primary uppercase leading-tight mb-4">Kurator Utama</span>
                <div class="w-full h-px bg-white/10 my-2"></div>
                <span class="font-label text-[10px] tracking-widest text-on-surface/40 uppercase">Pembaruan: {{ date('d.m.Y') }}</span>
                <span class="font-label text-[10px] tracking-widest text-on-surface/40 uppercase mt-1">Arsip Pusat Tokyo</span>
            </div>
        </div>
    </header>

    <!-- Stats Archival Telemetry -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-20">
        <!-- Value -->
        <div class="glass-card p-8 group reveal-on-scroll cursor-default">
            <span class="font-label text-[10px] tracking-[0.2em] text-on-surface/50 uppercase block mb-6 font-bold flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">payments</span> Nilai Total
            </span>
            <div class="text-5xl md:text-6xl font-headline font-black tracking-tighter text-on-surface flex items-start group-hover:scale-105 transition-transform duration-500">
                <span class="text-primary text-2xl mt-1.5 mr-2 font-bold">Rp</span>
                {{ number_format($totalInvestment, 0, ',', '.') }}
            </div>
        </div>

        <!-- Count -->
        <div class="glass-card p-8 group relative overflow-hidden reveal-on-scroll cursor-default border-primary/20 glow-red">
            <div class="absolute -right-8 -bottom-8 w-40 h-40 bg-primary/20 rounded-full blur-2xl group-hover:bg-primary/40 transition-colors duration-700"></div>
            <div class="relative z-10 flex justify-between items-end h-full">
                <div>
                    <span class="font-label text-[10px] tracking-[0.2em] text-primary uppercase block mb-4 font-bold flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm text-primary">library_books</span> Arsip Terindeks
                    </span>
                    <div class="text-7xl font-headline font-black tracking-tighter text-white">{{ $totalOwned }}</div>
                </div>
                <div class="text-right pb-1">
                    <span class="font-label text-[9px] tracking-widest text-on-surface/40 uppercase block mb-2">Penyelesaian</span>
                    <div class="text-3xl text-on-surface font-headline font-black">{{ $completionRate }}<span class="text-primary text-xl ml-1">%</span></div>
                </div>
            </div>
        </div>

        <!-- Genres -->
        <div class="glass-card p-8 reveal-on-scroll">
            <span class="font-label text-[10px] tracking-[0.2em] text-on-surface/50 uppercase block mb-6 font-bold flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">category</span> Arc Tema
            </span>
            <div class="space-y-4">
                @forelse($topGenres as $genre)
                <div class="group/genre">
                    <div class="flex justify-between items-end mb-1.5">
                        <span class="font-headline font-bold text-sm uppercase text-on-surface tracking-widest">{{ $genre->name }}</span>
                        <span class="font-label text-[10px] font-bold text-on-surface/50">{{ $genre->comics_count }} VOL</span>
                    </div>
                    <!-- Rounded progress -->
                    <div class="w-full h-[3px] bg-white/5 rounded-full overflow-hidden">
                        <div class="h-full bg-primary origin-left scale-x-0 group-hover/genre:scale-x-100 transition-transform duration-700 ease-out rounded-full shadow-[0_0_8px_rgba(183,16,42,0.8)]" 
                             style="width: {{ min(($genre->comics_count / max($totalOwned, 1)) * 100, 100) }}%"></div>
                    </div>
                </div>
                @empty
                <span class="text-xs font-label text-on-surface/50 uppercase font-bold">Belum ada arc dominan.</span>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Spotlight Full Bleed -->
    @if($currentlyReading)
    <section class="mb-24 reveal-on-scroll">
        <div class="flex items-center gap-4 mb-8 pl-2">
            <div class="w-2 h-2 rounded-full bg-primary animate-pulse shadow-[0_0_10px_rgba(183,16,42,0.8)]"></div>
            <h2 class="font-label text-[10px] tracking-[0.3em] uppercase font-bold text-primary">Sedang Diurai</h2>
        </div>
        
        <div class="relative w-full rounded-3xl overflow-hidden glass-card group cursor-pointer" style="min-height: 480px;">
            <!-- Background Image Parallax -->
            <div class="absolute inset-0 overflow-hidden">
                <img alt="{{ $currentlyReading->title }}" 
                     class="w-full h-[120%] object-cover object-top opacity-50 group-hover:scale-105 transition-transform duration-1000 parallax-img"
                     src="{{ $currentlyReading->cover_image ? asset($currentlyReading->cover_image) : 'https://lh3.googleusercontent.com/aida-public/AB6AXuCZzS7gEQGQo0X2hEMgP46WiWvQJ4_WU1ZzWW8bT4xaCSdtcqg-CwsUW7KMVg_gh1BBaJgRhunVHupVPUgaXyvZ51EyThQGwFA9syhqF6u0EO7dUC1tuGb06Ol1BVwhWgJ7bCEgKLrQzxwDXQr3ajouSs2aGAzY_dseu6OcepiINdx87RYlf6V0V5Rl-YTcbodnTBxDNrCfkM-slkeN1POOecxQKA4FGFvUEjbxNvZRdW1EFn7hUt-K7bVjEOzcW0yglBKJnxPPK-4' }}"/>
            </div>
            <!-- Overlay Gradients -->
            <div class="absolute inset-x-0 bottom-0 h-3/4 bg-gradient-to-t from-[#0c1a0e] via-[#0c1a0e]/80 to-transparent"></div>
            <div class="absolute inset-y-0 left-0 w-full md:w-2/3 bg-gradient-to-r from-[#0c1a0e] via-[#0c1a0e]/80 to-transparent"></div>
            
            <!-- Content -->
            <div class="absolute inset-0 p-8 md:p-14 flex flex-col justify-end items-start md:w-2/3">
                <span class="glass px-4 py-1.5 rounded-full font-label text-[9px] tracking-widest uppercase text-white/70 mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[12px] text-primary">bookmark</span>
                    Fokus Volume
                </span>
                <h3 class="text-4xl md:text-7xl font-headline font-black tracking-tighter uppercase mb-4 md:mb-6 leading-tight text-glow group-hover:text-primary-fixed transition-colors">
                    {{ $currentlyReading->title }}
                </h3>
                <p class="text-on-surface/70 text-base md:text-lg mb-8 line-clamp-3 md:line-clamp-none leading-relaxed max-w-xl">
                    {{ $currentlyReading->description ?? 'Menyelami lautan panel dan dialog. Setiap goresan tinta adalah jejak para master.' }}
                </p>
                <a href="{{ route('comics.show', $currentlyReading) }}" 
                   class="bg-primary/20 border border-primary/50 text-white px-8 py-4 rounded-full font-label text-[10px] tracking-[0.2em] font-bold uppercase hover:bg-primary hover:shadow-[0_0_30px_rgba(183,16,42,0.5)] transition-all backdrop-blur-md">
                    Lanjutkan Membaca
                </a>
            </div>
            
            <!-- Watermark -->
            <div class="absolute right-8 top-1/2 -translate-y-1/2 vertical-text select-none pointer-events-none opacity-[0.03]">
                <span class="text-[150px] font-black font-headline tracking-tighter">SAMURAI</span>
            </div>
        </div>
    </section>
    @endif

    <!-- AI Report -->
    <section class="mb-24 reveal-on-scroll">
        <div class="glass-card relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-primary/5 to-transparent z-0"></div>
            <div class="relative z-10 p-8 md:p-12">
                <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4 mb-8 border-b border-white/5 pb-6">
                    <div>
                        <h2 class="font-headline font-bold text-2xl uppercase tracking-widest text-on-surface mb-2">Intelijen Kurator</h2>
                        <span class="font-label text-[10px] tracking-[0.2em] text-on-surface/40 uppercase">A.I. Log / {{ date('d.m.y') }}</span>
                    </div>
                    <span class="glass px-3 py-1 bg-primary/10 rounded-full font-label text-[9px] tracking-[0.2em] font-bold text-primary flex items-center gap-2 self-start">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary animate-[pulse-orb_2s_infinite]"></span>
                        SYSTEM ACTIVE
                    </span>
                </div>
                <div id="narrative-content" class="min-h-[100px]">
                    <div class="animate-pulse space-y-4 max-w-4xl">
                        <div class="h-3 bg-white/10 rounded-full w-full"></div>
                        <div class="h-3 bg-white/10 rounded-full w-11/12"></div>
                        <div class="h-3 bg-white/10 rounded-full w-4/5"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bento Grid Collections -->
    <section class="grid grid-cols-1 lg:grid-cols-12 gap-8 reveal-on-scroll">
        <!-- Acq -->
        <div class="lg:col-span-8">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-end gap-3 mb-8 pl-2">
                <h2 class="font-headline font-black text-3xl uppercase tracking-tighter text-glow">Ekstraksi_Terbaru</h2>
                <a href="{{ route('comics.index') }}" class="glass px-4 py-1.5 rounded-full font-label text-[10px] tracking-widest text-primary font-bold hover:text-white hover:bg-primary/20 hover:border-primary/50 transition-colors">LIHAT SEMUA</a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 perspective-1000">
                @forelse($latestAcquisitions as $index => $comic)
                <a href="{{ route('comics.show', $comic) }}" class="block tilt-card w-full h-full animate-fade-up" style="animation-delay: {{ ($index+1)*100 }}ms">
                    <div class="glass-card overflow-hidden h-full flex flex-col card-tilt-target relative group hover:border-primary/40">
                        <!-- Cover Area -->
                        <div class="relative w-full h-64 overflow-hidden rounded-t-2xl bg-[#0a160c]">
                            <img alt="{{ $comic->title }}" 
                                 class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 opacity-90 group-hover:opacity-100"
                                 src="{{ $comic->cover_image ? asset($comic->cover_image) : '' }}"/>
                            <div class="absolute inset-0 bg-gradient-to-t from-[#0a160c] via-[#0a160c]/40 to-transparent"></div>
                            
                            <!-- priority pill -->
                            @if(strtolower($comic->priority ?? '') == 'extreme')
                            <div class="absolute top-4 right-4 glass px-2 py-1 bg-black/50 rounded-full text-[8px] font-label font-bold text-primary tracking-widest uppercase flex items-center gap-1 shadow-[0_0_10px_rgba(183,16,42,0.8)] border-primary/30">
                                <span class="material-symbols-outlined text-[10px]">whatshot</span>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Info Area -->
                        <div class="p-6 flex-1 flex flex-col z-10 -mt-10 pt-0">
                            <span class="font-label text-[9px] tracking-[0.2em] text-primary uppercase font-bold mb-3 drop-shadow-md">
                                {{ $comic->created_at->diffForHumans() }}
                            </span>
                            <h4 class="font-headline font-bold text-lg leading-tight uppercase tracking-tight text-white mb-3 line-clamp-2 drop-shadow-md group-hover:text-primary-fixed transition-colors">{{ $comic->title }}</h4>
                            <p class="font-label text-[10px] tracking-widest text-on-surface/40 uppercase mt-auto truncate">{{ $comic->author }}</p>
                        </div>
                    </div>
                </a>
                @empty
                <div class="col-span-3 text-center py-12 text-on-surface/30 uppercase tracking-[0.2em] font-label font-bold text-[10px] glass-card border-dashed">
                    Tidak ada anomali terdeteksi.
                </div>
                @endforelse
            </div>
        </div>

        <!-- Wishlist Sidebar -->
        <div class="lg:col-span-4 flex flex-col h-full">
            <div class="flex items-center gap-3 mb-8 pl-2">
                <span class="material-symbols-outlined text-on-surface/50 text-2xl">bookmark_add</span>
                <h2 class="font-headline font-black text-2xl uppercase tracking-tighter">Antrean</h2>
            </div>
            
            <div class="glass-card p-6 flex-1 flex flex-col relative overflow-hidden">
                <div class="absolute -right-8 top-20 text-[120px] text-white/[0.02] font-black material-symbols-outlined pointer-events-none rotate-12">receipt_long</div>
                <div class="space-y-4 flex-1 relative z-10 overflow-auto pr-2 custom-scroll max-h-[400px] lg:max-h-none">
                    @forelse($wishlist as $wish)
                    <div class="group flex gap-4 items-center p-3 rounded-xl hover:bg-white/5 transition-colors cursor-pointer w-full border border-transparent hover:border-white/5">
                        <div class="w-14 h-20 rounded-lg overflow-hidden bg-white/5 border border-white/10 flex-shrink-0">
                            <img src="{{ $wish->cover_image ? asset($wish->cover_image) : '' }}" class="w-full h-full object-cover opacity-70 group-hover:opacity-100 transition-opacity group-hover:scale-110 duration-500"/>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h5 class="font-headline font-bold text-sm uppercase group-hover:text-primary-fixed transition-colors truncate text-white/90 mb-1 leading-tight">{{ $wish->title }}</h5>
                            <div class="flex items-center justify-between mt-3">
                                <span class="glass px-2 rounded font-label text-[8px] tracking-[0.2em] text-on-surface/50 uppercase border-none bg-white/5">PRIORITAS: {{ $wish->priority }}</span>
                                <span class="font-label text-[10px] font-bold text-primary tracking-widest drop-shadow-[0_0_8px_rgba(183,16,42,0.3)]">{{ $wish->price ? 'Rp'.number_format($wish->price,0,',','.') : 'H?RGA' }}</span>
                            </div>
                        </div>
                    </div>
                    @empty
                        <div class="text-center py-12 text-on-surface/30 font-label text-[10px] tracking-[0.2em] uppercase">Antrean Kosong</div>
                    @endforelse
                </div>
                
                <a href="{{ route('comics.create') }}" class="w-full mt-6 glass bg-white/5 py-4 rounded-xl font-label text-[10px] tracking-[0.3em] font-bold text-center uppercase hover:bg-primary hover:text-white transition-all hover:border-primary/50 relative z-10 shadow-[0_0_15px_rgba(0,0,0,0.5)]">
                    Incaran Baru
                </a>
            </div>
        </div>
    </section>
</div>

@endsection

@section('extra_css')
<style>
    .perspective-1000 { perspective: 1000px; }
    .custom-scroll::-webkit-scrollbar { width: 4px; }
    .custom-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.15); border-radius: 99px; }
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
            const xPct = (x / rect.width - 0.5) * 20; 
            const yPct = (y / rect.height - 0.5) * -20;
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
                    heroText.style.transform = `translateY(${scrolled * 0.15}px)`;
                    heroText.style.opacity = 1 - (scrolled * 0.002);
                }
                
                // Image parallax inside cards
                if(parallaxImgs.length) {
                    parallaxImgs.forEach(img => {
                        const card = img.closest('.glass-card');
                        if (card) {
                            const rect = card.getBoundingClientRect();
                            if(rect.top < window.innerHeight && rect.bottom > 0) {
                                const yOffset = (rect.top - window.innerHeight/2) * -0.15;
                                img.style.transform = `translateY(${yOffset}px)`;
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
            p.className = 'font-body text-xl md:text-2xl text-on-surface leading-relaxed text-glow font-medium';
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
