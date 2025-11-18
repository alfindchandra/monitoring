@extends('layouts.dashboard')

@section('title', 'Edit Profile')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Edit Profile</h1>
        <p class="text-gray-600 mt-1">Kelola informasi profil Anda</p>
    </div>

    <div class="space-y-6">
        {{-- Update Profile Information --}}
        <div class="card">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Informasi Profile</h2>
            
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                {{-- Avatar --}}
                <div class="mb-6 flex items-center space-x-6">
                    <div class="flex-shrink-0">
                        @if($user->avatar)
                            <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}" class="w-24 h-24 rounded-full object-cover">
                        @else
                            <div class="w-24 h-24 rounded-full bg-primary-600 flex items-center justify-center text-white text-3xl font-bold">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Profile</label>
                        <input type="file" name="avatar" accept="image/jpeg,image/jpg,image/png"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">JPG, JPEG, PNG. Maksimal 2MB</p>
                        @error('avatar')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap *</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email *</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">No. Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Role & ORMAWA Info (Read-only) --}}
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-semibold text-gray-700">Role</p>
                            <p class="text-gray-900">
                                @if($user->isAdmin()) Admin Kampus
                                @elseif($user->isKetuaBem()) Ketua BEM
                                @else Ketua UKM
                                @endif
                            </p>
                        </div>
                        @if($user->ormawa)
                        <div>
                            <p class="text-sm font-semibold text-gray-700">ORMAWA</p>
                            <p class="text-gray-900">{{ $user->ormawa->name }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="flex items-center justify-end pt-4 border-t">
                    <button type="submit" class="btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>

       
    </div>
</div>
@endsection