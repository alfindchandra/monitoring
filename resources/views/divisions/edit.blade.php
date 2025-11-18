@extends('layouts.dashboard')

@section('title', 'Edit Divisi')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Edit Divisi</h1>
        <p class="text-gray-600 mt-1">Perbarui informasi divisi</p>
    </div>

    <div class="card">
        <form action="{{ route('divisions.update', $division) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Divisi/Departemen *</label>
                <input type="text" name="name" value="{{ old('name', $division->name) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                <textarea name="description" rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">{{ old('description', $division->description) }}</textarea>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Urutan Tampilan</label>
                <input type="number" name="order" value="{{ old('order', $division->order) }}" min="0"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
            </div>

            <div class="mb-6">
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ $division->is_active ? 'checked' : '' }}
                        class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                    <label for="is_active" class="ml-2 text-sm text-gray-700">Divisi Aktif</label>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                <a href="{{ route('divisions.index') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">Perbarui Divisi</button>
            </div>
        </form>
    </div>
</div>
@endsection