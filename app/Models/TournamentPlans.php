<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentPlans extends Model
{
    protected $fillable = [
        'TournamentID',
        'Stage',
        'Player1ID',
        'Player2ID',
        'Time',
        'WinnerID',
    ];
    use HasFactory;
}
