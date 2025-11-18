@extends('layouts.app')

@section('title', 'Semua ORMAWA')

{{-- Tambahkan Style untuk Animasi Card UKM --}}
@section('styles')
<style>
    /* Transisi Kustom untuk efek shadow yang lebih halus */
    .ukm-card {
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1); /* shadow-lg default */
    }
    /* Efek hover yang lebih dramatis dan modern */
    .ukm-card:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.15), 0 4px 6px -4px rgba(0, 0, 0, 0.15); /* shadow-xl/2xl kustom */
        transform: translateY(-5px);
    }
</style>
@endsection

@section('content')
{{-- Hero Section: Tetap Modern, Kontras Tinggi --}}
<div class="bg-gradient-to-br from-blue-700 via-blue-800 to-blue-900 text-white py-20 shadow-inner">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-5xl md:text-6xl font-extrabold mb-4 tracking-tight">
                Galeri Organisasi Mahasiswa
            </h1>
            <p class="text-xl text-blue-200 max-w-4xl mx-auto font-light">
                Jelajahi Badan Eksekutif Mahasiswa (BEM) dan beragam Unit Kegiatan Mahasiswa (UKM) yang aktif di kampus IKIP PGRI Bojonegoro.
            </p>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    {{-- BEM Section (Card Besar, Visually Dominant) --}}
    @if($bem)
    <div class="mb-20">
        <h2 class="text-4xl font-extrabold text-gray-900 mb-10 text-center relative after:block after:w-20 after:h-1 after:bg-blue-600 after:mx-auto after:mt-2">
            Badan Eksekutif Mahasiswa (BEM)
        </h2>
        <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden transform transition duration-500 hover:scale-[1.01]">
            <div class="md:flex">
                {{-- Logo & Slogan Column --}}
                <div class="md:w-1/3 bg-blue-600 p-10 flex flex-col items-center justify-center text-white space-y-4">
                    @if($bem->logo)
                        <img src="{{ Storage::url($bem->logo) }}" alt="{{ $bem->name }}" class="w-32 h-32 md:w-48 md:h-48 object-contain rounded-full border-4 border-white p-2 bg-white">
                    @else
                        <div class="w-32 h-32 md:w-48 md:h-48 rounded-full bg-white flex items-center justify-center text-blue-600 text-4xl font-black">
                            BEM
                        </div>
                    @endif
                    <h3 class="text-xl font-semibold text-center mt-3">{{ $bem->name }}</h3>
                </div>
                
                {{-- Detail & Deskripsi Column --}}
                <div class="md:w-2/3 p-10">
                    <p class="text-gray-700 mb-6 leading-relaxed text-lg italic border-l-4 border-blue-500 pl-4">
                        "{{ Str::limit($bem->description, 250) }}"
                    </p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        @if($bem->vision)
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="font-bold text-blue-700 mb-2 flex items-center text-lg">
                                <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Visi
                            </h4>
                            <p class="text-gray-600 text-base">{{ $bem->vision }}</p>
                        </div>
                        @endif
                        
                        @if($bem->mission)
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="font-bold text-blue-700 mb-2 flex items-center text-lg">
                                <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.108c-.628-.628-1.65-.628-2.278 0L12 11.53l-2.34-2.34c-.628-.628-1.65-.628-2.278 0-.628.628-.628 1.65 0 2.278L12 16.088l4.618-4.618c.628-.628.628-1.65 0-2.278z" />
                                </svg>
                                Misi
                            </h4>
                            <p class="text-gray-600 text-base">{{ $bem->mission }}</p>
                        </div>
                        @endif
                    </div>

                    <div class="flex flex-wrap gap-4 pt-4 border-t border-gray-100">
                        {{-- Social Media & Kontak --}}
                        @if($bem->email)
                        <a href="mailto:{{ $bem->email }}" class="inline-flex items-center px-5 py-2.5 bg-gray-100 hover:bg-gray-200 rounded-full text-sm font-medium text-gray-800 transition duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            Email
                        </a>
                        @endif
                        
                        @if($bem->instagram)
                        <a href="https://instagram.com/{{ ltrim($bem->instagram, '@') }}" target="_blank" class="inline-flex items-center px-5 py-2.5 bg-pink-500 hover:bg-pink-600 rounded-full text-sm font-medium text-white transition duration-200">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073z"/> </svg>
                            Instagram
                        </a>
                        @endif
                        
                        <a href="{{ route('public.ormawa.detail', $bem->slug) }}" class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-full text-sm font-bold transition duration-200 shadow-md hover:shadow-lg">
                            Detail Kepengurusan 
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    {{-- Placeholder jika BEM tidak ditemukan --}}
    <div class="mb-20 text-center p-12 bg-gray-50 rounded-xl border border-dashed border-gray-300">
        <p class="text-xl text-gray-500">
            <span class="font-bold text-gray-800">Badan Eksekutif Mahasiswa</span> belum tersedia. Kami akan segera memperbarui informasi ini!
        </p>
    </div>
    @endif

    <hr class="my-16 border-gray-200">

    {{-- UKM Section (Grid Modern dengan Efek Hover) --}}
    <div>
        <h2 class="text-4xl font-extrabold text-gray-900 mb-10 text-center relative after:block after:w-20 after:h-1 after:bg-blue-600 after:mx-auto after:mt-2">
            Unit Kegiatan Mahasiswa (UKM)
        </h2>
        
        @if(count($ukms) > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @foreach($ukms as $ukm)
            <div class="ukm-card bg-white rounded-2xl border border-gray-100 shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-1 overflow-hidden">
                {{-- Header Card UKM yang Lebih Menarik --}}
                <div class="bg-gradient-to-br from-blue-500 to-blue-700 p-8 text-center relative">
                    @if($ukm->logo)
                        <img src="{{ Storage::url($ukm->logo) }}" alt="{{ $ukm->name }}" class="w-20 h-20 mx-auto object-contain mb-4 rounded-full border-4 border-white">
                    @else
                        <div class="w-20 h-20 mx-auto rounded-full bg-white flex items-center justify-center text-blue-600 font-bold text-2xl mb-4 border-4 border-white">
                            {{ Str::upper(substr($ukm->name, 0, 3)) }}
                        </div>
                    @endif
                    <h3 class="text-xl font-bold text-white">{{ $ukm->name }}</h3>
                    <p class="text-sm text-blue-200 mt-1">{{ Str::limit($ukm->description, 50) }}</p>
                </div>
                
                <div class="p-6">
                    {{-- Deskripsi Ringkas --}}
                    <p class="text-gray-600 text-sm mb-4 line-clamp-3 min-h-[4.5rem]">
                        {{ $ukm->description }}
                    </p>
                    
                    {{-- Detail Pendirian --}}
                    @if($ukm->established_year)
                    <p class="text-xs text-gray-500 mb-4 flex items-center">
                        <svg class="w-4 h-4 inline mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Berdiri sejak <span class="font-semibold ml-1">{{ $ukm->established_year }}</span>
                    </p>
                    @endif
                    
                    {{-- Tombol Aksi --}}
                    <a href="{{ route('public.ormawa.detail', $ukm->slug) }}" class="block text-center bg-blue-50 hover:bg-blue-100 text-blue-700 font-semibold py-3 px-4 rounded-xl transition duration-300 ease-in-out">
                        Lihat Profil UKM →
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        {{-- Placeholder jika UKM tidak ditemukan --}}
        <div class="text-center p-12 bg-gray-50 rounded-xl border border-dashed border-gray-300">
            <p class="text-xl text-gray-500">
                Belum ada **Unit Kegiatan Mahasiswa** yang terdaftar saat ini. Cek kembali nanti!
            </p>
        </div>
        @endif
    </div>
</div>
@endsection