@extends('layouts.app')

@section('title', 'Koleksiku')

@section('content')
@include('comics.partials.index-header-filters')

<!-- Parallax Background blobs for library -->
<div class="fixed inset-0 z-0 pointer-events-none overflow-hidden mix-blend-screen opacity-40">
    <div class="absolute top-[20%] right-[-10%] w-[800px] h-[800px] bg-primary/20 rounded-full blur-[200px] bg-parallax"></div>
    <div class="absolute bottom-[0%] left-[-10%] w-[600px] h-[600px] bg-[#0c2e15]/60 rounded-full blur-[150px] bg-parallax"></div>
</div>

@include('comics.partials.index-grid')

<!-- Frameless FAB -->
<a href="{{ route('comics.create') }}" class="fixed bottom-8 right-8 z-[60] w-14 h-14 rounded-full bg-white text-black flex items-center justify-center hover:scale-110 hover:-translate-y-2 transition-all duration-300 group shadow-[0_4px_30px_rgba(255,255,255,0.4)] hover:shadow-[0_8px_40px_rgba(255,255,255,0.6)] cursor-pointer">
    <div class="absolute inset-0 bg-primary/20 rounded-full scale-0 group-hover:scale-100 transition-transform duration-300 ease-out"></div>
    <span class="material-symbols-outlined relative z-10 text-2xl transition-colors font-bold group-hover:text-primary">add</span>
</a>

@include('comics.partials.index-sidebar')

@endsection

@section('extra_css')
<style>
    .perspective-1000 { perspective: 1500px; transform-style: preserve-3d; }
    .custom-scroll::-webkit-scrollbar { width: 4px; }
    .custom-scroll::-webkit-scrollbar-thumb { background: rgba(183,16,42,0.3); border-radius: 99px; }
    .custom-scroll::-webkit-scrollbar-thumb:hover { background: rgba(183,16,42,0.8); }
</style>
@endsection

@section('fab')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // 3D Tilt Effect applied just to images
    const tiltCards = document.querySelectorAll('.tilt-card');
    tiltCards.forEach(card => {
        const target = card.querySelector('.card-tilt-target');
        card.addEventListener('mousemove', e => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const xPct = (x / rect.width - 0.5) * 12; 
            const yPct = (y / rect.height - 0.5) * -12;
            target.style.transform = `rotateY(${xPct}deg) rotateX(${yPct}deg) scale3d(1.03, 1.03, 1.03)`;
        });
        card.addEventListener('mouseleave', () => {
            target.style.transform = `rotateY(0deg) rotateX(0deg) scale3d(1, 1, 1)`;
        });
    });

    // Simple Parallax scroll
    const bgs = document.querySelectorAll('.bg-parallax');
    const covers = document.querySelectorAll('.cover-parallax');
    
    let ticking = false;
    window.addEventListener('scroll', () => {
        if(!ticking) {
            requestAnimationFrame(() => {
                const sy = window.scrollY;
                bgs.forEach(bg => { bg.style.transform = `translateY(${sy * 0.25}px)`; });
                covers.forEach(c => {
                    const rect = c.getBoundingClientRect();
                    // if in viewport
                    if(rect.top < window.innerHeight && rect.bottom > 0) {
                        c.style.transform = `translateY(${(rect.top - window.innerHeight/2)* -0.15}px) scale(1.05)`;
                    }
                });
                ticking = false;
            });
            ticking = true;
        }
    }, {passive: true});

    // TACTICAL FILTER SIDEBAR LOGIC (SLIDE IN/OUT)
    const toggleBtn = document.getElementById('toggleFilterBtn');
    const closeBtn = document.getElementById('closeFilterBtn');
    const sidebar = document.getElementById('filterSidebar');
    const overlay = document.getElementById('filterOverlay');
    const mainGrid = document.getElementById('mainGrid');

    function openSidebar() {
        sidebar.classList.remove('translate-x-full');
        overlay.classList.remove('opacity-0', 'pointer-events-none');
        overlay.classList.add('opacity-100');
        
        // 3D Push back effect on main grid when sidebar opens
        if(window.innerWidth > 768) {
            mainGrid.style.transform = 'perspective(1500px) rotateY(-3deg) translateX(-2%) scale(0.95)';
            mainGrid.style.filter = 'blur(2px)';
            mainGrid.style.opacity = '0.4';
        }
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        sidebar.classList.add('translate-x-full');
        overlay.classList.add('opacity-0', 'pointer-events-none');
        overlay.classList.remove('opacity-100');
        
        // Restore main grid
        mainGrid.style.transform = '';
        mainGrid.style.filter = '';
        mainGrid.style.opacity = '1';
        document.body.style.overflow = '';
    }

    if (toggleBtn) toggleBtn.addEventListener('click', openSidebar);
    if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
    if (overlay) overlay.addEventListener('click', closeSidebar);
});
</script>
@endsection
