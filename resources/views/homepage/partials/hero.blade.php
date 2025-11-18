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