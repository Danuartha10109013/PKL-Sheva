<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Clogin
{
    public function login ()
    {
        return view('login.signin');
    }
}
