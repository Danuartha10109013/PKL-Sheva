<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AutoLogout;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

Route::get('/', [Clogin::class, 'login'])->name('login');
Route::post('/loginz', [Clogin::class, 'input_login'])->name('input_login');
Route::get('/logout', [Clogin::class, 'logout'])->name('logout');


//auto Logout
Route::middleware([AutoLogout::class])->group(function () {
    //ckeditor
    Route::get('/ckfinder/upload', [KProjectController::class, 'upload'])->name('ckfinder.browser');
    Route::post('/ckeditor/upload', [KProjectController::class, 'upload'])->name('ckeditor.upload');


    //Forum
    Route::prefix('forum')->group(function () {
        Route::get('/{id}',[ForumDiskusiController::class,'index'])->name('forum');
        Route::post('/message/{id}',[ForumDiskusiController::class,'message'])->name('forum.message');
        Route::post('/post',[ForumDiskusiController::class,'foumstore'])->name('forum.post');
    });
    
    //Profile
    Route::prefix('profile')->group(function () {
        Route::get('{id}',[ProfileController::class,'index'])->name('profile');
        Route::post('/update',[ProfileController::class,'update'])->name('profile.update');
    });
    
    Route::group(['prefix' => 'pm', 'middleware' => ['pm'], 'as' => 'pm.'], function () {

        Route::get('/download/{filename}', function ($filename) {
            $filePath = public_path($filename);

            // Check if the file exists in the public folder
            if (File::exists($filePath)) {
                return Response::download($filePath);
            }

            // Return a 404 error if the file doesn't exist
            abort(404, 'File not found');
        })->name('download');


        //Dashboard
        Route::get('/', [DashboardController::class, 'projectManager'])->name('PM');
        Route::prefix('k-user')->group(function () {
            Route::get('/', [KelolaUser::class, 'index'])->name('k-user');
            Route::post('/store', [KelolaUser::class, 'store'])->name('k-user.store');
            Route::put('/update/{id}', [KelolaUser::class, 'update'])->name('k-user.update');
            Route::delete('/destroy/{id}', [KelolaUser::class, 'destroy'])->name('k-user.destroy');
        });
        Route::prefix('k-project')->group(function () {
            Route::get('/', [KProjectController::class, 'index'])->name('k-project');
            Route::get('/plan/{id}', [KProjectController::class, 'plan'])->name('k-project.plan');
            Route::get('/show/{id}', [KProjectController::class, 'show'])->name('k-project.show');
            Route::put('/plan/update/{id}', [KProjectController::class, 'update_plan'])->name('k-project.plan.update');
            Route::put('/plan/update/revision/{id}', [KProjectController::class, 'update_plan_revision'])->name('k-project.plan.update.revision');
            Route::post('/store', [KProjectController::class, 'store'])->name('k-project.store');
            Route::put('/update/{id}', [KProjectController::class, 'update'])->name('k-project.update');
            Route::delete('/delete/{id}', [KProjectController::class, 'delete'])->name('k-project.delete');
            Route::get('/launch/{id}', [KProjectController::class, 'launch'])->name('k-project.launch');
            Route::get('/communication/{id}', [KProjectController::class, 'communication'])->name('k-project.communication');
            Route::get('/print/{id}', [KProjectController::class, 'print'])->name('k-project.print');
            Route::get('/setuju/{id}', [ClientController::class, 'setuju'])->name('k-project.setuju');

        });
        Route::prefix('k-progres')->group(function () {
            Route::get('/', [KProgresController::class, 'index'])->name('k-progres');
            Route::get('/progres/{id}', [KProgresController::class, 'progres'])->name('k-progres.progres');
            Route::post('/update/{id}', [KProgresController::class, 'update'])->name('k-progres.update');
        });

        Route::prefix('k-forum')->group(function () {
            Route::get('/', [ForumDiskusiController::class, 'pm'])->name('k-forum');

        });

    });
    Route::group(['prefix' => 'team_lead', 'middleware' => ['team_lead'], 'as' => 'team_lead.'], function () {
        //Dashboard
        Route::get('/', [DashboardController::class, 'team_lead'])->name('team_lead');
        Route::prefix('project')->group(function () {
            Route::get('/', [TeamLeadController::class, 'project'])->name('project');
            Route::get('/plan/{id}', [TeamLeadController::class, 'plan'])->name('project.plan');
            Route::get('/show/{id}', [KProjectController::class, 'show'])->name('project.show');
            Route::get('/print/{id}', [KProjectController::class, 'print'])->name('project.print');
            Route::post('update/{id}', [TeamLeadController::class, 'update'])->name('project.update');
            Route::get('setuju/{id}', [TeamLeadController::class, 'setuju'])->name('project.setuju');
            Route::get('forum/', [ForumDiskusiController::class, 'pm'])->name('project.forum');

        });
        Route::prefix('progres')->group(function () {
            Route::get('/', [KProgresController::class, 'index'])->name('progres');
        });

    });
    Route::group(['prefix' => 'finance', 'middleware' => ['finance'], 'as' => 'finance.'], function () {
        //Dashboard
        Route::get('/', [DashboardController::class, 'finance'])->name('finance');
        Route::prefix('invoice')->group(function () {
            Route::get('/', [FinanceController::class, 'index'])->name('invoice');
            Route::get('/print/{id}', [FinanceController::class, 'print'])->name('invoice.print');
            Route::put('/update/{id}', [FinanceController::class, 'update'])->name('invoice.update');
            Route::post('/mail/{id}', [FinanceController::class, 'mail'])->name('invoice.mail');
            Route::post('/confirm30/{id}', [FinanceController::class, 'tiga'])->name('invoice.confirm30');
            Route::post('/confirm60/{id}', [FinanceController::class, 'enam'])->name('invoice.confirm60');
            Route::post('/confirm90/{id}', [FinanceController::class, 'sembilan'])->name('invoice.confirm90');
            Route::post('/confirm100/{id}', [FinanceController::class, 'sepuluh'])->name('invoice.confirm100');
        });
        Route::prefix('project')->group(function () {
            Route::get('/', [FinanceController::class, 'project'])->name('project');
            Route::get('/plan/{id}', [KProjectController::class, 'show'])->name('project.plan');
            Route::get('/print/{id}', [KProjectController::class, 'print'])->name('project.print');

        });

    });
    Route::group(['prefix' => 'klien', 'middleware' => ['klien'], 'as' => 'klien.'], function () {
        //Dashboard
        Route::get('/', [DashboardController::class, 'klien'])->name('klien');
        Route::prefix('project')->group(function () {
            Route::get('/{id}', [ClientController::class, 'plan'])->name('project');
            Route::post('/update/{id}', [ClientController::class, 'update'])->name('project.update');
            Route::get('/setuju/{id}', [ClientController::class, 'setuju'])->name('project.setuju');
            Route::get('/print/{id}', [KProjectController::class, 'print'])->name('project.print');
        });
        Route::prefix('invoice')->group(function () {
            Route::get('/{id}', [ClientController::class, 'invoice'])->name('invoice');
            Route::get('/print/{id}', [ClientController::class, 'p_invoice'])->name('p.invoice');

        });

    });
});