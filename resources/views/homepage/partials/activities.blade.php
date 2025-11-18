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
