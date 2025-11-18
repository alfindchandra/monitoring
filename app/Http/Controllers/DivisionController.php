<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Ormawa;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $ormawa = $user->ormawa;
        
        if (!$ormawa) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak terdaftar di ORMAWA manapun.');
        }
        
        $divisions = $ormawa->divisions()->orderBy('order')->get();
        
        return view('divisions.index', compact('ormawa', 'divisions'));
    }

    public function create()
    {
        $ormawa = auth()->user()->ormawa;
        
        if (!$ormawa) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak terdaftar di ORMAWA manapun.');
        }
        
        return view('divisions.create', compact('ormawa'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
        ]);

        $ormawa = auth()->user()->ormawa;
        
        if (!$ormawa) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak terdaftar di ORMAWA manapun.');
        }
        
        Division::create([
            'ormawa_id' => $ormawa->id,
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'order' => $validated['order'] ?? 0,
            'is_active' => true,
        ]);

        return redirect()->route('divisions.index')
            ->with('success', 'Divisi berhasil ditambahkan.');
    }

    public function edit(Division $division)
    {
        // Check authorization
        if ($division->ormawa_id !== auth()->user()->ormawa_id && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('divisions.edit', compact('division'));
    }

    public function update(Request $request, Division $division)
    {
        // Check authorization
        if ($division->ormawa_id !== auth()->user()->ormawa_id && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $division->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? $division->description,
            'order' => $validated['order'] ?? $division->order,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('divisions.index')
            ->with('success', 'Divisi berhasil diperbarui.');
    }

    public function destroy(Division $division)
    {
        // Check authorization
        if ($division->ormawa_id !== auth()->user()->ormawa_id && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        if ($division->members()->count() > 0) {
            return back()->with('error', 'Divisi tidak dapat dihapus karena masih memiliki anggota.');
        }
        
        $division->delete();

        return redirect()->route('divisions.index')
            ->with('success', 'Divisi berhasil dihapus.');
    }
}
