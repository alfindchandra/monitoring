@extends('layouts.dashboard')

@section('title', 'Edit Berita')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Edit Berita</h1>
        <p class="text-gray-600 mt-1">Perbarui informasi berita</p>
    </div>

    <div class="card">
        <form action="{{ route('news.update', $news) }}" method="POST" enctype="multipart/form-data" x-data="newsEditForm()">
            @csrf
            @method('PATCH')

            {{-- Title --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Berita *</label>
                <input type="text" name="title" value="{{ old('title', $news->title) }}" required
                    class="w-full px-4 py-3 text-lg border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
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
                        <option value="kegiatan" {{ old('category', $news->category) == 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                        <option value="prestasi" {{ old('category', $news->category) == 'prestasi' ? 'selected' : '' }}>Prestasi</option>
                        <option value="pengumuman" {{ old('category', $news->category) == 'pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                        <option value="opini" {{ old('category', $news->category) == 'opini' ? 'selected' : '' }}>Opini</option>
                        <option value="liputan" {{ old('category', $news->category) == 'liputan' ? 'selected' : '' }}>Liputan</option>
                        <option value="lainnya" {{ old('category', $news->category) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                {{-- Author --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Penulis</label>
                    <input type="text" name="author" value="{{ old('author', $news->author) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>
            </div>

            {{-- Excerpt --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Ringkasan</label>
                <textarea name="excerpt" rows="2"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">{{ old('excerpt', $news->excerpt) }}</textarea>
            </div>

            {{-- Content --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Konten Berita *</label>
                <textarea name="content" rows="15" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent font-mono text-sm">{{ old('content', $news->content) }}</textarea>
            </div>

            {{-- Featured Image --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Utama (Featured Image)</label>
                
                @if($news->featured_image)
                <div class="mb-3">
                    <img src="{{ Storage::url($news->featured_image) }}" alt="{{ $news->title }}" class="w-full h-64 object-cover rounded-lg">
                    <p class="text-xs text-gray-500 mt-1">Foto saat ini</p>
                </div>
                @endif
                
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500">
                                <span>Upload foto baru</span>
                                <input type="file" name="featured_image" class="sr-only" accept="image/*">
                            </label>
                        </div>
                        <p class="text-xs text-gray-500">Biarkan kosong jika tidak ingin mengubah</p>
                    </div>
                </div>
            </div>

            {{-- Existing Photos --}}
            @if($news->photos->count() > 0)
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Galeri Saat Ini</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($news->photos as $photo)
                    <div class="relative group">
                        <img src="{{ Storage::url($photo->path) }}" alt="{{ $photo->caption }}" class="w-full h-32 object-cover rounded-lg">
                        <div class="absolute top-2 right-2">
                            <label class="flex items-center bg-white rounded px-2 py-1 shadow-lg cursor-pointer">
                                <input type="checkbox" name="delete_photos[]" value="{{ $photo->id }}" class="mr-1">
                                <span class="text-xs font-semibold text-red-600">Hapus</span>
                            </label>
                        </div>
                        @if($photo->caption)
                        <p class="text-xs text-gray-600 mt-1">{{ $photo->caption }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- New Photos --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tambah Foto Baru</label>
                
                <div class="space-y-4" x-show="photos.length > 0">
                    <template x-for="(photo, index) in photos" :key="index">
                        <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg">
                            <div class="flex-shrink-0">
                                <img :src="photo.preview" class="w-24 h-24 object-cover rounded-lg">
                            </div>
                            <div class="flex-1">
                                <input type="text" :name="'photo_captions[' + index + ']'" x-model="photo.caption"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                                    placeholder="Keterangan foto">
                            </div>
                            <button type="button" @click="removePhoto(index)" class="text-red-600 hover:text-red-700">
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
                    <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $news->is_featured) ? 'checked' : '' }}
                        class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                    <label for="is_featured" class="ml-2 text-sm text-gray-700">
                        <strong>Jadikan Berita Unggulan</strong>
                    </label>
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex items-center justify-end space-x-3 pt-6 border-t">
                <a href="{{ route('news.show', $news) }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">
                    Perbarui Berita
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function newsEditForm() {
    return {
        photos: [],
        
        addPhotos(event) {
            const files = Array.from(event.target.files);
            files.forEach(file => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.photos.push({
                        preview: e.target.result,
                        caption: ''
                    });
                };
                reader.readAsDataURL(file);
            });
            
            const dt = new DataTransfer();
            files.forEach(file => dt.items.add(file));
            
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
@endsection
