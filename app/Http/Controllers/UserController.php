<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ormawa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('ormawa')->latest()->paginate(15);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $ormawas = Ormawa::where('is_active', true)->get();
        return view('users.create', compact('ormawas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,ketua_bem,ketua_ukm',
            'ormawa_id' => 'nullable|exists:ormawas,id',
            'phone' => 'nullable|string',
        ]);

        if ($validated['role'] !== 'admin' && !$request->ormawa_id) {
            return back()->withErrors(['ormawa_id' => 'ORMAWA harus dipilih untuk role Ketua BEM/UKM']);
        }

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'ormawa_id' => $validated['role'] === 'admin' ? null : $validated['ormawa_id'],
            'phone' => $validated['phone'],
            'is_active' => true,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $ormawas = Ormawa::where('is_active', true)->get();
        return view('users.edit', compact('user', 'ormawas'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,ketua_bem,ketua_ukm',
            'ormawa_id' => 'nullable|exists:ormawas,id',
            'phone' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'ormawa_id' => $validated['role'] === 'admin' ? null : $validated['ormawa_id'],
            'phone' => $validated['phone'],
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}