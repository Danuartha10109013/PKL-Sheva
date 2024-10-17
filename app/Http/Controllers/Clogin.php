<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Clogin
{
    public function login ()
    {
        return view('login.signin');
    }
    public function input_login(Request $request)
    {
        // dd($request->all());
        $loginType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $data = [
            $loginType => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($data)) {
            $user = Auth::user();
            
            // Cek peran pengguna setelah login berhasil
            if ($user->active == 0) {
                return redirect()->route('login')->with('error', 'Your Account was inactive, contact your admin');
            }
        
            // Redirect sesuai peran pengguna jika status aktif
            if ($user->role == 0) {
                return redirect()->route('pm.PM');
            } elseif ($user->role == 1) {
                return redirect()->route('team_lead.team_lead');
            } elseif ($user->role == 2) {
                return redirect()->route('finance.finance');
            } elseif ($user->role == 3) {
                return redirect()->route('klien.klien');
            }
        } else {
            // Redirect kembali ke halaman login jika gagal
            return redirect()->route('login')->with('error', 'Username atau Password anda salah!');
        }
    }
}

