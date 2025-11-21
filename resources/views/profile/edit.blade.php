@extends('layouts.dashboard')

@section('title', 'Edit Profile & Ormawa')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Edit Profile & Ormawa</h1>
        <p class="text-gray-600 mt-1">Kelola informasi akun dan data organisasi Anda</p>
    </div>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PATCH')

        {{-- 1. KARTU INFORMASI PENGGUNA --}}
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6 border-b pb-2">Informasi Akun</h2>
            
            {{-- Avatar User --}}
            <div class="mb-6 flex items-center space-x-6">
                <div class="flex-shrink-0">
                    @if($user->avatar)
                        <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}" class="w-20 h-20 rounded-full object-cover">
                    @else
                        <div class="w-20 h-20 rounded-full bg-primary-600 flex items-center justify-center text-white text-2xl font-bold">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Foto Profil Akun</label>
                    <input type="file" name="avatar" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                    @error('avatar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon (Pribadi)</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- 2. KARTU INFORMASI ORMAWA (Hanya tampil jika user punya ormawa) --}}
        @if($user->ormawa)
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6 border-b pb-2">Informasi Ormawa</h2>

            {{-- Logo Ormawa --}}
            <div class="mb-6 flex items-center space-x-6">
                <div class="flex-shrink-0">
                    @if($user->ormawa->logo)
                        <img src="{{ Storage::url($user->ormawa->logo) }}" alt="Logo" class="w-24 h-24 object-contain border rounded-lg bg-gray-50">
                    @else
                        <div class="w-24 h-24 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 border">Logo</div>
                    @endif
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Logo Organisasi</label>
                    <input type="file" name="ormawa_logo" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                    <p class="text-xs text-gray-500 mt-1">Format: PNG, JPG. Max 2MB.</p>
                    @error('ormawa_logo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Data Utama Ormawa --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ormawa</label>
                    <input type="text" name="ormawa_name" value="{{ old('ormawa_name', $user->ormawa->name) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipe</label>
                    <select name="ormawa_type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        <option value="ukm" {{ old('ormawa_type', $user->ormawa->type) == 'ukm' ? 'selected' : '' }}>UKM</option>
                        <option value="bem" {{ old('ormawa_type', $user->ormawa->type) == 'bem' ? 'selected' : '' }}>BEM</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Berdiri</label>
                    <input type="number" name="ormawa_established_year" value="{{ old('ormawa_established_year', $user->ormawa->established_year) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                </div>
            </div>

            {{-- Deskripsi, Visi, Misi --}}
            <div class="space-y-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat</label>
                    <textarea name="ormawa_description" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ old('ormawa_description', $user->ormawa->description) }}</textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Visi</label>
                        <textarea name="ormawa_vision" rows="4" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ old('ormawa_vision', $user->ormawa->vision) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Misi</label>
                        <textarea name="ormawa_mission" rows="4" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ old('ormawa_mission', $user->ormawa->mission) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Kontak & Sosmed Ormawa --}}
            <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4 mt-6">Kontak & Sosial Media</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Resmi Ormawa</label>
                    <input type="email" name="ormawa_email" value="{{ old('ormawa_email', $user->ormawa->email) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon / WhatsApp Official</label>
                    <input type="text" name="ormawa_phone" value="{{ old('ormawa_phone', $user->ormawa->phone) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Sekretariat</label>
                    <textarea name="ormawa_address" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ old('ormawa_address', $user->ormawa->address) }}</textarea>
                </div>
                
                {{-- Sosmed --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Instagram (URL/Username)</label>
                    <input type="text" name="ormawa_instagram" value="{{ old('ormawa_instagram', $user->ormawa->instagram) }}" placeholder="https://instagram.com/..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Facebook (URL)</label>
                    <input type="text" name="ormawa_facebook" value="{{ old('ormawa_facebook', $user->ormawa->facebook) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Youtube (URL)</label>
                    <input type="text" name="ormawa_youtube" value="{{ old('ormawa_youtube', $user->ormawa->youtube) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                </div>
            </div>
        </div>
        @endif

        {{-- Tombol Simpan --}}
        <div class="flex justify-end">
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Simpan Semua Perubahan
            </button>
        </div>
    </form>
</div>
@endsection