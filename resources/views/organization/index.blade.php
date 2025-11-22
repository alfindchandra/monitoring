@extends('layouts.dashboard')

@section('title', 'Struktur Organisasi')

@section('content')
<div class="space-y-6">
 @if(auth()->user()->isKetuaBem() || auth()->user()->isKetuaUkm())

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Struktur Organisasi</h1>
            <p class="text-gray-600 mt-1">Kepengurusan {{ $ormawa->name }}</p>
        </div>
        <a href="{{ route('organization.create') }}" class="btn-primary">
            <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Anggota
        </a>
    </div>
    @endif

    {{-- Inti Kepengurusan --}}
    <div class="card">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Inti Kepengurusan</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- Pembina --}}
            @if($structure['pembina']->count() > 0)
                @foreach($structure['pembina'] as $member)
                <div class="text-center">
                    <div class="mb-3">
                        @if($member->photo)
                            <img src="{{ Storage::url($member->photo) }}" alt="{{ $member->name }}" class="w-32 h-32 mx-auto rounded-full object-cover border-4 border-purple-200">
                        @else
                            <div class="w-32 h-32 mx-auto rounded-full bg-purple-100 flex items-center justify-center text-purple-600 text-3xl font-bold border-4 border-purple-200">
                                {{ substr($member->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <span class="inline-block px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-semibold mb-2">PEMBINA</span>
                    <h3 class="font-bold text-gray-900">{{ $member->name }}</h3>
                    @if($member->nim)<p class="text-sm text-gray-500">{{ $member->nim }}</p>@endif
                    <div class="mt-3 flex justify-center space-x-2">
                        <a href="{{ route('organization.edit', $member) }}" class="text-primary-600 hover:text-primary-700 text-sm font-semibold">Edit</a>
                    </div>
                </div>
                @endforeach
            @else
                <div class="col-span-full text-center py-4">
                    <p class="text-gray-500">Belum ada Pembina</p>
                </div>
            @endif
            
            {{-- Ketua --}}
            @if($structure['ketua']->count() > 0)
                @foreach($structure['ketua'] as $member)
                <div class="text-center">
                    <div class="mb-3">
                        @if($member->photo)
                            <img src="{{ Storage::url($member->photo) }}" alt="{{ $member->name }}" class="w-32 h-32 mx-auto rounded-full object-cover border-4 border-blue-200">
                        @else
                            <div class="w-32 h-32 mx-auto rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-3xl font-bold border-4 border-blue-200">
                                {{ substr($member->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold mb-2">KETUA</span>
                    <h3 class="font-bold text-gray-900">{{ $member->name }}</h3>
                    @if($member->nim)<p class="text-sm text-gray-500">{{ $member->nim }}</p>@endif
                    <div class="mt-3 flex justify-center space-x-2">
                        <a href="{{ route('organization.edit', $member) }}" class="text-primary-600 hover:text-primary-700 text-sm font-semibold">Edit</a>
                    </div>
                </div>
                @endforeach
            @endif
            
            {{-- Wakil Ketua --}}
            @if($structure['wakil_ketua']->count() > 0)
                @foreach($structure['wakil_ketua'] as $member)
                <div class="text-center">
                    <div class="mb-3">
                        @if($member->photo)
                            <img src="{{ Storage::url($member->photo) }}" alt="{{ $member->name }}" class="w-32 h-32 mx-auto rounded-full object-cover border-4 border-green-200">
                        @else
                            <div class="w-32 h-32 mx-auto rounded-full bg-green-100 flex items-center justify-center text-green-600 text-3xl font-bold border-4 border-green-200">
                                {{ substr($member->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <span class="inline-block px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold mb-2">WAKIL KETUA</span>
                    <h3 class="font-bold text-gray-900">{{ $member->name }}</h3>
                    @if($member->nim)<p class="text-sm text-gray-500">{{ $member->nim }}</p>@endif
                    <div class="mt-3 flex justify-center space-x-2">
                        <a href="{{ route('organization.edit', $member) }}" class="text-primary-600 hover:text-primary-700 text-sm font-semibold">Edit</a>
                    </div>
                </div>
                @endforeach
            @endif
            
            {{-- Sekretaris --}}
            @if($structure['sekretaris']->count() > 0)
                @foreach($structure['sekretaris'] as $member)
                <div class="text-center">
                    <div class="mb-3">
                        @if($member->photo)
                            <img src="{{ Storage::url($member->photo) }}" alt="{{ $member->name }}" class="w-32 h-32 mx-auto rounded-full object-cover border-4 border-orange-200">
                        @else
                            <div class="w-32 h-32 mx-auto rounded-full bg-orange-100 flex items-center justify-center text-orange-600 text-3xl font-bold border-4 border-orange-200">
                                {{ substr($member->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <span class="inline-block px-3 py-1 bg-orange-100 text-orange-800 rounded-full text-xs font-semibold mb-2">SEKRETARIS</span>
                    <h3 class="font-bold text-gray-900">{{ $member->name }}</h3>
                    @if($member->nim)<p class="text-sm text-gray-500">{{ $member->nim }}</p>@endif
                    <div class="mt-3 flex justify-center space-x-2">
                        <a href="{{ route('organization.edit', $member) }}" class="text-primary-600 hover:text-primary-700 text-sm font-semibold">Edit</a>
                    </div>
                </div>
                @endforeach
            @endif
            
            {{-- Bendahara --}}
            @if($structure['bendahara']->count() > 0)
                @foreach($structure['bendahara'] as $member)
                <div class="text-center">
                    <div class="mb-3">
                        @if($member->photo)
                            <img src="{{ Storage::url($member->photo) }}" alt="{{ $member->name }}" class="w-32 h-32 mx-auto rounded-full object-cover border-4 border-red-200">
                        @else
                            <div class="w-32 h-32 mx-auto rounded-full bg-red-100 flex items-center justify-center text-red-600 text-3xl font-bold border-4 border-red-200">
                                {{ substr($member->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <span class="inline-block px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold mb-2">BENDAHARA</span>
                    <h3 class="font-bold text-gray-900">{{ $member->name }}</h3>
                    @if($member->nim)<p class="text-sm text-gray-500">{{ $member->nim }}</p>@endif
                    <div class="mt-3 flex justify-center space-x-2">
                        <a href="{{ route('organization.edit', $member) }}" class="text-primary-600 hover:text-primary-700 text-sm font-semibold">Edit</a>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>

    {{-- Kepala Divisi & Anggota --}}
    @if($structure['kepala_divisi']->count() > 0 || $structure['anggota_divisi']->count() > 0)
    <div class="card">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Departemen & Divisi</h2>
        
        @php
            $divisionMembers = $members->whereIn('position', ['kepala_divisi', 'anggota_divisi'])->groupBy('division_id');
        @endphp
        
        @foreach($divisionMembers as $divisionId => $divMembers)
            @php
                $division = $divMembers->first()->division;
            @endphp
            
            <div class="mb-8 last:mb-0">
                <h3 class="text-lg font-bold text-primary-600 mb-4 pb-2 border-b-2 border-primary-200">
                    {{ $division->name }}
                </h3>
                
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($divMembers as $member)
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <div class="mb-2">
                            @if($member->photo)
                                <img src="{{ Storage::url($member->photo) }}" alt="{{ $member->name }}" class="w-20 h-20 mx-auto rounded-full object-cover">
                            @else
                                <div class="w-20 h-20 mx-auto rounded-full bg-gray-200 flex items-center justify-center text-gray-600 text-xl font-bold">
                                    {{ substr($member->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <span class="inline-block px-2 py-1 {{ $member->position === 'kepala_divisi' ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-200 text-gray-700' }} rounded-full text-xs font-semibold mb-1">
                            {{ $member->position_name }}
                        </span>
                        <h4 class="font-semibold text-gray-900 text-sm">{{ $member->name }}</h4>
                        @if($member->nim)<p class="text-xs text-gray-500">{{ $member->nim }}</p>@endif
                        <div class="mt-2 flex justify-center space-x-2">
                            <a href="{{ route('organization.edit', $member) }}" class="text-primary-600 hover:text-primary-700 text-xs font-semibold">Edit</a>
                            <form action="{{ route('organization.destroy', $member) }}" method="POST" class="inline" onsubmit="return confirm('Hapus anggota ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-700 text-xs font-semibold">Hapus</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
    @endif

    @if($members->count() === 0)
    <div class="card">
        <div class="text-center py-12">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Struktur Organisasi</h3>
            <p class="text-gray-600 mb-4">Mulai tambahkan anggota kepengurusan</p>
            <a href="{{ route('organization.create') }}" class="btn-primary inline-flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Anggota Pertama
            </a>
        </div>
    </div>
    @endif
</div>
@endsection