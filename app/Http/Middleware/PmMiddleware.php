<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PmMiddleware
{
    public function handle($request, Closure $next)
    {
        // Periksa apakah pengguna adalah pm (role = 0)
        if (Auth::check()) {
            if (Auth::user()->role == 0){
                return $next($request);
            }
            return response()->view('errors.custom', ['message' => 'Anda Bukan Project Manager'], 403);
        }
        return redirect('/');
        
        // Jika bukan admin, arahkan ke halaman lain
         // Ganti dengan kode status atau rute yang sesuai
    }
}
