<?php

namespace App\Http\Controllers;

use App\Models\ProjectM;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KProjectController
{
    public function index(){
        $data =ProjectM::all();
        $customer = User::where('role',3)->get();
        return view('page.pm.k-project.index',compact('data','customer'));
    }

    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'judul' => 'required|string|max:255',
            'customer' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
            'biaya' => 'nullable|numeric|min:0',
        ]);

        // Create a new project with the provided data
        ProjectM::create([
            'judul' => $request->judul,
            'customer_id' => $request->customer,
            'start' => $request->start,
            'end' => $request->end,
            'biaya' => $request->biaya,
            'pm_id' => Auth::user()->id,
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Project created successfully!');
    }
}
