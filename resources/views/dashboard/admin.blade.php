@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-6">
    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Dashboard Admin</h1>
            <p class="text-gray-600 mt-1">Selamat datang, {{ auth()->user()->name }}</p>
        </div>
        <div class="text-right">
            <p class="text-sm text-gray-500">{{ now()->isoFormat('dddd, D MMMM YYYY') }}</p>
            <p class="text-xs text-gray-400">Periode {{ date('Y') }}/{{ date('Y') + 1 }}</p>
        </div>
    </div>

    {{-- Main Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Total ORMAWA --}}
        <div class="card bg-gradient-to-br from-blue-500 to-blue-600 text-white hover:shadow-2xl transition duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-blue-400 bg-opacity-30 p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
            </div>
            <div>
                <p class="text-blue-100 text-sm font-medium">Total ORMAWA</p>
                <p class="text-4xl font-bold mt-2">{{ $totalOrmawa }}</p>
                <p class="text-blue-100 text-xs mt-1">1 BEM + {{ $totalOrmawa - 1 }} UKM</p>
            </div>
        </div>

        {{-- Total User --}}
        <div class="card bg-gradient-to-br from-green-500 to-green-600 text-white hover:shadow-2xl transition duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-green-400 bg-opacity-30 p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
            <div>
                <p class="text-green-100 text-sm font-medium">Total User</p>
                <p class="text-4xl font-bold mt-2">{{ $totalUsers }}</p>
                <p class="text-green-100 text-xs mt-1">Pengguna Aktif</p>
            </div>
        </div>

        {{-- Total Pengumuman --}}
        <div class="card bg-gradient-to-br from-purple-500 to-purple-600 text-white hover:shadow-2xl transition duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-purple-400 bg-opacity-30 p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                    </svg>
                </div>
            </div>
            <div>
                <p class="text-purple-100 text-sm font-medium">Pengumuman</p>
                <p class="text-4xl font-bold mt-2">{{ $totalAnnouncements }}</p>
                <p class="text-purple-100 text-xs mt-1">Total Terkirim</p>
            </div>
        </div>

        {{-- Total Kegiatan --}}
        <div class="card bg-gradient-to-br from-orange-500 to-orange-600 text-white hover:shadow-2xl transition duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-orange-400 bg-opacity-30 p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            <div>
                <p class="text-orange-100 text-sm font-medium">Kegiatan</p>
                <p class="text-4xl font-bold mt-2">{{ $totalActivities }}</p>
                <p class="text-orange-100 text-xs mt-1">Total Kegiatan</p>
            </div>
        </div>
    </div>

    {{-- Secondary Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Pengumuman Bulan Ini --}}
        <div class="card border-l-4 border-indigo-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Pengumuman Bulan Ini</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $announcementsThisMonth }}</p>
                </div>
                <div class="text-indigo-500">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Kegiatan Mendatang --}}
        <div class="card border-l-4 border-pink-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Kegiatan Mendatang</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $upcomingActivities }}</p>
                </div>
                <div class="text-pink-500">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- ORMAWA Aktif --}}
        <div class="card border-l-4 border-teal-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">ORMAWA Aktif</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $activeOrmawa }}</p>
                </div>
                <div class="text-teal-500">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="card">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Aksi Cepat</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('ormawas.create') }}" class="flex flex-col items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition duration-200 group">
                <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center mb-2 group-hover:scale-110 transition duration-200">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <span class="text-sm font-semibold text-gray-900 text-center">Tambah ORMAWA</span>
            </a>

            <a href="{{ route('users.create') }}" class="flex flex-col items-center p-4 bg-green-50 hover:bg-green-100 rounded-lg transition duration-200 group">
                <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center mb-2 group-hover:scale-110 transition duration-200">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <span class="text-sm font-semibold text-gray-900 text-center">Tambah User</span>
            </a>

            <a href="{{ route('ormawas.index') }}" class="flex flex-col items-center p-4 bg-purple-50 hover:bg-purple-100 rounded-lg transition duration-200 group">
                <div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center mb-2 group-hover:scale-110 transition duration-200">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <span class="text-sm font-semibold text-gray-900 text-center">Kelola ORMAWA</span>
            </a>

            <a href="{{ route('users.index') }}" class="flex flex-col items-center p-4 bg-orange-50 hover:bg-orange-100 rounded-lg transition duration-200 group">
                <div class="w-12 h-12 bg-orange-500 rounded-full flex items-center justify-center mb-2 group-hover:scale-110 transition duration-200">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <span class="text-sm font-semibold text-gray-900 text-center">Kelola User</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Recent Announcements --}}
        <div class="card">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900">Pengumuman Terbaru</h2>
                <a href="{{ route('announcements.inbox') }}" class="text-primary-600 hover:text-primary-700 text-sm font-semibold">Lihat Semua →</a>
            </div>
            
            @if($recentAnnouncements->count() > 0)
            <div class="space-y-3">
                @foreach($recentAnnouncements as $announcement)
                <div class="flex items-start space-x-3 p-3 hover:bg-gray-50 rounded-lg transition duration-200">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $announcement->title }}</p>
                        <p class="text-xs text-gray-500 mt-1">
                            {{ $announcement->ormawa->name }} • {{ $announcement->created_at->diffForHumans() }}
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                            @if($announcement->status === 'sent') bg-green-100 text-green-800 @else bg-gray-100 text-gray-800 @endif">
                            {{ $announcement->status === 'sent' ? 'Terkirim' : 'Draft' }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8">
                <svg class="w-12 h-12 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <p class="text-gray-500 text-sm">Belum ada pengumuman</p>
            </div>
            @endif
        </div>

        {{-- Recent Activities --}}
        <div class="card">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900">Kegiatan Terbaru</h2>
                <a href="{{ route('public.activitie') }}" class="text-primary-600 hover:text-primary-700 text-sm font-semibold">Lihat Semua →</a>
            </div>
            
            @if($recentActivities->count() > 0)
            <div class="space-y-3">
                @foreach($recentActivities as $activity)
                <div class="flex items-start space-x-3 p-3 hover:bg-gray-50 rounded-lg transition duration-200">
                    <div class="flex-shrink-0">
                        @if($activity->image)
                            <img src="{{ Storage::url($activity->image) }}" alt="{{ $activity->title }}" class="w-12 h-12 rounded-lg object-cover">
                        @else
                            <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $activity->title }}</p>
                        <p class="text-xs text-gray-500 mt-1">
                            {{ $activity->ormawa->name }} • {{ $activity->event_date->format('d M Y') }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8">
                <svg class="w-12 h-12 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p class="text-gray-500 text-sm">Belum ada kegiatan</p>
            </div>
            @endif
        </div>
    </div>

    {{-- ORMAWA Status Table --}}
    <div class="card">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Status ORMAWA</h2>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">ORMAWA</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Tipe</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase">Anggota</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase">Kegiatan</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase">Pengumuman</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($ormawaStats as $ormawa)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @if($ormawa->logo)
                                    <img src="{{ Storage::url($ormawa->logo) }}" alt="{{ $ormawa->name }}" class="w-8 h-8 rounded-full mr-3">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-bold text-xs mr-3">
                                        {{ substr($ormawa->name, 0, 2) }}
                                    </div>
                                @endif
                                <span class="font-medium text-gray-900">{{ $ormawa->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $ormawa->type === 'bem' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                {{ $ormawa->type === 'bem' ? 'BEM' : 'UKM' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center text-sm text-gray-900">
                            {{ $ormawa->members_count }}
                        </td>
                        <td class="px-6 py-4 text-center text-sm text-gray-900">
                            {{ $ormawa->activities_count }}
                        </td>
                        <td class="px-6 py-4 text-center text-sm text-gray-900">
                            {{ $ormawa->announcements_count }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $ormawa->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $ormawa->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection