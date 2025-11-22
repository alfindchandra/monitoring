@extends('layouts.dashboard')

@section('title', 'Pengumuman Saya')

@section('content')
<div class="space-y-6">
 @if(auth()->user()->isKetuaBem() || auth()->user()->isKetuaUkm())

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Pengumuman Saya</h1>
            <p class="text-gray-600 mt-1">Kelola pengumuman yang Anda buat</p>
        </div>
        <a href="{{ route('announcements.create') }}" class="btn-primary">
            <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Buat Pengumuman
        </a>
    </div>
    @endif

    <div class="card">
        @if($announcements->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Prioritas</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Penerima</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($announcements as $announcement)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <a href="{{ route('announcements.show', $announcement) }}" class="text-sm font-medium text-gray-900 hover:text-primary-600">
                                {{ $announcement->title }}
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($announcement->priority === 'urgent') bg-red-100 text-red-800
                                @elseif($announcement->priority === 'high') bg-orange-100 text-orange-800
                                @elseif($announcement->priority === 'normal') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($announcement->priority) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($announcement->status === 'sent') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $announcement->status === 'sent' ? 'Terkirim' : 'Draft' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $announcement->recipients->count() }} ORMAWA
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $announcement->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-right text-sm">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('announcements.show', $announcement) }}" class="text-primary-600 hover:text-primary-700">
                                    Lihat
                                </a>
                                <form action="{{ route('announcements.destroy', $announcement) }}" method="POST" 
                              onsubmit="return confirm('Hapus kegiatan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-700">
                                Hapus
                            </button>
                        </form>
                                @if($announcement->status === 'draft')
                                <a href="{{ route('announcements.edit', $announcement) }}" class="text-blue-600 hover:text-blue-700">
                                    Edit
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t">
            {{ $announcements->links() }}
        </div>
        @else
        <div class="text-center py-12">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Pengumuman</h3>
            <p class="text-gray-600 mb-4">Mulai buat pengumuman untuk mengirim informasi ke ORMAWA lain</p>
            <a href="{{ route('announcements.create') }}" class="btn-primary inline-flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Buat Pengumuman Pertama
            </a>
        </div>
        @endif
    </div>
</div>
@endsection