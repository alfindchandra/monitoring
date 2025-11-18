<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        $activities = Activity::with('ormawa')
            ->where('ormawa_id', $user->ormawa_id)
            ->latest()
            ->paginate(10);
        
        return view('activities.index', compact('activities'));
    }

    public function create()
    {
        return view('activities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'event_time' => 'nullable|date_format:H:i',
            'location' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'is_public' => 'boolean',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('activities', 'public');
        }

        Activity::create([
            'ormawa_id' => $request->user()->ormawa_id,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'event_date' => $validated['event_date'],
            'event_time' => $validated['event_time'] ?? null,
            'location' => $validated['location'] ?? null,
            'image' => $imagePath,
            'is_public' => $request->boolean('is_public'),
        ]);

        return redirect()->route('activities.index')
            ->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function show(Activity $activity)
    {
        return view('activities.show', compact('activity'));
    }

    public function edit(Activity $activity)
    {
        if ($activity->ormawa_id !== auth()->user()->ormawa_id && !auth()->user()->isAdmin()) {
            abort(403);
        }
        
        return view('activities.edit', compact('activity'));
    }

    public function update(Request $request, Activity $activity)
    {
        if ($activity->ormawa_id !== auth()->user()->ormawa_id && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'event_time' => 'nullable|date_format:H:i',
            'location' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'is_public' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($activity->image) {
                Storage::disk('public')->delete($activity->image);
            }
            $validated['image'] = $request->file('image')->store('activities', 'public');
        }

        $activity->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'event_date' => $validated['event_date'],
            'event_time' => $validated['event_time'] ?? $activity->event_time,
            'location' => $validated['location'] ?? $activity->location,
            'image' => $validated['image'] ?? $activity->image,
            'is_public' => $request->boolean('is_public'),
        ]);

        return redirect()->route('activities.index')
            ->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy(Activity $activity)
    {
        if ($activity->ormawa_id !== auth()->user()->ormawa_id && !auth()->user()->isAdmin()) {
            abort(403);
        }

        if ($activity->image) {
            Storage::disk('public')->delete($activity->image);
        }

        $activity->delete();

        return redirect()->route('activities.index')
            ->with('success', 'Kegiatan berhasil dihapus.');
    }
}
