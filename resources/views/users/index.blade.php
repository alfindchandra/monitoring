@extends('layouts.dashboard')

@section('title', 'Kelola User')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Kelola User</h1>
            <p class="text-gray-600 mt-1">Manajemen akun pengguna sistem</p>
        </div>
        <a href="{{ route('users.create') }}" class="btn-primary">
            <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah User
        </a>
    </div>

    <div class="card">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">ORMAWA</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-semibold">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <span class="ml-3 font-medium text-gray-900">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($user->role === 'admin') bg-purple-100 text-purple-800
                                @elseif($user->role === 'ketua_bem') bg-blue-100 text-blue-800
                                @else bg-green-100 text-green-800 @endif">
                                {{ $user->role === 'admin' ? 'Admin' : ($user->role === 'ketua_bem' ? 'Ketua BEM' : 'Ketua UKM') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $user->ormawa ? $user->ormawa->name : '-' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('users.edit', $user) }}" class="text-primary-600 hover:text-primary-700 font-semibold text-sm">
                                    Edit
                                </a>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('users.destroy', $user) }}" method="POST" 
                                      onsubmit="return confirm('Hapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700 font-semibold text-sm">
                                        Hapus
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection