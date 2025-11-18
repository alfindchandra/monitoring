@extends('layouts.dashboard')

@section('title', 'Kelola Divisi')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Kelola Divisi</h1>
            <p class="text-gray-600 mt-1">Departemen/Divisi {{ $ormawa->name }}</p>
        </div>
        <a href="{{ route('divisions.create') }}" class="btn-primary">
            <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Divisi
        </a>
    </div>

    <div class="card">
        @if($divisions->count() > 0)
        <div class="space-y-3">
            @foreach($divisions as $division)
            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200">
                <div class="flex items-center space-x-4 flex-1">
                    <div class="flex items-center justify-center w-12 h-12 bg-primary-100 rounded-lg">
                        <span class="text-primary-600 font-bold text-lg">{{ $division->order }}</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-gray-900">{{ $division->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $division->description }}</p>
                        <p class="text-xs text-gray-500 mt-1">
                            {{ $division->members()->count() }} anggota
                        </p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-3">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        {{ $division->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $division->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                    
                    <a href="{{ route('divisions.edit', $division) }}" class="text-primary-600 hover:text-primary-700 font-semibold">
                        Edit
                    </a>
                    
                    @if($division->members()->count() === 0)
                    <form action="{{ route('divisions.destroy', $division) }}" method="POST" 
                          onsubmit="return confirm('Hapus divisi ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-700 font-semibold">
                            Hapus
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Divisi</h3>
            <p class="text-gray-600 mb-4">Tambahkan departemen/divisi untuk organisasi Anda</p>
            <a href="{{ route('divisions.create') }}" class="btn-primary inline-flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Divisi Pertama
            </a>
        </div>
        @endif
    </div>
</div>
@endsection