@extends('layouts.dashboard')

@section('title', 'Dashboard Ketua UKM')

@section('content')
<div class="space-y-6">
    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
            <p class="text-gray-600 mt-1">{{ $ormawa->name }}</p>
        </div>
        <div class="mt-4 sm:mt-0 flex space-x-3">
            <a href="{{ route('activities.create') }}" class="btn-secondary">
                + Tambah Kegiatan
            </a>
            <a href="{{ route('announcements.create') }}" class="btn-primary">
                + Buat Pengumuman
            </a>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="card bg-gradient-to-br from-blue-500 to-blue-600 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Pengumuman Terkirim</p>
                    <p class="text-3xl font-bold mt-2">{{ $sentAnnouncements }}</p>
                </div>
                <div class="bg-blue-400 bg-opacity-30 p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="card bg-gradient-to-br from-purple-500 to-purple-600 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Pengumuman Masuk</p>
                    <p class="text-3xl font-bold mt-2">{{ $receivedAnnouncements }}</p>
                </div>
                <div class="bg-purple-400 bg-opacity-30 p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="card bg-gradient-to-br from-green-500 to-green-600 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Total Kegiatan</p>
                    <p class="text-3xl font-bold mt-2">{{ $totalActivities }}</p>
                </div>
                <div class="bg-green-400 bg-opacity-30 p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Recent Sent --}}
        <div class="card">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900">Pengumuman Terkirim</h2>
                <a href="{{ route('announcements.index') }}" class="text-primary-600 hover:text-primary-700 text-sm font-semibold">Lihat Semua →</a>
            </div>
            <div class="space-y-3">
                @forelse($recentSent as $announcement)
                <a href="{{ route('announcements.show', $announcement) }}" class="block p-3 hover:bg-gray-50 rounded-lg">
                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $announcement->title }}</p>
                    <p class="text-xs text-gray-500 mt-1">
                        Ke {{ $announcement->recipients->count() }} penerima • {{ $announcement->created_at->diffForHumans() }}
                    </p>
                </a>
                @empty
                <p class="text-gray-500 text-center py-4">Belum ada pengumuman terkirim</p>
                @endforelse
            </div>
        </div>

        {{-- Recent Received --}}
        <div class="card">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900">Pengumuman Masuk</h2>
                <a href="{{ route('announcements.inbox') }}" class="text-primary-600 hover:text-primary-700 text-sm font-semibold">Lihat Semua →</a>
            </div>
            <div class="space-y-3">
                @forelse($recentReceived as $announcement)
                <a href="{{ route('announcements.show', $announcement) }}" class="block p-3 hover:bg-gray-50 rounded-lg">
                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $announcement->title }}</p>
                    <p class="text-xs text-gray-500 mt-1">
                        Dari {{ $announcement->ormawa->name }} • {{ $announcement->created_at->diffForHumans() }}
                    </p>
                </a>
                @empty
                <p class="text-gray-500 text-center py-4">Belum ada pengumuman masuk</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection