<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

Route::get('/', [Clogin::class, 'login'])->name('login');
Route::get('/', [Clogin::class, 'login'])->name('login');