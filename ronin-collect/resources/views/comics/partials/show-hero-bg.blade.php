<!-- Hero Full Screen Parallax Background -->
<div class="fixed inset-0 z-0 h-[100vh] pointer-events-none overflow-hidden" id="hero-bg-container">
    <img alt="{{ $comic->title }}" 
         class="w-full h-[120%] object-cover object-top opacity-[0.25] select-none scale-105 transform origin-center mix-blend-screen" 
         id="hero-bg-img"
         src="{{ $comic->cover_image ? asset($comic->cover_image) : '' }}"/>
    <!-- Vignette / Fade out -->
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_transparent_0%,_#020603_100%)] opacity-95"></div>
    <div class="absolute inset-x-0 bottom-0 h-3/4 bg-gradient-to-t from-[#020603] via-[#020603]/90 to-transparent"></div>
</div>
