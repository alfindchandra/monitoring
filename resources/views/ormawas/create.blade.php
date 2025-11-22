@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="mb-6">
        <a href="{{ route('ormawas.index') }}" class="text-blue-600 hover:text-blue-700">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah ORMAWA Baru</h1>

        <form action="{{ route('ormawas.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Basic Information -->
            <div class="mb-8">
                <h2 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b">Informasi Dasar</h2>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 font-medium mb-2">
                            Nama ORMAWA *
                        </label>
                        <input type="text" 
                               name="name" 
                               value="{{ old('name') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                               placeholder="Contoh: BEM IKIP PGRI Bojonegoro"
                               required>
                        @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Type -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Tipe Organisasi *
                        </label>
                        <select name="type" 
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 @error('type') border-red-500 @enderror"
                                required>
                            <option value="">-- Pilih Tipe --</option>
                            <option value="bem" {{ old('type') == 'bem' ? 'selected' : '' }}>BEM (Badan Eksekutif Mahasiswa)</option>
                            <option value="ukm" {{ old('type') == 'ukm' ? 'selected' : '' }}>UKM (Unit Kegiatan Mahasiswa)</option>
                        </select>
                        @error('type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Established Year -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Tahun Berdiri
                        </label>
                        <input type="number" 
                               name="established_year" 
                               value="{{ old('established_year') }}"
                               min="1900" 
                               max="{{ date('Y') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 @error('established_year') border-red-500 @enderror"
                               placeholder="{{ date('Y') }}">
                        @error('established_year')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Logo -->
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 font-medium mb-2">
                            Logo ORMAWA
                        </label>
                        <input type="file" 
                               name="logo" 
                               id="logo"
                               accept="image/jpeg,image/jpg,image/png"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 @error('logo') border-red-500 @enderror">
                        <p class="text-gray-500 text-sm mt-1">Format: JPG, JPEG, PNG (Max: 2MB)</p>
                        @error('logo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        
                        <!-- Logo Preview -->
                        <div id="logoPreview" class="mt-4 hidden">
                            <p class="text-gray-700 font-medium mb-2">Preview Logo:</p>
                            <img id="previewImage" class="w-32 h-32 object-contain border rounded-lg">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="mb-8">
                <h2 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b">Deskripsi</h2>
                
                <div class="space-y-6">
                    <!-- Description -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Deskripsi Singkat
                        </label>
                        <textarea name="description" 
                                  rows="4"
                                  class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror"
                                  placeholder="Jelaskan tentang organisasi ini...">{{ old('description') }}</textarea>
                        @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Vision -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Visi
                        </label>
                        <textarea name="vision" 
                                  rows="3"
                                  class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 @error('vision') border-red-500 @enderror"
                                  placeholder="Visi organisasi...">{{ old('vision') }}</textarea>
                        @error('vision')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Mission -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Misi
                        </label>
                        <textarea name="mission" 
                                  rows="4"
                                  class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 @error('mission') border-red-500 @enderror"
                                  placeholder="1. Misi pertama&#10;2. Misi kedua&#10;3. dst...">{{ old('mission') }}</textarea>
                        @error('mission')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="mb-8">
                <h2 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b">Kontak & Informasi</h2>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Email -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Email
                        </label>
                        <input type="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                               placeholder="email@example.com">
                        @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            Nomor Telepon
                        </label>
                        <input type="text" 
                               name="phone" 
                               value="{{ old('phone') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 @error('phone') border-red-500 @enderror"
                               placeholder="08123456789">
                        @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 font-medium mb-2">
                            Alamat
                        </label>
                        <textarea name="address" 
                                  rows="2"
                                  class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 @error('address') border-red-500 @enderror"
                                  placeholder="Alamat lengkap organisasi...">{{ old('address') }}</textarea>
                        @error('address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Social Media -->
            <div class="mb-8">
                <h2 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b">Media Sosial</h2>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Instagram -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            <i class="fab fa-instagram text-pink-600 mr-2"></i>Instagram
                        </label>
                        <input type="text" 
                               name="instagram" 
                               value="{{ old('instagram') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 @error('instagram') border-red-500 @enderror"
                               placeholder="@username atau https://instagram.com/username">
                        @error('instagram')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Facebook -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">
                            <i class="fab fa-facebook text-blue-600 mr-2"></i>Facebook
                        </label>
                        <input type="text" 
                               name="facebook" 
                               value="{{ old('facebook') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 @error('facebook') border-red-500 @enderror"
                               placeholder="https://facebook.com/username">
                        @error('facebook')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- YouTube -->
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 font-medium mb-2">
                            <i class="fab fa-youtube text-red-600 mr-2"></i>YouTube
                        </label>
                        <input type="text" 
                               name="youtube" 
                               value="{{ old('youtube') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 @error('youtube') border-red-500 @enderror"
                               placeholder="https://youtube.com/c/channelname">
                        @error('youtube')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-3 pt-6 border-t">
                <a href="{{ route('ormawas.index') }}" 
                   class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit" 
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-save mr-2"></i>Simpan ORMAWA
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Logo preview
const logoInput = document.getElementById('logo');
const previewContainer = document.getElementById('logoPreview');
const previewImage = document.getElementById('previewImage');

logoInput.addEventListener('change', function(e) {
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