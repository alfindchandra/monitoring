@extends('layouts.dashboard')

@section('title', 'Edit Kegiatan')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Edit Kegiatan</h1>
        <p class="text-gray-600 mt-1">Perbarui informasi kegiatan</p>
    </div>

    <div class="card">
        <form action="{{ route('activities.update', $activity) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Kegiatan *</label>
                <input type="text" name="title" value="{{ old('title', $activity->title) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Kegiatan *</label>
                <textarea name="description" rows="6" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">{{ old('description', $activity->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Kegiatan *</label>
                    <input type="date" name="event_date" value="{{ old('event_date', $activity->event_date->format('Y-m-d')) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    @error('event_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Waktu Kegiatan</label>
                    <input type="time" name="event_time" value="{{ old('event_time', $activity->event_time ? date('H:i', strtotime($activity->event_time)) : '') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Lokasi</label>
                <input type="text" name="location" value="{{ old('location', $activity->location) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Kegiatan</label>
                @if($activity->image)
                    <img src="{{ Storage::url($activity->image) }}" alt="{{ $activity->title }}" class="w-full h-48 object-cover rounded-lg mb-3">
                @endif
                <input type="file" name="image" accept="image/jpeg,image/jpg,image/png"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah foto</p>
            </div>

            <div class="mb-6">
                <div class="flex items-center">
                    <input type="checkbox" name="is_public" id="is_public" value="1" {{ old('is_public', $activity->is_public) ? 'checked' : '' }}
                        class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                    <label for="is_public" class="ml-2 text-sm text-gray-700">
                        Tampilkan di halaman publik
                    </label>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                <a href="{{ route('activities.index') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">Perbarui Kegiatan</button>
            </div>
        </form>
    </div>
</div>
@endsection
