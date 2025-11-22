@extends('layouts.dashboard')

@section('title', 'Tulis Berita')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Tulis Berita Baru</h1>
        <p class="text-gray-600 mt-1">Publikasikan berita dan informasi untuk {{ auth()->user()->ormawa->name }}</p>
    </div>

    <div class="card">
        <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data" x-data="newsForm()">
            @csrf

            {{-- Title --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Berita *</label>
                <input type="text" name="title" value="{{ old('title') }}" required
                    class="w-full px-4 py-3 text-lg border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                    placeholder="Masukkan judul berita yang menarik...">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                {{-- Category --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori *</label>
                    <select name="category" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <option value="kegiatan" {{ old('category') == 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                        <option value="prestasi" {{ old('category') == 'prestasi' ? 'selected' : '' }}>Prestasi</option>
                        <option value="pengumuman" {{ old('category') == 'pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                        <option value="opini" {{ old('category') == 'opini' ? 'selected' : '' }}>Opini</option>
                        <option value="liputan" {{ old('category') == 'liputan' ? 'selected' : '' }}>Liputan</option>
                        <option value="lainnya" {{ old('category') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                {{-- Author --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Penulis</label>
                    <input type="text" name="author" value="{{ old('author', auth()->user()->name) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                        placeholder="Nama penulis">
                </div>
            </div>

            {{-- Excerpt --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Ringkasan (Opsional)</label>
                <textarea name="excerpt" rows="2"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                    placeholder="Ringkasan singkat berita (maks 500 karakter)">{{ old('excerpt') }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Jika dikosongkan, akan diambil dari 200 karakter pertama konten</p>
            </div>

            {{-- Content --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Konten Berita *</label>
                <textarea name="content" rows="15" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent font-mono text-sm"
                    placeholder="Tulis konten berita lengkap di sini...">{{ old('content') }}</textarea>
                @error('content')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Featured Image --}}
            <div x-data="photoUploader()">
    <div class="mb-6">
        <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Utama (Featured Image)</label>

        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-primary-400 transition duration-200">
            <div class="space-y-1 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" 
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>

                <div class="flex text-sm text-gray-600">
                    <label class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500">
                        <span>Upload foto</span>
                        <input type="file" name="featured_image" class="sr-only" accept="image/*" @change="previewFeatured($event)">
                    </label>
                    <p class="pl-1">atau drag and drop</p>
                </div>

                <p class="text-xs text-gray-500">PNG, JPG hingga 5MB</p>
            </div>
        </div>

        <div x-show="featuredPreview" class="mt-3">
            <img :src="featuredPreview" class="w-full h-64 object-cover rounded-lg">
        </div>
    </div>
</div>


            {{-- Multiple Photos --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Tambahan (Galeri)</label>
                <p class="text-xs text-gray-500 mb-3">Upload beberapa foto untuk galeri berita</p>
                
                <div class="space-y-4">
                    <template x-for="(photo, index) in photos" :key="index">
                        <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg">
                            <div class="flex-shrink-0">
                                <img :src="photo.preview" class="w-24 h-24 object-cover rounded-lg">
                            </div>
                            <div class="flex-1">
                                <input type="text" :name="'photo_captions[' + index + ']'" x-model="photo.caption"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                                    placeholder="Keterangan foto (opsional)">
                            </div>
                            <button type="button" @click="removePhoto(index)"
                                class="text-red-600 hover:text-red-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </template>
                </div>

                <div class="mt-3">
                    <label class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                        <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span class="text-sm font-medium text-gray-700">Tambah Foto</span>
                        <input type="file" class="hidden" accept="image/*" multiple @change="addPhotos($event)">
                    </label>
                </div>
            </div>

            {{-- Options --}}
            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                <div class="flex items-center">
                    <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                        class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                    <label for="is_featured" class="ml-2 text-sm text-gray-700">
                        <strong>Jadikan Berita Unggulan</strong>
                        <span class="text-gray-500 block">Berita unggulan akan ditampilkan di bagian atas halaman</span>
                    </label>
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex items-center justify-end space-x-3 pt-6 border-t">
                <a href="{{ route('news.index') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">
                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan sebagai Draft
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function newsForm() {
    return {
        featuredPreview: null,
        photos: [],
        photoFiles: [],
        
        previewFeatured(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.featuredPreview = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },
        
        addPhotos(event) {
            const files = Array.from(event.target.files);
            files.forEach((file, i) => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.photos.push({
                        preview: e.target.result,
                        caption: ''
                    });
                };
                reader.readAsDataURL(file);
            });
            
            // Create hidden input for files
            const dt = new DataTransfer();
            files.forEach(file => dt.items.add(file));
            
            // Append to form
            const input = document.createElement('input');
            input.type = 'file';
            input.name = 'photos[]';
            input.multiple = true;
            input.files = dt.files;
            input.style.display = 'none';
            event.target.form.appendChild(input);
            
            event.target.value = '';
        },
        
        removePhoto(index) {
            this.photos.splice(index, 1);
        }
    }
}
</script>
<script src="//unpkg.com/alpinejs" defer></script>

<script>
function photoUploader() {
    return {
        featuredPreview: null,
        previewFeatured(e) {
            const file = e.target.files[0];
            if (file) {
                this.featuredPreview = URL.createObjectURL(file);
            }
        }
    };
}
</script>
@endsection