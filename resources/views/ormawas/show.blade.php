{{-- resources/views/ormawas/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('ormawas.index') }}" class="text-blue-600 hover:text-blue-700">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
        
        <div class="flex gap-2">
            <a href="{{ route('ormawas.edit', $ormawa) }}" 
               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <form action="{{ route('ormawas.toggle-status', $ormawa) }}" method="POST" class="inline">
                @csrf
                <button type="submit" 
                        class="px-4 py-2 rounded-lg transition {{ $ormawa->is_active ? 'bg-orange-600 text-white hover:bg-orange-700' : 'bg-green-600 text-white hover:bg-green-700' }}">
                    <i class="fas fa-{{ $ormawa->is_active ? 'pause' : 'play' }} mr-2"></i>
                    {{ $ormawa->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                </button>
            </form>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Profile Card -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-8 text-white">
                    <div class="flex items-start gap-6">
                        @if($ormawa->logo)
                        <img src="{{ asset('storage/' . $ormawa->logo) }}" 
                             alt="{{ $ormawa->name }}"
                             class="w-24 h-24 bg-white rounded-lg object-contain p-2 flex-shrink-0">
                        @else
                        <div class="w-24 h-24 bg-white bg-opacity-20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-university text-5xl"></i>
                        </div>
                        @endif
                        
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="inline-block px-3 py-1 bg-white bg-opacity-20 rounded-full text-sm font-medium">
                                    {{ $ormawa->type == 'bem' ? 'BEM' : 'UKM' }}
                                </span>
                                @if($ormawa->is_active)
                                <span class="inline-block px-3 py-1 bg-green-500 rounded-full text-sm font-medium">
                                    <i class="fas fa-check-circle mr-1"></i>Aktif
                                </span>
                                @else
                                <span class="inline-block px-3 py-1 bg-red-500 rounded-full text-sm font-medium">
                                    <i class="fas fa-times-circle mr-1"></i>Nonaktif
                                </span>
                                @endif
                            </div>
                            <h1 class="text-3xl font-bold mb-2">{{ $ormawa->name }}</h1>
                            @if($ormawa->established_year)
                            <p class="text-blue-100">
                                <i class="fas fa-calendar-alt mr-2"></i>Berdiri sejak {{ $ormawa->established_year }}
                            </p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Content Tabs -->
                <div class="border-b">
                    <nav class="flex -mb-px">
                        <button onclick="showTab('about')" 
                                class="tab-button active px-6 py-3 border-b-2 border-blue-600 text-blue-600 font-medium"
                                data-tab="about">
                            Tentang
                        </button>
                        <button onclick="showTab('vision')" 
                                class="tab-button px-6 py-3 border-b-2 border-transparent text-gray-500 hover:text-gray-700"
                                data-tab="vision">
                            Visi & Misi
                        </button>
                        <button onclick="showTab('contact')" 
                                class="tab-button px-6 py-3 border-b-2 border-transparent text-gray-500 hover:text-gray-700"
                                data-tab="contact">
                            Kontak
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div class="p-6">
                    <!-- About Tab -->
                    <div id="about-content" class="tab-content">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Deskripsi</h3>
                        @if($ormawa->description)
                        <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $ormawa->description }}</p>
                        @else
                        <p class="text-gray-400 italic">Belum ada deskripsi</p>
                        @endif
                    </div>

                    <!-- Vision Tab -->
                    <div id="vision-content" class="tab-content hidden">
                        @if($ormawa->vision || $ormawa->mission)
                        <div class="space-y-6">
                            @if($ormawa->vision)
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 mb-3">Visi</h3>
                                <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $ormawa->vision }}</p>
                            </div>
                            @endif
                            
                            @if($ormawa->mission)
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 mb-3">Misi</h3>
                                <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $ormawa->mission }}</p>
                            </div>
                            @endif
                        </div>
                        @else
                        <p class="text-gray-400 italic">Belum ada visi dan misi</p>
                        @endif
                    </div>

                    <!-- Contact Tab -->
                    <div id="contact-content" class="tab-content hidden">
                        <div class="space-y-4">
                            @if($ormawa->email)
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-envelope text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Email</p>
                                    <a href="mailto:{{ $ormawa->email }}" class="text-gray-800 hover:text-blue-600">
                                        {{ $ormawa->email }}
                                    </a>
                                </div>
                            </div>
                            @endif

                            @if($ormawa->phone)
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-phone text-green-600"></i>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Telepon</p>
                                    <a href="tel:{{ $ormawa->phone }}" class="text-gray-800 hover:text-blue-600">
                                        {{ $ormawa->phone }}
                                    </a>
                                </div>
                            </div>
                            @endif

                            @if($ormawa->address)
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-map-marker-alt text-red-600"></i>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Alamat</p>
                                    <p class="text-gray-800">{{ $ormawa->address }}</p>
                                </div>
                            </div>
                            @endif

                            <!-- Social Media -->
                            @if($ormawa->instagram || $ormawa->facebook || $ormawa->youtube)
                            <div class="pt-4 border-t">
                                <p class="text-gray-500 text-sm mb-3">Media Sosial</p>
                                <div class="flex gap-3">
                                    @if($ormawa->instagram)
                                    <a href="{{ $ormawa->instagram }}" target="_blank"
                                       class="w-12 h-12 bg-pink-100 text-pink-600 rounded-lg flex items-center justify-center hover:bg-pink-200 transition">
                                        <i class="fab fa-instagram text-xl"></i>
                                    </a>
                                    @endif
                                    @if($ormawa->facebook)
                                    <a href="{{ $ormawa->facebook }}" target="_blank"
                                       class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-200 transition">
                                        <i class="fab fa-facebook-f text-xl"></i>
                                    </a>
                                    @endif
                                    @if($ormawa->youtube)
                                    <a href="{{ $ormawa->youtube }}" target="_blank"
                                       class="w-12 h-12 bg-red-100 text-red-600 rounded-lg flex items-center justify-center hover:bg-red-200 transition">
                                        <i class="fab fa-youtube text-xl"></i>
                                    </a>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Statistics -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Statistik</h3>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-users text-blue-600"></i>
                            </div>
                            <span class="text-gray-600">Pengguna</span>
                        </div>
                        <span class="text-2xl font-bold text-gray-800">{{ $stats['total_users'] }}</span>
                    </div>

                    <div class="flex items-center justify-between pb-3 border-b">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-calendar-check text-green-600"></i>
                            </div>
                            <span class="text-gray-600">Kegiatan</span>
                        </div>
                        <span class="text-2xl font-bold text-gray-800">{{ $stats['total_activities'] }}</span>
                    </div>

                    <div class="flex items-center justify-between pb-3 border-b">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-bullhorn text-purple-600"></i>
                            </div>
                            <span class="text-gray-600">Pengumuman</span>
                        </div>
                        <span class="text-2xl font-bold text-gray-800">{{ $stats['total_announcements'] }}</span>
                    </div>

                    <div class="flex items-center justify-between pb-3 border-b">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-sitemap text-orange-600"></i>
                            </div>
                            <span class="text-gray-600">Divisi</span>
                        </div>
                        <span class="text-2xl font-bold text-gray-800">{{ $stats['total_divisions'] }}</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-user-friends text-red-600"></i>
                            </div>
                            <span class="text-gray-600">Anggota</span>
                        </div>
                        <span class="text-2xl font-bold text-gray-800">{{ $stats['total_members'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Aksi Cepat</h3>
                
                <div class="space-y-2">
                    <a href="{{ route('ormawa.detail', $ormawa->slug) }}" 
                       class="block w-full bg-blue-50 text-blue-600 text-center px-4 py-2 rounded-lg hover:bg-blue-100 transition">
                        <i class="fas fa-eye mr-2"></i>Lihat Halaman Publik
                    </a>
                    <a href="{{ route('ormawas.edit', $ormawa) }}" 
                       class="block w-full bg-green-50 text-green-600 text-center px-4 py-2 rounded-lg hover:bg-green-100 transition">
                        <i class="fas fa-edit mr-2"></i>Edit Data
                    </a>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                <h3 class="text-lg font-bold text-red-800 mb-2">Zona Berbahaya</h3>
                <p class="text-red-600 text-sm mb-4">Tindakan di bawah ini tidak dapat dibatalkan</p>
                
                <form action="{{ route('ormawas.destroy', $ormawa) }}" 
                      method="POST" 
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus ORMAWA ini?\n\nSemua data terkait akan ikut terhapus!')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                        <i class="fas fa-trash mr-2"></i>Hapus ORMAWA
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function showTab(tabName) {
    // Hide all contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active from all buttons
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active', 'border-blue-600', 'text-blue-600');
        button.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected content
    document.getElementById(tabName + '-content').classList.remove('hidden');
    
    // Activate button
    const activeButton = document.querySelector(`[data-tab="${tabName}"]`);
    activeButton.classList.add('active', 'border-blue-600', 'text-blue-600');
    activeButton.classList.remove('border-transparent', 'text-gray-500');
}
</script>
@endpush
@endsection