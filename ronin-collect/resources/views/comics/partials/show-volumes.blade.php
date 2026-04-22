<!-- Subsystem / Volumes (Frameless Layout) -->
<div class="relative pt-16 mt-12 border-t border-white/5 animate-fade-up animate-delay-200">
    <div class="absolute top-0 right-[20%] w-[600px] h-40 bg-primary/10 blur-[150px] rounded-full pointer-events-none mix-blend-screen"></div>

    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-6 mb-16 px-4 md:px-0">
        <div>
            <h3 class="font-headline font-black text-4xl md:text-5xl uppercase tracking-tighter text-white mb-3 text-glow">
                Log Sub_Volume
            </h3>
            <span class="font-label text-[10px] tracking-[0.4em] text-[#8aab8c] font-bold uppercase block pl-1">Total Entitas Terhubung: <span class="text-white">{{ $comic->volumes->count() }}</span></span>
        </div>
        <a href="{{ route('volumes.create', ['comic_id' => $comic->id]) }}" class="border-b-2 border-primary text-white pb-1 font-label text-[10px] tracking-[0.4em] font-bold hover:text-primary transition-colors flex items-center gap-2 uppercase">
            Tambah Volume Baru <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
        </a>
    </div>
    
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-x-6 gap-y-12 perspective-1000 px-4 md:px-0">
        @forelse($comic->volumes as $index => $volume)
        <div class="tilt-card group block w-full cursor-pointer" style="animation: fade-up 0.6s ease both; animation-delay: {{ $index*60 }}ms;" onclick="window.location='{{ route('volumes.edit', $volume) }}'">
            <!-- Pure Image Block -->
            <div class="card-tilt-target relative overflow-hidden rounded-[20px] w-full bg-[#080f0a] shadow-2xl group-hover:shadow-[0_15px_40px_rgba(183,16,42,0.15)] transition-all duration-700 mb-5 border border-transparent group-hover:border-primary/30" style="aspect-ratio: 2/3;">
                <img class="absolute inset-0 w-[110%] h-[110%] object-cover transition-all duration-700 group-hover:scale-105 opacity-80 group-hover:opacity-100" src="{{ $volume->cover_image ? asset($volume->cover_image) : ($comic->cover_image ? asset($comic->cover_image) : '') }}" />
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 group-hover:from-black/70 group-hover:via-transparent transition-colors"></div>
                
                <div class="absolute inset-x-0 top-1/2 -translate-y-1/2 text-center pointer-events-none origin-center transform group-hover:scale-[0.8] group-hover:opacity-0 transition-all duration-500">
                    <span class="text-[80px] font-black font-headline text-white/90 drop-shadow-2xl">{{ str_pad($volume->volume_number, 2, '0', STR_PAD_LEFT) }}</span>
                </div>

                <!-- Hover Text Overlay -->
                <div class="absolute bottom-4 inset-x-0 flex justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                    <span class="text-white font-headline font-bold text-lg tracking-tight drop-shadow-[0_0_10px_rgba(183,16,42,1)]">VOL. {{ $volume->volume_number }}</span>
                </div>
            </div>
            
            <!-- Metadata under Image -->
            <div class="flex justify-between items-start px-2 border-l border-white/10 group-hover:border-primary/50 transition-colors">
                <p class="font-label text-[9px] tracking-[0.3em] text-[#8aab8c] uppercase font-bold mb-1">
                    {{ $volume->acquisition_date ? $volume->acquisition_date->format('M Y') : 'WAKTU [N/A]' }}
                </p>
                <span class="text-white/20 group-hover:text-primary font-label text-[9px] tracking-[0.3em] font-bold uppercase transition-colors">EDIT</span>
            </div>
        </div>
        @empty
        <div class="col-span-full py-32 text-center flex flex-col justify-center items-center rounded-3xl w-full">
            <span class="material-symbols-outlined text-4xl text-white/10 mb-6 drop-shadow">bookmark_remove</span>
            <span class="font-label tracking-[0.4em] text-white/30 uppercase text-[10px] font-bold">Fragmen data kosong. Menunggu inisiasi volume.</span>
        </div>
        @endforelse
    </div>
</div>
