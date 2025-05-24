<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStars extends Model
{
    protected $fillable = [
        'UserID',
        'TournamentID',
    ];

    use HasFactory;



    public function Tournament()
    {
        return $this->hasOne(Tournaments::class , 'id' , 'TournamentID');
    }
    public function User()
    {
        return $this->hasOne(TelegramUsers::class , 'id' , 'UserID');
    }


}
