@extends('layouts.app')

@section('title', $comic->title . ' - Details')

@section('content')
<div class="max-w-[1400px] mx-auto py-12">

<!-- Header Section -->
<div class="grid grid-cols-1 md:grid-cols-12 gap-12 mb-16">
    <div class="md:col-span-4 bg-surface-container-highest" style="aspect-ratio: 2/3;">
        <img alt="{{ $comic->title }}" class="w-full h-full object-cover" src="{{ $comic->cover_image ? asset($comic->cover_image) : 'https://lh3.googleusercontent.com/aida-public/AB6AXuBuSLbVuMgYMIEW7X8D_vNi_sj6FYjyq59jLA3de4cLKh64Yg_hk2pa2EDKrDeVwYjAu-qqI6b0uZk6q2mv3rt0HHns_JUPL4hFeyt6_eR_tNieEhemSlnOn8iUk9ttdNtfP5ucf1JgN5imwGgynUrT-pz0SxHu7Rq4YCoAcO0pPbC-lChHU1cEnOVY4KtVctUM1T5DvaCceLaykp_cVPk01L7DeDCwM1CjA4eZkbZQU6wcFwMT7Ijd6JEGKuUsKEe8gtoDw05_tDM' }}"/>
    </div>
    <div class="md:col-span-8 flex flex-col justify-center">
        <div class="flex flex-wrap items-center gap-4 mb-4">
            <span class="font-label text-primary tracking-[0.2em] text-xs font-bold uppercase">{{ str_replace('_', ' ', $comic->status) }}</span>
            @if($comic->tags->isNotEmpty())
            <span class="font-label text-outline tracking-[0.2em] text-xs font-bold uppercase">
                // 
                @foreach($comic->tags as $index => $tag)
                    <a href="{{ route('comics.index', ['tag' => $tag->name]) }}" class="hover:text-primary transition-colors">{{ $tag->name }}</a>{{ !$loop->last ? ' / ' : '' }}
                @endforeach
            </span>
            @endif
        </div>
        <h1 class="text-6xl md:text-8xl font-headline font-extrabold tracking-tighter text-on-surface uppercase mb-6">{{ $comic->title }}</h1>
        <h2 class="text-2xl font-headline text-on-surface-variant uppercase tracking-widest mb-8">Author // {{ $comic->author }}</h2>
        <p class="font-body text-xl text-on-surface leading-relaxed max-w-3xl mb-8">
            {{ $comic->description ?? 'No narrative synopsis available for this title.' }}
        </p>
        
        <div class="flex gap-4">
            <form action="{{ route('comics.destroy', $comic) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="border-2 border-primary text-primary px-8 py-3 font-label text-xs tracking-widest uppercase font-bold hover:bg-primary hover:text-white transition-all">Delete Title</button>
            </form>
        </div>
    </div>
</div>

<!-- Volumes Section -->
<div class="border-t border-surface-variant/30 pt-16">
    <div class="flex justify-between items-end mb-10">
        <h3 class="font-headline font-extrabold text-4xl uppercase tracking-tighter">Volumes</h3>
        <a href="{{ route('volumes.create', ['comic_id' => $comic->id]) }}" class="font-label text-xs tracking-widest text-[#b7102a] hover:underline font-bold mr-4">ADD VOLUME</a>
        <span class="font-label text-xs tracking-widest text-primary font-bold border-l-2 pl-4 border-primary/20">Total: {{ $comic->volumes->count() }}</span>
    </div>
    
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
        @forelse($comic->volumes as $volume)
        <div class="group">
            <div class="bg-surface-container-high overflow-hidden border border-transparent group-hover:border-primary transition-colors cursor-pointer relative" style="aspect-ratio: 2/3;">
                <img class="w-full h-full object-cover transition-transform group-hover:scale-110" src="{{ $volume->cover_image ? asset($volume->cover_image) : ($comic->cover_image ? asset($comic->cover_image) : '') }}" />
                <div class="absolute bottom-0 left-0 w-full bg-black/60 p-2 text-center text-white font-headline text-xl font-bold">
                    Vol. {{ $volume->volume_number }}
                </div>
            </div>
            <div class="flex justify-between items-center mt-2 px-1">
                <p class="font-label text-[10px] tracking-widest text-on-surface-variant uppercase">
                    {{ $volume->acquisition_date ? $volume->acquisition_date->format('M Y') : 'Unknown' }}
                </p>
                <a href="{{ route('volumes.edit', $volume) }}" class="text-primary hover:underline font-label text-[10px] tracking-widest">EDIT</a>
            </div>
        </div>
        @empty
        <div class="col-span-full py-12 text-center font-label tracking-widest text-on-surface/50 uppercase">
            No volumes associated with this title yet.
        </div>
        @endforelse
    </div>
</div>

</div>
@endsection
