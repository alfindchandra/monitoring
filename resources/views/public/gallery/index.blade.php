@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-br from-blue-600 to-blue-800 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Galeri Foto</h1>
            <p class="text-xl text-blue-100 max-w-2xl mx-auto">
                Dokumentasi kegiatan dan momen berharga ORMAWA IKIP PGRI Bojonegoro
            </p>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 py-12">
    
    <!-- Featured Photos (Opsional: Tetap ditampilkan sebagai highlight) -->
    @if(isset($featuredPhotos) && $featuredPhotos->count() > 0)
    <div class="mb-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Foto Unggulan</h2>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach($featuredPhotos as $featured)
            <a href="{{ route('gallery.show', $featured) }}" 
               class="group relative overflow-hidden rounded-lg shadow-lg hover:shadow-2xl transition">
                <div class="aspect-video overflow-hidden bg-gray-100">
                    <img src="{{ $featured->image_url }}" 
                         alt="{{ $featured->title }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent flex items-end p-6">
                    <div class="text-white">
                        <h3 class="text-xl font-bold mb-2">{{ $featured->title }}</h3>
                        <p class="text-sm text-gray-200">{{ $featured->ormawa->name }}</p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif


    @if($photos->count() > 0)
    <div class="columns-1 md:columns-1 lg:columns-2 xl:columns-3 gap-4 space-y-4">
        @foreach($photos as $photo)
        <div  
           class="break-inside-avoid block mb-4 group relative bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-xl transition">
            
            <div class="bg-gray-100">
                <img src="{{ $photo->thumbnail_url }}" 
                     alt="{{ $photo->title }}"
                     class="w-full h-auto object-contain group-hover:scale-105 transition duration-500"
                     loading="lazy">
            </div>
            
            <!-- Overlay Info -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <div class="absolute bottom-0 left-0 right-0 p-4">
                    <h3 class="text-white font-medium text-sm mb-1 line-clamp-2">{{ $photo->title }}</h3>
                    <p class="text-gray-300 text-xs">{{ $photo->ormawa->name }}</p>
                    
                    <!-- Stats Icons -->
                    <div class="flex items-center gap-3 text-gray-300 text-xs mt-2">
                        <span><i class="fas fa-eye mr-1"></i>{{ $photo->views_count }}</span>
                        <span><i class="fas fa-download mr-1"></i>{{ $photo->downloads_count }}</span>
                    </div>
                </div>
            </div>

            <!-- Featured Badge -->
            @if($photo->is_featured)
            <div class="absolute top-2 left-2">
                <span class="bg-yellow-500 text-white text-xs px-2 py-1 rounded-full shadow-sm">
                    <i class="fas fa-star"></i>
                </span>
            </div>
            @endif
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-10">
        {{ $photos->links() }}
    </div>

    @else
    <!-- Empty State -->
    <div class="bg-gray-50 rounded-lg p-16 text-center border-2 border-dashed border-gray-200">
        <i class="fas fa-images text-gray-300 text-6xl mb-4"></i>
        <h3 class="text-xl font-medium text-gray-600 mb-2">Belum Ada Foto</h3>
        <p class="text-gray-500">Saat ini belum ada dokumentasi yang diunggah.</p>
    </div>
    @endif

</div>
@endsection