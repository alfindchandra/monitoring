@extends('layouts.app')

@section('title', 'Pengumuman Publik')

@section('content')
{{-- Hero Section --}}
<div class="bg-gradient-to-br from-primary-600 via-primary-700 to-primary-900 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Pengumuman</h1>
            <p class="text-xl text-primary-100 max-w-3xl mx-auto">
                Informasi dan pengumuman terkini dari ORMAWA IKIP PGRI Bojonegoro
            </p>
        </div>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @if($announcements->count() > 0)
        <div class="space-y-6">
            @foreach($announcements as $announcement)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300">
                <div class="p-6">
                    {{-- Header --}}
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="flex items-center mb-2">
                                <span class="bg-primary-100 text-primary-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ $announcement->ormawa->name }}
                                </span>
                                <span class="ml-3 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($announcement->priority === 'urgent') bg-red-100 text-red-800
                                    @elseif($announcement->priority === 'high') bg-orange-100 text-orange-800
                                    @elseif($announcement->priority === 'normal') bg-blue-100 text-blue-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($announcement->priority) }}
                                </span>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $announcement->title }}</h3>
                        </div>
                    </div>
                    
                    {{-- Content --}}
                    <div class="prose max-w-none mb-4">
                        <p class="text-gray-600 leading-relaxed line-clamp-3">
                            {{ Str::limit($announcement->content, 300) }}
                        </p>
                    </div>
                    
                    {{-- Footer --}}
                    <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>{{ $announcement->created_at->format('d F Y, H:i') }}</span>
                        </div>
                        
                        @if($announcement->attachment)
                        <a href="{{ Storage::url($announcement->attachment) }}" target="_blank" 
                           class="inline-flex items-center text-primary-600 hover:text-primary-700 font-semibold text-sm">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Lihat Lampiran
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-12">
            {{ $announcements->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <svg class="w-24 h-24 mx-auto text-gray-400 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Belum Ada Pengumuman</h3>
            <p class="text-gray-600 mb-6">Pengumuman dari ORMAWA akan segera hadir</p>
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