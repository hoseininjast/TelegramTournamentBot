<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::post('/telegram/webhook', [\App\Http\Controllers\Telegram\TelegramController::class , 'index']);

Route::get('/' , [\App\Http\Controllers\WebController::class , 'GotoDashboard'])->name('index');


Route::group(['prefix' => 'Dashboard' , 'as' => 'Dashboard.' , 'middleware' => ['auth']] , function (){
    Route::get('index' , [\App\Http\Controllers\WebController::class , 'index'])->name('index');


    Route::group( ['prefix' => 'Users' , 'as' => 'Users.' ] ,function (){
        Route::get('index' , [\App\Http\Controllers\UserController::class , 'index'])->name('index');
        Route::get('Telegram' , [\App\Http\Controllers\UserController::class , 'Telegram'])->name('Telegram');
        Route::get('Add' , [\App\Http\Controllers\UserController::class , 'Add'])->name('Add');
        Route::post('Create' , [\App\Http\Controllers\UserController::class , 'Create'])->name('Create');
        Route::delete('Delete/{id}' , [\App\Http\Controllers\UserController::class , 'Delete'])->name('Delete');
        Route::delete('TelegramDelete/{id}' , [\App\Http\Controllers\UserController::class , 'TelegramDelete'])->name('TelegramDelete');
    });
    Route::group( ['prefix' => 'Profile' , 'as' => 'Profile.' ] ,function (){
        Route::get('Setting' , [\App\Http\Controllers\UserController::class , 'Setting'])->name('Setting');
        Route::post('Update' , [\App\Http\Controllers\UserController::class , 'Update'])->name('Update');
    });


    Route::group( ['prefix' => 'Games' , 'as' => 'Games.' ] ,function (){
        Route::get('index' , [\App\Http\Controllers\GamesController::class , 'index'])->name('index');
        Route::get('Add' , [\App\Http\Controllers\GamesController::class , 'Add'])->name('Add');
        Route::post('Create' , [\App\Http\Controllers\GamesController::class , 'Create'])->name('Create');
    });


    Route::group( ['prefix' => 'Tournaments' , 'as' => 'Tournaments.' ] ,function (){
        Route::get('index' , [\App\Http\Controllers\TournamentsController::class , 'index'])->name('index');
        Route::get('Add' , [\App\Http\Controllers\TournamentsController::class , 'Add'])->name('Add');
        Route::get('Manage/{ID}' , [\App\Http\Controllers\TournamentsController::class , 'Manage'])->name('Manage');
        Route::get('StartStage1/{ID}' , [\App\Http\Controllers\TournamentsController::class , 'StartStage1'])->name('StartStage1');
        Route::get('StartNextStage/{ID}' , [\App\Http\Controllers\TournamentsController::class , 'StartNextStage'])->name('StartNextStage');
        Route::post('Close/{ID}' , [\App\Http\Controllers\TournamentsController::class , 'Close'])->name('Close');
        Route::get('ClosePage/{ID}' , [\App\Http\Controllers\TournamentsController::class , 'ClosePage'])->name('ClosePage');
        Route::post('Create' , [\App\Http\Controllers\TournamentsController::class , 'Create'])->name('Create');
        Route::delete('Delete/{id}' , [\App\Http\Controllers\TournamentsController::class , 'Delete'])->name('Delete');
    });


    Route::group( ['prefix' => 'TournamentPlan' , 'as' => 'TournamentPlan.' ] ,function (){
        Route::get('Manage/{ID}' , [\App\Http\Controllers\TournamentPlansController::class , 'Manage'])->name('Manage');
        Route::get('JoinAsSupervisor/{ID}' , [\App\Http\Controllers\TournamentPlansController::class , 'JoinAsSupervisor'])->name('JoinAsSupervisor');
        Route::post('Update/{ID}' , [\App\Http\Controllers\TournamentPlansController::class , 'Update'])->name('Update');
        Route::post('SetTime/{ID}' , [\App\Http\Controllers\TournamentPlansController::class , 'SetTime'])->name('SetTime');
    });


});
