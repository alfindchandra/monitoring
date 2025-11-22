@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl">
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('photos.index') }}" class="text-blue-600 hover:text-blue-700">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Galeri
        </a>
        
        <div class="flex gap-2">
            @if(auth()->user()->ormawa_id === $photo->ormawa_id || auth()->user()->isAdmin())
            <a href="{{ route('photos.edit', $photo) }}" 
               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            @endif
            <a href="{{ route('photos.download', $photo) }}" 
               class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                <i class="fas fa-download mr-2"></i>Download
            </a>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Main Photo -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="relative bg-gray-900 flex items-center justify-center" style="min-height: 500px;">
                    <img src="{{ $photo->image_url }}" 
                         alt="{{ $photo->title }}"
                         class="max-w-full max-h-[80vh] object-contain"
                         id="mainPhoto">
                    
                    <!-- Badges -->
                    <div class="absolute top-4 left-4 flex gap-2">
                        @if($photo->is_featured)
                        <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm">
                            <i class="fas fa-star mr-1"></i>Unggulan
                        </span>
                        @endif
                        @if(!$photo->is_public)
                        <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm">
                            <i class="fas fa-lock mr-1"></i>Private
                        </span>
                        @endif
                    </div>
                </div>

                <!-- Photo Title & Description -->
                <div class="p-6">
                    <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ $photo->title }}</h1>
                    
                    @if($photo->description)
                    <p class="text-gray-600 leading-relaxed mb-4">{{ $photo->description }}</p>
                    @endif

                    <!-- Stats -->
                    <div class="flex items-center gap-6 text-gray-500 text-sm border-t pt-4">
                        <span><i class="fas fa-eye mr-2"></i>{{ $photo->views_count }} views</span>
                        <span><i class="fas fa-download mr-2"></i>{{ $photo->downloads_count }} downloads</span>
                        <span><i class="fas fa-calendar mr-2"></i>{{ $photo->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-6">
            <!-- Photo Info -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Informasi Foto</h3>
                
                <div class="space-y-3 text-sm">
                    <div>
                        <span class="text-gray-500">Album:</span>
                        <a href="{{ route('photos.album', $photo->album) }}" 
                           class="block text-blue-600 hover:text-blue-700 font-medium">
                            {{ $photo->album ?? 'Tanpa Album' }}
                        </a>
                    </div>

                    @if($photo->photographer)
                    <div>
                        <span class="text-gray-500">Fotografer:</span>
                        <p class="text-gray-800 font-medium">{{ $photo->photographer }}</p>
                    </div>
                    @endif

                    @if($photo->taken_date)
                    <div>
                        <span class="text-gray-500">Tanggal Pengambilan:</span>
                        <p class="text-gray-800 font-medium">{{ $photo->taken_date->format('d F Y') }}</p>
                    </div>
                    @endif

                    @if($photo->location)
                    <div>
                        <span class="text-gray-500">Lokasi:</span>
                        <p class="text-gray-800 font-medium">{{ $photo->location }}</p>
                    </div>
                    @endif

                    <div class="pt-3 border-t">
                        <span class="text-gray-500">Diupload oleh:</span>
                        <p class="text-gray-800 font-medium">{{ $photo->user->name }}</p>
                        <p class="text-gray-500 text-xs">{{ $photo->ormawa->name }}</p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            @if(auth()->user()->ormawa_id === $photo->ormawa_id || auth()->user()->isAdmin())
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Aksi</h3>
                
                <div class="space-y-2">
                    <a href="{{ route('photos.edit', $photo) }}" 
                       class="block w-full bg-blue-600 text-white text-center px-4 py-2 rounded-lg hover:bg-blue-700">
                        <i class="fas fa-edit mr-2"></i>Edit Foto
                    </a>
                    
                    <form action="{{ route('photos.destroy', $photo) }}" 
                          method="POST" 
                          onsubmit="return confirm('Yakin ingin menghapus foto ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="block w-full bg-red-600 text-white text-center px-4 py-2 rounded-lg hover:bg-red-700">
                            <i class="fas fa-trash mr-2"></i>Hapus Foto
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Related Photos -->
    @if($relatedPhotos->count() > 0)
    <div class="mt-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Foto Lainnya dari Album "{{ $photo->album }}"</h2>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($relatedPhotos as $related)
            <a href="{{ route('photos.show', $related) }}" 
               class="block group bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-lg transition">
                <div class="aspect-square overflow-hidden bg-gray-100">
                    <img src="{{ $related->thumbnail_url }}" 
                         alt="{{ $related->title }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                </div>
                <div class="p-2">
                    <p class="text-sm text-gray-800 truncate">{{ $related->title }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection