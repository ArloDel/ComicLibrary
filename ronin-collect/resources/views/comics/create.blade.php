{{-- ============================================================
     comics/create.blade.php
     Halaman tambah komik baru.
     Form di-render via partials, JS via file terpisah.
     ============================================================ --}}
@extends('layouts.app')

@section('title', 'Tambah Komik Baru')

@section('content')
<div class="max-w-[1400px] mx-auto py-12">
<div class="flex flex-col md:flex-row gap-16 items-start">

    @include('comics._partials._form_branding')

    <div class="flex-1 w-full space-y-12">

        <header class="space-y-2 mb-8">
            <p class="font-label text-primary tracking-[0.2em] text-xs font-bold uppercase">Submisi Arsip</p>
            <h1 class="text-5xl md:text-7xl font-headline font-extrabold tracking-tighter text-on-surface uppercase">
                Tambah Judul Komik
            </h1>
        </header>

        @include('comics._partials._autofill_panel')

        <form action="{{ route('comics.store') }}"
              method="POST"
              class="grid grid-cols-1 xl:grid-cols-12 gap-12"
              enctype="multipart/form-data">
            @csrf

            @include('comics._partials._form_fields', [
                'comic'       => null,
                'submitLabel' => 'SIMPAN_JUDUL',
                'submitIcon'  => 'arrow_forward',
            ])

            @include('comics._partials._form_sidebar', [
                'comic'        => null,
                'showUrlInput' => true,
            ])

        </form>
    </div>

</div>
</div>

<style>
    .source-tab { background: transparent; color: rgba(100,116,139,1); cursor: pointer; }
    .source-tab:hover { background: rgba(0,0,0,0.04); }
    .source-tab.active-tab { background: var(--color-primary, #b7102a); color: white; }
    @media (prefers-color-scheme: dark) {
        .source-tab.active-tab { background: var(--color-primary, #ffb3b1); color: #111; }
    }
</style>

{{-- Inject konfigurasi route Laravel ke JavaScript --}}
<script>
window.AUTOFILL_CONFIG = {
    routes: {
        anilist:     '{{ route('proxy.anilist') }}',
        mangadex:    '{{ route('proxy.mangadex') }}',
        googlebooks: '{{ route('proxy.googlebooks') }}',
        openlibrary: '{{ route('proxy.openlibrary') }}',
    },
    csrf: '{{ csrf_token() }}',
};
</script>
<script src="{{ asset('js/comic-autofill.js') }}"></script>

@endsection
