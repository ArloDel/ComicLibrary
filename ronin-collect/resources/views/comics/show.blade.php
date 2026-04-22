@extends('layouts.app')

@section('title', $comic->title . ' - Detail')

@section('extra_css')
<style>
/* For Detail Page, dark moody background */
body { background: #020603; }
.perspective-1000 { perspective: 1500px; transform-style: preserve-3d; }
</style>
@endsection

@section('content')

@include('comics.partials.show-hero-bg')

<div class="max-w-[1400px] mx-auto py-12 relative z-10 pt-32 px-4 md:px-0">

@include('comics.partials.show-metadata')

@include('comics.partials.show-volumes')

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Hero Bg Parallax Focus
    const bgImg = document.getElementById('hero-bg-img');
    let ticking = false;
    window.addEventListener('scroll', () => {
        if(!ticking) {
            window.requestAnimationFrame(() => {
                const s = window.scrollY;
                if(s < window.innerHeight) {
                    bgImg.style.transform = `translateY(${s * 0.4}px) scale(1.05)`;
                }
                ticking = false;
            });
            ticking = true;
        }
    }, {passive:true});

    // 3D Tilt Effect
    const tiltCards = document.querySelectorAll('.tilt-card');
    tiltCards.forEach(card => {
        const target = card.querySelector('.card-tilt-target');
        card.addEventListener('mousemove', e => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const xPct = (x / rect.width - 0.5) * 14; 
            const yPct = (y / rect.height - 0.5) * -14;
            target.style.transform = `rotateY(${xPct}deg) rotateX(${yPct}deg) scale3d(1.03, 1.03, 1.03)`;
        });
        card.addEventListener('mouseleave', () => {
            target.style.transform = `rotateY(0deg) rotateX(0deg) scale3d(1, 1, 1)`;
        });
    });
});
</script>
@endsection
