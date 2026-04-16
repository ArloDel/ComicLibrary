{{-- ============================================================
     comics/edit.blade.php
     Halaman edit komik.
     Menggunakan partials yang sama dengan halaman create.
     ============================================================ --}}
@extends('layouts.app')

@section('title', 'Edit ' . $comic->title)

@section('content')
<div class="max-w-[1400px] mx-auto py-12">
<div class="flex flex-col md:flex-row gap-16 items-start">

    @include('comics._partials._form_branding')

    <div class="flex-1 w-full space-y-12">

        <header class="space-y-2">
            <p class="font-label text-primary tracking-[0.2em] text-xs font-bold uppercase">Modifikasi Arsip</p>
            <h1 class="text-5xl md:text-7xl font-headline font-extrabold tracking-tighter text-on-surface uppercase">
                Edit {{ $comic->title }}
            </h1>
        </header>

        <form action="{{ route('comics.update', $comic) }}"
              method="POST"
              class="grid grid-cols-1 xl:grid-cols-12 gap-12"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('comics._partials._form_fields', [
                'comic'       => $comic,
                'submitLabel' => 'PERBARUI_JUDUL',
                'submitIcon'  => 'save',
            ])

            @include('comics._partials._form_sidebar', [
                'comic'        => $comic,
                'showUrlInput' => false,
            ])

        </form>
    </div>

</div>
</div>
@endsection
