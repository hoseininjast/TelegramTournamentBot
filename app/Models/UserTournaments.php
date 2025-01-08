<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTournaments extends Model
{
    protected $fillable = [
        'UserID',
        'TournamentID',
    ];
    use HasFactory;
}
