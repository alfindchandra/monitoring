@extends('layouts.dashboard')

@section('title', 'Kelola Kegiatan')

@section('content')
<div class="space-y-6">
 @if(auth()->user()->isKetuaBem() || auth()->user()->isKetuaUkm())
     <div class="flex items-center justify-between">

         <div>
            <h1 class="text-3xl font-bold text-gray-900">Kelola Kegiatan</h1>
            <p class="text-gray-600 mt-1">Kegiatan {{ auth()->user()->ormawa->name }}</p>
        </div>
        <a href="{{ route('activities.create') }}" class="btn-primary">
            <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Kegiatan
        </a>
    </div>
    @endif

    <div class="card">
        @if($activities->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($activities as $activity)
            <div class="bg-gray-50 rounded-lg overflow-hidden hover:shadow-lg transition duration-200">
                @if($activity->image)
                    <img src="{{ Storage::url($activity->image) }}" alt="{{ $activity->title }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                @endif
                
                <div class="p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                            {{ $activity->is_public ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $activity->is_public ? 'Publik' : 'Private' }}
                        </span>
                        <span class="text-xs text-gray-500">{{ $activity->event_date->format('d M Y') }}</span>
                    </div>
                    
                    <h3 class="font-bold text-gray-900 mb-2">{{ $activity->title }}</h3>
                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $activity->description }}</p>
                    
                    @if($activity->location)
                    <p class="text-xs text-gray-500 mb-3">
                        <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        </svg>
                        {{ $activity->location }}
                    </p>
                    @endif
                    
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('activities.edit', $activity) }}" class="flex-1 text-center bg-primary-50 hover:bg-primary-100 text-primary-700 font-semibold py-2 px-3 rounded-lg text-sm transition duration-200">
                            Edit
                        </a>
                        <form action="{{ route('activities.destroy', $activity) }}" method="POST" 
                              onsubmit="return confirm('Hapus kegiatan ini?')" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-50 hover:bg-red-100 text-red-700 font-semibold py-2 px-3 rounded-lg text-sm transition duration-200">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="mt-6">
            {{ $activities->links() }}
        </div>
        @else
        <div class="text-center py-12">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Kegiatan</h3>
            <p class="text-gray-600 mb-4">Mulai tambahkan kegiatan organisasi Anda</p>
            <a href="{{ route('activities.create') }}" class="btn-primary inline-flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Kegiatan Pertama
            </a>
        </div>
        @endif
    </div>
</div>
@endsection