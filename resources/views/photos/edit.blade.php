@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="mb-6">
        <a href="{{ route('photos.show', $photo) }}" class="text-blue-600 hover:text-blue-700">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Foto</h1>

        <form action="{{ route('photos.update', $photo) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Current Photo Preview -->
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Foto Saat Ini</label>
                <div class="relative w-full max-w-md">
                    <img src="{{ $photo->image_url }}" 
                         alt="{{ $photo->title }}"
                         class="w-full rounded-lg shadow-md"
                         id="currentPhoto">
                </div>
            </div>

            <!-- Replace Photo (Optional) -->
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Ganti Foto (Opsional)</label>
                <input type="file" 
                       name="photo" 
                       id="photo"
                       accept="image/jpeg,image/jpg,image/png"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                <p class="text-gray-500 text-sm mt-1">Format: JPG, JPEG, PNG (Max: 10MB)</p>
                @error('photo')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                
                <!-- New Photo Preview -->
                <div id="newPhotoPreview" class="mt-4 hidden">
                    <p class="text-gray-700 font-medium mb-2">Preview Foto Baru:</p>
                    <img id="previewImage" class="w-full max-w-md rounded-lg shadow-md">
                </div>
            </div>

            <!-- Album -->
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Album</label>
                <div class="flex gap-3">
                    <input type="text" 
                           name="album" 
                           id="album_input"
                           class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500"
                           value="{{ old('album', $photo->album) }}">
                    
                    @if($albums->count() > 0)
                    <select id="album_select" 
                            class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih Album --</option>
                        @foreach($albums as $album)
                        <option value="{{ $album }}" {{ $photo->album == $album ? 'selected' : '' }}>
                            {{ $album }}
                        </option>
                        @endforeach
                    </select>
                    @endif
                </div>
                @error('album')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Title -->
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Judul Foto *</label>
                <input type="text" 
                       name="title" 
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500"
                       value="{{ old('title', $photo->title) }}"
                       required>
                @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Deskripsi</label>
                <textarea name="description" 
                          rows="4"
                          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">{{ old('description', $photo->description) }}</textarea>
                @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Metadata -->
            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Fotografer</label>
                    <input type="text" 
                           name="photographer" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500"
                           value="{{ old('photographer', $photo->photographer) }}">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Tanggal Pengambilan</label>
                    <input type="date" 
                           name="taken_date" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500"
                           value="{{ old('taken_date', $photo->taken_date?->format('Y-m-d')) }}">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-medium mb-2">Lokasi</label>
                    <input type="text" 
                           name="location" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500"
                           value="{{ old('location', $photo->location) }}">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Urutan Tampilan</label>
                    <input type="number" 
                           name="order" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500"
                           value="{{ old('order', $photo->order) }}">
                    <p class="text-gray-500 text-sm mt-1">Semakin kecil angka, semakin depan posisinya</p>
                </div>
            </div>

            <!-- Settings -->
            <div class="mb-6 space-y-3">
                <label class="flex items-center">
                    <input type="checkbox" 
                           name="is_featured" 
                           value="1" 
                           {{ $photo->is_featured ? 'checked' : '' }}
                           class="mr-2">
                    <span class="text-gray-700">Tandai sebagai foto unggulan</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" 
                           name="is_public" 
                           value="1" 
                           {{ $photo->is_public ? 'checked' : '' }}
                           class="mr-2">
                    <span class="text-gray-700">Tampilkan di galeri publik</span>
                </label>
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('photos.show', $photo) }}" 
                   class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" 
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Album selector helper
const albumSelect = document.getElementById('album_select');
const albumInput = document.getElementById('album_input');

if (albumSelect) {
    albumSelect.addEventListener('change', function() {
        albumInput.value = this.value;
    });
}

// Photo preview
const photoInput = document.getElementById('photo');
const previewContainer = document.getElementById('newPhotoPreview');
const previewImage = document.getElementById('previewImage');

photoInput.addEventListener('change', function(e) {
    const file = e.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            previewContainer.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    } else {
        previewContainer.classList.add('hidden');
    }
});
</script>
@endpush
@endsection