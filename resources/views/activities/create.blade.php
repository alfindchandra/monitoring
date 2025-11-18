@extends('layouts.dashboard')

@section('title', 'Tambah Kegiatan')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Tambah Kegiatan Baru</h1>
        <p class="text-gray-600 mt-1">Buat kegiatan untuk {{ auth()->user()->ormawa->name }}</p>
    </div>

    <div class="card">
        <form action="{{ route('activities.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Title --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Kegiatan *</label>
                <input type="text" name="title" value="{{ old('title') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                    placeholder="Contoh: Workshop Desain Grafis">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Kegiatan *</label>
                <textarea name="description" rows="6" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                    placeholder="Jelaskan detail kegiatan...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                {{-- Event Date --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Kegiatan *</label>
                    <input type="date" name="event_date" value="{{ old('event_date') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    @error('event_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Event Time --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Waktu Kegiatan (Opsional)</label>
                    <input type="time" name="event_time" value="{{ old('event_time') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    @error('event_time')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Location --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Lokasi (Opsional)</label>
                <input type="text" name="location" value="{{ old('location') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                    placeholder="Contoh: Aula Kampus IKIP PGRI Bojonegoro">
                @error('location')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Image --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Kegiatan (Opsional)</label>
                <input type="file" name="image" accept="image/jpeg,image/jpg,image/png"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                <p class="text-xs text-gray-500 mt-1">Format: JPG, JPEG, PNG. Maksimal 2MB</p>
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Public Option --}}
            <div class="mb-6">
                <div class="flex items-center">
                    <input type="checkbox" name="is_public" id="is_public" value="1" {{ old('is_public') ? 'checked' : '' }} checked
                        class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                    <label for="is_public" class="ml-2 text-sm text-gray-700">
                        Tampilkan di halaman publik
                        <span class="text-gray-500">(Kegiatan dapat dilihat oleh pengunjung website)</span>
                    </label>
                </div>
            </div>

            {{-- Buttons --}}
            <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                <a href="{{ route('activities.index') }}" class="btn-secondary">
                    Batal
                </a>
                <button type="submit" class="btn-primary">
                    Simpan Kegiatan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection