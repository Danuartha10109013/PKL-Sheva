<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController
{
    public function projectManager ()
    {
        return view('page.pm.index');
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
