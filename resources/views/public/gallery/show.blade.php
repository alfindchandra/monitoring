@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="container mx-auto px-4 max-w-7xl">
        <!-- Breadcrumb -->
        <div class="mb-6">
            <a href="{{ route('gallery.index') }}" class="text-blue-600 hover:text-blue-700">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Galeri
            </a>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Main Photo -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <!-- Photo Display -->
                    <div class="relative bg-gray-900" style="min-height: 500px;">
                        <img src="{{ $photo->image_url }}" 
                             alt="{{ $photo->title }}"
                             class="w-full h-full object-contain max-h-[70vh]"
                             id="mainPhoto">
                        
                        @if($photo->is_featured)
                        <div class="absolute top-4 left-4">
                            <span class="bg-yellow-500 text-white px-4 py-2 rounded-full">
                                <i class="fas fa-star mr-2"></i>Foto Unggulan
                            </span>
                        </div>
                        @endif

                        <!-- Download Button -->
                        <div class="absolute bottom-4 right-4">
                            <a href="{{ route('photos.download', $photo) }}" 
                               class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition shadow-lg">
                                <i class="fas fa-download mr-2"></i>Download
                            </a>
                        </div>
                    </div>

                    <!-- Photo Info -->
                    <div class="p-8">
                        <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $photo->title }}</h1>
                        
                        @if($photo->description)
                        <p class="text-gray-600 leading-relaxed mb-6">{{ $photo->description }}</p>
                        @endif

                        <!-- Stats Row -->
                        <div class="flex flex-wrap items-center gap-6 text-gray-500 text-sm border-t border-b py-4 mb-6">
                            <span class="flex items-center">
                                <i class="fas fa-eye mr-2 text-blue-600"></i>
                                {{ number_format($photo->views_count) }} views
                            </span>
                            <span class="flex items-center">
                                <i class="fas fa-download mr-2 text-green-600"></i>
                                {{ number_format($photo->downloads_count) }} downloads
                            </span>
                            <span class="flex items-center">
                                <i class="fas fa-calendar mr-2 text-purple-600"></i>
                                {{ $photo->created_at->format('d F Y') }}
                            </span>
                        </div>

                        <!-- Share Section -->
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 mb-3">Bagikan Foto</h3>
                            <div class="flex gap-3">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('gallery.show', $photo)) }}" 
                                   target="_blank"
                                   class="flex-1 bg-blue-600 text-white text-center px-4 py-3 rounded-lg hover:bg-blue-700 transition">
                                    <i class="fab fa-facebook-f mr-2"></i>Facebook
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('gallery.show', $photo)) }}&text={{ urlencode($photo->title) }}" 
                                   target="_blank"
                                   class="flex-1 bg-sky-500 text-white text-center px-4 py-3 rounded-lg hover:bg-sky-600 transition">
                                    <i class="fab fa-twitter mr-2"></i>Twitter
                                </a>
                                <a href="https://wa.me/?text={{ urlencode($photo->title . ' - ' . route('gallery.show', $photo)) }}" 
                                   target="_blank"
                                   class="flex-1 bg-green-500 text-white text-center px-4 py-3 rounded-lg hover:bg-green-600 transition">
                                    <i class="fab fa-whatsapp mr-2"></i>WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Photo Details -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Detail Foto</h3>
                    
                    <div class="space-y-4">
                        <!-- ORMAWA -->
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-university text-blue-600"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs text-gray-500 mb-1">ORMAWA</p>
                                <a href="" 
                                   class="font-medium text-gray-800 hover:text-blue-600">
                                    {{ $photo->ormawa->name }}
                                </a>
                            </div>
                        </div>

                        <!-- Album -->
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-folder text-purple-600"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs text-gray-500 mb-1">Album</p>
                                <a href="{{ route('gallery.index', ['album' => $photo->album]) }}" 
                                   class="font-medium text-gray-800 hover:text-blue-600">
                                    {{ $photo->album ?? 'Tanpa Album' }}
                                </a>
                            </div>
                        </div>

                        @if($photo->photographer)
                        <!-- Photographer -->
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-camera text-green-600"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs text-gray-500 mb-1">Fotografer</p>
                                <p class="font-medium text-gray-800">{{ $photo->photographer }}</p>
                            </div>
                        </div>
                        @endif

                        @if($photo->taken_date)
                        <!-- Date Taken -->
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-calendar-day text-orange-600"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs text-gray-500 mb-1">Tanggal Pengambilan</p>
                                <p class="font-medium text-gray-800">{{ $photo->taken_date->format('d F Y') }}</p>
                            </div>
                        </div>
                        @endif

                        @if($photo->location)
                        <!-- Location -->
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-map-marker-alt text-red-600"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs text-gray-500 mb-1">Lokasi</p>
                                <p class="font-medium text-gray-800">{{ $photo->location }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Uploaded By -->
                        <div class="flex items-start gap-3 pt-4 border-t">
                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-user text-gray-600"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs text-gray-500 mb-1">Diupload oleh</p>
                                <p class="font-medium text-gray-800">{{ $photo->user->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CTA Download -->
                <div class="bg-gradient-to-br from-blue-600 to-blue-800 text-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold mb-2">Suka dengan foto ini?</h3>
                    <p class="text-blue-100 text-sm mb-4">Download foto ini untuk koleksi Anda</p>
                    <a href="{{ route('photos.download', $photo) }}" 
                       class="block w-full bg-white text-blue-600 text-center font-medium px-6 py-3 rounded-lg hover:bg-blue-50 transition">
                        <i class="fas fa-download mr-2"></i>Download Sekarang
                    </a>
                </div>
            </div>
        </div>

        <!-- Related Photos -->
        @if($relatedPhotos->count() > 0)
        <div class="mt-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-800">
                    Foto Lainnya dari "{{ $photo->album }}"
                </h2>
                <a href="{{ route('gallery.index', ['album' => $photo->album]) }}" 
                   class="text-blue-600 hover:text-blue-700 font-medium">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach($relatedPhotos as $related)
                <a href="{{ route('gallery.show', $related) }}" 
                   class="group block bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-xl transition">
                    <div class="aspect-square overflow-hidden bg-gray-100">
                        <img src="{{ $related->thumbnail_url }}" 
                             alt="{{ $related->title }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                    </div>
                    <div class="p-3">
                        <p class="text-sm font-medium text-gray-800 truncate group-hover:text-blue-600">
                            {{ $related->title }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">
                            <i class="fas fa-eye mr-1"></i>{{ $related->views_count }}
                        </p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection