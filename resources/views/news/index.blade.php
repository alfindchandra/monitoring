@extends('layouts.dashboard')

@section('title', 'Kelola Berita')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Kelola Berita</h1>
            <p class="text-gray-600 mt-1">Publikasikan berita dan informasi ORMAWA</p>
        </div>
        <a href="{{ route('news.create') }}" class="btn-primary">
            <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tulis Berita
        </a>
    </div>

    <div class="card">
        @if($news->count() > 0)
        <div class="space-y-4">
            @foreach($news as $item)
            <div class="flex items-start space-x-4 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200">
                {{-- Featured Image --}}
                <div class="flex-shrink-0">
                    @if($item->featured_image)
                        <img src="{{ Storage::url($item->featured_image) }}" alt="{{ $item->title }}" class="w-32 h-24 object-cover rounded-lg">
                    @else
                        <div class="w-32 h-24 bg-gradient-to-br from-primary-400 to-primary-600 rounded-lg flex items-center justify-center">
                            <svg class="w-12 h-12 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                        </div>
                    @endif
                </div>

                {{-- Content --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-center space-x-2 mb-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($item->category === 'prestasi') bg-yellow-100 text-yellow-800
                            @elseif($item->category === 'kegiatan') bg-blue-100 text-blue-800
                            @elseif($item->category === 'pengumuman') bg-red-100 text-red-800
                            @elseif($item->category === 'opini') bg-purple-100 text-purple-800
                            @elseif($item->category === 'liputan') bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ $item->category_name }}
                        </span>
                        
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($item->status === 'published') bg-green-100 text-green-800
                            @elseif($item->status === 'draft') bg-gray-100 text-gray-800
                            @else bg-orange-100 text-orange-800 @endif">
                            {{ ucfirst($item->status) }}
                        </span>
                        
                        @if($item->is_featured)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            Unggulan
                        </span>
                        @endif
                    </div>
                    
                    <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $item->title }}</h3>
                    <p class="text-sm text-gray-600 line-clamp-2 mb-2">{{ $item->excerpt }}</p>
                    
                    <div class="flex items-center text-xs text-gray-500 space-x-4">
                        <span>{{ $item->ormawa->name }}</span>
                        <span>•</span>
                        <span>{{ $item->author }}</span>
                        <span>•</span>
                        <span>{{ $item->created_at->format('d M Y') }}</span>
                        @if($item->status === 'published')
                        <span>•</span>
                        <span>{{ $item->views_count }} views</span>
                        @endif
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex-shrink-0 flex flex-col space-y-2">
                    <a href="{{ route('news.show', $item) }}" class="text-primary-600 hover:text-primary-700 font-semibold text-sm">
                        Lihat
                    </a>
                    <a href="{{ route('news.edit', $item) }}" class="text-blue-600 hover:text-blue-700 font-semibold text-sm">
                        Edit
                    </a>
                    @if($item->status === 'draft')
                    <form action="{{ route('news.publish', $item) }}" method="POST" onsubmit="return confirm('Publikasikan berita ini?')">
                        @csrf
                        <button type="submit" class="text-green-600 hover:text-green-700 font-semibold text-sm">
                            Publikasikan
                        </button>
                    </form>
                    @endif
                    <form action="{{ route('news.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus berita ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-700 font-semibold text-sm">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $news->links() }}
        </div>
        @else
        <div class="text-center py-12">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Berita</h3>
            <p class="text-gray-600 mb-4">Mulai tulis berita untuk ORMAWA Anda</p>
            <a href="{{ route('news.create') }}" class="btn-primary inline-flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tulis Berita Pertama
            </a>
        </div>
        @endif
    </div>
</div>
@endsection