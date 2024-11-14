<?php

namespace App\Http\Controllers;

use App\Models\ProjectM;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController
{
    public function projectManager ()
    {
        $client = User::where('role', 3)->count(); 
        return view('page.pm.index',compact('client'));
    }
    public function team_lead ()
    {
        return view('page.team_lead.index');
    }
    public function finance ()
    {
        return view('page.finance.index');
    }
    public function klien ()
    {
        $project = ProjectM::where('customer_id',Auth::user()->id)->value('judul');
        $ids = ProjectM::where('customer_id',Auth::user()->id)->value('id');
        $data= ProjectM::find($ids);
        return view('page.Klien.index',compact('project','data'));
    }
}
