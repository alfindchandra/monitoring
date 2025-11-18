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