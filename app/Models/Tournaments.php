<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournaments extends Model
{
    protected $fillable = [
        'Name',
        'Description',
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
}
