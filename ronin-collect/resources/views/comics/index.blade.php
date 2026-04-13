@extends('layouts.app')

@section('title', 'My Collection')

@section('extra_css')
<style>
    .manga-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 2rem;
        grid-auto-flow: dense;
    }
    .manga-panel-asymmetric {
        grid-column: span 1;
        grid-row: span 1;
    }
    .manga-panel-asymmetric:nth-child(3n) {
        grid-row: span 2;
    }
</style>
@endsection

@section('content')
<!-- Header & Filter Area -->
<header class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
<div>
<h1 class="font-headline text-5xl font-extrabold tracking-tighter uppercase mb-2">MY_COLLECTION</h1>
<p class="font-label text-xs tracking-[0.3em] text-primary uppercase">Total Titles: {{ $comics->count() }} / Last Updated: {{ date('d.m.y') }}</p>
</div>
<div class="flex flex-wrap gap-2">
<span class="bg-primary text-on-primary px-4 py-1 font-label text-[10px] tracking-widest uppercase cursor-pointer">ALL</span>
<span class="bg-surface-container-high text-on-surface-variant px-4 py-1 font-label text-[10px] tracking-widest uppercase cursor-pointer hover:bg-primary-fixed transition-colors">READ</span>
<span class="bg-surface-container-high text-on-surface-variant px-4 py-1 font-label text-[10px] tracking-widest uppercase cursor-pointer hover:bg-primary-fixed transition-colors">UNREAD</span>
<span class="bg-surface-container-high text-on-surface-variant px-4 py-1 font-label text-[10px] tracking-widest uppercase cursor-pointer hover:bg-primary-fixed transition-colors">FAVORITES</span>
</div>
</header>

<!-- Manga Grid -->
<section class="manga-grid">
@forelse($comics as $loopIndex => $comic)

    @if(($loopIndex + 1) % 3 == 0)
        <!-- Card Vertical Accent (3n rule) -->
        <article class="manga-panel-asymmetric bg-surface-container-lowest group cursor-pointer transition-all">
        <a href="{{ route('comics.show', $comic) }}" class="relative h-full overflow-hidden flex flex-col">
        <div class="relative flex-1">
        <img alt="{{ $comic->title }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" src="{{ $comic->cover_image ? asset($comic->cover_image) : 'https://lh3.googleusercontent.com/aida-public/AB6AXuAQTLTV_ppnXyTz8ypz4VbjCT9pYrW8C8IDPjH2me6mk-PY9G58A3mk00zAJj1kDOMBT1qZGFAfujP5khlcdBh_EGGCUs3yEOUX47MDpAaUZYktlzyj4dtpF7W9sXdprFeKgSwohekwuvGeVF2bKmyMKSPOxYIuGiFVMfJdEJ34RyWC8rfyql_RbDWovxy-7pczdETvCDWzXfVG4yZKLc4cxqO8fxd_PlwlGV8RF2GpsTdOC9EQX5lIMDq6CJML6nH1tAtlo2VVr8g' }}"/>
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
        <div class="absolute bottom-0 left-0 p-6">
        @if($comic->status == 'reading')
        <span class="bg-primary-container text-white font-label text-[10px] tracking-widest px-4 py-1 uppercase mb-4 inline-block">CURRENT FOCUS</span>
        @endif
        <h4 class="font-headline font-black text-3xl text-white tracking-tighter uppercase leading-none">{{ $comic->title }}</h4>
        </div>
        </div>
        <div class="p-4 bg-surface-container-lowest group-hover:bg-primary-fixed transition-colors">
        <div class="flex justify-between items-center">
        <span class="font-label text-[10px] tracking-widest opacity-60 uppercase">{{ $comic->author }}</span>
        <span class="bg-primary text-white font-label text-[10px] tracking-widest px-3 py-1 uppercase">{{ $comic->status }}</span>
        </div>
        </div>
        </a>
        </article>
    @else
        <!-- Regular Card -->
        <article class="manga-panel-asymmetric bg-surface-container-lowest group cursor-pointer transition-all">
        <a href="{{ route('comics.show', $comic) }}" class="block">
        <div class="relative overflow-hidden" style="aspect-ratio: 3/4;">
        <img alt="{{ $comic->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" src="{{ $comic->cover_image ? asset($comic->cover_image) : 'https://lh3.googleusercontent.com/aida-public/AB6AXuBuSLbVuMgYMIEW7X8D_vNi_sj6FYjyq59jLA3de4cLKh64Yg_hk2pa2EDKrDeVwYjAu-qqI6b0uZk6q2mv3rt0HHns_JUPL4hFeyt6_eR_tNieEhemSlnOn8iUk9ttdNtfP5ucf1JgN5imwGgynUrT-pz0SxHu7Rq4YCoAcO0pPbC-lChHU1cEnOVY4KtVctUM1T5DvaCceLaykp_cVPk01L7DeDCwM1CjA4eZkbZQU6wcFwMT7Ijd6JEGKuUsKEe8gtoDw05_tDM' }}"/>
        <div class="absolute top-0 right-0 p-4">
        @if($comic->status == 'completed' || $comic->status == 'reading')
        <span class="bg-primary text-white font-label text-[10px] tracking-widest px-3 py-1 uppercase">{{ $comic->status }}</span>
        @else
        <span class="bg-on-surface text-white font-label text-[10px] tracking-widest px-3 py-1 uppercase">{{ str_replace('_', ' ', $comic->status) }}</span>
        @endif
        </div>
        </div>
        <div class="p-4 bg-surface-container-lowest group-hover:bg-primary-fixed transition-colors">
        <h4 class="font-headline font-bold text-lg tracking-tighter uppercase mb-1">{{ $comic->title }}</h4>
        <div class="flex justify-between items-center">
        <span class="font-label text-[10px] tracking-widest opacity-60 uppercase">{{ $comic->author }}</span>
        <span class="material-symbols-outlined {{ strtolower($comic->priority ?? '') == 'extreme' ? 'text-primary' : 'text-on-surface-variant' }}" style="font-variation-settings: 'FILL' 1;">favorite</span>
        </div>
        </div>
        </a>
        </article>
    @endif

@empty
    <div class="col-span-full py-20 text-center font-label tracking-widest text-on-surface/50 uppercase">
        No titles found in your collection.
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
