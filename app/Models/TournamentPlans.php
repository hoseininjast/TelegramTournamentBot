<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentPlans extends Model
{
    protected $fillable = [
        'TournamentID',
        'Stage',
        'Group',
        'Player1ID',
        'Player1Score',
        'Player2ID',
        'Player2Score',
        'Time',
        'WinnerID',
        'Status',
    ];
    use HasFactory;





    public function Tournament()
    {
        return $this->hasOne(Tournaments::class , 'id' , 'TournamentID');
    }

    public function Player1()
    {
        return $this->belongsTo(TelegramUsers::class , 'Player1ID' , 'id');
    }

    public function Player2()
    {
        return $this->belongsTo(TelegramUsers::class , 'Player2ID' , 'id');
    }

    public function Winner()
    {
        return $this->belongsTo(TelegramUsers::class , 'WinnerID' , 'id');
    }
}
