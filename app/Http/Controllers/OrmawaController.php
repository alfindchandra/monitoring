<?php
namespace App\Http\Controllers;

use App\Models\Ormawa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OrmawaController extends Controller
{
    public function index()
    {
        $ormawas = Ormawa::latest()->paginate(15);
        return view('ormawas.index', compact('ormawas'));
    }

    public function create()
    {
        return view('ormawas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:bem,ukm',
            'description' => 'nullable|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'instagram' => 'nullable|string',
            'facebook' => 'nullable|string',
            'youtube' => 'nullable|string',
            'address' => 'nullable|string',
            'established_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'logo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('ormawa-logos', 'public');
        }

        Ormawa::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'type' => $validated['type'],
            'description' => $validated['description'] ?? null,
            'vision' => $validated['vision'] ?? null,
            'mission' => $validated['mission'] ?? null,
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'instagram' => $validated['instagram'] ?? null,
            'facebook' => $validated['facebook'] ?? null,
            'youtube' => $validated['youtube'] ?? null,
            'address' => $validated['address'] ?? null,
            'established_year' => $validated['established_year'] ?? null,
            'logo' => $logoPath,
            'is_active' => true,
        ]);

        return redirect()->route('ormawas.index')
            ->with('success', 'ORMAWA berhasil ditambahkan.');
    }

    public function edit(Ormawa $ormawa)
    {
        return view('ormawas.edit', compact('ormawa'));
    }

    public function update(Request $request, Ormawa $ormawa)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:bem,ukm',
            'description' => 'nullable|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'instagram' => 'nullable|string',
            'facebook' => 'nullable|string',
            'youtube' => 'nullable|string',
            'address' => 'nullable|string',
            'established_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'logo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            if ($ormawa->logo) {
                Storage::disk('public')->delete($ormawa->logo);
            }
            $validated['logo'] = $request->file('logo')->store('ormawa-logos', 'public');
        }

        $ormawa->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'type' => $validated['type'],
            'description' => $validated['description'] ?? $ormawa->description,
            'vision' => $validated['vision'] ?? $ormawa->vision,
            'mission' => $validated['mission'] ?? $ormawa->mission,
            'email' => $validated['email'] ?? $ormawa->email,
            'phone' => $validated['phone'] ?? $ormawa->phone,
            'instagram' => $validated['instagram'] ?? $ormawa->instagram,
            'facebook' => $validated['facebook'] ?? $ormawa->facebook,
            'youtube' => $validated['youtube'] ?? $ormawa->youtube,
            'address' => $validated['address'] ?? $ormawa->address,
            'established_year' => $validated['established_year'] ?? $ormawa->established_year,
            'logo' => $validated['logo'] ?? $ormawa->logo,
        ]);

        return redirect()->route('ormawas.index')
            ->with('success', 'ORMAWA berhasil diperbarui.');
    }

    public function destroy(Ormawa $ormawa)
    {
        if ($ormawa->users()->count() > 0) {
            return back()->with('error', 'ORMAWA tidak dapat dihapus karena masih memiliki user.');
        }

        if ($ormawa->logo) {
            Storage::disk('public')->delete($ormawa->logo);
        }

        $ormawa->delete();

        return redirect()->route('ormawas.index')
            ->with('success', 'ORMAWA berhasil dihapus.');
    }

    public function toggleStatus(Ormawa $ormawa)
    {
        $ormawa->update(['is_active' => !$ormawa->is_active]);
        
        return back()->with('success', 'Status ORMAWA berhasil diubah.');
    }
}