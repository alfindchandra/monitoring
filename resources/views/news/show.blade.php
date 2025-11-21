@extends('layouts.dashboard')

@section('title', $news->title)

@section('content')
<div class="max-w-5xl mx-auto">
    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('news.index') }}" class="inline-flex items-center text-primary-600 hover:text-primary-700 font-semibold">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Daftar Berita
        </a>
    </div>

    {{-- Status & Actions --}}
    <div class="card mb-6 bg-gray-50">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    @if($news->status === 'published') bg-green-100 text-green-800
                    @elseif($news->status === 'draft') bg-gray-100 text-gray-800
                    @else bg-orange-100 text-orange-800 @endif">
                    {{ ucfirst($news->status) }}
                </span>
                
                @if($news->is_featured)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    Unggulan
                </span>
                @endif
                
                @if($news->status === 'published')
                <span class="text-sm text-gray-600">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    {{ $news->views_count }} views
                </span>
                @endif
            </div>

            <div class="flex items-center space-x-2">
                @if($news->status === 'draft')
                <form action="{{ route('news.publish', $news) }}" method="POST" class="inline" onsubmit="return confirm('Publikasikan berita ini?')">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition duration-200">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Publikasikan
                    </button>
                </form>
                @endif

                <a href="{{ route('news.edit', $news) }}" class="btn-primary">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>

                <form action="{{ route('news.destroy', $news) }}" method="POST" class="inline" onsubmit="return confirm('Hapus berita ini? Tindakan tidak dapat dibatalkan!')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition duration-200">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <article class="card">
        {{-- Header --}}
        <header class="mb-6 pb-6 border-b">
            <div class="flex items-center space-x-2 mb-3">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                    @if($news->category === 'prestasi') bg-yellow-100 text-yellow-800
                    @elseif($news->category === 'kegiatan') bg-blue-100 text-blue-800
                    @elseif($news->category === 'pengumuman') bg-red-100 text-red-800
                    @elseif($news->category === 'opini') bg-purple-100 text-purple-800
                    @elseif($news->category === 'liputan') bg-green-100 text-green-800
                    @else bg-gray-100 text-gray-800 @endif">
                    {{ $news->category_name }}
                </span>
            </div>
            
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">{{ $news->title }}</h1>
            
            @if($news->excerpt)
            <p class="text-xl text-gray-600 mb-4">{{ $news->excerpt }}</p>
            @endif
            
            <div class="flex items-center text-sm text-gray-500 space-x-4">
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    {{ $news->author }}
                </span>
                <span>•</span>
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    {{ $news->created_at->format('d F Y') }}
                </span>
                @if($news->status === 'published')
                <span>•</span>
                <span>{{ $news->reading_time }} menit bacaan</span>
                @endif
            </div>
        </header>

        {{-- Featured Image --}}
        @if($news->featured_image)
        <div class="mb-8">
            <img src="{{ Storage::url($news->featured_image) }}" alt="{{ $news->title }}" class="w-full h-96 object-cover rounded-xl">
        </div>
        @endif

        {{-- Content --}}
        <div class="prose max-w-none mb-8">
            {!! nl2br(e($news->content)) !!}
        </div>

        {{-- Photo Gallery --}}
        @if($news->photos->count() > 0)
        <div class="mt-8 pt-8 border-t">
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Galeri Foto</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($news->photos as $photo)
                <div class="group relative">
                    <img src="{{ Storage::url($photo->path) }}" alt="{{ $photo->caption }}" class="w-full h-48 object-cover rounded-lg group-hover:opacity-75 transition duration-200">
                    @if($photo->caption)
                    <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white p-2 rounded-b-lg text-xs">
                        {{ $photo->caption }}
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Footer --}}
        <footer class="mt-8 pt-6 border-t">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-500">
                    <p>Dipublikasikan oleh <strong>{{ $news->ormawa->name }}</strong></p>
                </div>
                
                @if($news->status === 'published')
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-500">Bagikan:</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('public.news.show', $news->slug)) }}" target="_blank" class="text-blue-600 hover:text-blue-700">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('public.news.show', $news->slug)) }}&text={{ urlencode($news->title) }}" target="_blank" class="text-blue-400 hover:text-blue-500">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($news->title . ' - ' . route('public.news.show', $news->slug)) }}" target="_blank" class="text-green-600 hover:text-green-700">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    </a>
                </div>
                @endif
            </div>
        </footer>
    </article>
</div>
@endsection