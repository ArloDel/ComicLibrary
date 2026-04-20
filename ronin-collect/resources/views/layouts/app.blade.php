<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta name="csrf-token" content="{{ csrf_token() }}"/>
<title>RONIN_COLLECT | @yield('title', 'Arsip')</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,700;0,800;1,800&family=Manrope:wght@400;500;600;700&family=Space+Grotesk:wght@400;700&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script id="tailwind-config">
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          "primary":                   "#b7102a",
          "primary-bright":            "#e8192e",
          "primary-dim":               "#7a0b1c",
          "primary-container":         "#db313f",
          "primary-fixed":             "#ffdad8",
          "primary-fixed-dim":         "#ffb3b1",
          "on-primary":                "#ffffff",
          "on-primary-fixed":          "#410007",
          "on-primary-fixed-variant":  "#92001c",
          "background":                "#0c1a0e",
          "surface":                   "#111f13",
          "surface-dim":               "#0a160c",
          "surface-bright":            "#1e3020",
          "surface-variant":           "#1c2e1e",
          "surface-container-lowest":  "#0a160c",
          "surface-container-low":     "#111f13",
          "surface-container":         "#162018",
          "surface-container-high":    "#1c2a1e",
          "surface-container-highest": "#223024",
          "on-surface":                "#e8f5e9",
          "on-surface-variant":        "#8aab8c",
          "on-background":             "#e8f5e9",
          "outline":                   "#3d5e41",
          "outline-variant":           "#2a3e2c",
          "inverse-surface":           "#e8f5e9",
          "inverse-on-surface":        "#0c1a0e",
          "inverse-primary":           "#ffb3b1",
          "secondary":                 "#a0bcff",
          "on-secondary":              "#001b3c",
          "secondary-container":       "#30476a",
          "on-secondary-container":    "#d5e3ff",
          "tertiary":                  "#b8bec8",
          "on-tertiary":               "#23282f",
          "tertiary-container":        "#3a3f47",
          "on-tertiary-container":     "#d4dbe6",
          "error":                     "#ffb4ab",
          "on-error":                  "#690005",
          "error-container":           "#93000a",
          "on-error-container":        "#ffdad6",
        },
        borderRadius: {
          "DEFAULT": "8px",
          "sm":  "6px",
          "md":  "12px",
          "lg":  "16px",
          "xl":  "24px",
          "2xl": "32px",
          "3xl": "48px",
          "full": "9999px",
        },
        fontFamily: {
          "headline": ["Plus Jakarta Sans"],
          "body":     ["Manrope"],
          "label":    ["Space Grotesk"],
        },
      },
    },
  }
</script>
<style>
  /* ============================================================
     RONIN COLLECT — Global Design System
     Dark Glassmorphism + Parallax Theme
  ============================================================ */
  :root {
    --primary:           #b7102a;
    --primary-glow:      rgba(183, 16, 42, 0.4);
    --primary-glow-soft: rgba(183, 16, 42, 0.15);
    --glass-bg:          rgba(17, 31, 19, 0.55);
    --glass-border:      rgba(255, 255, 255, 0.07);
    --glass-hover:       rgba(183, 16, 42, 0.35);
  }

  *, *::before, *::after { box-sizing: border-box; }

  html, body { background: #0c1a0e; color: #e8f5e9; scroll-behavior: smooth; }

  /* Custom scrollbar */
  ::-webkit-scrollbar { width: 4px; }
  ::-webkit-scrollbar-track { background: #0a160c; }
  ::-webkit-scrollbar-thumb { background: var(--primary); border-radius: 2px; }

  /* ---- Glass Utilities ---- */
  .glass {
    background: var(--glass-bg);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid var(--glass-border);
  }

  .glass-card {
    background: rgba(17, 31, 19, 0.55);
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
    border: 1px solid rgba(255, 255, 255, 0.07);
    border-radius: 16px;
    transition: border-color 0.4s ease, box-shadow 0.4s ease, transform 0.4s cubic-bezier(0.23,1,0.32,1);
  }

  .glass-card:hover {
    border-color: rgba(183, 16, 42, 0.3);
    box-shadow: 0 8px 40px rgba(183, 16, 42, 0.1), 0 2px 8px rgba(0,0,0,0.4);
    transform: translateY(-2px);
  }

  /* ---- Glow ---- */
  .glow-red {
    box-shadow: 0 0 20px var(--primary-glow), 0 0 60px var(--primary-glow-soft);
  }
  .text-glow { text-shadow: 0 0 40px var(--primary-glow); }

  /* ---- Parallax ---- */
  .parallax-blob {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    pointer-events: none;
    will-change: transform;
  }

  /* ---- Animations ---- */
  @keyframes float-blob {
    0%,100% { transform: translate(0,0) scale(1); }
    33%     { transform: translate(30px,-40px) scale(1.05); }
    66%     { transform: translate(-20px,20px) scale(0.95); }
  }
  @keyframes float-blob-2 {
    0%,100% { transform: translate(0,0) scale(1); }
    33%     { transform: translate(-40px,30px) scale(1.08); }
    66%     { transform: translate(25px,-20px) scale(0.92); }
  }
  @keyframes fade-up {
    from { opacity:0; transform:translateY(28px); }
    to   { opacity:1; transform:translateY(0); }
  }
  @keyframes fade-in {
    from { opacity:0; }
    to   { opacity:1; }
  }
  @keyframes pulse-orb {
    0%,100% { box-shadow: 0 0 14px var(--primary-glow-soft); }
    50%     { box-shadow: 0 0 28px var(--primary-glow), 0 0 60px var(--primary-glow-soft); }
  }

  .animate-fade-up        { animation: fade-up  0.8s cubic-bezier(0.23,1,0.32,1) both; }
  .animate-fade-in        { animation: fade-in  0.6s ease both; }
  .animate-delay-100      { animation-delay: .1s; }
  .animate-delay-200      { animation-delay: .2s; }
  .animate-delay-300      { animation-delay: .3s; }
  .animate-delay-400      { animation-delay: .4s; }
  .animate-delay-500      { animation-delay: .5s; }

  /* ---- 3D Tilt ---- */
  .tilt-card { transform-style: preserve-3d; }

  /* ---- Nav active pill ---- */
  .nav-pill-active {
    color: var(--primary);
    background: rgba(183,16,42,.12);
    padding: 5px 14px;
    border-radius: 9999px;
  }

  /* ---- Scroll reveal ---- */
  .reveal-on-scroll { opacity: 0; }

  /* ---- Material Symbols ---- */
  .material-symbols-outlined {
    font-variation-settings: 'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 24;
  }
  .vertical-text { writing-mode: vertical-rl; }

  @yield('extra_css')
</style>
</head>
<body class="bg-background text-on-surface font-body overflow-x-hidden selection:bg-primary selection:text-white">

<!-- ====================================================
     TOP NAVBAR — Floating Glass Pill
==================================================== -->
<nav id="topnav"
     class="fixed top-4 left-1/2 -translate-x-1/2 z-50 glass rounded-full px-5 py-2.5 flex justify-between items-center transition-all duration-500"
     style="width: calc(100% - 2rem); max-width: 80rem;">

  <!-- Brand + Links -->
  <div class="flex items-center gap-5">
    <a href="{{ route('dashboard') }}"
       class="text-base font-black text-on-surface tracking-tighter font-headline uppercase flex items-center gap-2">
      <span class="w-5 h-5 bg-primary rounded-full flex-shrink-0"
            style="animation: pulse-orb 3s ease-in-out infinite;"></span>
      RONIN_COLLECT
    </a>
    <div class="hidden md:flex gap-0.5 font-label text-xs font-bold uppercase tracking-tight">
      <a href="{{ route('dashboard') }}"
         class="{{ request()->routeIs('dashboard') ? 'nav-pill-active' : 'text-on-surface/50 hover:text-on-surface px-3.5 py-1.5 rounded-full hover:bg-white/5' }} transition-all duration-200">
        Dasbor
      </a>
      <a href="{{ route('comics.index') }}"
         class="{{ request()->routeIs('comics.index') || request()->routeIs('comics.show') ? 'nav-pill-active' : 'text-on-surface/50 hover:text-on-surface px-3.5 py-1.5 rounded-full hover:bg-white/5' }} transition-all duration-200">
        Perpustakaan
      </a>
      <a href="{{ route('market.index') }}"
         class="{{ request()->routeIs('market.index') ? 'nav-pill-active' : 'text-on-surface/50 hover:text-on-surface px-3.5 py-1.5 rounded-full hover:bg-white/5' }} transition-all duration-200">
        Pasar
      </a>
    </div>
  </div>

  <!-- Search + Actions -->
  <div class="flex items-center gap-3">
    <div class="relative hidden lg:block">
      <input type="text"
             placeholder="CARI ARSIP..."
             class="bg-white/5 border border-white/8 rounded-full text-xs font-label tracking-widest placeholder:text-on-surface/25 w-48 px-4 py-2 focus:outline-none focus:border-primary/50 focus:bg-white/8 transition-all uppercase text-on-surface"/>
      <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface/40 text-sm">search</span>
    </div>
    <button class="w-8 h-8 glass rounded-full flex items-center justify-center text-on-surface/50 hover:text-primary transition-colors">
      <span class="material-symbols-outlined text-base">notifications</span>
    </button>
    <div class="w-8 h-8 rounded-full overflow-hidden border-2 border-primary/25 hover:border-primary transition-colors">
      <img alt="User" class="w-full h-full object-cover"
           src="https://lh3.googleusercontent.com/aida-public/AB6AXuDoHCpM7RNCEIsVWdImVdX5zT1vJ81G74hS9cohqQ-12xik0QMHhLaRsncf70ztYw7Q5UWo6oPcFMWJCion0Snphx-fGhgDyh024_6wikr9CgXeKcGvqGthK-P4piyTVvCN6-fPbp02rhypzZvqNRARyC-yQ_jKbXjJZ2UH5-rUA3sYKPM6s8bI-JnA3RvsUO27zHgUydSb4QTYGjuio3ArWDPuyW7MFWv1PCtB6f4v-AwPfxtvK9ZOdfqUWNzZ-1E8JvIq59iC1lQ"/>
    </div>
    <form action="{{ route('logout') }}" method="POST" class="inline">
      @csrf
      <button type="submit"
              class="font-label text-[10px] tracking-widest text-primary hover:text-primary-bright uppercase font-bold transition-colors">
        KELUAR
      </button>
    </form>
  </div>
</nav>

@hasSection('sidebar')
    @yield('sidebar')
@else
    <!-- ====================================================
         DEFAULT LAYOUT: Icon-only floating glass sidebar
    ==================================================== -->
    <div class="flex pt-16 min-h-screen">

      <!-- Sidebar -->
      <aside class="hidden md:flex flex-col items-center gap-4 py-6 fixed left-4 z-40 glass rounded-2xl"
             style="top: calc(1rem + 64px); height: calc(100vh - 6rem); width: 72px;">

        <a href="{{ route('comics.create') }}"
           class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center hover:bg-primary-bright transition-colors group relative"
           style="box-shadow: 0 4px 20px rgba(183,16,42,.4);">
          <span class="material-symbols-outlined text-white text-xl">add</span>
          <span class="tooltip-pill">Tambah Komik</span>
        </a>

        <div class="w-8 h-px bg-white/8"></div>

        <nav class="flex flex-col gap-3 items-center flex-1">
          <a href="{{ route('dashboard') }}"
             class="{{ request()->routeIs('dashboard') ? 'text-primary bg-primary/10' : 'text-on-surface/35 hover:text-on-surface/70 hover:bg-white/5' }} w-10 h-10 rounded-xl flex items-center justify-center transition-all group relative">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="tooltip-pill">Dasbor</span>
          </a>
          <a href="{{ route('comics.index') }}"
             class="{{ request()->routeIs('comics.*') ? 'text-primary bg-primary/10' : 'text-on-surface/35 hover:text-on-surface/70 hover:bg-white/5' }} w-10 h-10 rounded-xl flex items-center justify-center transition-all group relative">
            <span class="material-symbols-outlined">menu_book</span>
            <span class="tooltip-pill">Perpustakaan</span>
          </a>
          <a href="{{ route('comics.index') }}"
             class="text-on-surface/35 hover:text-on-surface/70 hover:bg-white/5 w-10 h-10 rounded-xl flex items-center justify-center transition-all group relative">
            <span class="material-symbols-outlined">favorite</span>
            <span class="tooltip-pill">Favorit</span>
          </a>
        </nav>

        <button class="text-on-surface/25 hover:text-on-surface/60 w-10 h-10 rounded-xl flex items-center justify-center transition-all group relative">
          <span class="material-symbols-outlined">settings</span>
          <span class="tooltip-pill">Pengaturan</span>
        </button>
      </aside>

      <main class="flex-1 md:ml-24 p-8 min-h-screen">
        @yield('content')
      </main>
    </div>
@endif

<!-- ====================================================
     FOOTER — Slanted glass
==================================================== -->
<footer class="relative mt-24 pt-16 pb-12 px-8 md:px-16 overflow-hidden"
        style="background: #080f09;">
  <!-- Slant top edge -->
  <div class="absolute inset-x-0 top-0 h-16 bg-background pointer-events-none"
       style="clip-path: polygon(0 0, 100% 0, 100% 0, 0 100%);"></div>
  <!-- Red glow -->
  <div class="absolute top-0 left-1/4 w-96 h-32 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>

  <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
    <div>
      <span class="font-headline font-black text-xl uppercase tracking-tighter text-on-surface flex items-center gap-2">
        <span class="w-4 h-4 bg-primary rounded-full" style="box-shadow:0 0 10px rgba(183,16,42,.6);"></span>
        RONIN_COLLECT
      </span>
      <p class="text-on-surface/25 font-label text-[10px] tracking-widest uppercase mt-2">
        © 2024 SANG KURATOR RONIN. HAK CIPTA DILINDUNGI.
      </p>
    </div>
    <div class="flex flex-wrap justify-center gap-8 font-label text-[10px] tracking-widest uppercase">
      <a class="text-on-surface/35 hover:text-primary transition-colors" href="#">Twitter</a>
      <a class="text-on-surface/35 hover:text-primary transition-colors" href="#">Instagram</a>
      <a class="text-on-surface/35 hover:text-primary transition-colors" href="#">Syarat &amp; Ketentuan</a>
    </div>
  </div>
</footer>

@yield('fab')

<!-- ====================================================
     GLOBAL SCRIPTS
==================================================== -->
<style>
  .tooltip-pill {
    position: absolute;
    left: calc(100% + 10px);
    top: 50%;
    transform: translateY(-50%);
    background: #162018;
    color: #e8f5e9;
    font-size: 10px;
    font-family: 'Space Grotesk', sans-serif;
    letter-spacing: .1em;
    text-transform: uppercase;
    padding: 5px 12px;
    border-radius: 9999px;
    white-space: nowrap;
    border: 1px solid rgba(255,255,255,.08);
    opacity: 0;
    pointer-events: none;
    transition: opacity .2s ease;
    font-weight: 700;
  }
  .group:hover .tooltip-pill { opacity: 1; }
</style>
<script>
  /* Navbar scroll tint */
  const _nav = document.getElementById('topnav');
  window.addEventListener('scroll', () => {
    _nav.style.background = window.scrollY > 20
      ? 'rgba(10,20,11,0.92)' : '';
  }, { passive: true });

  /* Scroll-reveal via IntersectionObserver */
  const _io = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        e.target.style.animation = 'fade-up 0.7s cubic-bezier(0.23,1,0.32,1) both';
        e.target.style.opacity  = '1';
        _io.unobserve(e.target);
      }
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

  document.querySelectorAll('.reveal-on-scroll').forEach(el => _io.observe(el));
</script>
</body>
</html>
