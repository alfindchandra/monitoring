@extends('layouts.dashboard')

@section('title', 'Buat Pengumuman')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Buat Pengumuman Baru</h1>
        <p class="text-gray-600 mt-1">Kirim informasi atau surat ke ORMAWA lain</p>
    </div>

    <div class="card">
        <form action="{{ route('announcements.store') }}" method="POST" enctype="multipart/form-data" x-data="ormawaSelector">
            @csrf

            {{-- Title --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Pengumuman <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                    placeholder="Contoh: Undangan Rapat Koordinasi ORMAWA">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Content --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Isi Pengumuman <span class="text-red-500">*</span></label>
                <textarea name="content" rows="8" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                    placeholder="Tulis isi pengumuman di sini...">{{ old('content') }}</textarea>
                @error('content')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Priority --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Prioritas <span class="text-red-500">*</span></label>
                <select name="priority" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Rendah</option>
                    <option value="normal" {{ old('priority') == 'normal' ? 'selected' : '' }} selected>Normal</option>
                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Tinggi</option>
                    <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Mendesak</option>
                </select>
                @error('priority')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Attachment --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Lampiran Surat <span class="text-red-500">*</span></label>
                <input type="file" name="attachment" accept=".pdf,.doc,.docx" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                <p class="text-xs text-gray-500 mt-1">Format: PDF, DOC, DOCX Maksimal 5MB</p>
                @error('attachment')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Recipients --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Penerima <span class="text-red-500">*</span></label>
                
                <div class="flex items-center mb-3">
                    <input type="checkbox" id="select_all"
                        x-model="selectAll"
                        @change="toggleAll()"
                        class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                    <label for="select_all" class="ml-2 text-sm font-semibold text-gray-700">Pilih Semua ORMAWA</label>
                </div>

                <div class="border border-gray-200 rounded-lg p-4 max-h-64 overflow-y-auto space-y-2">
                    @foreach($ormawas as $ormawa)
                        @if($ormawa->id != auth()->user()->ormawa_id)
                        <div class="flex items-center p-2 hover:bg-gray-50 rounded">
                            <input type="checkbox" name="recipients[]" value="{{ $ormawa->id }}" 
                                id="ormawa_{{ $ormawa->id }}" x-model="selectedOrmawas"
                                class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                            <label for="ormawa_{{ $ormawa->id }}" class="ml-3 text-sm text-gray-700 flex-1">
                                <span class="font-medium">{{ $ormawa->name }}</span>
                                <span class="text-gray-500 text-xs ml-2">({{ $ormawa->type == 'bem' ? 'BEM' : 'UKM' }})</span>
                            </label>
                        </div>
                        @endif
                    @endforeach
                </div>
                
                <p class="text-sm text-gray-600 mt-2">
                    <span x-text="selectedOrmawas.length"></span> ORMAWA dipilih
                </p>
                
                @error('recipients')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Public Option --}}
            <div class="mb-6">
                <div class="flex items-center">
                    <input type="checkbox" name="is_public" id="is_public" value="1" {{ old('is_public') ? 'checked' : '' }}
                        class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                    <label for="is_public" class="ml-2 text-sm text-gray-700">
                        Tampilkan di halaman publik
                        <span class="text-gray-500">(Pengumuman dapat dilihat oleh pengunjung website)</span>
                    </label>
                </div>
            </div>

            {{-- Buttons --}}
            <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                <a href="{{ route('announcements.index') }}" class="btn-secondary">
                    Batal
                </a>
                <button type="submit" class="btn-primary">
                    Simpan sebagai Draft
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('ormawaSelector', () => ({
            selectAll: false,
            selectedOrmawas: [],

            // Masukkan semua id ormawa di sini
            allOrmawas: @json($ormawas->where('id', '!=', auth()->user()->ormawa_id)->pluck('id')),

            toggleAll() {
                if (this.selectAll) {
                    // Jika checkbox "Pilih Semua" dicentang, pilih semua ORMAWA
                    this.selectedOrmawas = [...this.allOrmawas];
                } else {
                    // Jika checkbox "Pilih Semua" tidak dicentang, kosongkan pilihan
                    this.selectedOrmawas = [];
                }
            }
        }))
    })
</script>

@endsection