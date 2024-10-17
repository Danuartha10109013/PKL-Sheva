<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AutoLogout;
use Illuminate\Support\Facades\Route;

Route::get('/', [Clogin::class, 'login'])->name('login');
Route::post('/loginz', [Clogin::class, 'input_login'])->name('input_login');


//auto Logout
Route::middleware([AutoLogout::class])->group(function () {
    
    //Profile
    Route::prefix('profile')->group(function () {
        Route::get('{id}',[ProfileController::class,'index'])->name('profile');
        Route::put('/update',[ProfileController::class,'update'])->name('profile.update');
    });
    
    Route::group(['prefix' => 'pm', 'middleware' => ['pm'], 'as' => 'pm.'], function () {
        //Dashboard
        Route::get('/', [DashboardController::class, 'projectManager'])->name('PM');

    });
    Route::group(['prefix' => 'team_lead', 'middleware' => ['team_lead'], 'as' => 'team_lead.'], function () {
        //Dashboard
        Route::get('/', [DashboardController::class, 'team_lead'])->name('team_lead');

    });
    Route::group(['prefix' => 'finance', 'middleware' => ['finance'], 'as' => 'finance.'], function () {
        //Dashboard
        Route::get('/', [DashboardController::class, 'finance'])->name('finance');

    });
    Route::group(['prefix' => 'klien', 'middleware' => ['klien'], 'as' => 'klien.'], function () {
        //Dashboard
        Route::get('/', [DashboardController::class, 'klien'])->name('klien');

    });
});