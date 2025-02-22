<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::group(['prefix' => 'V1' , 'as' => 'V1.'] , function (){
    Route::group(['prefix' => 'Games' , 'as' => 'Games.' ] , function (){
        Route::get('/' , [\App\Http\Controllers\Api\V1\GamesController::class , 'index'])->name('index');
    });
    Route::group(['prefix' => 'Tournaments' , 'as' => 'Tournaments.' ] , function (){
        Route::get('/' , [\App\Http\Controllers\Api\V1\TournamentsController::class , 'index'])->name('index');
        Route::get('Detail/{ID}' , [\App\Http\Controllers\Api\V1\TournamentsController::class , 'Detail'])->name('Detail');
        Route::post('MyTournaments' , [\App\Http\Controllers\Api\V1\TournamentsController::class , 'MyTournaments'])->name('MyTournaments');
        Route::post('Join' , [\App\Http\Controllers\Api\V1\TournamentsController::class , 'Join'])->name('Join');
        Route::post('JoinStatus' , [\App\Http\Controllers\Api\V1\TournamentsController::class , 'JoinStatus'])->name('JoinStatus');
    });
});
