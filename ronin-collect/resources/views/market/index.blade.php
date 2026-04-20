@extends('layouts.app')

@section('title', 'Terminal Pasar Gelap')

@section('content')
<!-- Ambient Parallax Layer -->
<div class="fixed inset-0 z-0 pointer-events-none overflow-hidden mix-blend-screen opacity-50">
    <div class="absolute top-[30%] left-[40%] w-[1200px] h-[1200px] rounded-full border border-primary/20 bg-transparent animate-[ping_4s_cubic-bezier(0,0,0.2,1)_infinite] -translate-x-1/2 -translate-y-1/2 shadow-[0_0_50px_rgba(183,16,42,0.1)]"></div>
    <div class="absolute top-[30%] left-[40%] w-[800px] h-[800px] rounded-full border border-primary/10 bg-transparent animate-[ping_4s_cubic-bezier(0,0,0.2,1)_infinite_1s] -translate-x-1/2 -translate-y-1/2 shadow-[0_0_30px_rgba(183,16,42,0.1)]"></div>
    <div class="absolute top-[40%] right-[-10%] w-[800px] h-[800px] bg-primary/20 rounded-full blur-[150px] bg-parallax"></div>
    <div class="absolute bottom-[-10%] left-[-10%] w-[600px] h-[600px] bg-[#0c2e15]/40 rounded-full blur-[120px] bg-parallax"></div>
    
    <!-- Crosshairs Grid Map -->
    <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:40px_40px] [mask-image:radial-gradient(ellipse_60%_60%_at_50%_40%,#000_10%,transparent_100%)]"></div>
</div>

<header class="mb-16 flex flex-col md:flex-row md:items-end justify-between gap-8 animate-fade-in relative z-20 px-4 md:px-0">
    <div>
        <div class="flex items-center gap-3 mb-4">
            <span class="w-2.5 h-2.5 bg-primary animate-[pulse-orb_1s_infinite] shadow-[0_0_15px_rgba(183,16,42,1)] rounded-full"></span>
            <span class="font-label text-[12px] tracking-[0.4em] text-primary uppercase font-bold drop-shadow-[0_0_8px_rgba(183,16,42,0.8)]">Black Market Uplink</span>
        </div>
        <h1 class="font-headline text-5xl md:text-7xl font-black tracking-tighter uppercase mb-2 text-white drop-shadow-xl flex items-center gap-4">
            Radar Ekstraksi
        </h1>
        <p class="font-body text-white/50 text-base md:text-lg max-w-xl font-medium tracking-wide">
            Transmisi intersep dari jaringan gelap. Mengawasi {{ $bounties->count() }} target buruan yang terfragmentasi.
        </p>
    </div>
    
    <div class="text-right border-r border-primary/50 pr-6 py-2">
        <span class="font-label text-[10px] tracking-[0.3em] text-[#8aab8c] uppercase font-bold block mb-1">Status Enkripsi</span>
        <span class="font-label text-sm tracking-widest text-white uppercase font-bold">Terhubung <span class="text-primary">•</span></span>
    </div>
</header>
<div class="w-full h-px bg-gradient-to-r from-primary/30 to-transparent mb-12 hidden md:block"></div>

<!-- Bounty Radar List (Frameless Grid) -->
<section class="relative z-10 px-4 md:px-0 min-h-[50vh]">
    <div class="grid grid-cols-1 gap-12 lg:gap-16">
        @forelse($bounties as $index => $bounty)
            <div class="group flex flex-col md:flex-row gap-8 items-start animate-fade-up relative w-full" style="animation-delay: {{ min($index*100, 800) }}ms;">
                
                <!-- Number / Radar Blip Indicator -->
                <div class="hidden md:flex flex-col items-center pt-8 pr-4">
                    <span class="font-label text-white/20 text-xs font-bold">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    <div class="h-24 w-[1px] bg-gradient-to-b from-white/10 to-transparent my-2"></div>
                </div>

                <!-- Cover Frameless -->
                <a href="{{ route('comics.show', $bounty) }}" class="relative overflow-hidden rounded-[24px] bg-[#080f0a] shadow-xl drop-shadow-2xl flex-shrink-0 border border-primary/10 group-hover:border-primary/40 transition-colors w-40 md:w-56" style="aspect-ratio: 2/3;">
                    <img src="{{ $bounty->cover_image ? asset($bounty->cover_image) : '' }}" class="absolute inset-0 w-full h-[105%] object-cover object-top opacity-60 group-hover:scale-110 group-hover:opacity-100 transition-all duration-700 mix-blend-screen"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-80 z-0"></div>
                    
                    @if(strtolower($bounty->priority) == 'extreme')
                         <div class="absolute inset-0 border-[2px] border-primary/20 rounded-[24px] pointer-events-none group-hover:border-primary/50 transition-colors"></div>
                    @endif
                </a>

                <!-- Intel Data Core -->
                <div class="flex flex-col flex-1 pb-4 border-b border-white/5 md:self-center w-full">
                    <div class="flex flex-wrap items-center justify-between mb-4 gap-4">
                        <div class="flex items-center gap-3">
                            <!-- Priority Badge -->
                            @php
                                $badgeColor = match(strtolower($bounty->priority)) {
                                    'extreme' => 'text-primary bg-primary/10 border-primary/30 shadow-[0_0_15px_rgba(183,16,42,0.5)]',
                                    'high' => 'text-orange-400 bg-orange-400/10 border-orange-400/30',
                                    'medium' => 'text-yellow-400 bg-yellow-400/10 border-yellow-400/30',
                                    default => 'text-blue-400 bg-blue-400/10 border-blue-400/30',
                                };
                            @endphp
                            <span class="border {{ $badgeColor }} font-label text-[9px] tracking-[0.2em] font-bold px-3 py-1.5 rounded-full uppercase truncate max-w-[120px]">
                                TINGKAT: {{ $bounty->priority }}
                            </span>
                            <span class="font-label text-[10px] tracking-[0.2em] text-[#8aab8c] font-bold uppercase truncate max-w-[150px]">
                                <span class="w-1 h-3 inline-block bg-[#8aab8c] align-middle mr-1.5"></span> {{ $bounty->author }}
                            </span>
                        </div>
                    </div>

                    <h3 class="font-headline font-black text-3xl md:text-5xl text-white tracking-tighter uppercase leading-[0.9] text-glow mb-4 break-words">
                        {{ $bounty->title }}
                    </h3>

                    <div class="flex flex-col sm:flex-row sm:items-center gap-8 border-l border-white/10 pl-6 mb-8 mt-2 mix-blend-screen opacity-90 group-hover:opacity-100 transition-opacity">
                        <div>
                            <span class="font-label text-[9px] tracking-[0.3em] font-bold uppercase text-white/40 block mb-1">Estimasi Nilai Tebusan</span>
                            <span class="font-headline font-black text-2xl md:text-3xl text-white drop-shadow-md">
                                <span class="text-white/30 text-lg mr-1 tracking-widest font-label font-bold">Rp</span>{{ $bounty->price ? number_format($bounty->price, 0, ',', '.') : 'TIDAK DIKETAHUI' }}
                            </span>
                        </div>
                        <div class="hidden sm:block h-10 w-[1px] bg-white/10"></div>
                        <div>
                            <span class="font-label text-[9px] tracking-[0.3em] font-bold uppercase text-white/40 block mb-1">Status Arsip</span>
                            <span class="font-body font-bold text-white tracking-wide flex items-center gap-2">
                                <span class="material-symbols-outlined text-[16px] text-white/60">pending_actions</span> Menunggu Eksekusi
                            </span>
                        </div>
                    </div>
                    
                    <!-- Tactical Search Integration -->
                    <div class="mt-auto pt-6 flex gap-4">
                        <!-- Tokopedia Rapid Search -->
                        <a href="https://www.tokopedia.com/search?q={{ urlencode($bounty->title) }}" target="_blank" rel="noopener noreferrer" 
                           class="inline-flex items-center gap-2 bg-[#03AC0E] hover:bg-[#03AC0E]/80 text-white font-label font-bold uppercase text-[10px] tracking-[0.3em] px-6 py-3.5 rounded-full transition-all shadow-[0_4px_15px_rgba(3,172,14,0.3)] hover:shadow-[0_0_25px_rgba(3,172,14,0.6)] hover:-translate-y-1">
                            <span class="material-symbols-outlined text-[14px]">storefront</span> 
                            Deteksi Tokopedia
                        </a>

                        <!-- Shopee Rapid Search Option (Can also add later) -->
                        <a href="https://shopee.co.id/search?keyword={{ urlencode($bounty->title) }}" target="_blank" rel="noopener noreferrer" 
                           class="inline-flex items-center gap-2 border border-[#EE4D2D]/30 bg-transparent hover:bg-[#EE4D2D]/10 text-[#EE4D2D] font-label font-bold uppercase text-[10px] tracking-[0.3em] px-6 py-3.5 rounded-full transition-all hover:shadow-[0_0_20px_rgba(238,77,45,0.4)]">
                            <span class="material-symbols-outlined text-[14px]">shopping_bag</span> 
                            Pindai Shopee
                        </a>
                    </div>
                </div>
            </div>
            
            @if(!$loop->last)
                <div class="md:hidden w-full h-px bg-white/5 my-4"></div>
            @endif
        @empty
            <div class="col-span-1 py-32 text-center flex flex-col items-center w-full">
                <span class="material-symbols-outlined text-6xl text-white/10 drop-shadow-2xl mb-8 animate-pulse">radar</span>
                <p class="font-label tracking-[0.4em] text-white/40 uppercase font-bold text-xs">Jaringan Bersih. Tidak Ada Target Ekstraksi Aktif.</p>
                <a href="{{ route('comics.create') }}" class="mt-8 border border-white/20 px-8 py-3 rounded-full font-label text-[10px] uppercase tracking-[0.3em] text-white/60 hover:text-white hover:border-white transition-colors">Daftarkan Target Baru</a>
            </div>
        @endforelse
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Elegant ambient background panning
    const bgs = document.querySelectorAll('.bg-parallax');
    window.addEventListener('scroll', () => {
        requestAnimationFrame(() => {
            const sy = window.scrollY;
            bgs.forEach(bg => { bg.style.transform = `translateY(${sy * 0.15}px)`; });
        });
    }, {passive:true});
});
</script>

@endsection
