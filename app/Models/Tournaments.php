<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournaments extends Model
{
    protected $fillable = [
        'Name',
        'Description',
        'Image',
        'PlayerCount',
        'TotalStage',
        'LastStage',
        'StagesDate',
        'Type',
        'Mode',
        'Price',
        'Time',
        'Start',
        'End',
        'GameID',
        'Winners',
        'Awards',
        'Status',
    ];
    use HasFactory;

    protected $casts = [
        'Awards' => 'array',
        'StagesDate' => 'array',
    ];


    public function Game()
    {
        return $this->hasOne(Games::class , 'id' , 'GameID');
    }

    public function Players()
    {
        return $this->hasMany(UserTournaments::class , 'TournamentID' , 'id');
    }
    public function Plans()
    {
        return $this->hasMany(TournamentPlans::class , 'TournamentID' , 'id');
    }
    public function History()
    {
        return $this->hasOne(TournamentHistory::class , 'TournamentID' , 'id');
    }
    public function isJoined(int $UserID)
    {
        return $this->Players()->where('UserID' , $UserID)->count() > 0 ? true : false ;
    }
    public function GetImage()
    {
        return $this->Image != null ? $this->Image : $this->Game->Image ;
    }
    public function GetPrice()
    {
        return $this->Price * 1000;
    }
}
