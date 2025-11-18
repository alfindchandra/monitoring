<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ORMAWA IKIP PGRI Bojonegoro</title>
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

                <a href="{{ route('public.announcements') }}" 
                   class="relative group text-gray-700 hover:text-primary-600 transition">
                    Pengumuman
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


    {{-- Hero Section --}}
    <header class="relative bg-primary-700 text-white pt-3">
        <div class="absolute inset-0 bg-black opacity-30"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-28 md:py-36">
            <div class="text-center">
                <h1 class="text-5xl md:text-7xl font-extrabold mb-4 animate-fade-in tracking-tight">
                    Wadah Aksi Mahasiswa
                </h1>
                <p class="text-xl md:text-3xl mb-10 font-light text-primary-200 animate-fade-in delay-200">
                    Organisasi Mahasiswa IKIP PGRI Bojonegoro
                </p>
                <p class="text-lg max-w-4xl mx-auto mb-12 text-primary-100">
                    Pengembangan potensi, kreativitas, dan kepemimpinan melalui berbagai Unit Kegiatan Mahasiswa dan Badan Eksekutif Mahasiswa.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center animate-fade-in delay-400">
                    <a href="{{ route('public.ormawa') }}" class="bg-white text-primary-700 hover:bg-primary-100 px-10 py-3 rounded-full text-lg font-bold transition duration-300 shadow-xl transform hover:scale-105">
                        Lihat Semua ORMAWA
                    </a>
                    <a href="" class="bg-primary-500 border border-primary-500 hover:bg-primary-400 px-10 py-3 rounded-full text-lg font-bold transition duration-300 shadow-xl transform hover:scale-105">
                        Kegiatan Terkini →
                    </a>
                </div>
            </div>
        </div>
        {{-- Gelombang Bawah --}}
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-gray-100">
                <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="currentColor"/>
            </svg>
        </div>
    </header>

    {{-- BEM Section (Badan Eksekutif Mahasiswa) --}}
    @if(isset($bem))
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 bg-gray-100">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-200">
            <div class="md:grid md:grid-cols-3">
                {{-- Logo & Identitas (Kolom Kiri) --}}
                <div class="col-span-1 bg-primary-600 p-10 flex items-center justify-center text-white">
                    <div class="text-center">
                        @if($bem->logo)
                            <img src="{{ Storage::url($bem->logo) }}" alt="{{ $bem->name }}" class="w-40 h-40 mx-auto mb-6 rounded-full object-cover ring-4 ring-white p-3 shadow-lg">
                        @else
                            <div class="w-40 h-40 mx-auto mb-6 rounded-full bg-white flex items-center justify-center text-primary-600 text-5xl font-extrabold shadow-lg">
                                BEM
                            </div>
                        @endif
                        <h3 class="text-3xl font-bold mt-4">{{ $bem->name }}</h3>
                        <p class="text-primary-200 text-lg">Badan Eksekutif Mahasiswa</p>
                    </div>
                </div>
                {{-- Deskripsi (Kolom Kanan) --}}
                <div class="col-span-2 p-10 md:p-12">
                    <span class="inline-block bg-primary-100 text-primary-800 text-sm font-semibold px-4 py-1 rounded-full mb-4">Fokus Utama</span>
                    <h2 class="text-4xl font-bold text-gray-900 mb-6">Badan Eksekutif Mahasiswa</h2>
                    <p class="text-gray-600 mb-8 leading-relaxed text-lg">{{ $bem->description }}</p>
                    
                    @if(isset($bem->vision))
                    <div class="mb-8 p-4 bg-primary-50 rounded-xl border-l-4 border-primary-600">
                        <h4 class="font-bold text-primary-800 mb-2 flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.001 12.001 0 0012 21a12.001 12.001 0 008.618-17.964z" /></svg>
                            Visi:
                        </h4>
                        <p class="text-gray-700 italic">{{ $bem->vision }}</p>
                    </div>
                    @endif
                    
                    <a href="{{ route('public.ormawa.detail', $bem->slug) }}" class="inline-flex items-center text-primary-700 hover:text-primary-800 font-bold transition duration-200 group">
                        Selengkapnya tentang BEM
                        <svg class="w-6 h-6 ml-2 group-hover:translate-x-1 transition duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.5 12h-11M14.5 9l3 3-3 3"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- UKM Section (Unit Kegiatan Mahasiswa) --}}
    <section class="bg-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4 tracking-tight">Jelajahi Minat & Bakat Anda</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Tersedia beragam Unit Kegiatan Mahasiswa (UKM) yang siap menjadi wadah pengembangan diri Anda.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($ukms as $ukm)
                <div class="card-ukm text-center hover:shadow-2xl transition duration-300 transform hover:-translate-y-2">
                    <a href="{{ route('public.ormawa.detail', $ukm->slug) }}">
                        @if($ukm->logo)
                            <img src="{{ Storage::url($ukm->logo) }}" alt="{{ $ukm->name }}" class="w-24 h-24 mx-auto mb-5 rounded-xl object-cover border-2 border-gray-100 shadow-md p-1">
                        @else
                            <div class="w-24 h-24 mx-auto mb-5 rounded-xl bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white font-bold text-2xl shadow-md">
                                {{ strtoupper(substr($ukm->name, 0, 3)) }}
                            </div>
                        @endif
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $ukm->name }}</h3>
                        <p class="text-gray-500 text-sm mb-4 line-clamp-3">{{ $ukm->description }}</p>
                        <span class="text-primary-600 hover:text-primary-700 font-semibold text-sm mt-3 inline-block">
                            Lihat Detail
                            <svg class="w-4 h-4 ml-1 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7-7 7M10 12H3"/></svg>
                        </span>
                    </a>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-16">
                <a href="{{ route('public.ormawa') }}" class="px-8 py-3 bg-primary-600 text-white rounded-full text-lg font-semibold hover:bg-primary-700 transition duration-300 shadow-lg hover:shadow-xl">
                    Semua UKM & ORMAWA
                </a>
            </div>
        </div>
    </section>

    {{-- Recent Activities --}}
    @if($recentActivities->count() > 0)
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 bg-gray-100">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4 tracking-tight">Kegiatan Terbaru</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Sorotan dari kegiatan-kegiatan menarik yang telah dilaksanakan oleh ORMAWA.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @foreach($recentActivities as $activity)
            <article class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition duration-300 transform hover:-translate-y-1 border border-gray-200">
                @if($activity->image)
                    <img src="{{ Storage::url($activity->image) }}" alt="{{ $activity->title }}" class="w-full h-56 object-cover transition duration-300 group-hover:scale-105">
                @else
                    <div class="w-full h-56 bg-primary-400 flex items-center justify-center text-white text-2xl font-bold">No Image</div>
                @endif
                <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                        <span class="bg-primary-100 text-primary-700 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
                            {{ $activity->ormawa->name }}
                        </span>
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-1 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            {{ $activity->event_date->format('d M Y') }}
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3 leading-snug hover:text-primary-700 transition duration-200">{{ $activity->title }}</h3>
                    <p class="text-gray-600 mb-4 line-clamp-3">{{ $activity->description }}</p>
                    <a href="" class="text-primary-600 hover:text-primary-700 font-semibold inline-flex items-center">
                        Baca Selengkapnya
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7-7 7M10 12H3"/></svg>
                    </a>
                </div>
            </article>
            @endforeach
        </div>
        <div class="text-center mt-16">
            <a href="" class="text-lg font-semibold text-gray-700 hover:text-primary-700 border-b-2 border-gray-300 hover:border-primary-700 transition duration-300">
                Lihat Semua Kegiatan (Link ke halaman Kegiatan)
            </a>
        </div>
    </section>
    @endif

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