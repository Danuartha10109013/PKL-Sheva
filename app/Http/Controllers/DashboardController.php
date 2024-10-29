<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
        return view('page.Klien.index');
    }
}
