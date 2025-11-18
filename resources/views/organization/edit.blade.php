@extends('layouts.dashboard')

@section('title', 'Edit Anggota Organisasi')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Edit Anggota Organisasi</h1>
        <p class="text-gray-600 mt-1">Perbarui data anggota</p>
    </div>

    <div class="card">
        <form action="{{ route('organization.update', $member) }}" method="POST" enctype="multipart/form-data" x-data="{ position: '{{ $member->position }}' }">
            @csrf
            @method('PATCH')

            {{-- Data Pribadi --}}
            <h3 class="text-lg font-bold text-gray-900 mb-4">Data Pribadi</h3>
            
            @if($member->photo)
            <div class="mb-6">
                <img src="{{ Storage::url($member->photo) }}" alt="{{ $member->name }}" class="w-32 h-32 rounded-full object-cover">
            </div>
            @endif
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap *</label>
                    <input type="text" name="name" value="{{ old('name', $member->name) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">NIM</label>
                    <input type="text" name="nim" value="{{ old('nim', $member->nim) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', $member->email) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">No. Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone', $member->phone) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Update Foto</label>
                <input type="file" name="photo" accept="image/jpeg,image/jpg,image/png"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah foto</p>
            </div>

            {{-- Jabatan --}}
            <h3 class="text-lg font-bold text-gray-900 mb-4 mt-8">Jabatan</h3>
            
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Posisi/Jabatan *</label>
                <select name="position" x-model="position" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <option value="pembina" {{ $member->position === 'pembina' ? 'selected' : '' }}>Pembina</option>
                    <option value="ketua" {{ $member->position === 'ketua' ? 'selected' : '' }}>Ketua</option>
                    <option value="wakil_ketua" {{ $member->position === 'wakil_ketua' ? 'selected' : '' }}>Wakil Ketua</option>
                    <option value="sekretaris" {{ $member->position === 'sekretaris' ? 'selected' : '' }}>Sekretaris</option>
                    <option value="bendahara" {{ $member->position === 'bendahara' ? 'selected' : '' }}>Bendahara</option>
                    <option value="kepala_divisi" {{ $member->position === 'kepala_divisi' ? 'selected' : '' }}>Kepala Divisi</option>
                    <option value="anggota_divisi" {{ $member->position === 'anggota_divisi' ? 'selected' : '' }}>Anggota Divisi</option>
                </select>
            </div>

            <div class="mb-6" x-show="position === 'kepala_divisi' || position === 'anggota_divisi'">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Divisi/Departemen *</label>
                <select name="division_id"
                    :required="position === 'kepala_divisi' || position === 'anggota_divisi'"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <option value="">Pilih Divisi</option>
                    @foreach($divisions as $division)
                        <option value="{{ $division->id }}" {{ $member->division_id == $division->id ? 'selected' : '' }}>
                            {{ $division->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Periode --}}
            <h3 class="text-lg font-bold text-gray-900 mb-4 mt-8">Periode Kepengurusan</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Mulai *</label>
                    <input type="number" name="period_start" value="{{ old('period_start', $member->period_start) }}" 
                        min="2000" max="2100" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Selesai *</label>
                    <input type="number" name="period_end" value="{{ old('period_end', $member->period_end) }}" 
                        min="2000" max="2100" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>
            </div>

            <div class="mb-6">
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ $member->is_active ? 'checked' : '' }}
                        class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                    <label for="is_active" class="ml-2 text-sm text-gray-700">Anggota Aktif</label>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-6 border-t">
                <a href="{{ route('organization.index') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">Perbarui Anggota</button>
            </div>
        </form>
    </div>
</div>
@endsection