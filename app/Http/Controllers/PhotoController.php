<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
// Gunakan Intervention Image jika terinstall, jika tidak biarkan null
// use Intervention\Image\Facades\Image; 

class PhotoController extends Controller
{
    // ... existing index, album methods ...
    
    public function index()
    {
        // ... code index tetap sama ...
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            $photos = Photo::with(['ormawa', 'user'])->latest()->paginate(24);
            $albums = Photo::distinct('album')->pluck('album')->filter();
        } else {
            $ormawa = $user->ormawa;
            if (!$ormawa) {
                return redirect()->route('dashboard')->with('error', 'Anda tidak terdaftar di ORMAWA manapun.');
            }
            
            $photos = Photo::where('ormawa_id', $ormawa->id)
                ->with('user')
                ->latest()
                ->paginate(24);
            $albums = Photo::where('ormawa_id', $ormawa->id)
                ->distinct('album')
                ->pluck('album')
                ->filter();
        }
        
        return view('photos.index', compact('photos', 'albums'));
    }

    // ... existing album method ...

    public function create()
    {
        $ormawa = auth()->user()->ormawa;
        
        if (!$ormawa && !auth()->user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak terdaftar di ORMAWA manapun.');
        }
        
        $albums = Photo::where('ormawa_id', $ormawa->id)
            ->distinct('album')
            ->pluck('album')
            ->filter();
        
        return view('photos.create', compact('ormawa', 'albums'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'album' => 'nullable|string|max:255',
            'default_title' => 'nullable|string|max:255',
            'default_description' => 'nullable|string',
            
            'photos' => 'required|array|min:1',
            'photos.*' => 'required|image|mimes:jpeg,jpg,png|max:10240', // Max 10MB
            
            // Array input dari preview area
            'titles' => 'nullable|array',
            'titles.*' => 'nullable|string|max:255',
            'descriptions' => 'nullable|array',
            'descriptions.*' => 'nullable|string',
            
            'photographer' => 'nullable|string|max:255',
            'taken_date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
            'is_public' => 'boolean',
        ]);

        $user = auth()->user();
        $ormawa = $user->ormawa;
        
        if (!$ormawa && !$user->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak terdaftar di ORMAWA manapun.');
        }

        $uploadedCount = 0;

        if($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $photo) {
                // Upload original photo
                $photoPath = $photo->store('photos/original', 'public');
                
                // LOGIKA JUDUL:
                // 1. Cek judul spesifik per foto (dari array titles index ke-i)
                // 2. Jika kosong, gunakan Default Title
                // 3. Jika kosong, gunakan Nama File asli
                $specificTitle = isset($validated['titles'][$index]) ? $validated['titles'][$index] : null;
                $finalTitle = $specificTitle 
                              ?: ($validated['default_title'] 
                              ?: pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME));

                // LOGIKA DESKRIPSI:
                $specificDesc = isset($validated['descriptions'][$index]) ? $validated['descriptions'][$index] : null;
                $finalDesc = $specificDesc ?: ($validated['default_description'] ?? null);
                
                Photo::create([
                    'ormawa_id' => $ormawa->id,
                    'user_id' => $user->id,
                    'album' => $validated['album'] ?? 'Tanpa Album',
                    'title' => $finalTitle,
                    'description' => $finalDesc,
                    'path' => $photoPath,
                    'thumbnail_path' => null, // Implementasikan thumbnail jika perlu
                    'photographer' => $validated['photographer'] ?? $user->name,
                    'taken_date' => $validated['taken_date'] ?? now(),
                    'location' => $validated['location'] ?? null,
                    'is_featured' => $request->boolean('is_featured'),
                    'is_public' => $request->boolean('is_public'),
                    'order' => $index,
                ]);
                
                $uploadedCount++;
            }
        }

        return redirect()->route('photos.index')
            ->with('success', "{$uploadedCount} foto berhasil diunggah.");
    }

    // ... sisa method show, edit, update, destroy, publicGallery tetap sama ...
    // (Pastikan method destroy menghapus file dari storage)
    
    public function show(Photo $photo)
    {
         if ($photo->ormawa_id !== auth()->user()->ormawa_id && !auth()->user()->isAdmin()) {
            if (!$photo->is_public) {
                abort(403, 'Unauthorized action.');
            }
        }
        
        $photo->load(['ormawa', 'user']);
        $photo->incrementViews();
        
        $relatedPhotos = Photo::where('id', '!=', $photo->id)
            ->where('album', $photo->album)
            ->where('ormawa_id', $photo->ormawa_id)
            ->where('is_public', true) // Pastikan hanya mengambil public untuk related
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();
        
        return view('photos.show', compact('photo', 'relatedPhotos'));
    }

    public function edit(Photo $photo)
    {
        if ($photo->ormawa_id !== auth()->user()->ormawa_id && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        $albums = Photo::where('ormawa_id', $photo->ormawa_id)
            ->distinct('album')
            ->pluck('album')
            ->filter();
        
        return view('photos.edit', compact('photo', 'albums'));
    }

    public function update(Request $request, Photo $photo)
    {
        if ($photo->ormawa_id !== auth()->user()->ormawa_id && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        $validated = $request->validate([
            'album' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:10240',
            'photographer' => 'nullable|string|max:255',
            'taken_date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
            'is_public' => 'boolean',
        ]);

        if ($request->hasFile('photo')) {
            if ($photo->path) Storage::disk('public')->delete($photo->path);
            $validated['path'] = $request->file('photo')->store('photos/original', 'public');
        }

        $photo->update([
            'album' => $validated['album'] ?? $photo->album,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'path' => $validated['path'] ?? $photo->path,
            'photographer' => $validated['photographer'],
            'taken_date' => $validated['taken_date'],
            'location' => $validated['location'],
            'is_featured' => $request->boolean('is_featured'),
            'is_public' => $request->boolean('is_public'),
        ]);

        return redirect()->route('photos.show', $photo)->with('success', 'Foto berhasil diperbarui.');
    }

    public function destroy(Photo $photo)
    {
        if ($photo->ormawa_id !== auth()->user()->ormawa_id && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        if ($photo->path) Storage::disk('public')->delete($photo->path);
        // if ($photo->thumbnail_path) Storage::disk('public')->delete($photo->thumbnail_path);

        $photo->delete();

        return redirect()->route('photos.index')->with('success', 'Foto berhasil dihapus.');
    }
        public function publicGallery(Request $request)
    {
        $query = Photo::with(['ormawa', 'user'])
            ->public()
            ->ordered();

        // Filter by album
        if ($request->has('album') && $request->album !== 'all') {
            $query->byAlbum($request->album);
        }

        // Filter by ORMAWA
        if ($request->has('ormawa')) {
            $query->where('ormawa_id', $request->ormawa);
        }

        $photos = $query->paginate(24);
        $ormawas = \App\Models\Ormawa::where('is_active', true)->get();
        $albums = Photo::public()->distinct('album')->pluck('album')->filter();
        $featuredPhotos = Photo::public()->featured()->take(6)->get();

        return view('public.gallery.index', compact('photos', 'ormawas', 'albums', 'featuredPhotos'));
    }

}