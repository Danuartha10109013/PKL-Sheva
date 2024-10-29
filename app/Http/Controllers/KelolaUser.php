<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
class KelolaUser
{
    public function index(){
        $data= User::all();
        return view('page.pm.k-user.index',compact('data'));
    }
    public function update(Request $request, $id)
    {
        // dd($request->all());
        // Find the user by ID
        $user = User::findOrFail($id);

        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Update user fields
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;

        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Handle profile image upload
        if ($request->hasFile('profile')) {
            $image = $request->file('profile');
            $folderPath = 'user_profile/' . $user->id;
            $extension = $image->getClientOriginalExtension();
            $fileName = uniqid() . '.' . $extension;

            // Delete old image if exists
            if ($user->profile && Storage::exists($folderPath . '/' . $user->profile)) {
                Storage::delete($folderPath . '/' . $user->profile);
            }

            // Store new profile image and save only the file name
            $image->storeAs($folderPath, $fileName, 'public');
            $user->profile = $fileName;
        }

        // Save updated user data
        $user->save();

        // Redirect with a success message
        return redirect()->back()->with('success', 'User updated successfully!');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'no_pegawai' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'active' => 'required|boolean',
            'role' => 'required|in:0,1,2,3',
            'birthday' => 'nullable|date',
            'email' => 'required|string|email|max:255|unique:users',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Store the profile image if it exists
        $profilePath = null;
        if ($request->hasFile('profile')) {
            $profilePath = $request->file('profile')->store('user_profiles', 'public');
        }

        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'no_pegawai' => $request->no_pegawai,
            'jabatan' => $request->jabatan,
            'alamat' => $request->alamat,
            'active' => $request->active,
            'role' => $request->role,
            'birthday' => $request->birthday,
            'email' => $request->email,
            'profile' => $profilePath,
            'password' => Hash::make($request->password),
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'User added successfully.');
    }

    public function destroy($id)
    {
        // Find the user by ID
        $user = User::find($id);

        // Check if user exists
        if (!$user) {
            return redirect()->route('pm.k-user')->with('error', 'User not found.');
        }

        // Delete the user
        $user->delete();

        // Redirect with a success message
        return redirect()->route('pm.k-user')->with('success', 'User deleted successfully.');
    }
}

