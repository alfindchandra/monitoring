@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
 @if(auth()->user()->isKetuaBem() || auth()->user()->isKetuaUkm())

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Galeri Foto</h1>
            <p class="text-gray-600 mt-1">Kelola foto dan dokumentasi kegiatan</p>
        </div>
        <a href="{{ route('photos.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-2"></i>Upload Foto
        </a>
    </div>
    @endif

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        {{ session('success') }}
    </div>
    @endif

    <!-- Filter Albums -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
        <div class="flex items-center gap-3 overflow-x-auto">
            <span class="text-gray-700 font-medium whitespace-nowrap">Album:</span>
            <a href="{{ route('photos.index') }}" 
               class="px-4 py-2 rounded-lg {{ !request('album') ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} transition whitespace-nowrap">
                Semua
            </a>
            @foreach($albums as $album)
            <a href="{{ route('photos.album', $album) }}" 
               class="px-4 py-2 rounded-lg {{ request('album') == $album ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} transition whitespace-nowrap">
                {{ $album }}
            </a>
            @endforeach
        </div>
    </div>

    <!-- Photos Grid -->
    @if($photos->count() > 0)
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
        @foreach($photos as $photo)
        <div class="group relative bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-lg transition">
            <a href="{{ route('photos.show', $photo) }}" class="block aspect-square overflow-hidden bg-gray-100">
                <img src="{{ $photo->image_url }}" 
                     alt="{{ $photo->title }}"
                     class="w-full h-full object-cover group-hover:scale-110 transition duration-300"
                     loading="lazy">
            </a>
            
            <!-- Overlay Info -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/0 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                <div class="absolute bottom-0 left-0 right-0 p-3">
                    <h3 class="text-white font-medium text-sm truncate">{{ $photo->title }}</h3>
                    <p class="text-gray-300 text-xs mt-1">
                        <i class="fas fa-eye mr-1"></i>{{ $photo->views_count }}
                    </p>
                </div>
            </div>

            <!-- Badges -->
            <div class="absolute top-2 left-2 flex gap-1">
                @if($photo->is_featured)
                <span class="bg-yellow-500 text-white text-xs px-2 py-1 rounded">
                   <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.364 1.118l1.518 4.674c.3.921-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.364-1.118L2.977 10.1c-.783-.57-.38-1.81.588-1.81h4.915a1 1 0 00.95-.69l1.519-4.674z" />
                   </svg>
                </span>
                @endif
                @if(!$photo->is_public)
                <span class="bg-red-500 text-white text-xs px-2 py-1 rounded">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-3.866-3.582-7-8-7s-8 3.134-8 7 3.582 7 8 7 8-3.134 8-7zM12 11V7m0 4l3-3m-3 3l-3-3" />
                    </svg>
                </span>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity flex gap-1">
                <a href="{{ route('photos.edit', $photo) }}" 
                   class="bg-blue-600 text-white p-2 rounded hover:bg-blue-700 transition text-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </a>
                <form action="{{ route('photos.destroy', $photo) }}" 
                      method="POST" 
                      onsubmit="return confirm('Hapus foto ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="bg-red-600 text-white p-2 rounded hover:bg-red-700 transition text-xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $photos->links() }}
    </div>
    @else
    <div class="bg-gray-50 rounded-lg p-12 text-center">
        <i class="fas fa-images text-gray-300 text-6xl mb-4"></i>
        <h3 class="text-xl font-medium text-gray-600 mb-2">Belum Ada Foto</h3>
        <p class="text-gray-500 mb-4">Mulai dokumentasikan kegiatan dengan upload foto pertama</p>
        <a href="{{ route('photos.create') }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-2"></i>Upload Foto
        </a>
    </div>
    @endif
</div>
@endsection