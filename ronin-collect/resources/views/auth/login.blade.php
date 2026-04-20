<!DOCTYPE html>
<html class="dark" lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>RONIN_COLLECT | Gateway Otorisasi</title>
<script src="https://cdn.tailwindcss.com?plugins=forms"></script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800;900&family=Manrope:wght@400;500;600;700&family=Space+Grotesk:wght@400;700&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script id="tailwind-config">
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          "primary": "#b7102a",
          "primary-bright": "#e8192e",
          "background": "#020603",
        },
        fontFamily: {
          "headline": ["Plus Jakarta Sans"],
          "body": ["Manrope"],
          "label": ["Space Grotesk"]
        }
      }
    }
  }
</script>
<style>
    /* Premium Glassmorphism & Animations Login */
    @keyframes orb-float-1 {
        0%,100% { transform: translate(0,0) scale(1) rotate(0); }
        50% { transform: translate(-150px, 150px) scale(1.1) rotate(90deg); filter: blur(140px); }
    }
    @keyframes orb-float-2 {
        0%,100% { transform: translate(0,0) scale(1); }
        50% { transform: translate(150px, -200px) scale(0.9); filter: blur(120px); }
    }
    @keyframes float-slow {
        0%,100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    .orb-1 { animation: orb-float-1 30s infinite cubic-bezier(0.4, 0, 0.2, 1); }
    .orb-2 { animation: orb-float-2 25s infinite cubic-bezier(0.4, 0, 0.2, 1); }
    .float-slow { animation: float-slow 6s ease-in-out infinite; }
    
    .glass-panel {
        background: rgba(12, 26, 14, 0.4);
        backdrop-filter: blur(48px);
        -webkit-backdrop-filter: blur(48px);
        border: 1px solid rgba(255,255,255,0.06);
        border-radius: 40px;
        box-shadow: 0 40px 120px rgba(0,0,0,0.9), inset 0 0 0 1px rgba(255,255,255,0.03);
    }
    
    .input-glass {
        background: rgba(0,0,0,0.5);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 16px;
        color: white;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.5);
    }
    .input-glass:focus {
        background: rgba(183,16,42,0.15);
        border-color: rgba(183,16,42,0.8);
        box-shadow: 0 0 25px rgba(183,16,42,0.3), inset 0 2px 4px rgba(0,0,0,0.5);
        outline: none;
        transform: translateY(-2px);
    }

    body {
        margin: 0;
        background-color: #020603;
        background-image: radial-gradient(circle at 50% 50%, #0a140b 0%, #020603 100%);
    }

    .glow-text { text-shadow: 0 0 40px rgba(183,16,42,0.6); }
    
    /* Material icons setup */
    .material-symbols-outlined { font-variation-settings: 'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 24; }
</style>
</head>
<body class="text-white font-body min-h-screen flex items-center justify-center p-4 lg:p-12 overflow-hidden relative selection:bg-primary selection:text-white">

    <!-- Cinematic Background -->
    <div class="absolute inset-0 z-0 pointer-events-none mix-blend-screen overflow-hidden">
        <!-- noise overlay -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg viewBox=%220 0 200 200%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cfilter id=%22noiseFilter%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%220.8%22 numOctaves=%223%22 stitchTiles=%22stitch%22/%3E%3C/filter%3E%3Crect width=%22100%25%22 height=%22100%25%22 filter=%22url(%23noiseFilter)%22/%3E%3C/svg%3E')] opacity-[0.04]"></div>
        
        <!-- Animated Orbs -->
        <div class="absolute top-[0%] left-[-5%] w-[800px] h-[800px] bg-primary/25 rounded-full blur-[150px] orb-1 mix-blend-screen"></div>
        <div class="absolute bottom-[-10%] right-[-5%] w-[700px] h-[700px] bg-[#0c2e15]/40 rounded-full blur-[120px] orb-2 mix-blend-screen"></div>
    </div>

    <!-- Main Card -->
    <div class="w-full max-w-[1280px] flex flex-col lg:flex-row min-h-[720px] relative z-10 glass-panel overflow-hidden float-slow">
        
        <!-- Left: Branding Deco -->
        <div class="lg:w-[55%] p-10 lg:p-20 flex flex-col justify-between border-b lg:border-b-0 lg:border-r border-white/5 relative group">
            <div class="absolute inset-0 bg-gradient-to-br from-black/80 via-black/40 to-transparent z-0"></div>
            
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-10">
                    <span class="w-2.5 h-2.5 rounded-full bg-primary shadow-[0_0_15px_rgba(183,16,42,1)] animate-pulse"></span>
                    <span class="font-label text-white/50 tracking-[0.4em] text-[10px] font-bold uppercase block border border-white/10 px-3 py-1 rounded-full bg-white/5">Koneksi Aman / SSL 2048</span>
                </div>
                
                <h1 class="font-headline font-black text-6xl xl:text-[100px] tracking-tighter uppercase leading-[0.8] mb-8 text-transparent bg-clip-text bg-gradient-to-br from-white via-white/80 to-[#8aab8c] drop-shadow-2xl">
                    RONIN<br>
                    <span class="text-primary glow-text filter drop-shadow-[0_0_20px_rgba(183,16,42,0.8)] leading-[0.9] inline-block pt-2">COLLECT</span>
                </h1>
                
                <p class="font-body text-xl md:text-2xl text-white/60 font-medium max-w-md leading-relaxed drop-shadow-md">
                    Terminal kurasi terpadu .<br>Goresan tinta dijaga ketat di dalam brankas digital.
                </p>
            </div>

            <!-- Stylized watermark -->
            <div class="absolute bottom-10 right-10 vertical-text text-[150px] font-black font-headline text-white/[0.015] select-none pointer-events-none z-0 tracking-tighter">
                ARSIP
            </div>
            
            <div class="relative z-10 mt-16 lg:mt-0 flex flex-wrap gap-4">
                <span class="font-label text-[9px] tracking-[0.3em] font-bold text-[#8aab8c] uppercase border border-white/10 bg-white/5 px-4 py-2 rounded-full backdrop-blur-md">Sys V1.0.4</span>
                <span class="font-label text-[9px] tracking-[0.3em] font-bold text-[#8aab8c] uppercase border border-white/10 bg-white/5 px-4 py-2 rounded-full backdrop-blur-md flex items-center gap-2">
                    <span class="material-symbols-outlined text-[12px]">public</span> Node Tokyo
                </span>
            </div>
        </div>
        
        <!-- Right: Auth Form -->
        <div class="lg:w-[45%] p-10 lg:p-20 flex flex-col justify-center relative bg-gradient-to-l from-black/40 to-transparent">
            <div class="mb-14">
                <h2 class="font-headline font-black text-4xl lg:text-5xl uppercase tracking-tighter text-white mb-3 text-glow drop-shadow-xl">Otorisasi</h2>
                <p class="font-label text-xs tracking-[0.2em] text-primary uppercase font-bold flex items-center gap-2">
                    <span class="material-symbols-outlined text-[14px]">lock</span> Harap verifikasi identitas terminal
                </p>
            </div>
            
            <form action="{{ route('login') }}" method="POST" class="space-y-8 w-full">
                @csrf
                
                <div class="group/input">
                    <label class="font-label text-[10px] uppercase tracking-[0.3em] text-white/50 font-bold block mb-3 transition-colors group-focus-within/input:text-primary-bright">Akses ID</label>
                    <div class="relative">
                        <span class="absolute left-5 top-1/2 -translate-y-1/2 material-symbols-outlined text-white/40 group-focus-within/input:text-primary transition-colors text-xl">person</span>
                        <input name="name" value="{{ old('name') }}" type="text" required autofocus class="w-full input-glass pl-14 pr-5 py-4 font-body placeholder:text-white/20 text-lg" placeholder="ex. archivist_01"/>
                    </div>
                    @error('name')
                        <span class="text-primary-bright font-bold text-xs mt-3 tracking-wide flex items-center gap-1.5 bg-primary/10 border border-primary/30 p-2 rounded-lg">
                            <span class="material-symbols-outlined text-sm">warning</span> {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="group/input pt-2">
                    <label class="font-label text-[10px] uppercase tracking-[0.3em] text-white/50 font-bold block mb-3 transition-colors group-focus-within/input:text-primary-bright">Kode Enkripsi</label>
                    <div class="relative">
                        <span class="absolute left-5 top-1/2 -translate-y-1/2 material-symbols-outlined text-white/40 group-focus-within/input:text-primary transition-colors text-xl">key</span>
                        <input name="password" type="password" required class="w-full input-glass pl-14 pr-5 py-4 font-body placeholder:text-white/20 tracking-widest text-xl h-[62px]" placeholder="••••••••"/>
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-6 pb-8">
                    <div class="relative flex items-center cursor-pointer">
                        <input type="checkbox" name="remember" id="remember" class="peer w-6 h-6 rounded-lg border-white/20 bg-black/50 checked:bg-primary checked:border-primary focus:ring-primary focus:ring-offset-0 focus:ring-2 transition-all cursor-pointer">
                        <span class="material-symbols-outlined absolute pointer-events-none text-white text-[16px] left-[4px] opacity-0 peer-checked:opacity-100 transition-opacity drop-shadow">check</span>
                    </div>
                    <label for="remember" class="font-label text-[10px] uppercase tracking-[0.2em] font-bold text-white/50 cursor-pointer hover:text-white transition-colors">Bypass Sesi Berikutnya</label>
                </div>

                <button type="submit" class="w-full group relative inline-flex items-center justify-between p-5 bg-white text-black rounded-2xl font-headline font-extrabold tracking-tight text-xl shadow-[0_0_30px_rgba(255,255,255,0.2)] hover:shadow-[0_0_50px_rgba(255,255,255,0.6)] hover:scale-[1.02] active:scale-[0.98] transition-all overflow-hidden border-2 border-white cursor-pointer z-10">
                    <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-black/10 to-transparent -translate-x-[150%] skew-x-[30deg] group-hover:animate-[shine_1.5s_ease-out]"></div>
                    <span class="uppercase tracking-widest relative z-10 pl-2">Inisialisasi</span>
                    <span class="w-10 h-10 bg-black text-white rounded-xl flex items-center justify-center relative z-10 transition-transform group-hover:translate-x-1 group-hover:bg-primary group-hover:shadow-[0_0_15px_rgba(183,16,42,1)]">
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </span>
                </button>
                <style>
                    @keyframes shine {
                        100% { transform: translateX(150%) skew-x(30deg); }
                    }
                </style>
            </form>
        </div>
    </div>
</body>
</html>
