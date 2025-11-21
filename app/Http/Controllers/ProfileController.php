<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; 

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

  public function update(Request $request)
    {
        $user = $request->user();

        // 1. Validasi User & Ormawa
        $rules = [
            // Validasi User
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|max:2048',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ];

        // Tambahkan validasi Ormawa jika user punya ormawa
        if ($user->ormawa) {
            $rules = array_merge($rules, [
                'ormawa_name' => 'required|string|max:255',
                'ormawa_type' => 'required|in:bem,ukm',
                'ormawa_logo' => 'nullable|image|max:2048',
                'ormawa_email' => 'nullable|email|max:255',
                'ormawa_phone' => 'nullable|string|max:20',
                'ormawa_established_year' => 'nullable|integer',
                'ormawa_description' => 'nullable|string',
                'ormawa_vision' => 'nullable|string',
                'ormawa_mission' => 'nullable|string',
                'ormawa_address' => 'nullable|string',
                'ormawa_instagram' => 'nullable|string|max:255',
                'ormawa_facebook' => 'nullable|string|max:255',
                'ormawa_youtube' => 'nullable|string|max:255',
            ]);
        }

        $validated = $request->validate($rules);

        // 2. Update Data User
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];

        if ($request->hasFile('avatar')) {
            if ($user->avatar) Storage::disk('public')->delete($user->avatar);
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai']);
            }
            $user->password = Hash::make($request->new_password);
        }
        
        $user->save();

        // 3. Update Data Ormawa
        if ($user->ormawa) {
            $ormawa = $user->ormawa;
            
            // Handle Logo Ormawa
            if ($request->hasFile('ormawa_logo')) {
                if ($ormawa->logo) Storage::disk('public')->delete($ormawa->logo);
                $ormawa->logo = $request->file('ormawa_logo')->store('ormawa-logos', 'public');
            }

            // Siapkan data update ormawa
            $ormawaData = [
                'name' => $validated['ormawa_name'],
                'type' => $validated['ormawa_type'],
                'email' => $validated['ormawa_email'],
                'phone' => $validated['ormawa_phone'],
                'established_year' => $validated['ormawa_established_year'],
                'description' => $validated['ormawa_description'],
                'vision' => $validated['ormawa_vision'],
                'mission' => $validated['ormawa_mission'],
                'address' => $validated['ormawa_address'],
                'instagram' => $validated['ormawa_instagram'],
                'facebook' => $validated['ormawa_facebook'],
                'youtube' => $validated['ormawa_youtube'],
            ];

            // Update Slug jika nama berubah
            if ($ormawa->name !== $validated['ormawa_name']) {
                $ormawaData['slug'] = Str::slug($validated['ormawa_name']);
            }

            // Simpan logo jika ada perubahan (di atas hanya assign property model tapi belum save ke DB dalam array update ini, jadi kita update modelnya langsung)
            $ormawa->fill($ormawaData);
            $ormawa->save();
        }

        return back()->with('success', 'Profile dan data Ormawa berhasil diperbarui.');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        $user = $request->user();

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Password tidak sesuai']);
        }

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}