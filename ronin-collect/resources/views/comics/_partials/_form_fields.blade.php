{{-- ============================================================
     _form_fields.blade.php
     Field-field input utama form komik.
     Dipakai bersama oleh comics/create dan comics/edit.

     Variabel yang dibutuhkan (di-pass via @include):
       - $comic       : App\Models\Comic|null  — null untuk create
       - $submitLabel : string                 — teks tombol submit
       - $submitIcon  : string                 — nama Material Symbol icon
     ============================================================ --}}
<div class="xl:col-span-8 space-y-10">

    {{-- Judul --}}
    <div class="group">
        <label class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant block mb-2">
            Identifikasi Primer (Judul)
        </label>
        <input name="title"
               value="{{ old('title', $comic?->title ?? '') }}"
               required
               class="w-full bg-transparent border-t-0 border-x-0 border-b-2 border-primary focus:ring-0 focus:border-on-surface px-0 py-4 text-4xl md:text-5xl font-headline font-black tracking-tight uppercase placeholder:opacity-20 transition-all"
               placeholder="MASUKKAN NAMA JUDUL"
               type="text"/>
        @error('title')
            <span class="text-xs text-primary font-bold">{{ $message }}</span>
        @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

        {{-- Penulis --}}
        <div>
            <label class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant block mb-2">
                Kreator / Penulis
            </label>
            <input name="author"
                   value="{{ old('author', $comic?->author ?? '') }}"
                   required
                   class="w-full bg-surface-container-low border-0 focus:ring-2 focus:ring-primary px-4 py-3 font-body text-on-surface placeholder:text-outline/40"
                   placeholder="misal: Akira Toriyama"
                   type="text"/>
            @error('author')
                <span class="text-xs text-primary font-bold">{{ $message }}</span>
            @enderror
        </div>

        {{-- Status --}}
        <div>
            <label class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant block mb-2">
                Status Membaca
            </label>
            <select name="status" required
                    class="w-full bg-surface-container-low border-0 focus:ring-2 focus:ring-primary px-4 py-3 font-body text-on-surface uppercase text-sm tracking-widest">
                @foreach(['plan_to_read' => 'Rencana Dibaca', 'reading' => 'Sedang Dibaca', 'completed' => 'Selesai', 'wishlist' => 'Incaran / Wishlist'] as $val => $lbl)
                    <option value="{{ $val }}" {{ old('status', $comic?->status ?? '') === $val ? 'selected' : '' }}>
                        {{ $lbl }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Prioritas --}}
        <div>
            <label class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant block mb-2">
                Prioritas (Untuk Incaran)
            </label>
            <select name="priority"
                    class="w-full bg-surface-container-low border-0 focus:ring-2 focus:ring-primary px-4 py-3 font-body text-on-surface uppercase text-sm tracking-widest">
                <option value="">Tidak Ada</option>
                @foreach(['low' => 'Rendah', 'medium' => 'Menengah', 'high' => 'Tinggi', 'extreme' => 'Ekstrem'] as $val => $lbl)
                    <option value="{{ $val }}" {{ old('priority', $comic?->priority ?? '') === $val ? 'selected' : '' }}>
                        {{ $lbl }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Harga --}}
        <div>
            <label class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant block mb-2">
                Estimasi Harga (Untuk Incaran/Koleksi)
            </label>
            <input name="price"
                   value="{{ old('price', $comic?->price ?? '') }}"
                   type="number"
                   step="1000"
                   class="w-full bg-surface-container-low border-0 focus:ring-2 focus:ring-primary px-4 py-3 font-body text-on-surface placeholder:text-outline/40"
                   placeholder="40000"/>
        </div>

    </div>

    {{-- Tag / Genre --}}
    <div>
        <label class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant block mb-2">
            Tag / Genre (Pisahkan dengan koma)
        </label>
        <input name="tags_input"
               value="{{ old('tags_input', $tagsString ?? '') }}"
               class="w-full bg-surface-container-low border-0 focus:ring-2 focus:ring-primary px-4 py-3 font-body text-on-surface placeholder:text-outline/40 uppercase text-sm tracking-widest"
               placeholder="misal: Action, Shonen"
               type="text"/>
    </div>

    {{-- Sinopsis --}}
    <div>
        <label class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant block mb-2">
            Sinopsis Naratif
        </label>
        <textarea name="description"
                  class="w-full bg-surface-container-low border-0 focus:ring-2 focus:ring-primary px-4 py-4 font-body text-on-surface leading-relaxed resize-none"
                  placeholder="Deskripsikan perjalanan, dunianya, dan keadaannya..."
                  rows="6">{{ old('description', $comic?->description ?? '') }}</textarea>
    </div>

    {{-- Tombol Submit --}}
    <div class="pt-6">
        <button type="submit"
                class="group relative inline-flex items-center justify-center w-full md:w-auto px-12 py-5 bg-gradient-to-br from-primary to-primary-container text-on-primary font-headline font-extrabold tracking-tighter text-xl uppercase transition-all active:scale-95 shadow-lg shadow-primary/10">
            <span>{{ $submitLabel }}</span>
            <span class="material-symbols-outlined ml-3 group-hover:translate-x-1 transition-transform"
                  data-icon="{{ $submitIcon }}">{{ $submitIcon }}</span>
        </button>
    </div>

</div>
