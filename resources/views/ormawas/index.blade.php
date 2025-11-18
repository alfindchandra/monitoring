@extends('layouts.dashboard')

@section('title', 'Kelola ORMAWA')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Kelola ORMAWA</h1>
            <p class="text-gray-600 mt-1">Manajemen BEM dan Unit Kegiatan Mahasiswa</p>
        </div>
        <a href="{{ route('ormawas.create') }}" class="btn-primary">
            <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah ORMAWA
        </a>
    </div>

    <div class="card">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($ormawas as $ormawa)
            <div class="bg-gray-50 rounded-lg overflow-hidden hover:shadow-lg transition duration-200">
                <div class="bg-gradient-to-br {{ $ormawa->type === 'bem' ? 'from-blue-500 to-blue-700' : 'from-primary-500 to-primary-700' }} p-4 text-center">
                    @if($ormawa->logo)
                        <img src="{{ Storage::url($ormawa->logo) }}" alt="{{ $ormawa->name }}" class="w-20 h-20 mx-auto object-contain mb-2">
                    @else
                        <div class="w-20 h-20 mx-auto rounded-lg bg-white flex items-center justify-center text-primary-600 font-bold text-xl mb-2">
                            {{ substr($ormawa->name, 0, 3) }}
                        </div>
                    @endif
                    <h3 class="text-white font-bold">{{ $ormawa->name }}</h3>
                </div>
                
                <div class="p-4">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-semibold text-gray-500 uppercase">
                            {{ $ormawa->type === 'bem' ? 'BEM' : 'UKM' }}
                        </span>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                            {{ $ormawa->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $ormawa->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                    
                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $ormawa->description }}</p>
                    
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('ormawas.edit', $ormawa) }}" class="flex-1 text-center bg-primary-50 hover:bg-primary-100 text-primary-700 font-semibold py-2 px-3 rounded-lg text-sm">
                            Edit
                        </a>
                        <form action="{{ route('ormawas.toggle-status', $ormawa) }}" method="POST" class="flex-1">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full {{ $ormawa->is_active ? 'bg-red-50 hover:bg-red-100 text-red-700' : 'bg-green-50 hover:bg-green-100 text-green-700' }} font-semibold py-2 px-3 rounded-lg text-sm">
                                {{ $ormawa->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="mt-6">
            {{ $ormawas->links() }}
        </div>
    </div>
</div>
@endsection