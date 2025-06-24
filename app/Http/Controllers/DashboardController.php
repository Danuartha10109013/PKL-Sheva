<?php

namespace App\Http\Controllers;

use App\Models\NotifKlienM;
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

    if(Auth::user()->role == 3){
        foreach($request->notif_ids as $n){
            $notif = NotifM::find($n);
            $notif->status = 1;
            $notif->save();
        }
    }else{
        
        foreach($request->notif_ids as $n){
            $notif = NotifM::find($n);
            $notif->status_finance = 1;
            $notif->save();
        }
    }
    

    return back()->with('success', 'Notifikasi berhasil ditandai sebagai telah dibaca.');
}
    public function deletenotif(Request $request)
{
    // dd(Auth::user()->role);
    // Validate that 'notif_ids' is an array
    $request->validate([
        'notif_ids' => 'required|array',
        'notif_ids.*' => 'integer|exists:notification,id',
    ]);
    if(Auth::user()->role == 3){

        foreach($request->notif_ids as $n){
            $notif = NotifM::find($n);
            $notif->hapus = 1;
            $notif->save();
        }
    }else{

        foreach($request->notif_ids as $n){
            $notif = NotifM::find($n);
            $notif->hapus_finance = 1;
            $notif->save();
        }
    }
    

    return back()->with('success', 'Notifikasi berhasil dihapus.');
}
    public function readnotifpm(Request $request)
{
    // dd($request->all());
    // Validate that 'notif_ids' is an array
    $request->validate([
    'notif_ids' => 'required|array',
    'notif_ids.*' => 'integer|exists:notification,id',
]);

// Update the status to 1 (read)
if(Auth::user()->role == 1){

    foreach ($request->notif_ids as $n) {
        $notif = NotifKlienM::find($n);
        if ($notif) {
            $notif->status_tl = 1;
            $notif->save();
        }
    }
}else{
    foreach ($request->notif_ids as $n) {
        $notif = NotifKlienM::find($n);
        if ($notif) {
            $notif->status = 1;
            $notif->save();
        }
    }

}


    return back()->with('success', 'Notifikasi berhasil ditandai sebagai telah dibaca.');
}
    public function deletenotifpm(Request $request)
{
    // dd($request->all());
    // Validate that 'notif_ids' is an array
    $request->validate([
    'notif_ids' => 'required|array',
    'notif_ids.*' => 'integer|exists:notification,id',
]);
if(Auth::user()->role == 1){

    foreach ($request->notif_ids as $n) {
        $notif = NotifKlienM::find($n);
        if ($notif) {
            $notif->hapus_tl = 1;
            $notif->save();
        }
    }
}else{

    foreach ($request->notif_ids as $n) {
        $notif = NotifKlienM::find($n);
        if ($notif) {
            $notif->hapus = 1;
            $notif->save();
        }
    }
}
// Update the status to 1 (read)


    return back()->with('success', 'Notifikasi berhasil dihapus');
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
    public function klien (Request $request)
    {
        $cc = $request->project;
        // dd($request->project);
        if($request->project){

            $projects = ProjectM::where('customer_id', Auth::user()->id)
                       ->get();
                       
            $ids = ProjectM::where('customer_id', Auth::user()->id)
                        ->latest()
                        ->value('id');
            $data= ProjectM::find($request->project);
        }else{

            $projects = ProjectM::where('customer_id', Auth::user()->id)
                       ->get();
                       
            $ids = ProjectM::where('customer_id', Auth::user()->id)
                        ->latest()
                        ->value('id');
            $data= ProjectM::find($ids);
        }
        return view('page.Klien.index',compact('projects','data','cc'));
    }
}
