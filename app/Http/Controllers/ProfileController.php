<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
            'no_pegawai' => 'required|string|max:50',
            'jabatan' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $user = User::find(Auth::user()->id);
        // Update the profile data
        $user->name = $request->name;
        $user->username = $request->username;
        $user->no_pegawai = $request->no_pegawai;
        $user->jabatan = $request->jabatan;
        $user->email = $request->email;

        // Check if password was provided and update it
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($user->profile && Storage::exists($user->profile)) {
                Storage::delete($user->profile);
            }

            // Store the new profile image
            $path = $request->file('profile_image')->store('profile_images');
            $user->profile = $path;
        }

        // Save the updated user data
        $user->save();

        // Redirect with a success message
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
