@extends('layouts.app')

@section('title', 'Berita ORMAWA')

@section('content')
{{-- Hero Section --}}
<div class="bg-gradient-to-br from-primary-600 via-primary-700 to-primary-900 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Berita ORMAWA</h1>
            <p class="text-xl text-primary-100 max-w-3xl mx-auto">
                Informasi terkini dan terlengkap dari Organisasi Mahasiswa IKIP PGRI Bojonegoro
            </p>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    {{-- Featured News --}}
    @if($featuredNews->count() > 0)
    <div class="mb-12">
        <h2 class="text-3xl font-bold text-gray-900 mb-6">Berita Unggulan</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($featuredNews as $featured)
            <a href="{{ route('public.news.show', $featured->slug) }}" class="group">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300">
                    @if($featured->featured_image)
                        <img src="{{ Storage::url($featured->featured_image) }}" alt="{{ $featured->title }}" class="w-full h-56 object-cover group-hover:scale-105 transition duration-300">
                    @else
                        <div class="w-full h-56 bg-gradient-to-br from-primary-400 to-primary-600"></div>
                    @endif
                    <div class="p-6">
                        <div class="flex items-center space-x-2 mb-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($featured->category === 'prestasi') bg-yellow-100 text-yellow-800
                                @elseif($featured->category === 'kegiatan') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $featured->category_name }}
                            </span>
                            <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-primary-600 line-clamp-2">{{ $featured->title }}</h3>
                        <p class="text-gray-600 mb-3 line-clamp-2">{{ $featured->excerpt }}</p>
                        <div class="flex items-center text-sm text-gray-500">
                            <span>{{ $featured->ormawa->name }}</span>
                            <span class="mx-2">•</span>
                            <span>{{ $featured->published_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Filters --}}
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            {{-- Category Filter --}}
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('public.news.index') }}" 
                   class="px-4 py-2 rounded-full font-medium text-sm transition duration-200 {{ !request('category') ? 'bg-primary-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Semua
                </a>
                <a href="{{ route('public.news.index', ['category' => 'prestasi']) }}" 
                   class="px-4 py-2 rounded-full font-medium text-sm transition duration-200 {{ request('category') == 'prestasi' ? 'bg-yellow-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Prestasi
                </a>
                <a href="{{ route('public.news.index', ['category' => 'kegiatan']) }}" 
                   class="px-4 py-2 rounded-full font-medium text-sm transition duration-200 {{ request('category') == 'kegiatan' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Kegiatan
                </a>
                <a href="{{ route('public.news.index', ['category' => 'pengumuman']) }}" 
                   class="px-4 py-2 rounded-full font-medium text-sm transition duration-200 {{ request('category') == 'pengumuman' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Pengumuman
                </a>
                <a href="{{ route('public.news.index', ['category' => 'opini']) }}" 
                   class="px-4 py-2 rounded-full font-medium text-sm transition duration-200 {{ request('category') == 'opini' ? 'bg-purple-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Opini
                </a>
                <a href="{{ route('public.news.index', ['category' => 'liputan']) }}" 
                   class="px-4 py-2 rounded-full font-medium text-sm transition duration-200 {{ request('category') == 'liputan' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Liputan
                </a>
            </div>

            {{-- ORMAWA Filter --}}
            <div>
                <select onchange="window.location.href=this.value" class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500">
                    <option value="{{ route('public.news.index') }}">Semua ORMAWA</option>
                    @foreach($ormawas as $ormawa)
                        <option value="{{ route('public.news.index', ['ormawa' => $ormawa->id]) }}" 
                                {{ request('ormawa') == $ormawa->id ? 'selected' : '' }}>
                            {{ $ormawa->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- News Grid --}}
    @if($news->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($news as $item)
        <article class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 transform hover:-translate-y-1">
            <a href="{{ route('public.news.show', $item->slug) }}" class="block">
                @if($item->featured_image)
                    <img src="{{ Storage::url($item->featured_image) }}" alt="{{ $item->title }}" class="w-full h-56 object-cover">
                @else
                    <div class="w-full h-56 bg-gradient-to-br from-gray-400 to-gray-600"></div>
                @endif
            </a>
            
            <div class="p-6">
                <div class="flex items-center justify-between mb-3">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        @if($item->category === 'prestasi') bg-yellow-100 text-yellow-800
                        @elseif($item->category === 'kegiatan') bg-blue-100 text-blue-800
                        @elseif($item->category === 'pengumuman') bg-red-100 text-red-800
                        @elseif($item->category === 'opini') bg-purple-100 text-purple-800
                        @elseif($item->category === 'liputan') bg-green-100 text-green-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ $item->category_name }}
                    </span>
                    <span class="text-xs text-gray-500">{{ $item->reading_time }} min</span>
                </div>
                
                <a href="{{ route('public.news.show', $item->slug) }}">
                    <h3 class="text-xl font-bold text-gray-900 mb-2 hover:text-primary-600 transition line-clamp-2">
                        {{ $item->title }}
                    </h3>
                </a>
                
                <p class="text-gray-600 mb-4 line-clamp-3">{{ $item->excerpt }}</p>
                
                <div class="flex items-center justify-between pt-4 border-t">
                    <div class="flex items-center text-sm text-gray-500">
                        <span class="font-medium">{{ $item->ormawa->name }}</span>
                    </div>
                    <div class="text-xs text-gray-400">
                        {{ $item->published_at->format('d M Y') }}
                    </div>
                </div>
            </div>
        </article>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-12">
        {{ $news->links() }}
    </div>
    @else
    <div class="text-center py-16">
        <svg class="w-24 h-24 mx-auto text-gray-400 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
        </svg>
        <h3 class="text-2xl font-bold text-gray-900 mb-2">Belum Ada Berita</h3>
        <p class="text-gray-600">Berita akan segera hadir</p>
    </div>
    @endif
</div>
@endsection