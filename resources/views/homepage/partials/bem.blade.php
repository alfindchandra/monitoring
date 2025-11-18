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