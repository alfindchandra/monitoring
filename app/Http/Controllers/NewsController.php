<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    // Dashboard - List berita ORMAWA
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            $news = News::with(['ormawa', 'user'])->latest()->paginate(10);
        } else {
            $ormawa = $user->ormawa;
            if (!$ormawa) {
                return redirect()->route('dashboard')->with('error', 'Anda tidak terdaftar di ORMAWA manapun.');
            }
            $news = News::where('ormawa_id', $ormawa->id)
                ->with('user')
                ->latest()
                ->paginate(10);
        }
        
        return view('news.index', compact('news'));
    }

    // Form create
    public function create()
    {
        $ormawa = auth()->user()->ormawa;
        
        if (!$ormawa && !auth()->user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak terdaftar di ORMAWA manapun.');
        }
        
        return view('news.create', compact('ormawa'));
    }

    // Store berita
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            'author' => 'nullable|string|max:255',
            'category' => 'required|in:prestasi,kegiatan,pengumuman,opini,liputan,lainnya',
            'is_featured' => 'boolean',
            'photos.*' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            'photo_captions.*' => 'nullable|string|max:255',
        ]);

        $user = auth()->user();
        $ormawa = $user->ormawa;
        
        if (!$ormawa && !$user->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak terdaftar di ORMAWA manapun.');
        }

        // Upload featured image
        $featuredImagePath = null;
        if ($request->hasFile('featured_image')) {
            $featuredImagePath = $request->file('featured_image')->store('news/featured', 'public');
        }

        // Create news
        $news = News::create([
            'ormawa_id' => $ormawa->id,
            'user_id' => $user->id,
            'title' => $validated['title'],
            'excerpt' => $validated['excerpt'] ?? Str::limit(strip_tags($validated['content']), 200),
            'content' => $validated['content'],
            'featured_image' => $featuredImagePath,
            'author' => $validated['author'] ?? $user->name,
            'category' => $validated['category'],
            'is_featured' => $request->boolean('is_featured'),
            'status' => 'draft',
        ]);

        // Upload additional photos
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $photo) {
                $photoPath = $photo->store('news/photos', 'public');
                
                NewsPhoto::create([
                    'news_id' => $news->id,
                    'path' => $photoPath,
                    'caption' => $request->photo_captions[$index] ?? null,
                    'order' => $index,
                ]);
            }
        }

        return redirect()->route('news.show', $news)
            ->with('success', 'Berita berhasil dibuat sebagai draft.');
    }

    // Show detail berita
    public function show(News $news)
    {
        // Check authorization
        if ($news->ormawa_id !== auth()->user()->ormawa_id && !auth()->user()->isAdmin()) {
            // Allow if published for public view
            if ($news->status !== 'published') {
                abort(403, 'Unauthorized action.');
            }
        }
        
        $news->load(['ormawa', 'user', 'photos']);
        
        return view('news.show', compact('news'));
    }

    // Form edit
    public function edit(News $news)
    {
        // Check authorization
        if ($news->ormawa_id !== auth()->user()->ormawa_id && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        $news->load('photos');
        
        return view('news.edit', compact('news'));
    }

    // Update berita
    public function update(Request $request, News $news)
    {
        // Check authorization
        if ($news->ormawa_id !== auth()->user()->ormawa_id && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            'author' => 'nullable|string|max:255',
            'category' => 'required|in:prestasi,kegiatan,pengumuman,opini,liputan,lainnya',
            'is_featured' => 'boolean',
            'photos.*' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            'photo_captions.*' => 'nullable|string|max:255',
            'delete_photos' => 'nullable|array',
        ]);

        // Update featured image
        if ($request->hasFile('featured_image')) {
            if ($news->featured_image) {
                Storage::disk('public')->delete($news->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('news/featured', 'public');
        }

        // Update news
        $news->update([
            'title' => $validated['title'],
            'excerpt' => $validated['excerpt'] ?? Str::limit(strip_tags($validated['content']), 200),
            'content' => $validated['content'],
            'featured_image' => $validated['featured_image'] ?? $news->featured_image,
            'author' => $validated['author'] ?? $news->author,
            'category' => $validated['category'],
            'is_featured' => $request->boolean('is_featured'),
        ]);

        // Delete selected photos
        if ($request->has('delete_photos')) {
            foreach ($request->delete_photos as $photoId) {
                $photo = NewsPhoto::find($photoId);
                if ($photo && $photo->news_id === $news->id) {
                    Storage::disk('public')->delete($photo->path);
                    $photo->delete();
                }
            }
        }

        // Upload new photos
        if ($request->hasFile('photos')) {
            $maxOrder = $news->photos()->max('order') ?? 0;
            
            foreach ($request->file('photos') as $index => $photo) {
                $photoPath = $photo->store('news/photos', 'public');
                
                NewsPhoto::create([
                    'news_id' => $news->id,
                    'path' => $photoPath,
                    'caption' => $request->photo_captions[$index] ?? null,
                    'order' => $maxOrder + $index + 1,
                ]);
            }
        }

        return redirect()->route('news.show', $news)
            ->with('success', 'Berita berhasil diperbarui.');
    }

    // Delete berita
    public function destroy(News $news)
    {
        // Check authorization
        if ($news->ormawa_id !== auth()->user()->ormawa_id && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete featured image
        if ($news->featured_image) {
            Storage::disk('public')->delete($news->featured_image);
        }

        // Delete all photos
        foreach ($news->photos as $photo) {
            Storage::disk('public')->delete($photo->path);
            $photo->delete();
        }

        $news->delete();

        return redirect()->route('news.index')
            ->with('success', 'Berita berhasil dihapus.');
    }

    // Publish berita
    public function publish(News $news)
    {
        // Check authorization
        if ($news->ormawa_id !== auth()->user()->ormawa_id && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $news->publish();

        return redirect()->route('news.show', $news)
            ->with('success', 'Berita berhasil dipublikasikan.');
    }

    // Public - List all published news
    public function publicIndex(Request $request)
    {
        $query = News::with(['ormawa', 'user'])
            ->published()
            ->latest('published_at');

        // Filter by category
        if ($request->has('category') && $request->category !== 'all') {
            $query->byCategory($request->category);
        }

        // Filter by ORMAWA
        if ($request->has('ormawa')) {
            $query->where('ormawa_id', $request->ormawa);
        }

        $news = $query->paginate(12);
        $ormawas = \App\Models\Ormawa::where('is_active', true)->get();
        $featuredNews = News::published()->featured()->latest('published_at')->take(3)->get();

        return view('public.news.index', compact('news', 'ormawas', 'featuredNews'));
    }

    // Public - Show detail
    public function publicShow($slug)
    {
        $news = News::where('slug', $slug)
            ->published()
            ->with(['ormawa', 'user', 'photos'])
            ->firstOrFail();

        // Increment views
        $news->incrementViews();

        // Related news
        $relatedNews = News::where('id', '!=', $news->id)
            ->where('ormawa_id', $news->ormawa_id)
            ->published()
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('public.news.show', compact('news', 'relatedNews'));
    }
}