@extends('layouts.dashboard')

@section('title', 'Tambah Anggota Organisasi')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Tambah Anggota Organisasi</h1>
        <p class="text-gray-600 mt-1">Tambahkan anggota ke struktur {{ $ormawa->name }}</p>
    </div>

    <div class="card">
        <form action="{{ route('organization.store') }}" method="POST" enctype="multipart/form-data" x-data="{ position: 'kepala_divisi' }">
            @csrf

            {{-- Data Pribadi --}}
            <h3 class="text-lg font-bold text-gray-900 mb-4">Data Pribadi</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                        placeholder="Nama lengkap">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">NIM (Opsional untuk Pembina)</label>
                    <input type="text" name="nim" value="{{ old('nim') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                        placeholder="2021010001">
                    @error('nim')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                        placeholder="email@example.com">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">No. Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                        placeholder="081234567890">
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Foto (Opsional)</label>
                <input type="file" name="photo" accept="image/jpeg,image/jpg,image/png"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                <p class="text-xs text-gray-500 mt-1">JPG, JPEG, PNG. Maksimal 2MB</p>
                @error('photo')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Jabatan --}}
            <h3 class="text-lg font-bold text-gray-900 mb-4 mt-8">Jabatan</h3>
            
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Posisi/Jabatan *</label>
                <select name="position" x-model="position" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <option value="pembina">Pembina</option>
                    <option value="ketua">Ketua</option>
                    <option value="wakil_ketua">Wakil Ketua</option>
                    <option value="sekretaris">Sekretaris</option>
                    <option value="bendahara">Bendahara</option>
                    <option value="kepala_divisi">Kepala Divisi</option>
                    <option value="anggota_divisi">Anggota Divisi</option>
                </select>
                @error('position')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6" x-show="position === 'kepala_divisi' || position === 'anggota_divisi'">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Divisi/Departemen *</label>
                <select name="division_id"
                    :required="position === 'kepala_divisi' || position === 'anggota_divisi'"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <option value="">Pilih Divisi</option>
                    @foreach($divisions as $division)
                        <option value="{{ $division->id }}">{{ $division->name }}</option>
                    @endforeach
                </select>
                @error('division_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Periode --}}
            <h3 class="text-lg font-bold text-gray-900 mb-4 mt-8">Periode Kepengurusan</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Mulai *</label>
                    <input type="number" name="period_start" value="{{ old('period_start', date('Y')) }}" 
                        min="2000" max="2100" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    @error('period_start')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Selesai *</label>
                    <input type="number" name="period_end" value="{{ old('period_end', date('Y') + 1) }}" 
                        min="2000" max="2100" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    @error('period_end')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-6 border-t">
                <a href="{{ route('organization.index') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">Simpan Anggota</button>
            </div>
        </form>
    </div>
</div>
@endsection
