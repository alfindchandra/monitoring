@extends('layouts.dashboard')

@section('title', 'Kotak Masuk')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Kotak Masuk</h1>
        <p class="text-gray-600 mt-1">Pengumuman yang diterima oleh {{ auth()->user()->ormawa->name }}</p>
    </div>

    <div class="card">
        @if($announcements->count() > 0)
        <div class="space-y-4">
            @foreach($announcements as $announcement)
            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition duration-200 {{ $announcement->pivot->is_read ? '' : 'bg-blue-50 border-blue-200' }}">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center mb-2">
                            @if(!$announcement->pivot->is_read)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-2">
                                    Baru
                                </span>
                            @endif
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($announcement->priority === 'urgent') bg-red-100 text-red-800
                                @elseif($announcement->priority === 'high') bg-orange-100 text-orange-800
                                @elseif($announcement->priority === 'normal') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($announcement->priority) }}
                            </span>
                        </div>
                        
                        <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $announcement->title }}</h3>
                        <p class="text-gray-600 mb-3 line-clamp-2">{{ Str::limit($announcement->content, 200) }}</p>
                        
                        <div class="flex items-center text-sm text-gray-500 space-x-4">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Dari: <strong class="ml-1">{{ $announcement->ormawa->name }}</strong>
                            </span>
                            <span>•</span>
                            <span>{{ $announcement->created_at->diffForHumans() }}</span>
                            @if($announcement->attachment)
                            <span class="flex items-center text-primary-600">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                </svg>
                                Ada Lampiran
                            </span>
                            @endif
                        </div>
                    </div>
                    
                    <a href="{{ route('announcements.show', $announcement) }}" 
                       onclick="event.preventDefault(); fetch('{{ route('announcements.read', $announcement) }}').then(() => window.location.href = '{{ route('announcements.show', $announcement) }}')"
                       class="ml-4 btn-primary whitespace-nowrap">
                        Lihat Detail
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="mt-6">
            {{ $announcements->links() }}
        </div>
        @else
        <div class="text-center py-12">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Kotak Masuk Kosong</h3>
            <p class="text-gray-600">Belum ada pengumuman yang diterima</p>
        </div>
        @endif
    </div>
</div>
@endsection