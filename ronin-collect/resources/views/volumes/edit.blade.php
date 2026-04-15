@extends('layouts.app')

@section('title', 'Edit Volume ' . $volume->volume_number)

@section('content')
<div class="max-w-[800px] mx-auto py-12">

<header class="space-y-2 mb-12">
<p class="font-label text-primary tracking-[0.2em] text-xs font-bold uppercase">Modifikasi Volume</p>
<h1 class="text-5xl font-headline font-extrabold tracking-tighter text-on-surface uppercase">Edit Volume</h1>
</header>

<form action="{{ route('volumes.update', $volume) }}" method="POST" class="space-y-8" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Comic Selection -->
        <div class="md:col-span-2">
            <label class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant block mb-2">Pilih Judul</label>
            <select name="comic_id" required class="w-full bg-surface-container-low border-0 focus:ring-2 focus:ring-primary px-4 py-3 font-body text-on-surface uppercase text-sm tracking-widest">
                @foreach($comics as $comic)
                    <option value="{{ $comic->id }}" {{ (old('comic_id', $volume->comic_id) == $comic->id) ? 'selected' : '' }}>
                        {{ $comic->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Volume Number -->
        <div>
        <label class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant block mb-2">Nomor Volume</label>
        <input name="volume_number" value="{{ old('volume_number', $volume->volume_number) }}" required class="w-full bg-surface-container-low border-0 focus:ring-2 focus:ring-primary px-4 py-3 font-body text-on-surface placeholder:text-outline/40" placeholder="misal: 1" type="text"/>
        </div>

        <!-- Acquisition Date -->
        <div>
        <label class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant block mb-2">Tanggal Akuisisi</label>
        <input name="acquisition_date" value="{{ old('acquisition_date', $volume->acquisition_date ? $volume->acquisition_date->format('Y-m-d') : '') }}" type="date" class="w-full bg-surface-container-low border-0 focus:ring-2 focus:ring-primary px-4 py-3 font-body text-on-surface uppercase text-sm tracking-widest"/>
        </div>
        
        <!-- Cover Image -->
        <div class="md:col-span-2">
            <label class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant block mb-2">Gambar Sampul</label>
            
            <div class="space-y-3">
                <div>
                    <span class="font-label text-[9px] uppercase tracking-widest text-on-surface-variant/70 block mb-1">Unggah dari Perangkat (Opsional)</span>
                    <input name="cover_image" type="file" accept="image/*" class="w-full bg-surface-container-low border-0 focus:ring-2 focus:ring-primary px-4 py-3 font-body text-on-surface"/>
                </div>
                <div class="flex items-center gap-4">
                    <div class="h-[1px] flex-1 bg-outline-variant/30"></div>
                    <span class="font-label text-[9px] uppercase tracking-widest text-on-surface-variant/50">ATAU</span>
                    <div class="h-[1px] flex-1 bg-outline-variant/30"></div>
                </div>
                <div>
                    <span class="font-label text-[9px] uppercase tracking-widest text-on-surface-variant/70 block mb-1">Impor dari URL (Opsional)</span>
                    <input name="cover_image_url" type="url" value="{{ old('cover_image_url') }}" class="w-full bg-surface-container-low border-0 focus:ring-2 focus:ring-primary px-4 py-3 font-body text-on-surface placeholder:text-outline/40" placeholder="https://contoh.com/gambar.jpg"/>
                    @error('cover_image_url')
                        <p class="text-error text-xs mt-1 font-body">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            @if($volume->cover_image)
                <div class="mt-4">
                    <p class="font-label text-[9px] text-on-surface-variant/70 uppercase mb-2">Sampul Saat Ini:</p>
                    <img src="{{ asset($volume->cover_image) }}" class="h-48 object-cover border border-outline-variant">
                </div>
            @endif
        </div>
    </div>
    
    <div class="pt-6">
    <button type="submit" class="group relative inline-flex items-center justify-center w-full md:w-auto px-12 py-5 bg-gradient-to-br from-primary to-primary-container text-on-primary font-headline font-extrabold tracking-tighter text-xl uppercase transition-all active:scale-95 shadow-lg shadow-primary/10">
    <span>PERBARUI_VOLUME</span>
    <span class="material-symbols-outlined ml-3 group-hover:translate-x-1 transition-transform" data-icon="save">save</span>
    </button>
    </div>

</form>
</div>
@endsection
