@extends('layouts.dashboard')

@section('title', 'Edit User')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Edit User</h1>
        <p class="text-gray-600 mt-1">Perbarui informasi user</p>
    </div>

    <div class="card">
        <form action="{{ route('users.update', $user) }}" method="POST" x-data="{ role: '{{ $user->role }}' }">
            @csrf
            @method('PATCH')

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

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Password Baru</label>
                    <input type="password" name="password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah password</p>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Role *</label>
                    <select name="role" x-model="role" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin Kampus</option>
                        <option value="ketua_bem" {{ $user->role === 'ketua_bem' ? 'selected' : '' }}>Ketua BEM</option>
                        <option value="ketua_ukm" {{ $user->role === 'ketua_ukm' ? 'selected' : '' }}>Ketua UKM</option>
                    </select>
                </div>

                <div x-show="role !== 'admin'">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">ORMAWA *</label>
                    <select name="ormawa_id" :required="role !== 'admin'"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <option value="">Pilih ORMAWA</option>
                        @foreach($ormawas as $ormawa)
                            <option value="{{ $ormawa->id }}" {{ $user->ormawa_id == $ormawa->id ? 'selected' : '' }}>
                                {{ $ormawa->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">No. Telepon</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
            </div>

            <div class="mb-6">
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ $user->is_active ? 'checked' : '' }}
                        class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                    <label for="is_active" class="ml-2 text-sm text-gray-700">Akun Aktif</label>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                <a href="{{ route('users.index') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">Perbarui User</button>
            </div>
        </form>
    </div>
</div>
@endsection