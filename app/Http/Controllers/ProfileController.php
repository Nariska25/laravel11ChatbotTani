<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'gender' => 'required|string',
            'dob' => 'nullable|date',
            'image_path' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'dob' => $request->dob,
        ];

        if ($request->hasFile('image_path')) {
            $file = $request->file('image_path');
        
            // Debug info
            logger('UPLOAD FILE DEBUG', [
                'originalName' => $file->getClientOriginalName(),
                'isValid' => $file->isValid(),
                'path' => $file->path(),
                'mime' => $file->getMimeType(),
            ]);
        
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('profile_images', $filename, 'public');
        
            // Simpan path ke database
            $data['image_path'] = 'profile_images/' . $filename;
        }
        
        

        $user->update($data);

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui.');
    }

    public function alamat()
    {
        $user = Auth::user();
        return view('profile.alamat', compact('user'));
    }

    public function editAlamat()
    {
        $user = Auth::user();
        return view('profile.editalamat', compact('user'));
    }

    public function updateAlamat(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'province' => 'required|string|max:100',
        ]);

        $user = Auth::user();

        $user->update([
            'address' => $request->address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'province' => $request->province,
        ]);

        return redirect()->route('profile.alamat')->with('success', 'Alamat berhasil diperbarui!');
    }

    public function password()
    {
        $user = Auth::user();
        return view('profile.updatepassword', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required'],
            'new_password' => [
                'required',
                'min:8',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
                Rule::notIn([$user->email])
            ],
        ], [
            'new_password.not_in' => 'Password tidak boleh sama dengan email Anda.',
            'new_password.mixedCase' => 'Password harus memiliki huruf besar dan kecil.',
            'new_password.numbers' => 'Password harus memiliki setidaknya satu angka.',
            'new_password.symbols' => 'Password harus memiliki setidaknya satu karakter khusus.',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai']);
        }

        $user->update([
            'password' => bcrypt($request->new_password),
        ]);

        return redirect()->route('profile.password')->with('success', 'Password berhasil diperbarui.');
    }
}
