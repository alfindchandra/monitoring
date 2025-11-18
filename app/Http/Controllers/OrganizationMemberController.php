<?php

namespace App\Http\Controllers;

use App\Models\OrganizationMember;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrganizationMemberController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $ormawa = $user->ormawa;
        
        if (!$ormawa) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak terdaftar di ORMAWA manapun.');
        }
        
        $members = $ormawa->currentMembers()->with('division')->get();
        
        // Group by position
        $structure = [
            'pembina' => $members->where('position', 'pembina'),
            'ketua' => $members->where('position', 'ketua'),
            'wakil_ketua' => $members->where('position', 'wakil_ketua'),
            'sekretaris' => $members->where('position', 'sekretaris'),
            'bendahara' => $members->where('position', 'bendahara'),
            'kepala_divisi' => $members->where('position', 'kepala_divisi'),
            'anggota_divisi' => $members->where('position', 'anggota_divisi'),
        ];
        
        return view('organization.index', compact('ormawa', 'structure', 'members'));
    }

    public function create()
    {
        $ormawa = auth()->user()->ormawa;
        
        if (!$ormawa) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak terdaftar di ORMAWA manapun.');
        }
        
        $divisions = $ormawa->divisions()->where('is_active', true)->orderBy('order')->get();
        
        return view('organization.create', compact('ormawa', 'divisions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'position' => 'required|in:pembina,ketua,wakil_ketua,sekretaris,bendahara,kepala_divisi,anggota_divisi',
            'division_id' => 'nullable|exists:divisions,id',
            'period_start' => 'required|integer|min:2000|max:2100',
            'period_end' => 'required|integer|min:2000|max:2100|gte:period_start',
        ]);

        $ormawa = auth()->user()->ormawa;
        
        if (!$ormawa) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak terdaftar di ORMAWA manapun.');
        }
        
        // Validate division_id belongs to this ormawa
        if ($request->division_id) {
            $division = Division::find($request->division_id);
            if (!$division || $division->ormawa_id !== $ormawa->id) {
                return back()->withErrors(['division_id' => 'Divisi tidak valid']);
            }
        }
        
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('organization-members', 'public');
        }

        OrganizationMember::create([
            'ormawa_id' => $ormawa->id,
            'division_id' => $validated['division_id'] ?? null,
            'name' => $validated['name'],
            'nim' => $validated['nim'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'] ?? null,
            'photo' => $photoPath,
            'position' => $validated['position'],
            'period_start' => $validated['period_start'],
            'period_end' => $validated['period_end'],
            'is_active' => true,
        ]);

        return redirect()->route('organization.index')
            ->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function edit(OrganizationMember $member)
    {
        // Check authorization
        if ($member->ormawa_id !== auth()->user()->ormawa_id && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        $divisions = $member->ormawa->divisions()->where('is_active', true)->orderBy('order')->get();
        
        return view('organization.edit', compact('member', 'divisions'));
    }

    public function update(Request $request, OrganizationMember $member)
    {
        // Check authorization
        if ($member->ormawa_id !== auth()->user()->ormawa_id && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'position' => 'required|in:pembina,ketua,wakil_ketua,sekretaris,bendahara,kepala_divisi,anggota_divisi',
            'division_id' => 'nullable|exists:divisions,id',
            'period_start' => 'required|integer|min:2000|max:2100',
            'period_end' => 'required|integer|min:2000|max:2100|gte:period_start',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('photo')) {
            if ($member->photo) {
                Storage::disk('public')->delete($member->photo);
            }
            $validated['photo'] = $request->file('photo')->store('organization-members', 'public');
        }

        $member->update([
            'name' => $validated['name'],
            'nim' => $validated['nim'] ?? $member->nim,
            'phone' => $validated['phone'] ?? $member->phone,
            'email' => $validated['email'] ?? $member->email,
            'photo' => $validated['photo'] ?? $member->photo,
            'position' => $validated['position'],
            'division_id' => $validated['division_id'] ?? null,
            'period_start' => $validated['period_start'],
            'period_end' => $validated['period_end'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('organization.index')
            ->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(OrganizationMember $member)
    {
        // Check authorization
        if ($member->ormawa_id !== auth()->user()->ormawa_id && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        if ($member->photo) {
            Storage::disk('public')->delete($member->photo);
        }
        
        $member->delete();

        return redirect()->route('organization.index')
            ->with('success', 'Anggota berhasil dihapus.');
    }
}