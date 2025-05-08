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
    Route::group(['prefix' => 'User' , 'as' => 'User.' ] , function (){
        Route::get('Find/{UserID}' , [\App\Http\Controllers\Api\V1\UserController::class , 'Find'])->name('Find');
        Route::post('FindOrCreate' , [\App\Http\Controllers\Api\V1\UserController::class , 'FindOrCreate'])->name('FindOrCreate');
    });

    Route::group(['prefix' => 'Profile' , 'as' => 'Profile.' ] , function (){
        Route::post('UpdateImage' , [\App\Http\Controllers\Api\V1\UserController::class , 'UpdateImage'])->name('UpdateImage');

    });


    Route::group(['prefix' => 'Payment' , 'as' => 'Payment.' ] , function (){
        Route::get('GetPrice/{TokenName}' , [\App\Http\Controllers\Api\V1\PaymentsController::class , 'GetPrice'])->name('GetPrice');
        Route::post('Create' , [\App\Http\Controllers\Api\V1\PaymentsController::class , 'Create'])->name('Create');
        Route::post('Check' , [\App\Http\Controllers\Api\V1\PaymentsController::class , 'Check'])->name('Check');
    });

    Route::group(['prefix' => 'Withdraw' , 'as' => 'Withdraw.' ] , function (){
        Route::post('Create' , [\App\Http\Controllers\Api\V1\WithdrawController::class , 'Create'])->name('Create');
        Route::post('Check' , [\App\Http\Controllers\Api\V1\WithdrawController::class , 'Check'])->name('Check');
    });

    Route::group(['prefix' => 'PaymentHistory' , 'as' => 'PaymentHistory.' ] , function (){
        Route::post('List' , [\App\Http\Controllers\Api\V1\UserPaymentHistoryController::class , 'List'])->name('List');
    });


    Route::group(['prefix' => 'ReferralPlan' , 'as' => 'ReferralPlan.' ] , function (){
        Route::get('List' , [\App\Http\Controllers\Api\V1\ReferralPlanController::class , 'List'])->name('List');
        Route::post('Check' , [\App\Http\Controllers\Api\V1\ReferralPlanController::class , 'Check'])->name('Check');
    });


});
