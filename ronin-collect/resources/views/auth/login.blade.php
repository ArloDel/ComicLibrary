<!DOCTYPE html>
<html class="light" lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>RONIN_COLLECT | Masuk</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&family=Manrope:wght@400;500;600;700&family=Space_Grotesk:wght@400;700&display=swap" rel="stylesheet"/>
<script id="tailwind-config">
      tailwind.config = {
        theme: {
          extend: {
            "colors": {
              "primary": "#b7102a",
              "primary-container": "#db313f",
              "background": "#f3fcf0",
              "on-background": "#161d16",
              "surface-container-low": "#edf6ea",
              "outline": "#8f6f6e"
            },
            "fontFamily": {
              "headline": ["Plus Jakarta Sans"],
              "body": ["Manrope"],
              "label": ["Space Grotesk"]
            }
          }
        }
      }
</script>
</head>
<body class="bg-background text-on-background font-body min-h-screen flex items-center justify-center p-6 lg:p-12">
    <div class="w-full max-w-[1200px] flex flex-col lg:flex-row gap-12 bg-white shadow-2xl p-8 lg:p-16 relative overflow-hidden">
        
        <!-- Decorative bg elements -->
        <div class="absolute -top-32 -left-32 w-64 h-64 bg-primary/5 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-32 -right-32 w-64 h-64 bg-primary-container/10 rounded-full blur-3xl"></div>

        <!-- Branding Panel -->
        <div class="lg:w-1/2 flex flex-col justify-between border-b lg:border-b-0 lg:border-r border-outline/20 pb-12 lg:pb-0 lg:pr-12 relative z-10">
            <div>
                <span class="font-label text-primary tracking-[0.2em] text-[10px] font-bold uppercase mb-4 block">Modul Otorisasi</span>
                <h1 class="font-headline font-black text-6xl md:text-8xl tracking-tighter uppercase leading-tight mb-6">
                    RONIN<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-primary-container">COLLECT</span>
                </h1>
                <p class="font-body text-xl opacity-70 max-w-sm">Terminal aman untuk kurator dan arsiparis.</p>
            </div>
            <div class="mt-12 lg:mt-0 font-label text-[10px] tracking-widest uppercase opacity-40">
                Sistem Versi 1.0.4 // Cabang Kyoto
            </div>
        </div>
        
        <!-- Login Form -->
        <div class="lg:w-1/2 flex flex-col justify-center relative z-10">
            <h2 class="font-headline font-extrabold text-3xl uppercase tracking-tighter mb-8">Akses Diperlukan</h2>
            
            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label class="font-label text-[10px] uppercase tracking-widest opacity-70 block mb-2">ID Kurator / Nama Pengguna</label>
                    <input name="name" value="{{ old('name') }}" type="text" required autofocus class="w-full bg-surface-container-low border-0 border-b-2 border-transparent focus:border-primary px-4 py-4 font-body placeholder:opacity-40 transition-colors" placeholder="misal. kurator_01"/>
                    @error('name')
                        <span class="text-primary font-bold text-xs mt-2 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="font-label text-[10px] uppercase tracking-widest opacity-70 block mb-2">Kode Sandi</label>
                    <input name="password" type="password" required class="w-full bg-surface-container-low border-0 border-b-2 border-transparent focus:border-primary px-4 py-4 font-body placeholder:opacity-40 transition-colors" placeholder="********"/>
                </div>

                <div class="flex items-center gap-3 pt-2 pb-4">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-primary bg-surface-container-low border-outline/30 focus:ring-primary rounded-none">
                    <label for="remember" class="font-label text-[10px] uppercase tracking-widest opacity-70">Ingat Terminal Ini</label>
                </div>

                <button type="submit" class="w-full group relative inline-flex items-center justify-center p-5 bg-gradient-to-r from-primary to-primary-container text-white font-headline font-extrabold tracking-tighter text-xl uppercase transition-all shadow-lg hover:shadow-primary/20 active:scale-[0.98]">
                    <span>Autentikasi</span>
                    <svg class="w-5 h-5 ml-3 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="square" stroke-linejoin="miter" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </form>
        </div>
    </div>
</body>
</html>
