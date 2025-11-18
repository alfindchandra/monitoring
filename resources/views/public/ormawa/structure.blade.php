@extends('layouts.app')

@section('title', 'Struktur Organisasi ' . $ormawa->name)

@section('content')
{{-- Hero Section --}}
<div class="bg-gradient-to-br from-primary-600 via-primary-700 to-primary-900 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Struktur Organisasi</h1>
            <p class="text-xl text-primary-100">{{ $ormawa->name }}</p>
            <div class="mt-6">
                <a href="{{ route('public.ormawa.detail', $ormawa->slug) }}" class="inline-flex items-center text-white hover:text-primary-100">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke Profil ORMAWA
                </a>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    {{-- Pembina --}}
    @if($structure['pembina'])
    <div class="mb-12">
        <h2 class="text-2xl font-bold text-center text-gray-900 mb-8">Pembina</h2>
        <div class="flex justify-center">
            <div class="text-center">
                <div class="mb-4">
                    @if($structure['pembina']->photo)
                        <img src="{{ Storage::url($structure['pembina']->photo) }}" alt="{{ $structure['pembina']->name }}" 
                             class="w-40 h-40 mx-auto rounded-full object-cover border-4 border-purple-200 shadow-lg">
                    @else
                        <div class="w-40 h-40 mx-auto rounded-full bg-purple-100 flex items-center justify-center text-purple-600 text-4xl font-bold border-4 border-purple-200 shadow-lg">
                            {{ substr($structure['pembina']->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <span class="inline-block px-4 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-semibold mb-2">PEMBINA</span>
                <h3 class="text-xl font-bold text-gray-900">{{ $structure['pembina']->name }}</h3>
                @if($structure['pembina']->nim)<p class="text-gray-500">{{ $structure['pembina']->nim }}</p>@endif
            </div>
        </div>
    </div>
    @endif

    {{-- Inti Kepengurusan --}}
    <div class="mb-12">
        <h2 class="text-2xl font-bold text-center text-gray-900 mb-8">Pengurus Inti</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            {{-- Ketua --}}
            @if($structure['ketua'])
            <div class="text-center">
                <div class="mb-4">
                    @if($structure['ketua']->photo)
                        <img src="{{ Storage::url($structure['ketua']->photo) }}" alt="{{ $structure['ketua']->name }}" 
                             class="w-32 h-32 mx-auto rounded-full object-cover border-4 border-blue-200">
                    @else
                        <div class="w-32 h-32 mx-auto rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-3xl font-bold border-4 border-blue-200">
                            {{ substr($structure['ketua']->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold mb-2">KETUA</span>
                <h3 class="font-bold text-gray-900">{{ $structure['ketua']->name }}</h3>
                @if($structure['ketua']->nim)<p class="text-sm text-gray-500">{{ $structure['ketua']->nim }}</p>@endif
            </div>
            @endif

            {{-- Wakil Ketua --}}
            @if($structure['wakil_ketua'])
            <div class="text-center">
                <div class="mb-4">
                    @if($structure['wakil_ketua']->photo)
                        <img src="{{ Storage::url($structure['wakil_ketua']->photo) }}" alt="{{ $structure['wakil_ketua']->name }}" 
                             class="w-32 h-32 mx-auto rounded-full object-cover border-4 border-green-200">
                    @else
                        <div class="w-32 h-32 mx-auto rounded-full bg-green-100 flex items-center justify-center text-green-600 text-3xl font-bold border-4 border-green-200">
                            {{ substr($structure['wakil_ketua']->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <span class="inline-block px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold mb-2">WAKIL KETUA</span>
                <h3 class="font-bold text-gray-900">{{ $structure['wakil_ketua']->name }}</h3>
                @if($structure['wakil_ketua']->nim)<p class="text-sm text-gray-500">{{ $structure['wakil_ketua']->nim }}</p>@endif
            </div>
            @endif

            {{-- Sekretaris --}}
            @if($structure['sekretaris'])
            <div class="text-center">
                <div class="mb-4">
                    @if($structure['sekretaris']->photo)
                        <img src="{{ Storage::url($structure['sekretaris']->photo) }}" alt="{{ $structure['sekretaris']->name }}" 
                             class="w-32 h-32 mx-auto rounded-full object-cover border-4 border-orange-200">
                    @else
                        <div class="w-32 h-32 mx-auto rounded-full bg-orange-100 flex items-center justify-center text-orange-600 text-3xl font-bold border-4 border-orange-200">
                            {{ substr($structure['sekretaris']->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <span class="inline-block px-3 py-1 bg-orange-100 text-orange-800 rounded-full text-xs font-semibold mb-2">SEKRETARIS</span>
                <h3 class="font-bold text-gray-900">{{ $structure['sekretaris']->name }}</h3>
                @if($structure['sekretaris']->nim)<p class="text-sm text-gray-500">{{ $structure['sekretaris']->nim }}</p>@endif
            </div>
            @endif

            {{-- Bendahara --}}
            @if($structure['bendahara'])
            <div class="text-center">
                <div class="mb-4">
                    @if($structure['bendahara']->photo)
                        <img src="{{ Storage::url($structure['bendahara']->photo) }}" alt="{{ $structure['bendahara']->name }}" 
                             class="w-32 h-32 mx-auto rounded-full object-cover border-4 border-red-200">
                    @else
                        <div class="w-32 h-32 mx-auto rounded-full bg-red-100 flex items-center justify-center text-red-600 text-3xl font-bold border-4 border-red-200">
                            {{ substr($structure['bendahara']->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <span class="inline-block px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold mb-2">BENDAHARA</span>
                <h3 class="font-bold text-gray-900">{{ $structure['bendahara']->name }}</h3>
                @if($structure['bendahara']->nim)<p class="text-sm text-gray-500">{{ $structure['bendahara']->nim }}</p>@endif
            </div>
            @endif
        </div>
    </div>

    {{-- Departemen & Divisi --}}
    @if(count($structure['divisions']) > 0)
    <div>
        <h2 class="text-2xl font-bold text-center text-gray-900 mb-8">Departemen & Divisi</h2>
        
        @foreach($structure['divisions'] as $divisionData)
        <div class="mb-12 last:mb-0">
            <div class="bg-primary-600 text-white py-4 px-6 rounded-t-lg">
                <h3 class="text-xl font-bold">{{ $divisionData['info']->name }}</h3>
                @if($divisionData['info']->description)
                <p class="text-primary-100 text-sm mt-1">{{ $divisionData['info']->description }}</p>
                @endif
            </div>
            
            <div class="bg-white border border-gray-200 rounded-b-lg p-6">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                    {{-- Kepala Divisi --}}
                    @if($divisionData['kepala'])
                    <div class="text-center">
                        <div class="mb-3">
                            @if($divisionData['kepala']->photo)
                                <img src="{{ Storage::url($divisionData['kepala']->photo) }}" alt="{{ $divisionData['kepala']->name }}" 
                                     class="w-24 h-24 mx-auto rounded-full object-cover border-2 border-indigo-300">
                            @else
                                <div class="w-24 h-24 mx-auto rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-2xl font-bold border-2 border-indigo-300">
                                    {{ substr($divisionData['kepala']->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <span class="inline-block px-2 py-1 bg-indigo-100 text-indigo-800 rounded-full text-xs font-semibold mb-1">KEPALA DIVISI</span>
                        <h4 class="font-semibold text-gray-900 text-sm">{{ $divisionData['kepala']->name }}</h4>
                        @if($divisionData['kepala']->nim)<p class="text-xs text-gray-500">{{ $divisionData['kepala']->nim }}</p>@endif
                    </div>
                    @endif
                    
                    {{-- Anggota --}}
                    @foreach($divisionData['anggota'] as $anggota)
                    <div class="text-center">
                        <div class="mb-3">
                            @if($anggota->photo)
                                <img src="{{ Storage::url($anggota->photo) }}" alt="{{ $anggota->name }}" 
                                     class="w-24 h-24 mx-auto rounded-full object-cover">
                            @else
                                <div class="w-24 h-24 mx-auto rounded-full bg-gray-100 flex items-center justify-center text-gray-600 text-2xl font-bold">
                                    {{ substr($anggota->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <span class="inline-block px-2 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-semibold mb-1">ANGGOTA</span>
                        <h4 class="font-semibold text-gray-900 text-sm">{{ $anggota->name }}</h4>
                        @if($anggota->nim)<p class="text-xs text-gray-500">{{ $anggota->nim }}</p>@endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    @if(!$structure['ketua'] && !$structure['pembina'] && count($structure['divisions']) === 0)
    <div class="text-center py-16">
        <svg class="w-24 h-24 mx-auto text-gray-400 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        <h3 class="text-2xl font-bold text-gray-900 mb-2">Struktur Organisasi Belum Tersedia</h3>
        <p class="text-gray-600">Informasi struktur kepengurusan akan segera diperbarui</p>
    </div>
    @endif
</div>
@endsection