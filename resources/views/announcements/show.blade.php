@extends('layouts.dashboard')

@section('title', 'Detail Pengumuman')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <a href="{{ url()->previous() }}" class="text-primary-600 hover:text-primary-700 inline-flex items-center mb-4">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
        <div class="flex items-start justify-between">
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-gray-900">{{ $announcement->title }}</h1>
                <div class="flex items-center space-x-4 mt-2 text-sm text-gray-600">
                    <span>Dari: <strong>{{ $announcement->ormawa->name }}</strong></span>
                    <span>•</span>
                    <span>{{ $announcement->created_at->format('d M Y, H:i') }}</span>
                </div>
            </div>
            <div class="flex space-x-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    @if($announcement->priority === 'urgent') bg-red-100 text-red-800
                    @elseif($announcement->priority === 'high') bg-orange-100 text-orange-800
                    @elseif($announcement->priority === 'normal') bg-blue-100 text-blue-800
                    @else bg-gray-100 text-gray-800 @endif">
                    {{ ucfirst($announcement->priority) }}
                </span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    @if($announcement->status === 'sent') bg-green-100 text-green-800
                    @else bg-gray-100 text-gray-800 @endif">
                    {{ $announcement->status === 'sent' ? 'Terkirim' : 'Draft' }}
                </span>
            </div>
        </div>
    </div>

    <div class="card mb-6">
        <div class="prose max-w-none">
            {!! nl2br(e($announcement->content)) !!}
        </div>

        @if($announcement->attachment)
        <div class="mt-6 pt-6 border-t">
            <p class="text-sm font-semibold text-gray-700 mb-2">Lampiran:</p>
            <a href="{{ Storage::url($announcement->attachment) }}" target="_blank" 
               class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm">
                <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Download Lampiran
            </a>
        </div>
        @endif
    </div>

    <div class="card mb-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Penerima ({{ $announcement->recipients->count() }})</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            @foreach($announcement->recipients as $recipient)
            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-semibold">
                    {{ substr($recipient->name, 0, 2) }}
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium text-gray-900">{{ $recipient->name }}</p>
                    <p class="text-xs text-gray-500">{{ $recipient->type == 'bem' ? 'BEM' : 'UKM' }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    @if($announcement->ormawa_id === auth()->user()->ormawa_id)
    <div class="flex items-center justify-end space-x-3">
        @if($announcement->status === 'draft')
        <a href="{{ route('announcements.edit', $announcement) }}" class="btn-secondary">
            Edit Pengumuman
        </a>
        <form action="{{ route('announcements.send', $announcement) }}" method="POST" 
              onsubmit="return confirm('Kirim pengumuman ini ke semua penerima?')">
            @csrf
            <button type="submit" class="btn-primary">
                Kirim Sekarang
            </button>
        </form>
        @endif
        
        @if($announcement->status === 'draft')
        <form action="{{ route('announcements.destroy', $announcement) }}" method="POST" 
              onsubmit="return confirm('Hapus pengumuman ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold">
                Hapus
            </button>
        </form>
        @endif
    </div>
    @endif
</div>
@endsection