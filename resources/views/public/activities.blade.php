@extends('layouts.app')

@section('title', 'Kegiatan ORMAWA')

@section('content')
{{-- Hero Section --}}
<div class="bg-gradient-to-br from-primary-600 via-primary-700 to-primary-900 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Kegiatan ORMAWA</h1>
            <p class="text-xl text-primary-100 max-w-3xl mx-auto">
                Berbagai kegiatan menarik dari BEM dan Unit Kegiatan Mahasiswa
            </p>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @if($activities->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($activities as $activity)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 transform hover:-translate-y-1">
                @if($activity->image)
                    <img src="{{ Storage::url($activity->image) }}" alt="{{ $activity->title }}" class="w-full h-56 object-cover">
                @else
                    <div class="w-full h-56 bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center">
                        <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                @endif
                
                <div class="p-6">
                    {{-- ORMAWA Badge --}}
                    <div class="flex items-center mb-3">
                        <span class="bg-primary-100 text-primary-700 px-3 py-1 rounded-full text-xs font-semibold">
                            {{ $activity->ormawa->name }}
                        </span>
                    </div>
                    
                    {{-- Title --}}
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $activity->title }}</h3>
                    
                    {{-- Description --}}
                    <p class="text-gray-600 mb-4 line-clamp-3">{{ $activity->description }}</p>
                    
                    {{-- Meta Info --}}
                    <div class="space-y-2 text-sm text-gray-500">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>{{ $activity->event_date->format('d F Y') }}</span>
                        </div>
                        
                        @if($activity->event_time)
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ date('H:i', strtotime($activity->event_time)) }} WIB</span>
                        </div>
                        @endif
                        
                        @if($activity->location)
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="line-clamp-1">{{ $activity->location }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-12">
            {{ $activities->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <svg class="w-24 h-24 mx-auto text-gray-400 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Belum Ada Kegiatan</h3>
            <p class="text-gray-600 mb-6">Kegiatan dari ORMAWA akan segera hadir</p>
            <a href="{{ route('home') }}" class="btn-primary inline-flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Kembali ke Beranda
            </a>
        </div>
    @endif
</div>
@endsection