<?php

namespace App\Http\Controllers;

use App\Models\NotifM;
use App\Models\ProjectM;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController
{
    public function readnotif(Request $request)
{
    // Validate that 'notif_ids' is an array
    $request->validate([
        'notif_ids' => 'required|array',
        'notif_ids.*' => 'integer|exists:notification,id',
    ]);

    // Update the status to 1 (read)
    NotifM::whereIn('id', $request->notif_ids)
        ->where('user_id', Auth::user()->id) // Ensure users can only update their own notifs
        ->update(['status' => 1]);

    return back()->with('success', 'Notifikasi berhasil ditandai sebagai telah dibaca.');
}
    public function projectManager ()
    {
        $client = User::where('role', 3)->count(); 
        // $data = ProjectM::all()->sort('updated_at','desc');
        $data = ProjectM::orderBy('updated_at', 'desc')->get();

        $customer = User::all();
        $team_leader = User::all();
        return view('page.pm.index',compact('client','data','customer','team_leader'));
    }
    public function team_lead ()
    {
        $project = ProjectM::where('team_leader_id',Auth::user()->id)->value('judul');
        $ids = ProjectM::where('team_leader_id',Auth::user()->id)->value('id');
        $datain = ProjectM::where('team_leader_id',Auth::user()->id)->orderBy('updated_at', 'desc')->get();
        // dd($ids);
        $customer = User::all();
        $team_leader = User::all();
        $data= ProjectM::find($ids);
        return view('page.team_lead.index',compact('project','data','datain','customer','team_leader'));
    }
    public function finance ()
    {
        $client = User::where('role', 3)->count(); 
        // $data = ProjectM::all()->sort('updated_at','desc');
        $data = ProjectM::orderBy('updated_at', 'desc')->get();

        $customer = User::all();
        $team_leader = User::all();
        return view('page.finance.index',compact('client','data','customer','team_leader'));
    }
    public function klien ()
    {
        $project = ProjectM::where('customer_id', Auth::user()->id)
                   ->latest()
                   ->value('judul');
        $ids = ProjectM::where('customer_id', Auth::user()->id)
                    ->latest()
                    ->value('id');
        $data= ProjectM::find($ids);
        return view('page.Klien.index',compact('project','data'));
    }
}
