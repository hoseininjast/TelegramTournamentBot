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
    ];


    public function Game()
    {
        return $this->hasOne(Games::class , 'id' , 'GameID');
    }
}
