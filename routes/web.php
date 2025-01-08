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



Route::group(['as' => 'Dashboard.' , 'middleware' => ['auth']] , function (){
    Route::get('/' , [\App\Http\Controllers\WebController::class , 'index'])->name('index');


    Route::group( ['prefix' => 'Users' , 'as' => 'Users.' ] ,function (){
        Route::get('index' , [\App\Http\Controllers\UserController::class , 'index'])->name('index');
        Route::get('Add' , [\App\Http\Controllers\UserController::class , 'Add'])->name('Add');
        Route::post('Create' , [\App\Http\Controllers\UserController::class , 'Create'])->name('Create');
    });

    Route::group( ['prefix' => 'Games' , 'as' => 'Games.' ] ,function (){
        Route::get('index' , [\App\Http\Controllers\GamesController::class , 'index'])->name('index');
        Route::get('Add' , [\App\Http\Controllers\GamesController::class , 'Add'])->name('Add');
        Route::post('Create' , [\App\Http\Controllers\GamesController::class , 'Create'])->name('Create');
    });

    Route::group( ['prefix' => 'Tournaments' , 'as' => 'Tournaments.' ] ,function (){
        Route::get('index' , [\App\Http\Controllers\TournamentsController::class , 'index'])->name('index');
        Route::get('Add' , [\App\Http\Controllers\TournamentsController::class , 'Add'])->name('Add');
        Route::post('Create' , [\App\Http\Controllers\TournamentsController::class , 'Create'])->name('Create');
    });



});
