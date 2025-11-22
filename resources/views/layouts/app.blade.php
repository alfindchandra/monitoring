<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - ORMAWA IKIP PGRI Bojonegoro</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    @vite('resources/css/app.css', 'resources/js/app.js')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* Custom Utility Class untuk Card (Opsional, untuk konsistensi) */
        .card-ukm {
            @apply bg-white p-6 rounded-xl shadow-lg border border-gray-100;
        }

        /* Animasi sederhana untuk Hero */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 1s ease-out;
        }
    </style>
</head>
<body class="bg-gray-100 antialiased">
    {{-- Navbar --}}
    <nav x-data="{ open: false }" 
     class="fixed top-0 w-full z-50 backdrop-blur-xl  bg-white/70 border-b border-gray-200/50 shadow-sm transition-all">
    
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between items-center h-20">

            <!-- Logo --> 
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <span class="text-lg font-bold text-gray-700">ORMAWA IKIP PGRI</span>
            </a>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center gap-8 text-sm font-semibold">

                <!-- Hover underline modern -->
                <a href="{{ route('home') }}" 
                   class="relative text-gray-700 hover:text-primary-600 transition">
                    Beranda
                    <span class="absolute left-0 -bottom-1 w-0 h-[2px] bg-primary-600 transition-all duration-300 group-hover:w-full"></span>
                </a>

                <a href="{{ route('public.ormawa') }}" 
                   class="relative group text-gray-700 hover:text-primary-600 transition">
                    ORMAWA
                    <span class="absolute left-0 -bottom-1 w-0 h-[2px] bg-primary-600 transition-all duration-300 group-hover:w-full"></span>
                </a>

                <a href="{{ route('public.activitie') }}" 
                   class="relative group text-gray-700 hover:text-primary-600 transition">
                    Kegiatan
                    <span class="absolute left-0 -bottom-1 w-0 h-[2px] bg-primary-600 transition-all duration-300 group-hover:w-full"></span>
                </a>

                <a href="{{ route('public.news.index')}}" class="relative group text-gray-700 hover:text-primary-600 transition">
                    Berita <span class="absolute left-0 -bottom-1 w-0 h-[2px] bg-primary-600 transition-all duration-300 group-hover:w-full"></span >
                </a>

                <a href="{{ route('gallery.index') }}" 
                   class="relative group text-gray-700 hover:text-primary-600 transition">
                    Foto
                    <span class="absolute left-0 -bottom-1 w-0 h-[2px] bg-primary-600 transition-all duration-300 group-hover:w-full"></span>
                </a>

                @auth
                    <a href="{{ route('dashboard') }}" 
                       class="px-5 py-2 rounded-full bg-primary-600 text-white hover:bg-primary-700 shadow-md hover:shadow-lg transition-all">
                       Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" 
                       class="px-5 py-2 rounded-full bg-primary-600 text-white hover:bg-primary-700 shadow-md hover:shadow-lg transition-all">
                       Login
                    </a>
                @endauth
            </div>

            <!-- Mobile Toggle -->
            <button @click="open = !open" 
                    class="md:hidden text-gray-600 hover:text-primary-600 transition p-2">
                <svg x-show="!open" class="h-7 w-7" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M4 6h16M4 12h16M4 18h16" />
                </svg>

                <svg x-show="open" class="h-7 w-7" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" 
         x-transition
         class="md:hidden bg-white/90 backdrop-blur-lg border-t shadow-lg">
         
        <div class="px-6 py-4 space-y-3">

            <a href="{{ route('home') }}" 
               class="block text-gray-700 hover:bg-primary-50 hover:text-primary-700 rounded-lg px-3 py-2">
               Beranda
            </a>

            <a href="{{ route('public.ormawa') }}" 
               class="block text-gray-700 hover:bg-primary-50 hover:text-primary-700 rounded-lg px-3 py-2">
               ORMAWA
            </a>

            <a href="#" 
               class="block text-gray-700 hover:bg-primary-50 hover:text-primary-700 rounded-lg px-3 py-2">
               Kegiatan
            </a>

            <a href="#" 
               class="block text-gray-700 hover:bg-primary-50 hover:text-primary-700 rounded-lg px-3 py-2">
               Pengumuman
            </a>

            @auth
                <a href="{{ route('dashboard') }}" 
                   class="block text-center mt-2 px-3 py-2 rounded-full bg-primary-600 text-white font-semibold hover:bg-primary-700">
                   Dashboard
                </a>
            @else
                <a href="#" 
                   class="block text-center mt-2 px-3 py-2 rounded-full bg-primary-600 text-white font-semibold hover:bg-primary-700">
                   Login
                </a>
            @endauth
        </div>
    </div>
</nav>
    {{-- Content --}}
    <main class="pt-24">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-12">
                {{-- Logo/Identitas --}}
                <div class="col-span-2 md:col-span-1">
                    <h3 class="text-3xl font-extrabold text-primary-400 mb-4 tracking-tight">ORMAWA</h3>
                    <p class="text-gray-400 text-sm">Organisasi Mahasiswa <br>IKIP PGRI Bojonegoro. <br>Wadah kreasi dan inovasi.</p>
                </div>
                {{-- Navigasi --}}
                <div>
                    <h4 class="text-xl font-bold mb-5 text-gray-200">Navigasi</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition duration-200">Beranda</a></li>
                        <li><a href="{{ route('public.ormawa') }}" class="text-gray-400 hover:text-white transition duration-200">ORMAWA</a></li>
                        <li><a href="" class="text-gray-400 hover:text-white transition duration-200">Kegiatan</a></li>
                        <li><a href="" class="text-gray-400 hover:text-white transition duration-200">Pengumuman</a></li>
                    </ul>
                </div>
                {{-- Kontak --}}
                <div>
                    <h4 class="text-xl font-bold mb-5 text-gray-200">Kontak</h4>
                    <ul class="space-y-3">
                        <li class="text-gray-400">IKIP PGRI Bojonegoro</li>
                        <li class="text-gray-400">Jl. Panglima Polim No. 46, Bojonegoro</li>
                        <li class="text-gray-400 hover:text-white"><a href="mailto:info@ikip.ac.id">info@ikip.ac.id</a></li>
                        <li class="text-gray-400 hover:text-white">+(62) 123 456 789</li>
                    </ul>
                </div>
                {{-- Sosial Media (Contoh) --}}
                <div>
                    <h4 class="text-xl font-bold mb-5 text-gray-200">Sosial Media</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-primary-500 transition duration-200">
                            {{-- Icon Instagram --}}
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M7.5 0h9a7.5 7.5 0 017.5 7.5v9a7.5 7.5 0 01-7.5 7.5h-9A7.5 7.5 0 010 16.5v-9A7.5 7.5 0 017.5 0zm-.5 12a5 5 0 1010 0 5 5 0 00-10 0zm8.5-6h.5v.5h-.5v-.5z"/></svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-primary-500 transition duration-200">
                            {{-- Icon Facebook --}}
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5c0-2.14 1.28-3.35 3.28-3.35.95 0 1.8.07 2.04.1v2.7h-1.5c-1.12 0-1.34.53-1.34 1.31V12h3.04l-.4 3h-2.64v6.8A10.03 10.03 0 0022 12z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-500 text-sm">
                <p>&copy; 2024 ORMAWA IKIP PGRI Bojonegoro. All rights reserved.</p>
                <p class="mt-1">Dibuat dengan <span class="text-red-500">❤️</span> dan Tailwind CSS.</p>
            </div>
        </div>
    </footer>
</body>
</html>