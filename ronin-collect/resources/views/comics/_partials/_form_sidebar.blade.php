{{-- ============================================================
     _form_sidebar.blade.php
     Kolom kanan form: upload cover dan metadata checklist.
     Dipakai bersama oleh comics/create dan comics/edit.

     Variabel yang dibutuhkan (di-pass via @include):
       - $comic        : App\Models\Comic|null — null untuk create
       - $showUrlInput : bool                  — true jika halaman create
     ============================================================ --}}
<div class="xl:col-span-4 space-y-6">

    <label class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant block">
        Representasi Visual (Unggah Gambar)
    </label>

    <input name="cover_image"
           id="cover_image"
           type="file"
           accept="image/*"
           class="w-full bg-surface-container-low border-0 focus:ring-2 focus:ring-primary px-4 py-3 font-body text-on-surface"/>

    @if($showUrlInput ?? false)
        {{-- Hanya di halaman Create: hidden input URL + pratinjau cover dari API --}}
        <input type="hidden" name="cover_image_url" id="cover_image_url">

        <div id="cover_preview_container" class="hidden mt-6">
            <div class="flex items-center justify-between mb-2">
                <label class="font-label text-[10px] uppercase tracking-widest text-primary block font-bold">
                    Pratinjau Sampul
                </label>
                <span id="cover_source_badge"
                      class="text-[8px] font-label tracking-widest uppercase px-2 py-0.5 bg-primary/10 text-primary border border-primary/20">
                </span>
            </div>
            <div id="cover_preview"
                 class="w-full aspect-[2/3] bg-surface-container-high bg-cover bg-center border border-outline/20 shadow-md transition-all">
            </div>
            <button type="button" id="clear_cover_btn"
                    class="mt-3 text-[10px] font-label uppercase tracking-widest text-on-surface-variant hover:text-primary transition-colors flex items-center gap-1">
                <span class="material-symbols-outlined text-sm" data-icon="close">close</span>
                Hapus Sampul Otomatis
            </button>
        </div>

    @else
        {{-- Hanya di halaman Edit: tampilkan sampul yang sudah ada --}}
        @if($comic?->cover_image)
            <div class="mb-4">
                <p class="font-label text-[10px] text-on-surface-variant uppercase mb-2">Sampul Saat Ini:</p>
                <img src="{{ asset($comic->cover_image) }}"
                     class="h-48 object-cover border border-outline-variant"
                     alt="Sampul saat ini">
            </div>
        @endif
    @endif

    {{-- Metadata Checklist --}}
    <div class="p-6 bg-surface-container-low mt-8">
        <h3 class="font-label text-[10px] uppercase tracking-widest text-primary mb-4 font-bold">
            Daftar Periksa Metadata
        </h3>
        <ul class="space-y-3">
            <li class="flex items-center gap-3 text-xs font-body text-on-surface-variant">
                <span class="material-symbols-outlined text-sm text-primary"
                      data-icon="check_circle"
                      style="font-variation-settings: 'FILL' 1;">check_circle</span>
                Aset Sampul Resolusi Tinggi
            </li>
            <li class="flex items-center gap-3 text-xs font-body text-on-surface-variant">
                <span class="material-symbols-outlined text-sm text-outline-variant"
                      data-icon="radio_button_unchecked">radio_button_unchecked</span>
                Nomor Registrasi ISBN-13
            </li>
        </ul>
    </div>

</div>
