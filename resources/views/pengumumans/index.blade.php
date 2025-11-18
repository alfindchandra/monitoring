@extends('layouts.dashboard')
@section('title', 'Pengumuman Saya')
@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-semibold text-gray-900 mb-6">Pengumuman Saya</h1>

        @if ($announcements->count() > 0)
            @foreach ($announcements as $announcement)
                <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-4">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $announcement->title }}</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Dikirim oleh {{ $announcement->ormawa->name }} pada {{ $announcement->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                        <p class="text-gray-700">{{ $announcement->content }}</p>
                    </div>
                </div>
            @endforeach
        @else
            <p class="text-gray-600">Anda belum memiliki pengumuman.</p>
        @endif
    </div>
@endsection