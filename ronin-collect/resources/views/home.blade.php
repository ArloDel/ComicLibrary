@extends('layouts.app')

@section('title', 'Dashboard')

@section('sidebar')
<!-- SideNav (Vertical Accent for Desktop) -->
<aside class="hidden xl:flex fixed left-0 top-0 h-screen w-20 flex-col items-center justify-center bg-surface-container-low z-40 gap-12 pt-20">
<span class="vertical-text font-label text-[10px] tracking-[0.5em] text-on-surface/40 uppercase">Archival_System_v.01</span>
<div class="flex flex-col gap-8 text-on-surface/60">
<a href="{{ route('comics.index') }}" class="material-symbols-outlined hover:text-primary cursor-pointer transition-colors">menu_book</a>
<a href="{{ route('comics.index') }}" class="material-symbols-outlined hover:text-primary cursor-pointer transition-colors">visibility</a>
<a href="{{ route('comics.index') }}" class="material-symbols-outlined hover:text-primary cursor-pointer transition-colors">favorite</a>
<a href="{{ route('comics.index') }}" class="material-symbols-outlined hover:text-primary cursor-pointer transition-colors">auto_stories</a>
</div>
</aside>

<main class="xl:ml-20 pt-24 pb-20 min-h-screen">
<!-- Hero Section -->
<section class="px-8 md:px-16 grid grid-cols-1 lg:grid-cols-12 gap-8 items-end border-b border-surface-variant/30 pb-16">
<div class="lg:col-span-8">
<h1 class="text-7xl md:text-9xl font-black font-headline tracking-tighter leading-none uppercase mb-6">
                    The<br/><span class="text-primary">Editorial</span><br/>Ronin.
                </h1>
<p class="max-w-xl text-lg text-on-surface-variant font-body">
                    A curated digital sanctuary for high-energy Shonen impact and disciplined Japanese minimalism. Every volume is a calculated stroke in a larger narrative.
                </p>
</div>
<div class="lg:col-span-4 flex flex-col items-start lg:items-end gap-4">
<div class="bg-primary px-6 py-4 w-full lg:w-auto mt-8 md:mt-0">
<span class="font-label text-xs tracking-widest text-on-primary block mb-2 uppercase">Current Status</span>
<span class="font-headline font-extrabold text-2xl text-on-primary uppercase leading-none">Master Curator</span>
</div>
<div class="font-label text-[10px] tracking-widest text-on-surface/50 uppercase text-left lg:text-right">
                    Last Updated: {{ date('d.M.Y') }}<br/>
                    Tokyo Central Archive
                </div>
</div>
</section>

<!-- Spotlight: Currently Reading -->
<section class="mt-20 px-8 md:px-16">
<div class="flex items-center gap-4 mb-12">
<span class="h-[2px] w-12 bg-primary"></span>
<h2 class="font-label text-xs tracking-[0.3em] uppercase font-bold text-primary">Currently_Reading</h2>
</div>
<div class="relative group bg-surface-container-low grid grid-cols-1 lg:grid-cols-2 gap-0 overflow-hidden">
@if($currentlyReading)
<div class="overflow-hidden" style="aspect-ratio: 4/5;">
<img alt="{{ $currentlyReading->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" data-alt="{{ $currentlyReading->title }}" src="{{ $currentlyReading->cover_image ? asset($currentlyReading->cover_image) : 'https://lh3.googleusercontent.com/aida-public/AB6AXuCZzS7gEQGQo0X2hEMgP46WiWvQJ4_WU1ZzWW8bT4xaCSdtcqg-CwsUW7KMVg_gh1BBaJgRhunVHupVPUgaXyvZ51EyThQGwFA9syhqF6u0EO7dUC1tuGb06Ol1BVwhWgJ7bCEgKLrQzxwDXQr3ajouSs2aGAzY_dseu6OcepiINdx87RYlf6V0V5Rl-YTcbodnTBxDNrCfkM-slkeN1POOecxQKA4FGFvUEjbxNvZRdW1EFn7hUt-K7bVjEOzcW0yglBKJnxPPK-4' }}"/>
</div>
<div class="p-8 md:p-16 flex flex-col justify-between">
<div>
<span class="font-label text-xs text-primary font-bold tracking-widest uppercase mb-4 block underline underline-offset-8">Current Volume Focus</span>
<h3 class="text-5xl md:text-6xl font-headline font-extrabold tracking-tighter uppercase mb-6 leading-tight">{{ $currentlyReading->title }}</h3>
<p class="text-on-surface-variant text-lg max-w-md mb-8">
                            {{ $currentlyReading->description ?? 'Experience the profound journey of the legendary swordsman. This archival edition features remastered ink plates and exclusive author commentary on the philosophy of the blade.' }}
                        </p>
</div>
<div class="flex flex-wrap gap-4 mt-8 md:mt-0">
<a href="{{ route('comics.show', $currentlyReading) }}" class="bg-primary text-on-primary px-10 py-5 font-headline font-bold uppercase tracking-widest hover:bg-primary-container transition-colors inline-block text-center">
                            Continue Reading
                        </a>
</div>
</div>
@else
<div class="p-8 md:p-16 flex flex-col items-center justify-center col-span-2 text-center py-24">
    <span class="material-symbols-outlined text-6xl text-primary opacity-50 mb-4 block">bookmark_border</span>
    <p class="text-on-surface-variant text-lg font-body uppercase tracking-widest">Nothing currently being read. Pick up a new volume.</p>
</div>
@endif
<!-- Stylized Vertical Watermark -->
<div class="absolute right-4 top-1/2 -translate-y-1/2 vertical-text hidden lg:block select-none pointer-events-none">
<span class="text-[120px] font-black text-on-surface/[0.03] font-headline">SAMURAI</span>
</div>
</div>
</section>

<!-- Bento Grid: Acquisitions & Wishlist -->
<section class="mt-32 px-8 md:px-16 grid grid-cols-1 lg:grid-cols-12 gap-8">
<!-- Latest Acquisitions -->
<div class="lg:col-span-8">
<div class="flex justify-between items-end mb-10 border-b-2 border-on-surface pb-4">
<h2 class="font-headline font-extrabold text-4xl uppercase tracking-tighter">Latest_Acquisitions</h2>
<a class="font-label text-xs tracking-widest text-primary font-bold hover:underline" href="{{ route('comics.index') }}">VIEW ALL</a>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

@forelse($latestAcquisitions as $comic)
    <a href="{{ route('comics.show', $comic) }}" class="group block cursor-pointer">
    <div class="bg-surface-container-highest overflow-hidden mb-4 border border-transparent group-hover:border-primary transition-colors" style="aspect-ratio: 2/3;">
    <img alt="{{ $comic->title }}" class="w-full h-full object-cover transition-transform group-hover:scale-110" src="{{ $comic->cover_image ? asset($comic->cover_image) : 'https://lh3.googleusercontent.com/aida-public/AB6AXuAsVVa9HFIaPIkgr3U-gxt5M7P4iPWzH4jCMU8sEu8p3hRWLfPMsGemiWkrHu3V8KpE3xp04tnSzkaClnY6sf4I2pxU67LPJMOu_IALpnurC8YTlAyJB2U_ZgqJFcJyonmQhof5XqeuhYcani6SlbyDScR9ZrQtVvBjOuDHmc0KOz4ZeRmxZ_ZvnY0Un6swucEU6faZM8iyeCa0PDNYnKVQcTRmXlCwL9UZopV8lh2ssN02RFTYWCT8ATiIamBZMnHSlGg5czK56nw' }}"/>
    </div>
    <span class="font-label text-[10px] tracking-widest text-primary uppercase font-bold">{{ $comic->created_at->diffForHumans() }}</span>
    <h4 class="font-headline font-bold text-lg uppercase tracking-tight group-hover:text-primary transition-colors mt-1">{{ $comic->title }}</h4>
    <p class="font-label text-xs text-on-surface/50 uppercase">{{ $comic->author }}</p>
    </a>
@empty
    <div class="col-span-3 text-center py-12 text-on-surface/50 uppercase tracking-widest font-label font-bold text-sm">
        No recent acquisitions found.
    </div>
@endforelse

</div>
</div>

<!-- Wishlist Sidebar -->
<div class="lg:col-span-4 bg-on-background text-surface p-8">
<div class="flex items-center gap-3 mb-8">
<span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">favorite</span>
<h2 class="font-headline font-extrabold text-2xl uppercase tracking-tighter">Wishlist_Queue</h2>
</div>
<div class="space-y-8 min-h-[300px]">

@forelse($wishlist as $wish)
    <div class="flex gap-4 items-start border-b border-surface/10 pb-6 group cursor-pointer">
    <div class="w-16 h-20 bg-surface/10 flex-shrink-0 overflow-hidden">
    <img alt="{{ $wish->title }}" class="w-full h-full object-cover opacity-60 group-hover:opacity-100 transition-opacity" src="{{ $wish->cover_image ? asset($wish->cover_image) : 'https://lh3.googleusercontent.com/aida-public/AB6AXuAz4dKzSvm70-_RQjOgJRFdgPvqvdqGhw6j-PVrWSw9T4DOUwecaItvuNIc7KXDOzH8UQG1P6sT1P2XALjfxmEbxo4XjFVyhpqIfpmgO_OiEDFCcm0t3UAt_tV4GRnxdFdorf2QbgzDD1WHCA-nK893GqJx9TYK0llxTyaKoZMkp8Yev78byiO9bt9VkjGhJDf2UW7WcZIpqHoea7ceDfx6tOCym7s2iTRlxe6yxRgUc5LqUil24nwaK_L5Q9x0JOs0Q9Pnei7fsKo' }}"/>
    </div>
    <div>
    <h5 class="font-headline font-bold text-sm uppercase group-hover:text-primary transition-colors">{{ $wish->title }}</h5>
    <p class="font-label text-[10px] tracking-widest text-surface/40 uppercase mb-2">Priority: {{ $wish->priority }}</p>
    <span class="text-xs font-bold text-primary">{{ $wish->price ? '$'.$wish->price : 'PRICE UNKNOWN' }}</span>
    </div>
    </div>
@empty
    <div class="text-center py-12 text-surface/50 uppercase tracking-widest font-label font-bold text-xs mt-12">
        Wishlist queue is empty.
    </div>
@endforelse

</div>
<a href="{{ route('comics.create') }}" class="w-full mt-12 border-2 border-surface/20 py-4 font-label text-xs tracking-widest uppercase hover:bg-surface hover:text-on-background transition-all font-bold block text-center">
                    Add New Wish
                </a>
</div>
</section>
</main>
@endsection
