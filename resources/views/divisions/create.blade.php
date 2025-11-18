@extends('layouts.dashboard')

@section('title', 'Tambah Divisi')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Tambah Divisi Baru</h1>
        <p class="text-gray-600 mt-1">Buat departemen/divisi untuk {{ $ormawa->name }}</p>
    </div>

    <div class="card">
        <form action="{{ route('divisions.store') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Divisi/Departemen *</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                    placeholder="Contoh: Divisi Hubungan Masyarakat">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                <textarea name="description" rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                    placeholder="Jelaskan tugas dan tanggung jawab divisi ini">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Urutan Tampilan</label>
                <input type="number" name="order" value="{{ old('order', 0) }}" min="0"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                    placeholder="0">
                <p class="text-xs text-gray-500 mt-1">Semakin kecil angka, semakin atas posisinya</p>
                @error('order')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                <a href="{{ route('divisions.index') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">Simpan Divisi</button>
            </div>
        </form>
    </div>
</div>
@endsection