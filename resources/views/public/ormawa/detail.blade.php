@extends('layouts.app')

@section('title', $ormawa->name)

@section('content')
{{-- Hero Section --}}
<div class="bg-gradient-to-br from-primary-600 via-primary-700 to-primary-900 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-center gap-8">
            <div class="flex-shrink-0">
                @if($ormawa->logo)
                    <img src="{{ Storage::url($ormawa->logo) }}" alt="{{ $ormawa->name }}" class="w-32 h-32 md:w-40 md:h-40 object-contain bg-white rounded-2xl p-4">
                @else
                    <div class="w-32 h-32 md:w-40 md:h-40 rounded-2xl bg-white flex items-center justify-center text-primary-600 text-4xl font-bold">
                        {{ substr($ormawa->name, 0, 3) }}
                    </div>
                @endif
            </div>
            <div class="flex-1 text-center md:text-left">
                <span class="inline-block px-3 py-1 bg-primary-500 rounded-full text-sm font-semibold mb-3">
                    {{ $ormawa->type === 'bem' ? 'Badan Eksekutif Mahasiswa' : 'Unit Kegiatan Mahasiswa' }}
                </span>
                <h1 class="text-4xl md:text-5xl font-extrabold mb-4">{{ $ormawa->name }}</h1>
                <p class="text-xl text-primary-100">{{ $ormawa->description }}</p>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-8">
            {{-- Vision & Mission --}}
            @if($ormawa->vision || $ormawa->mission)
            <div class="card">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Visi & Misi</h2>
                
                @if($ormawa->vision)
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-900 mb-3 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        Visi
                    </h3>
                    <p class="text-gray-600 leading-relaxed pl-8">{{ $ormawa->vision }}</p>
                </div>
                @endif
                
                @if($ormawa->mission)
                <div>
                    <h3 class="font-semibold text-gray-900 mb-3 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                        Misi
                    </h3>
                    <p class="text-gray-600 leading-relaxed pl-8">{{ $ormawa->mission }}</p>
                </div>
                @endif
            </div>
            @endif

            {{-- Recent Activities --}}
            @if($activities->count() > 0)
            <div class="card">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Kegiatan Terkini</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($activities as $activity)
                    <div class="bg-gray-50 rounded-lg overflow-hidden hover:shadow-lg transition duration-200">
                        @if($activity->image)
                            <img src="{{ Storage::url($activity->image) }}" alt="{{ $activity->title }}" class="w-full h-40 object-cover">
                        @else
                            <div class="w-full h-40 bg-gradient-to-br from-primary-400 to-primary-600"></div>
                        @endif
                        <div class="p-4">
                            <h3 class="font-bold text-gray-900 mb-2">{{ $activity->title }}</h3>
                            <p class="text-sm text-gray-600 mb-2 line-clamp-2">{{ $activity->description }}</p>
                            <p class="text-xs text-gray-500">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $activity->event_date->format('d M Y') }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Contact Info --}}
            <div class="card">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Informasi Kontak</h3>
                <div class="space-y-3">
                    @if($ormawa->email)
                    <a href="mailto:{{ $ormawa->email }}" class="flex items-center p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition duration-200">
                        <svg class="w-5 h-5 mr-3 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span class="text-sm text-gray-700">{{ $ormawa->email }}</span>
                    </a>
                    @endif
                    
                    @if($ormawa->phone)
                    <a href="tel:{{ $ormawa->phone }}" class="flex items-center p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition duration-200">
                        <svg class="w-5 h-5 mr-3 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span class="text-sm text-gray-700">{{ $ormawa->phone }}</span>
                    </a>
                    @endif
                    
                    @if($ormawa->instagram)
                    <a href="https://instagram.com/{{ ltrim($ormawa->instagram, '@') }}" target="_blank" class="flex items-center p-3 bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 rounded-lg transition duration-200 text-white">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                        <span class="text-sm font-semibold">{{ $ormawa->instagram }}</span>
                    </a>
                    @endif
                </div>
            </div>

            {{-- Info Lainnya --}}
            <div class="card bg-primary-50">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Informasi</h3>
                <div class="space-y-2 text-sm">
                    @if($ormawa->established_year)
                    <p class="text-gray-700">
                        <strong>Tahun Berdiri:</strong> {{ $ormawa->established_year }}
                    </p>
                    @endif
                    <p class="text-gray-700">
                        <strong>Tipe:</strong> {{ $ormawa->type === 'bem' ? 'Badan Eksekutif Mahasiswa' : 'Unit Kegiatan Mahasiswa' }}
                    </p>
                    @if($ormawa->address)
                    <p class="text-gray-700">
                        <strong>Alamat:</strong><br>{{ $ormawa->address }}
                    </p>
                    @endif
                </div>
            </div>
            <div class="card">
    <h3 class="text-xl font-bold text-gray-900 mb-4">Menu</h3>
    <div class="space-y-2">
        <a href="{{ route('public.ormawa.structure', $ormawa->slug) }}" 
           class="flex items-center p-3 bg-primary-50 hover:bg-primary-100 rounded-lg transition duration-200">
            <svg class="w-5 h-5 mr-3 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span class="font-semibold text-primary-700">Struktur Organisasi</span>
        </a>
    </div>
</div>
        </div>
    </div>
</div>
@endsection