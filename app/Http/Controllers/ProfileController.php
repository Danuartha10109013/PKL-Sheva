<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;


class ProfileController
{
    public function index($id)
    {
        $data=User::find($id);
        return view('page.profil.profil', compact('data'));
    }


    
    public function update(Request $request)
    {
        $user = Auth::user();
    
        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'no_pegawai' => 'nullable|string|max:50',
            'jabatan' => 'nullable|string|max:100',
            'npwp' => 'nullable',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => [
            'nullable',
            'confirmed',
                Password::min(8)
                    ->mixedCase()    // mengharuskan huruf besar & kecil
                    ->letters()      // mengharuskan huruf (sudah termasuk huruf besar/kecil)
                    ->numbers()      // mengharuskan angka
                    ->symbols(),     // mengharuskan simbol (karakter spesial)
            ],
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        // Check if validation fails
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        // Update the profile data
        $user->name = $request->name;
        $user->username = $request->username;
        $user->no_pegawai = $request->no_pegawai;
        $user->jabatan = $request->jabatan;
        $user->npwp = $request->npwp;
        $user->email = $request->email;
    
        // Check if password was provided and update it
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
    
        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
    
            // Define the folder path based on user ID
            $folderPath = 'user_profile/' . $user->id;
    
            // Get the original file extension
            $extension = $image->getClientOriginalExtension();
    
            // Generate a unique file name
            $fileName = uniqid() . '.' . $extension;
    
            // Delete old image if exists
            if ($user->profile && Storage::exists($folderPath . '/' . $user->profile)) {
                Storage::delete($folderPath . '/' . $user->profile);
            }
    
            // Store the new profile image in the specified folder
            $image->storeAs($folderPath, $fileName, 'public');
    
            // Save only the image name in the database
            $user->profile = $fileName;
        }
    
        // Save the updated user data
        $user->save();
    
        // Redirect with a success message
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
    
}
