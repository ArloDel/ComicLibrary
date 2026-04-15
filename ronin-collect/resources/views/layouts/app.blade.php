<!DOCTYPE html>
<html class="light" lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta name="csrf-token" content="{{ csrf_token() }}"/>
<title>RONIN_COLLECT | @yield('title', 'Arsip')</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&family=Manrope:wght@400;500;600;700&family=Space_Grotesk:wght@400;700&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "on-error": "#ffffff",
                    "on-primary-container": "#fffbff",
                    "on-secondary-container": "#445a7f",
                    "inverse-primary": "#ffb3b1",
                    "surface-container-high": "#e2ebdf",
                    "secondary": "#485f84",
                    "surface-container-low": "#edf6ea",
                    "on-tertiary": "#ffffff",
                    "secondary-fixed-dim": "#b0c7f1",
                    "tertiary-fixed-dim": "#c6c6c6",
                    "background": "#f3fcf0",
                    "on-primary-fixed-variant": "#92001c",
                    "surface-container-lowest": "#ffffff",
                    "on-background": "#161d16",
                    "on-tertiary-container": "#fcfcfc",
                    "secondary-fixed": "#d5e3ff",
                    "on-tertiary-fixed-variant": "#474747",
                    "primary-container": "#db313f",
                    "primary-fixed": "#ffdad8",
                    "outline": "#8f6f6e",
                    "surface-bright": "#f3fcf0",
                    "surface-variant": "#dce5d9",
                    "surface-container": "#e7f0e5",
                    "inverse-surface": "#2a322b",
                    "secondary-container": "#bbd3fd",
                    "on-tertiary-fixed": "#1b1b1b",
                    "on-primary": "#ffffff",
                    "tertiary": "#5c5c5c",
                    "outline-variant": "#e4bebc",
                    "error": "#ba1a1a",
                    "on-surface": "#161d16",
                    "tertiary-fixed": "#e2e2e2",
                    "primary": "#b7102a",
                    "inverse-on-surface": "#eaf3e7",
                    "on-secondary": "#ffffff",
                    "tertiary-container": "#747474",
                    "error-container": "#ffdad6",
                    "on-primary-fixed": "#410007",
                    "surface-dim": "#d4ddd1",
                    "on-surface-variant": "#5b403f",
                    "on-error-container": "#93000a",
                    "primary-fixed-dim": "#ffb3b1",
                    "surface": "#f3fcf0",
                    "surface-tint": "#bb152c",
                    "surface-container-highest": "#dce5d9",
                    "on-secondary-fixed": "#001b3c",
                    "on-secondary-fixed-variant": "#30476a"
            },
            "borderRadius": {
                    "DEFAULT": "0rem",
                    "lg": "0rem",
                    "xl": "0rem",
                    "full": "9999px"
            },
            "fontFamily": {
                    "headline": ["Plus Jakarta Sans"],
                    "body": ["Manrope"],
                    "label": ["Space Grotesk"]
            }
          },
        },
      }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .vertical-text {
            writing-mode: vertical-rl;
        }
        @yield('extra_css')
</style>
</head>
<body class="bg-background text-on-background font-body selection:bg-primary-fixed selection:text-on-primary-fixed-variant">

<!-- TopNavBar -->
<nav class="fixed top-0 w-full z-50 bg-[#f3fcf0]/80 dark:bg-[#161d16]/80 backdrop-blur-md flex justify-between items-center px-8 py-4 w-full border-b border-surface-variant/30">
<div class="flex items-center gap-8">
<a href="{{ route('dashboard') }}" class="text-2xl font-black text-[#161d16] dark:text-[#f3fcf0] tracking-tighter font-headline uppercase">RONIN_COLLECT</a>
<div class="hidden md:flex gap-6 font-headline tracking-tighter uppercase text-sm">
<a class="{{ request()->routeIs('dashboard') ? 'text-[#b7102a] border-b-4 border-[#b7102a] pb-1' : 'text-[#161d16] dark:text-[#f3fcf0] opacity-70 hover:text-[#b7102a]' }} transition-colors duration-200" href="{{ route('dashboard') }}">Dasbor</a>
<a class="{{ request()->routeIs('comics.index') || request()->routeIs('comics.show') ? 'text-[#b7102a] border-b-4 border-[#b7102a] pb-1' : 'text-[#161d16] dark:text-[#f3fcf0] opacity-70 hover:text-[#b7102a]' }} transition-colors duration-200" href="{{ route('comics.index') }}">Perpustakaan</a>
<a class="text-[#161d16] dark:text-[#f3fcf0] opacity-70 hover:text-[#b7102a] transition-colors duration-200" href="#">Pasar</a>
<a class="text-[#161d16] dark:text-[#f3fcf0] opacity-70 hover:text-[#b7102a] transition-colors duration-200" href="#">Kurasi</a>
</div>
</div>
<div class="flex items-center gap-6">
<div class="relative hidden lg:block">
<input class="bg-transparent border-t-0 border-l-0 border-r-0 border-b-2 border-primary focus:ring-0 focus:border-primary-container text-xs font-label tracking-widest placeholder:opacity-50 w-64 uppercase" placeholder="CARI ARSIP..." type="text"/>
<span class="material-symbols-outlined absolute right-0 top-1/2 -translate-y-1/2 text-primary">search</span>
</div>
<div class="flex items-center gap-4">
<span class="material-symbols-outlined text-on-background opacity-70 cursor-pointer scale-105 transition-transform hover:text-primary">notifications</span>
<img alt="User profile" class="w-8 h-8 rounded-none border border-outline-variant bg-surface-container-low" data-alt="close up minimalist portrait" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDoHCpM7RNCEIsVWdImVdX5zT1vJ81G74hS9cohqQ-12xik0QMHhLaRsncf70ztYw7Q5UWo6oPcFMWJCion0Snphx-fGhgDyh024_6wikr9CgXeKcGvqGthK-P4piyTVvCN6-fPbp02rhypzZvqNRARyC-yQ_jKbXjJZ2UH5-rUA3sYKPM6s8bI-JnA3RvsUO27zHgUydSb4QTYGjuio3ArWDPuyW7MFWv1PCtB6f4v-AwPfxtvK9ZOdfqUWNzZ-1E8JvIq59iC1lQ"/>
<form action="{{ route('logout') }}" method="POST" class="inline">
    @csrf
    <button type="submit" class="font-label text-[10px] tracking-widest text-[#b7102a] hover:underline uppercase ml-2 pt-1 font-bold">KELUAR</button>
</form>
</div>
</div>
</nav>

@hasSection('sidebar')
    @yield('sidebar')
@else
    <div class="flex pt-20 min-h-screen">
    <!-- SideNavBar (Desktop Only) -->
    <aside class="hidden md:flex flex-col h-screen w-64 fixed left-0 bg-[#edf6ea] dark:bg-[#1c261c] py-20">
    <div class="px-6 mb-12">
    <div class="flex items-center gap-3 mb-6">
    <div class="w-10 h-10 bg-primary flex items-center justify-center">
    <span class="material-symbols-outlined text-white">star</span>
    </div>
    <div>
    <h3 class="font-headline font-black text-xs tracking-tighter uppercase">ARSIP_01</h3>
    <p class="font-label text-[10px] text-primary tracking-widest">Status Kurator Utama</p>
    </div>
    </div>
    <a href="{{ route('comics.create') }}" class="w-full block text-center bg-primary text-white font-label text-[10px] tracking-widest py-3 hover:bg-primary-container transition-colors uppercase">
        TAMBAH KOMIK BARU
    </a>
    </div>
    <nav class="flex-1 overflow-y-auto">
    <div class="flex flex-col gap-1">
    <a class="bg-[#b7102a] text-white font-bold p-4 flex items-center gap-4 font-label text-xs tracking-widest uppercase cursor-pointer" href="{{ route('comics.index') }}">
    <span class="material-symbols-outlined" data-icon="menu_book">menu_book</span>
                            Shonen
                        </a>
    <a class="text-[#161d16] dark:text-[#f3fcf0] p-4 flex items-center gap-4 font-label text-xs tracking-widest uppercase cursor-pointer hover:bg-[#ffdad8] transition-all" href="{{ route('comics.index') }}">
    <span class="material-symbols-outlined" data-icon="visibility">visibility</span>
                            Seinen
                        </a>
    <a class="text-[#161d16] dark:text-[#f3fcf0] p-4 flex items-center gap-4 font-label text-xs tracking-widest uppercase cursor-pointer hover:bg-[#ffdad8] transition-all" href="{{ route('comics.index') }}">
    <span class="material-symbols-outlined" data-icon="favorite">favorite</span>
                            Shojo
                        </a>
    </div>
    </nav>
    <div class="mt-auto px-4 py-8 flex flex-col gap-2">
    <a class="flex items-center gap-4 text-on-surface p-2 font-label text-[10px] tracking-widest opacity-70 hover:opacity-100 transition-opacity uppercase" href="#">
    <span class="material-symbols-outlined text-sm" data-icon="settings">settings</span>
                        Pengaturan
                    </a>
    </div>
    </aside>

    <main class="flex-1 md:ml-64 p-8 bg-surface mt-20">
        @yield('content')
    </main>
    </div>
@endif

<!-- Footer -->
<footer class="bg-[#161d16] dark:bg-[#0a0f0a] w-full py-12 flex flex-col md:flex-row justify-between items-center px-12 mt-auto z-50 relative">
<div class="mb-8 md:mb-0">
<span class="text-[#f3fcf0] font-black tracking-tighter font-headline text-xl uppercase">RONIN_COLLECT</span>
<p class="text-[#f3fcf0] opacity-50 font-body text-[10px] tracking-widest uppercase mt-2">© 2024 SANG KURATOR RONIN. HAK CIPTA DILINDUNGI.</p>
</div>
<div class="flex flex-wrap justify-center gap-8 font-label text-[10px] tracking-widest uppercase">
<a class="text-[#f3fcf0] opacity-50 hover:opacity-100 transition-opacity underline-offset-4 hover:underline" href="#">Twitter</a>
<a class="text-[#f3fcf0] opacity-50 hover:opacity-100 transition-opacity underline-offset-4 hover:underline" href="#">Instagram</a>
<a class="text-[#f3fcf0] opacity-50 hover:opacity-100 transition-opacity underline-offset-4 hover:underline" href="#">Syarat & Ketentuan</a>
</div>
</footer>

@yield('fab')

</body>
</html>
