<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
class KelolaUser
{
    public function index(){
        $data= User::orderBy('created_at','desc')->get();
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
        $user->no_pegawai = $request->no_pegawai;
        $user->npwp = $request->npwp;

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
    // Basic validation rules
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users',
        'alamat' => 'nullable|string|max:255',
        'active' => 'required|boolean',
        'role' => 'required|in:0,1,2,3',
        'birthday' => 'nullable|date',
        'email' => 'required|string|email|max:255|unique:users',
        'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    // Conditional validation for npwp only for Client (role 3)
    $validator->sometimes('npwp', 'required|digits:16', function ($input) {
        return $input->role == '3';
    });

    // Conditional validation for no_pegawai and jabatan for non-client roles (0,1,2)
    $validator->sometimes(['no_pegawai', 'jabatan'], 'required|string|max:255', function ($input) {
        return in_array($input->role, ['0', '1', '2']);
    });

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Create user, set no_pegawai & jabatan null for Client, npwp null for others
    $user = User::create([
        'name' => $request->name,
        'username' => $request->username,
        'no_pegawai' => in_array($request->role, ['0', '1', '2']) ? $request->no_pegawai : null,
        'jabatan' => in_array($request->role, ['0', '1', '2']) ? $request->jabatan : null,
        'npwp' => $request->role == '3' ? $request->npwp : null,
        'alamat' => $request->alamat,
        'active' => $request->active,
        'role' => $request->role,
        'birthday' => $request->birthday,
        'email' => $request->email,
        'profile' => null, // Will update if image uploaded
        'password' => Hash::make($request->password),
    ]);

    // Handle profile image upload if exists
    if ($request->hasFile('profile')) {
        $image = $request->file('profile');
        $folderPath = 'user_profile/' . $user->id;
        $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
        $profilePath = $image->storeAs($folderPath, $fileName, 'public');

        // Update user's profile image filename
        $user->update(['profile' => $fileName]);
    }

    return response()->json([
        'success' => true,
        'message' => 'User added successfully!'
    ]);
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

