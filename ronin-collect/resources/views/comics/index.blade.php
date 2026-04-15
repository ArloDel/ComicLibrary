@extends('layouts.app')

@section('title', 'Koleksiku')

@section('extra_css')
<style>
/* Replaced unreliable raw intrinsic CSS grid with reliable responsive Tailwind grid layout */
</style>
@endsection

@section('content')
<!-- Header & Filter Area -->
<header class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
<div>
<h1 class="font-headline text-5xl font-extrabold tracking-tighter uppercase mb-2">KOLEKSIKU</h1>
<p class="font-label text-xs tracking-[0.3em] text-primary uppercase">Total Judul: {{ $comics->count() }} / Pembaruan Terakhir: {{ date('d.m.y') }}</p>
</div>
<div class="flex flex-wrap gap-2">
@if(request('tag'))
<a href="{{ route('comics.index') }}" class="bg-primary flex items-center gap-2 text-on-primary px-4 py-1 font-label text-[10px] tracking-widest uppercase cursor-pointer hover:bg-primary-container transition-colors">FILTER: {{ request('tag') }} <span class="material-symbols-outlined text-[10px]">close</span></a>
@else
<a href="{{ route('comics.index') }}" class="bg-primary text-on-primary px-4 py-1 font-label text-[10px] tracking-widest uppercase cursor-pointer">SEMUA</a>
@endif
<span class="bg-surface-container-high text-on-surface-variant px-4 py-1 font-label text-[10px] tracking-widest uppercase cursor-pointer hover:bg-primary-fixed transition-colors">DIBACA</span>
<span class="bg-surface-container-high text-on-surface-variant px-4 py-1 font-label text-[10px] tracking-widest uppercase cursor-pointer hover:bg-primary-fixed transition-colors">BELUM DIBACA</span>
<span class="bg-surface-container-high text-on-surface-variant px-4 py-1 font-label text-[10px] tracking-widest uppercase cursor-pointer hover:bg-primary-fixed transition-colors">FAVORIT</span>
</div>
</header>

<!-- Manga Grid -->
<section class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 md:gap-6 grid-flow-row-dense">
@forelse($comics as $loopIndex => $comic)

    @if(($loopIndex + 1) % 5 == 0)
        <!-- Featured Card (Asymmetrical Accent) -->
        <article class="col-span-2 row-span-2 bg-surface-container-lowest group cursor-pointer transition-all">
        <a href="{{ route('comics.show', $comic) }}" class="relative h-full w-full overflow-hidden flex flex-col min-h-[300px] md:min-h-[400px]">
        <div class="relative flex-1">
        <img alt="{{ $comic->title }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" src="{{ $comic->cover_image ? asset($comic->cover_image) : 'https://lh3.googleusercontent.com/aida-public/AB6AXuAQTLTV_ppnXyTz8ypz4VbjCT9pYrW8C8IDPjH2me6mk-PY9G58A3mk00zAJj1kDOMBT1qZGFAfujP5khlcdBh_EGGCUs3yEOUX47MDpAaUZYktlzyj4dtpF7W9sXdprFeKgSwohekwuvGeVF2bKmyMKSPOxYIuGiFVMfJdEJ34RyWC8rfyql_RbDWovxy-7pczdETvCDWzXfVG4yZKLc4cxqO8fxd_PlwlGV8RF2GpsTdOC9EQX5lIMDq6CJML6nH1tAtlo2VVr8g' }}"/>
        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent"></div>
        <div class="absolute bottom-0 left-0 p-6 w-full">
        @if($comic->status == 'reading')
        <span class="bg-primary-container text-white font-label text-[10px] tracking-widest px-4 py-1 uppercase mb-4 inline-block shadow-lg">FOKUS SAAT INI</span>
        @endif
        <h4 class="font-headline font-black text-2xl md:text-3xl text-white tracking-tighter uppercase leading-tight mb-3">{{ $comic->title }}</h4>
        @if($comic->tags->isNotEmpty())
        <div class="flex flex-wrap gap-2 mb-3">
            @foreach($comic->tags->take(3) as $tag)
                <span class="text-white/60 text-[9px] font-label uppercase tracking-widest border border-white/20 px-2 py-0.5">{{ $tag->name }}</span>
            @endforeach
        </div>
        @endif
        <div class="flex flex-wrap gap-2 justify-between items-center border-t border-white/20 pt-4">
        <span class="font-label text-[10px] tracking-widest text-white/70 uppercase">{{ $comic->author }}</span>
        <span class="bg-primary text-white font-label text-[10px] tracking-widest px-3 py-1 uppercase">{{ $comic->status }}</span>
        </div>
        </div>
        </div>
        </a>
        </article>
    @else
        <!-- Regular Card -->
        <article class="col-span-1 bg-surface-container-lowest group cursor-pointer transition-all flex flex-col shadow-sm hover:shadow-md">
        <a href="{{ route('comics.show', $comic) }}" class="flex flex-col h-full w-full">
        <div class="relative overflow-hidden w-full" style="aspect-ratio: 2/3;">
        <img alt="{{ $comic->title }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" src="{{ $comic->cover_image ? asset($comic->cover_image) : 'https://lh3.googleusercontent.com/aida-public/AB6AXuBuSLbVuMgYMIEW7X8D_vNi_sj6FYjyq59jLA3de4cLKh64Yg_hk2pa2EDKrDeVwYjAu-qqI6b0uZk6q2mv3rt0HHns_JUPL4hFeyt6_eR_tNieEhemSlnOn8iUk9ttdNtfP5ucf1JgN5imwGgynUrT-pz0SxHu7Rq4YCoAcO0pPbC-lChHU1cEnOVY4KtVctUM1T5DvaCceLaykp_cVPk01L7DeDCwM1CjA4eZkbZQU6wcFwMT7Ijd6JEGKuUsKEe8gtoDw05_tDM' }}"/>
        <div class="absolute top-0 right-0 p-3">
        @if($comic->status == 'completed' || $comic->status == 'reading')
        <span class="bg-primary text-white font-label text-[9px] tracking-widest px-2 py-1 uppercase shadow-sm">{{ str_replace('_', ' ', str_replace('completed', 'selesai', str_replace('reading', 'sedang dibaca', $comic->status))) }}</span>
        @else
        <span class="bg-on-surface/80 backdrop-blur-sm text-white font-label text-[9px] tracking-widest px-2 py-1 uppercase shadow-sm">{{ str_replace('_', ' ', $comic->status) }}</span>
        @endif
        </div>
        </div>
        <div class="p-4 flex-1 flex flex-col bg-surface-container-lowest group-hover:bg-primary/5 transition-colors">
        <h4 class="font-headline font-bold text-sm md:text-base tracking-tighter uppercase mb-2 line-clamp-2" title="{{ $comic->title }}">{{ $comic->title }}</h4>
        @if($comic->tags->isNotEmpty())
        <div class="flex flex-wrap gap-1 mb-2">
            @foreach($comic->tags->take(2) as $tag)
                <span class="bg-surface-variant/50 text-on-surface-variant px-1.5 py-0.5 text-[8px] font-label uppercase tracking-widest">{{ $tag->name }}</span>
            @endforeach
            @if($comic->tags->count() > 2)
                <span class="text-on-surface-variant/50 px-1 py-0.5 text-[8px] font-label uppercase tracking-widest">+{{ $comic->tags->count() - 2 }}</span>
            @endif
        </div>
        @endif
        <div class="flex justify-between items-end mt-auto pt-1">
        <span class="font-label text-[9px] tracking-widest opacity-60 uppercase truncate flex-1 pr-2" title="{{ $comic->author }}">{{ $comic->author }}</span>
        <span class="material-symbols-outlined text-[16px] {{ strtolower($comic->priority ?? '') == 'extreme' ? 'text-primary' : 'text-on-surface-variant/30' }}" style="font-variation-settings: 'FILL' 1;">favorite</span>
        </div>
        </div>
        </a>
        </article>
    @endif

@empty
    <div class="col-span-full py-20 text-center font-label tracking-widest text-on-surface/50 uppercase">
        Tidak ada judul ditemukan di koleksi Anda.
    </div>
@endforelse
</section>
@endsection

@section('fab')
<!-- FAB (Contextual for Library/Home) -->
<a href="{{ route('comics.create') }}" class="fixed bottom-8 right-8 bg-primary text-white w-14 h-14 flex items-center justify-center shadow-2xl hover:scale-110 transition-transform z-[60]">
<span class="material-symbols-outlined">add</span>
</a>
@endsection
