@extends('layouts.app')

@section('title', 'Add New Volume')

@section('content')
<div class="max-w-[800px] mx-auto py-12">

<header class="space-y-2 mb-12">
<p class="font-label text-primary tracking-[0.2em] text-xs font-bold uppercase">Volume Archival Submission</p>
<h1 class="text-5xl font-headline font-extrabold tracking-tighter text-on-surface uppercase">Add New Volume</h1>
</header>

<form action="{{ route('volumes.store') }}" method="POST" class="space-y-8" enctype="multipart/form-data">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Comic Selection -->
        <div class="md:col-span-2">
            <label class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant block mb-2">Select Title</label>
            <select name="comic_id" required class="w-full bg-surface-container-low border-0 focus:ring-2 focus:ring-primary px-4 py-3 font-body text-on-surface uppercase text-sm tracking-widest">
                @foreach($comics as $comic)
                    <option value="{{ $comic->id }}" {{ old('comic_id') == $comic->id ? 'selected' : '' }}>
                        {{ $comic->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Volume Number -->
        <div>
        <label class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant block mb-2">Volume Number</label>
        <input name="volume_number" value="{{ old('volume_number') }}" required class="w-full bg-surface-container-low border-0 focus:ring-2 focus:ring-primary px-4 py-3 font-body text-on-surface placeholder:text-outline/40" placeholder="e.g. 1" type="text"/>
        </div>

        <!-- Acquisition Date -->
        <div>
        <label class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant block mb-2">Acquisition Date</label>
        <input name="acquisition_date" value="{{ old('acquisition_date') }}" type="date" class="w-full bg-surface-container-low border-0 focus:ring-2 focus:ring-primary px-4 py-3 font-body text-on-surface uppercase text-sm tracking-widest"/>
        </div>
        
        <!-- Cover Image -->
        <div class="md:col-span-2">
        <label class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant block mb-2">Cover Image (Upload)</label>
        <input name="cover_image" type="file" accept="image/*" class="w-full bg-surface-container-low border-0 focus:ring-2 focus:ring-primary px-4 py-3 font-body text-on-surface"/>
        </div>
    </div>
    
    <div class="pt-6">
    <button type="submit" class="group relative inline-flex items-center justify-center w-full md:w-auto px-12 py-5 bg-gradient-to-br from-primary to-primary-container text-on-primary font-headline font-extrabold tracking-tighter text-xl uppercase transition-all active:scale-95 shadow-lg shadow-primary/10">
    <span>SAVE_VOLUME</span>
    <span class="material-symbols-outlined ml-3 group-hover:translate-x-1 transition-transform" data-icon="arrow_forward">arrow_forward</span>
    </button>
    </div>

</form>
</div>
@endsection
