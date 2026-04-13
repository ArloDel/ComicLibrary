@extends('layouts.app')

@section('title', 'Edit ' . $comic->title)

@section('content')
<div class="max-w-[1400px] mx-auto py-12">
<!-- Asymmetric Layout Container -->
<div class="flex flex-col md:flex-row gap-16 items-start">
<!-- Vertical Branding Accent -->
<div class="hidden lg:flex flex-col items-center gap-8">
<span class="vertical-text font-label text-xs tracking-widest text-primary uppercase">Manga Archival Form</span>
<div class="w-[2px] h-32 bg-primary"></div>
<span class="vertical-text font-label text-xs tracking-widest text-on-surface-variant uppercase">Tokyo / Kyoto</span>
</div>

<!-- Form Section -->
<div class="flex-1 w-full space-y-12">
<header class="space-y-2">
<p class="font-label text-primary tracking-[0.2em] text-xs font-bold uppercase">Archive Modification</p>
<h1 class="text-5xl md:text-7xl font-headline font-extrabold tracking-tighter text-on-surface uppercase">Edit {{ $comic->title }}</h1>
</header>

<form action="{{ route('comics.update', $comic) }}" method="POST" class="grid grid-cols-1 xl:grid-cols-12 gap-12" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <!-- Content Entry (8 columns) -->
    <div class="xl:col-span-8 space-y-10">
        
        <!-- Title Input -->
        <div class="group">
        <label class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant block mb-2">Primary Identification (Title)</label>
        <input name="title" value="{{ old('title', $comic->title) }}" required class="w-full bg-transparent border-t-0 border-x-0 border-b-2 border-primary focus:ring-0 focus:border-on-surface px-0 py-4 text-4xl md:text-5xl font-headline font-black tracking-tight uppercase placeholder:opacity-20 transition-all" placeholder="ENTER TITLE NAME" type="text"/>
        @error('title') <span class="text-xs text-primary font-bold">{{ $message }}</span> @enderror
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
        <!-- Author -->
        <div>
        <label class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant block mb-2">Creator / Author</label>
        <input name="author" value="{{ old('author', $comic->author) }}" required class="w-full bg-surface-container-low border-0 focus:ring-2 focus:ring-primary px-4 py-3 font-body text-on-surface placeholder:text-outline/40" placeholder="e.g. Akira Toriyama" type="text"/>
        @error('author') <span class="text-xs text-primary font-bold">{{ $message }}</span> @enderror
        </div>
        
        <!-- Status -->
        <div>
        <label class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant block mb-2">Reading Status</label>
        <select name="status" required class="w-full bg-surface-container-low border-0 focus:ring-2 focus:ring-primary px-4 py-3 font-body text-on-surface uppercase text-sm tracking-widest">
            <option value="plan_to_read" {{ old('status', $comic->status) == 'plan_to_read' ? 'selected' : '' }}>Plan to Read</option>
            <option value="reading" {{ old('status', $comic->status) == 'reading' ? 'selected' : '' }}>Reading</option>
            <option value="completed" {{ old('status', $comic->status) == 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="wishlist" {{ old('status', $comic->status) == 'wishlist' ? 'selected' : '' }}>Wishlist</option>
        </select>
        </div>
        
        <!-- Priority -->
        <div>
        <label class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant block mb-2">Priority (For Wishlist)</label>
        <select name="priority" class="w-full bg-surface-container-low border-0 focus:ring-2 focus:ring-primary px-4 py-3 font-body text-on-surface uppercase text-sm tracking-widest">
            <option value="">None</option>
            <option value="low" {{ old('priority', $comic->priority) == 'low' ? 'selected' : '' }}>Low</option>
            <option value="medium" {{ old('priority', $comic->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
            <option value="high" {{ old('priority', $comic->priority) == 'high' ? 'selected' : '' }}>High</option>
            <option value="extreme" {{ old('priority', $comic->priority) == 'extreme' ? 'selected' : '' }}>Extreme</option>
        </select>
        </div>
        
        <!-- Price -->
        <div>
        <label class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant block mb-2">Estimated Price (For Wishlist)</label>
        <input name="price" value="{{ old('price', $comic->price) }}" type="number" step="0.01" class="w-full bg-surface-container-low border-0 focus:ring-2 focus:ring-primary px-4 py-3 font-body text-on-surface placeholder:text-outline/40" placeholder="0.00"/>
        </div>
        </div>

        <!-- Tags / Genres -->
        <div>
        <label class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant block mb-2">Tags / Genres (Pisahkan dengan koma)</label>
        <input name="tags_input" value="{{ old('tags_input', $tagsString ?? '') }}" class="w-full bg-surface-container-low border-0 focus:ring-2 focus:ring-primary px-4 py-3 font-body text-on-surface placeholder:text-outline/40 uppercase text-sm tracking-widest" placeholder="e.g. Action, Shonen" type="text"/>
        </div>

        <!-- Description -->
        <div>
        <label class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant block mb-2">Narrative Synopsis</label>
        <textarea name="description" class="w-full bg-surface-container-low border-0 focus:ring-2 focus:ring-primary px-4 py-4 font-body text-on-surface leading-relaxed resize-none" placeholder="Describe the journey, the world, and the stakes..." rows="6">{{ old('description', $comic->description) }}</textarea>
        </div>
        
        <!-- CTA -->
        <div class="pt-6">
        <button type="submit" class="group relative inline-flex items-center justify-center w-full md:w-auto px-12 py-5 bg-gradient-to-br from-primary to-primary-container text-on-primary font-headline font-extrabold tracking-tighter text-xl uppercase transition-all active:scale-95 shadow-lg shadow-primary/10">
        <span>UPDATE_TITLE</span>
        <span class="material-symbols-outlined ml-3 group-hover:translate-x-1 transition-transform" data-icon="save">save</span>
        </button>
        </div>
    </div>
    
    <!-- Asset Entry (4 columns) -->
    <div class="xl:col-span-4 space-y-6">
        <label class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant block">Visual Representation (Image Upload)</label>
        
        @if($comic->cover_image)
            <div class="mb-4">
                <p class="font-label text-[10px] text-on-surface-variant uppercase mb-2">Current Cover:</p>
                <img src="{{ asset($comic->cover_image) }}" class="h-48 object-cover border border-outline-variant">
            </div>
        @endif
        
        <input name="cover_image" type="file" accept="image/*" class="w-full bg-surface-container-low border-0 focus:ring-2 focus:ring-primary px-4 py-3 font-body text-on-surface"/>
        
        <div class="p-6 bg-surface-container-low mt-8">
        <h3 class="font-label text-[10px] uppercase tracking-widest text-primary mb-4 font-bold">Metadata Checklist</h3>
        <ul class="space-y-3">
        <li class="flex items-center gap-3 text-xs font-body text-on-surface-variant">
        <span class="material-symbols-outlined text-sm text-primary" data-icon="check_circle" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                                High-Resolution Cover Asset
                                            </li>
        <li class="flex items-center gap-3 text-xs font-body text-on-surface-variant">
        <span class="material-symbols-outlined text-sm text-outline-variant" data-icon="radio_button_unchecked">radio_button_unchecked</span>
                                                ISBN-13 Registration Number
                                            </li>
        </ul>
        </div>
    </div>
</form>

</div>
</div>
</div>
@endsection
